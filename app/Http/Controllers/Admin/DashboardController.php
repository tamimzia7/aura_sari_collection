<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('status', ['delivered', 'completed'])->sum('grand_total');
        $totalCustomers = User::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard.index', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'totalCustomers',
            'pendingOrders',
            'processingOrders',
            'recentOrders',
        ));
    }
}
