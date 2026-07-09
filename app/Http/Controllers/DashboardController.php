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
    public function index()
    {
        $user = Auth::user();
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        $deliveredOrders = Order::where('user_id', $user->id)->where('status', 'delivered')->count();
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        $addresses = Address::where('user_id', $user->id)->get();

        return view('dashboard.index', compact('user', 'totalOrders', 'pendingOrders', 'wishlistCount', 'deliveredOrders', 'recentOrders', 'addresses'));
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
        $user->update($request->only(['name', 'email', 'phone']));

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

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => bcrypt($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully');
    }

    public function updateAddress(Request $request, $id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);

        if ($request->is_default) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        $request->validate([
            'label' => ['nullable', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address_line_1' => ['nullable', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $address->update($request->all());

        return back()->with('success', 'Address updated successfully');
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
