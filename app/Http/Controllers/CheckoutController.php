<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
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

            return $order;
        });

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed successfully!');
    }
}
