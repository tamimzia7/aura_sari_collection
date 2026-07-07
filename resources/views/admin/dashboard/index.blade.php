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
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-tshirt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Products</div>
                <div class="stat-value">1,248</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up me-1"></i>12.5% from last month
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">3,842</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up me-1"></i>8.2% from last month
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">$68,420</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up me-1"></i>23.1% from last month
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Customers</div>
                <div class="stat-value">2,156</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up me-1"></i>5.7% from last month
                </div>
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
                            <tr>
                                <td><a href="{{ route('admin.orders.show', 1) }}" class="text-primary-custom text-decoration-none fw-semibold">#ORD-001</a></td>
                                <td>Priya Sharma</td>
                                <td>Jul 5, 2026</td>
                                <td><span class="badge-status delivered">Delivered</span></td>
                                <td>$249.00</td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('admin.orders.show', 2) }}" class="text-primary-custom text-decoration-none fw-semibold">#ORD-002</a></td>
                                <td>Ananya Gupta</td>
                                <td>Jul 5, 2026</td>
                                <td><span class="badge-status processing">Processing</span></td>
                                <td>$189.00</td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('admin.orders.show', 3) }}" class="text-primary-custom text-decoration-none fw-semibold">#ORD-003</a></td>
                                <td>Riya Patel</td>
                                <td>Jul 4, 2026</td>
                                <td><span class="badge-status shipped">Shipped</span></td>
                                <td>$329.00</td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('admin.orders.show', 4) }}" class="text-primary-custom text-decoration-none fw-semibold">#ORD-004</a></td>
                                <td>Neha Verma</td>
                                <td>Jul 4, 2026</td>
                                <td><span class="badge-status pending">Pending</span></td>
                                <td>$159.00</td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('admin.orders.show', 5) }}" class="text-primary-custom text-decoration-none fw-semibold">#ORD-005</a></td>
                                <td>Meera Joshi</td>
                                <td>Jul 3, 2026</td>
                                <td><span class="badge-status cancelled">Cancelled</span></td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('admin.orders.show', 6) }}" class="text-primary-custom text-decoration-none fw-semibold">#ORD-006</a></td>
                                <td>Kavita Singh</td>
                                <td>Jul 3, 2026</td>
                                <td><span class="badge-status delivered">Delivered</span></td>
                                <td>$445.00</td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('admin.orders.show', 7) }}" class="text-primary-custom text-decoration-none fw-semibold">#ORD-007</a></td>
                                <td>Sunita Reddy</td>
                                <td>Jul 2, 2026</td>
                                <td><span class="badge-status delivered">Delivered</span></td>
                                <td>$275.00</td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('admin.orders.show', 8) }}" class="text-primary-custom text-decoration-none fw-semibold">#ORD-008</a></td>
                                <td>Deepika Kumar</td>
                                <td>Jul 2, 2026</td>
                                <td><span class="badge-status processing">Processing</span></td>
                                <td>$599.00</td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('admin.orders.show', 9) }}" class="text-primary-custom text-decoration-none fw-semibold">#ORD-009</a></td>
                                <td>Anjali Desai</td>
                                <td>Jul 1, 2026</td>
                                <td><span class="badge-status shipped">Shipped</span></td>
                                <td>$128.00</td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('admin.orders.show', 10) }}" class="text-primary-custom text-decoration-none fw-semibold">#ORD-010</a></td>
                                <td>Pooja Nair</td>
                                <td>Jul 1, 2026</td>
                                <td><span class="badge-status pending">Pending</span></td>
                                <td>$367.00</td>
                            </tr>
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
                    <div class="list-group-item d-flex align-items-center gap-3 px-4 py-3 border-0 border-bottom">
                        <div class="avatar-sm" style="background:#8B5CF6;">PS</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="font-size:14px;">Priya Sharma</div>
                            <div class="small text-muted">priya@example.com</div>
                        </div>
                        <span class="text-muted" style="font-size:12px;">Just now</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center gap-3 px-4 py-3 border-0 border-bottom">
                        <div class="avatar-sm" style="background:#10b981;">AG</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="font-size:14px;">Ananya Gupta</div>
                            <div class="small text-muted">ananya@example.com</div>
                        </div>
                        <span class="text-muted" style="font-size:12px;">2 hours ago</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center gap-3 px-4 py-3 border-0 border-bottom">
                        <div class="avatar-sm" style="background:#f59e0b;">RP</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="font-size:14px;">Riya Patel</div>
                            <div class="small text-muted">riya@example.com</div>
                        </div>
                        <span class="text-muted" style="font-size:12px;">4 hours ago</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center gap-3 px-4 py-3 border-0 border-bottom">
                        <div class="avatar-sm" style="background:#ef4444;">NV</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="font-size:14px;">Neha Verma</div>
                            <div class="small text-muted">neha@example.com</div>
                        </div>
                        <span class="text-muted" style="font-size:12px;">Yesterday</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center gap-3 px-4 py-3 border-0 border-bottom">
                        <div class="avatar-sm" style="background:#6366f1;">MJ</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="font-size:14px;">Meera Joshi</div>
                            <div class="small text-muted">meera@example.com</div>
                        </div>
                        <span class="text-muted" style="font-size:12px;">Yesterday</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center gap-3 px-4 py-3 border-0">
                        <div class="avatar-sm" style="background:#ec4899;">KS</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="font-size:14px;">Kavita Singh</div>
                            <div class="small text-muted">kavita@example.com</div>
                        </div>
                        <span class="text-muted" style="font-size:12px;">2 days ago</span>
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
