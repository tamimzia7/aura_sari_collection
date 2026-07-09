@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4>Dashboard</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-soft-primary" onclick="location.reload();">
            <i class="fas fa-sync-alt me-1"></i> Refresh
        </button>
    </div>
</div>

@if($lowStockCount > 0 || $pendingOrders > 0 || $newCustomersToday > 0)
<div class="row g-3 mb-4">
    @if($lowStockCount > 0)
    <div class="col-xl-4">
        <div class="alert alert-warning d-flex align-items-center gap-3 mb-0 border-0 shadow-sm" role="alert" style="border-radius:12px;">
            <div class="flex-shrink-0" style="width:40px;height:40px;border-radius:10px;background:rgba(245,158,11,0.15);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-exclamation-triangle" style="color:#d97706;"></i>
            </div>
            <div>
                <strong>Low Stock Warning!</strong> {{ $lowStockCount }} product(s) are running low on stock.
                <a href="{{ route('admin.products.index') }}" class="alert-link">View Products</a>
            </div>
        </div>
    </div>
    @endif
    @if($pendingOrders > 0)
    <div class="col-xl-4">
        <div class="alert alert-info d-flex align-items-center gap-3 mb-0 border-0 shadow-sm" role="alert" style="border-radius:12px;">
            <div class="flex-shrink-0" style="width:40px;height:40px;border-radius:10px;background:rgba(59,130,246,0.15);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-clock" style="color:#2563eb;"></i>
            </div>
            <div>
                <strong>{{ $pendingOrders }} Pending Order(s)</strong> require your attention.
                <a href="{{ route('admin.orders.index') }}" class="alert-link">View Orders</a>
            </div>
        </div>
    </div>
    @endif
    @if($newCustomersToday > 0)
    <div class="col-xl-4">
        <div class="alert alert-success d-flex align-items-center gap-3 mb-0 border-0 shadow-sm" role="alert" style="border-radius:12px;">
            <div class="flex-shrink-0" style="width:40px;height:40px;border-radius:10px;background:rgba(16,185,129,0.15);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-user-plus" style="color:#059669;"></i>
            </div>
            <div>
                <strong>{{ $newCustomersToday }} New Customer(s)</strong> joined today.
                <a href="{{ route('admin.customers.index') }}" class="alert-link">View Customers</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endif

