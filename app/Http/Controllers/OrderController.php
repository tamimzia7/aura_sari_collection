<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'shippingAddress', 'billingAddress'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function track($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('orders.track', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->findOrFail($id);

        if (! in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'This order cannot be cancelled');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully');
    }
}
