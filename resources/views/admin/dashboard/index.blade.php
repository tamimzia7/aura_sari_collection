@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Dashboard</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-soft-primary" onclick="location.reload();">
            <i class="fas fa-sync-alt me-1"></i> Refresh
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
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
    <div class="col-xl-4 col-md-6">
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
    <div class="col-xl-4 col-md-6">
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
    <div class="col-xl-4 col-md-6">
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
    <div class="col-xl-4 col-md-6">
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Pending Orders</div>
                <div class="stat-value">{{ number_format($pendingOrders) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Completed Orders</div>
                <div class="stat-value">{{ number_format($completedOrders) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
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
    <div class="col-xl-4 col-md-6">
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
    <div class="col-xl-4 col-md-6">
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

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Sales Overview</span>
                <div>
                    <select class="form-select form-select-sm" style="width:auto;display:inline-block;" id="salesPeriod">
                        <option value="7">Last 7 Days</option>
                        <option value="30" selected>Last 30 Days</option>
                        <option value="90">Last 90 Days</option>
                        <option value="365">This Year</option>
                    </select>
                </div>
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
                <span>Order Status</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="orderStatusChart"></canvas>
                </div>
                <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center" id="orderStatusLegend">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Customers -->
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Orders</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-soft-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentOrders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary-custom text-decoration-none fw-semibold">#ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</a></td>
                                <td>{{ $order->user?->name ?? 'Guest' }}</td>
                                <td>{{ $order->created_at->format('M j, Y') }}</td>
                                <td><span class="badge-status {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                <td>₹{{ number_format($order->grand_total, 0) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No recent orders found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Customers</span>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-soft-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse ($recentCustomers as $customer)
                    @php
                        $colors = ['#8B5CF6', '#10b981', '#f59e0b', '#ef4444', '#6366f1', '#ec4899'];
                        $bg = $colors[$loop->index % count($colors)];
                        $initials = collect(explode(' ', $customer->name))->map(fn($part) => strtoupper(substr($part, 0, 1)))->implode('');
                    @endphp
                    <div class="list-group-item d-flex align-items-center gap-3 px-4 py-3 border-0 border-bottom">
                        <div class="avatar-sm" style="background: {{ $bg }};">{{ $initials }}</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="font-size:14px;">{{ $customer->name }}</div>
                            <div class="small text-muted">{{ $customer->email }}</div>
                        </div>
                        <span class="text-muted" style="font-size:12px;">{{ $customer->created_at->format('M j, Y') }}</span>
                    </div>
                    @empty
                    <div class="list-group-item text-center py-4 text-muted border-0">No recent customers found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const currentMonth = new Date().getMonth();

    const labels = [];
    const data = [];
    for (let i = 11; i >= 0; i--) {
        const monthIndex = (currentMonth - i + 12) % 12;
        labels.push(months[monthIndex]);
        data.push(Math.floor(Math.random() * 8000) + 2000);
    }

    new Chart(salesCtx, {
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
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1a1d23',
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return '$' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 11 },
                        color: '#9ca3af'
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(0,0,0,0.04)'
                    },
                    ticks: {
                        font: { size: 11 },
                        color: '#9ca3af',
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Order Status Donut Chart
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    const statusData = {
        labels: ['Delivered', 'Processing', 'Shipped', 'Pending', 'Cancelled'],
        data: [1420, 680, 520, 340, 182],
        colors: ['#10b981', '#3b82f6', '#f59e0b', '#8B5CF6', '#ef4444']
    };

    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusData.labels,
            datasets: [{
                data: statusData.data,
                backgroundColor: statusData.colors,
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
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1a1d23',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const pct = ((context.parsed / total) * 100).toFixed(1);
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

    // Build legend for donut chart
    const legend = document.getElementById('orderStatusLegend');
    statusData.labels.forEach(function(label, i) {
        const item = document.createElement('div');
        item.className = 'd-flex align-items-center gap-1';
        item.innerHTML = '<span style="width:10px;height:10px;border-radius:50%;background:' + statusData.colors[i] + ';display:inline-block;"></span> ' +
            '<span style="font-size:12px;color:#6c757d;">' + label + '</span>';
        legend.appendChild(item);
    });

    // Sales period change
    $('#salesPeriod').on('change', function() {
        alert('Sales period changed to: ' + $(this).val() + ' days. Will fetch from server.');
    });
});
</script>
@endpush
