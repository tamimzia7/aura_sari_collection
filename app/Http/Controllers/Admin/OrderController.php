<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                    );
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product.images', 'shippingAddress', 'billingAddress', 'user'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,confirmed,processing,shipped,delivered,cancelled'],
            'payment_status' => ['nullable', 'string', 'in:pending,pending_verification,cash_on_delivery,paid,failed,refunded'],
        ]);

        $order = Order::findOrFail($id);

        $data = $request->only(['status']);
        if ($request->filled('payment_status')) {
            $data['payment_status'] = $request->payment_status;
        }

        $oldStatus = $order->status;
        $order->update($data);

        if ($request->status !== $oldStatus) {
            $statusLabels = [
                'pending' => 'is now Pending.',
                'confirmed' => 'has been Confirmed!',
                'processing' => 'is now Processing.',
                'shipped' => 'has been Shipped!',
                'delivered' => 'has been Delivered!',
                'cancelled' => 'has been Cancelled.',
            ];
            $label = $statusLabels[$request->status] ?? 'has been updated.';
            $title = 'Order Status Updated';
            $message = "Order #{$order->order_number} {$label}";

            if ($order->user_id) {
                Notification::createForCustomer(
                    $order->user_id,
                    $title,
                    $message,
                    $order->id
                );
            }
        }

        return back()->with('success', 'Order status updated successfully.');
    }

    public function verifyPayment($id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_status !== Order::PAYMENT_PENDING_VERIFICATION) {
            return back()->with('error', 'Payment is not pending verification.');
        }

        $order->update(['payment_status' => Order::PAYMENT_PAID]);

        if ($order->user_id) {
            Notification::createForCustomer(
                $order->user_id,
                'Payment Verified',
                "Payment for Order #{$order->order_number} has been verified.",
                $order->id
            );
        }

        return back()->with('success', 'Payment verified successfully.');
    }

    public function markPaid($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['payment_status' => Order::PAYMENT_PAID]);

        if ($order->user_id) {
            Notification::createForCustomer(
                $order->user_id,
                'Payment Marked as Paid',
                "Payment for Order #{$order->order_number} has been marked as paid.",
                $order->id
            );
        }

        return back()->with('success', 'Payment marked as paid.');
    }

    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => Order::STATUS_CONFIRMED]);

        if ($order->user_id) {
            Notification::createForCustomer(
                $order->user_id,
                'Order Confirmed',
                "Your Order #{$order->order_number} has been confirmed.",
                $order->id
            );
        }

        return back()->with('success', 'Order confirmed successfully.');
    }

    public function rejectOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => Order::STATUS_CANCELLED]);

        if ($order->user_id) {
            Notification::createForCustomer(
                $order->user_id,
                'Order Cancelled',
                "Your Order #{$order->order_number} has been cancelled.",
                $order->id
            );
        }

        return back()->with('success', 'Order rejected.');
    }

    public function cancelOrder($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if (in_array($order->status, [Order::STATUS_DELIVERED, Order::STATUS_CANCELLED])) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $item->product?->increment('stock_quantity', $item->quantity);
                if ($item->product && $item->product->stock_status === 'out_of_stock' && $item->product->stock_quantity > 0) {
                    $item->product->update(['stock_status' => 'in_stock']);
                }
            }

            $order->update(['status' => Order::STATUS_CANCELLED]);

            if ($order->user_id) {
                Notification::createForCustomer(
                    $order->user_id,
                    'Order Cancelled',
                    "Your Order #{$order->order_number} has been cancelled.",
                    $order->id
                );
            }
        });

        return back()->with('success', 'Order cancelled successfully.');
    }

    public function invoice($id)
    {
        $order = Order::with(['items.product', 'shippingAddress', 'user'])
            ->findOrFail($id);

        $settings = Setting::pluck('value', 'key');

        return view('admin.orders.invoice', compact('order', 'settings'));
    }

    public function printInvoice($id)
    {
        $order = Order::with(['items.product', 'shippingAddress', 'user'])
            ->findOrFail($id);

        return view('admin.orders.print', compact('order'));
    }
}
