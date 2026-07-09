<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::with('product.images')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();

            return response()->json([
                'success' => true,
                'added' => false,
                'message' => 'Removed from wishlist',
            ]);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'success' => true,
            'added' => true,
            'message' => 'Added to wishlist',
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'wishlist_id' => ['required', 'exists:wishlists,id'],
        ]);

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->findOrFail($request->wishlist_id);

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Removed from wishlist',
        ]);
    }

    public function moveToCart(Request $request)
    {
        $request->validate([
            'wishlist_id' => ['required', 'exists:wishlists,id'],
        ]);

        $wishlist = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->findOrFail($request->wishlist_id);

        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $wishlist->product_id)
            ->first();

        if ($existingCart) {
            $existingCart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $wishlist->product_id,
                'quantity' => 1,
            ]);
        }

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Moved to cart',
        ]);
    }
}
