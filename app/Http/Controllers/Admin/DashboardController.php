<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalCollections = Collection::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::whereIn('status', ['completed', 'delivered'])->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        $inStock = Product::where('stock_status', 'in_stock')->count();
        $outOfStock = Product::where('stock_status', 'out_of_stock')->count();
        $lowStockCount = Product::where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', 5)
            ->count();

        $totalRevenue = Order::whereIn('status', ['delivered', 'completed'])->sum('grand_total');
        $monthlyRevenue = Order::whereIn('status', ['delivered', 'completed'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('grand_total');
        $todayRevenue = Order::whereIn('status', ['delivered', 'completed'])
            ->whereDate('created_at', today())
            ->sum('grand_total');

        $monthlySales = Order::whereIn('status', ['delivered', 'completed'])
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(grand_total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
        $salesChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $salesChartData[] = (float) ($monthlySales->get($i, 0));
        }

        $ordersByMonth = Order::whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');
        $ordersChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $ordersChartData[] = (int) ($ordersByMonth->get($i, 0));
        }

        $topSellingProducts = OrderItem::selectRaw('product_id, SUM(quantity) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(10)
            ->with('product')
            ->get();

        $categoryWiseProducts = Product::selectRaw('category_id, COUNT(*) as count')
            ->where('status', true)
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $recentCustomers = User::where('role', 'customer')->latest()->take(8)->get();
        $lowStockProducts = Product::with('category')
            ->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', 5)
            ->orderBy('stock_quantity')
            ->take(10)
            ->get();

        $newCustomersToday = User::where('role', 'customer')
            ->whereDate('created_at', today())
            ->count();
        $pendingReviewsCount = Review::where('is_approved', false)->count();

        return view('admin.dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalCollections',
            'totalOrders',
            'totalCustomers',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'inStock',
            'outOfStock',
            'lowStockCount',
            'totalRevenue',
            'monthlyRevenue',
            'todayRevenue',
            'salesChartData',
            'ordersChartData',
            'topSellingProducts',
            'categoryWiseProducts',
            'recentOrders',
            'recentCustomers',
            'lowStockProducts',
            'newCustomersToday',
            'pendingReviewsCount',
        ));
    }
}