<div class="row g-3 mb-4">

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-tshirt"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Products</div>
                <div class="stat-value">{{ number_format($totalProducts) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-tags"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Categories</div>
                <div class="stat-value">{{ number_format($totalCategories) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon indigo"><i class="fas fa-layer-group"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Collections</div>
                <div class="stat-value">{{ number_format($totalCollections) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">{{ number_format($totalOrders) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Customers</div>
                <div class="stat-value">{{ number_format($totalCustomers) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-label">Pending Orders</div>
                <div class="stat-value">{{ number_format($pendingOrders) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-spinner"></i></div>
            <div class="stat-info">
                <div class="stat-label">Processing Orders</div>
                <div class="stat-value">{{ number_format($processingOrders) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-label">Completed Orders</div>
                <div class="stat-value">{{ number_format($completedOrders) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
            <div class="stat-info">
                <div class="stat-label">Cancelled Orders</div>
                <div class="stat-value">{{ number_format($cancelledOrders) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-box"></i></div>
            <div class="stat-info">
                <div class="stat-label">In Stock</div>
                <div class="stat-value">{{ number_format($inStock) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-box-open"></i></div>
            <div class="stat-info">
                <div class="stat-label">Out of Stock</div>
                <div class="stat-value">{{ number_format($outOfStock) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="stat-info">
                <div class="stat-label">Low Stock Items</div>
                <div class="stat-value">{{ number_format($lowStockCount) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-rupee-sign"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">₹{{ number_format($totalRevenue, 0) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-calendar-alt"></i></div>
            <div class="stat-info">
                <div class="stat-label">Monthly Revenue</div>
                <div class="stat-value">₹{{ number_format($monthlyRevenue, 0) }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-sun"></i></div>
            <div class="stat-info">
                <div class="stat-label">Today's Revenue</div>
                <div class="stat-value">₹{{ number_format($todayRevenue, 0) }}</div>
            </div>
        </div>
    </div>

</div>

<div class="row g-4 mb-4">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-chart-line me-2"></i>Monthly Sales ({{ date('Y') }})</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-chart-bar me-2"></i>Orders by Month</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-trophy me-2"></i>Top Selling Products</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="topProductsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-chart-pie me-2"></i>Category Wise Products</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clock me-2"></i>Latest Orders</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-soft-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary-custom text-decoration-none fw-semibold">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->user?->name ?? 'Guest' }}</td>
                                <td class="text-muted">{{ $order->created_at->format('M j, Y') }}</td>
                                <td>
                                    <span class="badge-status {{ $order->status }}">
                                        <i class="fas fa-{{ $order->status === 'pending' ? 'clock' : ($order->status === 'processing' ? 'spinner' : ($order->status === 'shipped' ? 'truck' : ($order->status === 'delivered' ? 'check-circle' : 'times-circle'))) }} me-1"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-end fw-semibold">₹{{ number_format($order->grand_total, 0) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No orders yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-user-plus me-2"></i>Latest Customers</span>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-soft-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentCustomers->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentCustomers as $customer)
                        <div class="list-group-item d-flex align-items-center gap-3 px-4 py-3 border-0 border-bottom">
                            <div class="avatar-md" style="background: rgba(139,92,246,0.12); color: var(--primary-color);">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <div class="fw-semibold" style="font-size:14px;">{{ $customer->name }}</div>
                                <div class="small text-muted">{{ $customer->email }}</div>
                            </div>
                            <div class="text-end flex-shrink-0">
                                <div class="small text-muted">{{ $customer->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-users fa-2x mb-2" style="color: #d1d5db;"></i>
                        <p class="mb-0">No customers yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-exclamation-triangle me-2"></i>Low Stock Products</span>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-soft-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if($lowStockProducts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($lowStockProducts as $product)
                        <div class="list-group-item d-flex align-items-center gap-3 px-4 py-3 border-0 border-bottom">
                            <div class="avatar-md" style="background: #fef3c7; color: #d97706;">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <div class="fw-semibold text-truncate" style="font-size:14px;">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                                </div>
                                <div class="small text-muted">{{ $product->category?->name ?? 'No category' }}</div>
                            </div>
                            <div class="text-end flex-shrink-0">
                                <div class="fw-bold {{ $product->stock_quantity <= 2 ? 'text-danger' : 'text-warning' }}" style="font-size:16px;">
                                    {{ $product->stock_quantity }}
                                </div>
                                <div class="small text-muted">left</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-check-circle fa-2x mb-2" style="color: #10b981;"></i>
                        <p class="mb-0">All products are well stocked.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-bolt me-2"></i>Quick Actions</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-soft-primary w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                            <i class="fas fa-plus-circle fa-lg"></i>
                            <span style="font-size:13px;">Add Product</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-soft-primary w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                            <i class="fas fa-truck fa-lg"></i>
                            <span style="font-size:13px;">Manage Orders</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-soft-success w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                            <i class="fas fa-tag fa-lg"></i>
                            <span style="font-size:13px;">Add Category</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.collections.create') }}" class="btn btn-soft-warning w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                            <i class="fas fa-layer-group fa-lg"></i>
                            <span style="font-size:13px;">Add Collection</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.coupons.create') }}" class="btn btn-soft-primary w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                            <i class="fas fa-percent fa-lg"></i>
                            <span style="font-size:13px;">Add Coupon</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.banners.create') }}" class="btn btn-soft-danger w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                            <i class="fas fa-images fa-lg"></i>
                            <span style="font-size:13px;">Add Banner</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const salesData = @json($salesChartData);
    const ordersData = @json($ordersChartData);

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue',
                data: salesData,
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139,92,246,0.08)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#8B5CF6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1d23',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return '₹' + context.parsed.y.toLocaleString('en-IN');
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#9ca3af' } },
                y: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        font: { size: 11 }, color: '#9ca3af',
                        callback: function(value) { return '₹' + value.toLocaleString('en-IN'); }
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('ordersChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Orders',
                data: ordersData,
                backgroundColor: 'rgba(59,130,246,0.7)',
                borderColor: '#3b82f6',
                borderWidth: 1,
                borderRadius: 4,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1d23',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#9ca3af' } },
                y: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { font: { size: 11 }, color: '#9ca3af', stepSize: 1 }
                }
            }
        }
    });

    new Chart(document.getElementById('topProductsChart'), {
        type: 'bar',
        data: {
            labels: @json($topSellingProducts->pluck('product.name')->map(function($n) { return $n ? \Illuminate\Support\Str::limit($n, 18) : 'N/A'; })),
            datasets: [{
                label: 'Units Sold',
                data: @json($topSellingProducts->pluck('total_qty')),
                backgroundColor: 'rgba(245,158,11,0.7)',
                borderColor: '#f59e0b',
                borderWidth: 1,
                borderRadius: 4,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1d23',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { font: { size: 11 }, color: '#9ca3af', stepSize: 1 }
                },
                y: {
                    grid: { display: false },
                    ticks: { font: { size: 10 }, color: '#6c757d' }
                }
            }
        }
    });

    const catLabels = @json($categoryWiseProducts->pluck('category.name')->map(function($n) { return $n ?? 'Uncategorized'; }));
    const catData = @json($categoryWiseProducts->pluck('count'));
    const catColors = ['#8B5CF6', '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#6366f1', '#ec4899', '#14b8a6', '#f97316', '#84cc16'];

    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: catLabels,
            datasets: [{
                data: catData,
                backgroundColor: catColors.slice(0, catData.length),
                borderWidth: 3,
                borderColor: '#fff',
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 16, usePointStyle: true, font: { size: 11 }, color: '#6c757d' }
                },
                tooltip: {
                    backgroundColor: '#1a1d23',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const pct = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + context.parsed + ' (' + pct + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush