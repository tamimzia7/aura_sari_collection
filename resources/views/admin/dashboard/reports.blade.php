@extends('admin.layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4>Reports</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-rupee-sign"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">₹{{ number_format($totalRevenue, 0) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">{{ number_format($totalOrders) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-chart-line me-2"></i>Monthly Revenue ({{ date('Y') }})</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-trophy me-2"></i>Top Products</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-end">Units Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $item)
                            <tr>
                                <td>{{ $item->product?->name ?? 'Deleted Product' }}</td>
                                <td class="text-end fw-semibold">{{ $item->total_qty }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-muted">No sales data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-users me-2"></i>Top Customers</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Email</th>
                                <th class="text-end">Orders</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topCustomers as $customer)
                            <tr>
                                <td class="fw-semibold">{{ $customer->name }}</td>
                                <td class="text-muted">{{ $customer->email }}</td>
                                <td class="text-end">{{ $customer->orders_count }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No customer data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
    const data = [];
    for (let i = 1; i <= 12; i++) {
        data.push({{ $monthlySales->get($i, 0) }});
    }
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: months,
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
});
</script>
@endpush
