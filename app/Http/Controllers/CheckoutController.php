<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product.images')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }

        $addresses = Address::where('user_id', Auth::id())->get();
        $subtotal = $cartItems->sum(fn ($item) => ($item->product->discounted_price * $item->quantity));

        $coupon = session('coupon');
        $discount = $coupon['discount'] ?? 0;
        $shippingCost = 0;
        $tax = 0;
        $grandTotal = $subtotal - $discount + $shippingCost + $tax;

        $settings = Setting::pluck('value', 'key');

        return view('checkout.index', compact('cartItems', 'addresses', 'subtotal', 'discount', 'shippingCost', 'tax', 'grandTotal', 'settings'));
    }

    public function store(CheckoutRequest $request)
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty');
        }

        $subtotal = $cartItems->sum(fn ($item) => ($item->product->discounted_price * $item->quantity));
        $coupon = session('coupon');
        $discount = $coupon['discount'] ?? 0;
        $shippingCost = 0;
        $tax = 0;
        $grandTotal = $subtotal - $discount + $shippingCost + $tax;

        $isAdvancePayment = $request->payment_method !== 'cod';
        $paymentStatus = $isAdvancePayment ? Order::PAYMENT_PENDING_VERIFICATION : Order::PAYMENT_CASH_ON_DELIVERY;

        $order = DB::transaction(function () use ($request, $cartItems, $subtotal, $discount, $shippingCost, $tax, $grandTotal, $paymentStatus, $isAdvancePayment) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => Order::STATUS_PENDING,
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'transaction_id' => $isAdvancePayment ? $request->transaction_id : null,
                'sender_number' => $isAdvancePayment ? $request->sender_number : null,
                'shipping_address_id' => $request->shipping_address_id,
                'billing_address_id' => $request->billing_address_id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'coupon_code' => session('coupon.code'),
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'notes' => $request->notes,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'product_image' => $cartItem->product->image_url,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->discounted_price,
                    'total' => $cartItem->product->discounted_price * $cartItem->quantity,
                ]);

                $cartItem->product->decrement('stock_quantity', $cartItem->quantity);

                if ($cartItem->product->stock_quantity <= 0) {
                    $cartItem->product->update(['stock_status' => 'out_of_stock']);
                }
            }

            if ($couponCode = session('coupon.code')) {
                Coupon::where('code', $couponCode)->increment('used_count');
            }

            Cart::where('user_id', Auth::id())->delete();
            session()->forget('coupon');

            Notification::createForAdmin(
                'New Order Received',
                "Order #{$order->order_number} placed by {$order->user->name}. Total: ₹".number_format($grandTotal, 0),
                $order->id
            );

            return $order;
        });

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed successfully!');
    }

    public function directCheckout($id)
    {
        $product = Product::with('images')->findOrFail($id);

        if (! $product->isInStock) {
            return redirect()->route('products.show', $product->slug)
                ->with('error', 'This product is out of stock.');
        }

        $settings = Setting::pluck('value', 'key');
        $quantity = 1;
        $price = $product->discounted_price;
        $subtotal = $price * $quantity;
        $shippingCost = 0;
        $discount = 0;
        $grandTotal = $subtotal - $discount + $shippingCost;

        $view = view('checkout.direct', compact(
            'product', 'quantity', 'price', 'subtotal',
            'shippingCost', 'discount', 'grandTotal', 'settings'
        ));

        return $view;
    }

    public function directStore(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'string', 'in:cod,bkash,nagad,rocket'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'alt_phone' => ['nullable', 'string', 'max:20'],
            'division' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:500'],
            'transaction_id' => ['nullable', 'required_if:payment_method,bkash,nagad,rocket', 'string', 'max:255'],
            'sender_number' => ['nullable', 'string', 'max:50'],
        ], [
            'transaction_id.required_if' => 'Transaction ID is required for advance payment.',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock_quantity < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $price = $product->discounted_price;
        $subtotal = $price * $validated['quantity'];
        $shippingCost = 0;
        $grandTotal = $subtotal + $shippingCost;

        $isAdvancePayment = $validated['payment_method'] !== 'cod';
        $paymentStatus = $isAdvancePayment ? Order::PAYMENT_PENDING_VERIFICATION : Order::PAYMENT_CASH_ON_DELIVERY;

        $order = DB::transaction(function () use ($validated, $product, $price, $subtotal, $shippingCost, $grandTotal, $paymentStatus, $isAdvancePayment) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => Order::STATUS_PENDING,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $paymentStatus,
                'transaction_id' => $isAdvancePayment ? $validated['transaction_id'] : null,
                'sender_number' => $isAdvancePayment ? $validated['sender_number'] : null,
                'shipping_address_id' => null,
                'billing_address_id' => null,
                'subtotal' => $subtotal,
                'discount' => 0,
                'coupon_code' => null,
                'shipping_cost' => $shippingCost,
                'tax' => 0,
                'grand_total' => $grandTotal,
                'notes' => $validated['notes'] ?? null,
            ]);

            $shippingAddress = Address::create([
                'user_id' => Auth::id(),
                'label' => 'Shipping',
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address_line1' => $validated['address'],
                'address_line2' => $validated['area'],
                'city' => $validated['district'],
                'state' => $validated['division'],
                'zip_code' => $validated['division'],
                'country' => 'Bangladesh',
                'type' => 'shipping',
                'is_default' => false,
            ]);

            $order->update([
                'shipping_address_id' => $shippingAddress->id,
                'billing_address_id' => $shippingAddress->id,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_image' => $product->image_url,
                'quantity' => $validated['quantity'],
                'price' => $price,
                'total' => $subtotal,
            ]);

            $product->decrement('stock_quantity', $validated['quantity']);

            if ($product->stock_quantity <= 0) {
                $product->update(['stock_status' => 'out_of_stock']);
            }

            Notification::createForAdmin(
                'New Order Received',
                "Order #{$order->order_number} placed by {$order->user->name}. Total: ₹".number_format($grandTotal, 0),
                $order->id
            );

            return $order;
        });

        return redirect()->route('orders.show', $order->id)
            ->with('success', "Order #{$order->order_number} placed successfully!");
    }
}
