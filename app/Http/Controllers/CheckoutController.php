<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
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

        return view('checkout.index', compact('cartItems', 'addresses', 'subtotal', 'discount', 'shippingCost', 'tax', 'grandTotal'));
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

        $order = DB::transaction(function () use ($request, $cartItems, $subtotal, $discount, $shippingCost, $tax, $grandTotal) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
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
            }

            if ($couponCode = session('coupon.code')) {
                Coupon::where('code', $couponCode)->increment('used_count');
            }

            Cart::where('user_id', Auth::id())->delete();
            session()->forget('coupon');

            return $order;
        });

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed successfully!');
    }
}
