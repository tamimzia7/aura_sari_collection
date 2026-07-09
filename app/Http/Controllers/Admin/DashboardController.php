<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalCollections = Collection::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::whereIn('status', ['completed', 'delivered'])->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $inStock = Product::where('stock_status', 'in_stock')->count();
        $outOfStock = Product::where('stock_status', 'out_of_stock')->count();
        $totalRevenue = Order::whereIn('status', ['delivered', 'completed'])->sum('grand_total');
        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $recentCustomers = User::where('role', '!=', 'admin')->latest()->take(6)->get();

        return view('admin.dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalCollections',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'totalCustomers',
            'inStock',
            'outOfStock',
            'totalRevenue',
            'recentOrders',
            'recentCustomers',
        ));
    }
}
