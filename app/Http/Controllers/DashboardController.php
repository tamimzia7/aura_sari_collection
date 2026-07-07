<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $totalWishlist = Wishlist::where('user_id', $user->id)->count();
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();

        return view('dashboard.index', compact('user', 'totalOrders', 'pendingOrders', 'totalWishlist', 'recentOrders'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.Auth::id()],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = Auth::user();
        $user->update($request->only(['name', 'email']));

        return back()->with('success', 'Profile updated successfully');
    }

    public function addresses()
    {
        $addresses = Address::where('user_id', Auth::id())->get();

        return view('dashboard.addresses', compact('addresses'));
    }

    public function storeAddress(StoreAddressRequest $request)
    {
        if ($request->is_default) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        Address::create(array_merge($request->validated(), ['user_id' => Auth::id()]));

        return back()->with('success', 'Address added successfully');
    }

    public function destroyAddress($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        return back()->with('success', 'Address deleted successfully');
    }

    public function orders()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('dashboard.orders', compact('orders'));
    }

    public function orderDetails($id)
    {
        $order = Order::with(['items.product', 'shippingAddress', 'billingAddress'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('dashboard.order-details', compact('order'));
    }

    public function wishlist()
    {
        $wishlistItems = Wishlist::with('product.images')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('dashboard.wishlist', compact('wishlistItems'));
    }
}
