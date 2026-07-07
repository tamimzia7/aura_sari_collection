<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected function getCartIdentifier(): string|int|null
    {
        return Auth::check() ? Auth::id() : session()->getId();
    }

    protected function getCartQuery()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id());
        }

        return Cart::where('session_id', session()->getId());
    }

    public function index()
    {
        $cartItems = $this->getCartQuery()
            ->with('product.images')
            ->get();

        $subtotal = $cartItems->sum(fn ($item) => ($item->product->discounted_price * $item->quantity));
        $cartCount = $cartItems->sum('quantity');

        return view('cart.index', compact('cartItems', 'subtotal', 'cartCount'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'variant_id' => ['nullable', 'exists:product_variants,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $product = Product::findOrFail($request->product_id);

        $data = [
            'product_id' => $product->id,
            'variant_id' => $request->variant_id,
            'quantity' => $request->quantity,
        ];

        if (Auth::check()) {
            $data['user_id'] = Auth::id();
            $data['session_id'] = null;
        } else {
            $data['session_id'] = session()->getId();
            $data['user_id'] = null;
        }

        $existing = $this->getCartQuery()
            ->where('product_id', $product->id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $request->quantity);
        } else {
            Cart::create($data);
        }

        $count = $this->getCartQuery()->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => $count,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => ['required', 'exists:carts,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $cart = $this->getCartQuery()->findOrFail($request->cart_id);
        $cart->update(['quantity' => $request->quantity]);

        $count = $this->getCartQuery()->sum('quantity');
        $subtotal = $this->getCartQuery()
            ->with('product')
            ->get()
            ->sum(fn ($item) => ($item->product->discounted_price * $item->quantity));

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'cart_count' => $count,
            'subtotal' => $subtotal,
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_id' => ['required', 'exists:carts,id'],
        ]);

        $cart = $this->getCartQuery()->findOrFail($request->cart_id);
        $cart->delete();

        $count = $this->getCartQuery()->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => $count,
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'exists:coupons,code'],
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if (! $coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code',
            ]);
        }

        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has reached its usage limit',
            ]);
        }

        $subtotal = $this->getCartQuery()
            ->with('product')
            ->get()
            ->sum(fn ($item) => ($item->product->discounted_price * $item->quantity));

        if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => "Minimum order amount of {$coupon->min_order_amount} is required",
            ]);
        }

        $discount = $coupon->type === 'percentage'
            ? ($subtotal * $coupon->value / 100)
            : min($coupon->value, $subtotal);

        session(['coupon' => ['code' => $coupon->code, 'discount' => $discount]]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully',
            'discount' => $discount,
        ]);
    }

    public function getCount()
    {
        $count = $this->getCartQuery()->sum('quantity');

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }
}
