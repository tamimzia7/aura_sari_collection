@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4>Dashboard</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
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

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-tshirt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Products</div>
                <div class="stat-value">{{ number_format($totalProducts) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Categories</div>
                <div class="stat-value">{{ number_format($totalCategories) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon indigo">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Collections</div>
                <div class="stat-value">{{ number_format($totalCollections) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">{{ number_format($totalOrders) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Customers</div>
                <div class="stat-value">{{ number_format($totalCustomers) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">₹{{ number_format($totalRevenue, 0) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">In Stock</div>
                <div class="stat-value">{{ number_format($inStock) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Out of Stock</div>
                <div class="stat-value">{{ number_format($outOfStock) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-line me-2"></i>Sales Overview</span>
                <select class="form-select form-select-sm" style="width:auto;display:inline-block;" id="salesPeriod">
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                    <option value="90">Last 90 Days</option>
                    <option value="365">This Year</option>
                </select>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-chart-pie me-2"></i>Order Status</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="orderStatusChart"></canvas>
                </div>
                <div class="mt-3 d-flex flex-wrap gap-3 justify-content-center" id="orderStatusLegend"></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clock me-2"></i>Recent Orders</span>
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
                                        <i class="fas {{ $order->status === 'pending' ? 'fa-clock' : ($order->status === 'processing' ? 'fa-spinner' : ($order->status === 'shipped' ? 'fa-truck' : ($order->status === 'delivered' ? 'fa-check-circle' : 'fa-times-circle'))) }} me-1"></i>
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
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const currentMonth = new Date().getMonth();
    const labels = [];
    const data = [];
    for (let i = 11; i >= 0; i--) {
        const monthIndex = (currentMonth - i + 12) % 12;
        labels.push(months[monthIndex]);
        data.push(Math.floor(Math.random() * 8000) + 2000);
    }
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue',
                data: data,
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
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 }, color: '#9ca3af' }
                },
                y: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        font: { size: 11 },
                        color: '#9ca3af',
                        callback: function(value) {
                            return '₹' + value.toLocaleString('en-IN');
                        }
                    }
                }
            }
        }
    });
    new Chart(document.getElementById('orderStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'Processing', 'Shipped', 'Pending', 'Cancelled'],
            datasets: [{
                data: [{{ $completedOrders }}, {{ $processingOrders }}, 0, {{ $pendingOrders }}, 0],
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#8B5CF6', '#ef4444'],
                borderWidth: 3,
                borderColor: '#fff',
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false },
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
        },
        plugins: [{
            afterDraw: function(chart) {
                const { ctx, data, chartArea: { width, height, top } } = chart;
                const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                ctx.save();
                ctx.font = '700 24px Inter, sans-serif';
                ctx.fillStyle = '#1a1d23';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(total.toLocaleString(), width / 2, top + height / 2 - 8);
                ctx.font = '12px Inter, sans-serif';
                ctx.fillStyle = '#9ca3af';
                ctx.fillText('Total Orders', width / 2, top + height / 2 + 16);
                ctx.restore();
            }
        }]
    });
    const legend = document.getElementById('orderStatusLegend');
    if (legend) {
        const items = [
            { label: 'Delivered', color: '#10b981' },
            { label: 'Processing', color: '#3b82f6' },
            { label: 'Pending', color: '#8B5CF6' },
        ];
        items.forEach(function(item) {
            const el = document.createElement('div');
            el.className = 'd-flex align-items-center gap-1';
            el.innerHTML = '<span style="width:10px;height:10px;border-radius:50%;background:' + item.color + ';display:inline-block;"></span> <span style="font-size:12px;color:#6c757d;">' + item.label + '</span>';
            legend.appendChild(el);
        });
    }
});
</script>
@endpush