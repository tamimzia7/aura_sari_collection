<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class ReportsController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::whereIn('status', ['delivered', 'completed'])->sum('grand_total');
        $totalOrders = Order::count();

        $monthlySales = Order::whereIn('status', ['delivered', 'completed'])
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(grand_total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $topProducts = OrderItem::selectRaw('product_id, SUM(quantity) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(10)
            ->with('product')
            ->get();

        $topCustomers = User::where('role', 'customer')
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->take(10)
            ->get();

        return view('admin.dashboard.reports', compact(
            'totalRevenue',
            'totalOrders',
            'monthlySales',
            'topProducts',
            'topCustomers',
        ));
    }
}
