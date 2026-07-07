@extends('admin.layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Orders</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-soft-primary" onclick="location.reload();">
            <i class="fas fa-sync-alt me-1"></i> Refresh
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="search-box" style="position:relative;width:100%;">
                    <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#adb5bd;font-size:14px;"></i>
                    <input type="text" class="form-control" placeholder="Search order # or customer..." style="padding-left:40px;">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">All Status</option>
                    <option>Pending</option>
                    <option>Processing</option>
                    <option>Shipped</option>
                    <option>Delivered</option>
                    <option>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">Payment Status</option>
                    <option>Paid</option>
                    <option>Pending</option>
                    <option>Failed</option>
                    <option>Refunded</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">Date Range</option>
                    <option>Today</option>
                    <option>This Week</option>
                    <option>This Month</option>
                    <option>This Year</option>
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-soft-primary w-100"><i class="fas fa-filter"></i></button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th style="width:100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $orders = [
                            ['id' => 'ORD-001', 'customer' => 'Priya Sharma', 'date' => 'Jul 5, 2026', 'status' => 'Delivered', 'items' => 3, 'total' => 24900, 'payment' => 'Paid'],
                            ['id' => 'ORD-002', 'customer' => 'Ananya Gupta', 'date' => 'Jul 5, 2026', 'status' => 'Processing', 'items' => 2, 'total' => 18900, 'payment' => 'Paid'],
                            ['id' => 'ORD-003', 'customer' => 'Riya Patel', 'date' => 'Jul 4, 2026', 'status' => 'Shipped', 'items' => 4, 'total' => 32900, 'payment' => 'Paid'],
                            ['id' => 'ORD-004', 'customer' => 'Neha Verma', 'date' => 'Jul 4, 2026', 'status' => 'Pending', 'items' => 1, 'total' => 15900, 'payment' => 'Pending'],
                            ['id' => 'ORD-005', 'customer' => 'Meera Joshi', 'date' => 'Jul 3, 2026', 'status' => 'Cancelled', 'items' => 2, 'total' => 0, 'payment' => 'Refunded'],
                            ['id' => 'ORD-006', 'customer' => 'Kavita Singh', 'date' => 'Jul 3, 2026', 'status' => 'Delivered', 'items' => 5, 'total' => 44500, 'payment' => 'Paid'],
                            ['id' => 'ORD-007', 'customer' => 'Sunita Reddy', 'date' => 'Jul 2, 2026', 'status' => 'Delivered', 'items' => 2, 'total' => 27500, 'payment' => 'Paid'],
                            ['id' => 'ORD-008', 'customer' => 'Deepika Kumar', 'date' => 'Jul 2, 2026', 'status' => 'Processing', 'items' => 3, 'total' => 59900, 'payment' => 'Paid'],
                            ['id' => 'ORD-009', 'customer' => 'Anjali Desai', 'date' => 'Jul 1, 2026', 'status' => 'Shipped', 'items' => 1, 'total' => 12800, 'payment' => 'Paid'],
                            ['id' => 'ORD-010', 'customer' => 'Pooja Nair', 'date' => 'Jul 1, 2026', 'status' => 'Pending', 'items' => 2, 'total' => 36700, 'payment' => 'Pending'],
                            ['id' => 'ORD-011', 'customer' => 'Ritu Agarwal', 'date' => 'Jun 30, 2026', 'status' => 'Delivered', 'items' => 3, 'total' => 41200, 'payment' => 'Paid'],
                            ['id' => 'ORD-012', 'customer' => 'Shalini Iyer', 'date' => 'Jun 29, 2026', 'status' => 'Cancelled', 'items' => 1, 'total' => 0, 'payment' => 'Refunded'],
                        ];
                    @endphp

                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', 1) }}" class="text-primary-custom text-decoration-none fw-semibold">
                                #{{ $order['id'] }}
                            </a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-sm" style="background:{{ ['#8B5CF6','#10b981','#f59e0b','#3b82f6','#ef4444','#6366f1','#ec4899','#14b8a6','#f97316','#8b5cf6','#06b6d4','#a855f7'][$loop->index % 12] }};">
                                    {{ preg_replace('/[^A-Z]/', '', $order['customer']) }}
                                </div>
                                <span>{{ $order['customer'] }}</span>
                            </div>
                        </td>
                        <td style="font-size:13px;color:#6c757d;">{{ $order['date'] }}</td>
                        <td>
                            @if($order['status'] === 'Delivered')
                                <span class="badge-status delivered">Delivered</span>
                            @elseif($order['status'] === 'Processing')
                                <span class="badge-status processing">Processing</span>
                            @elseif($order['status'] === 'Shipped')
                                <span class="badge-status shipped">Shipped</span>
                            @elseif($order['status'] === 'Pending')
                                <span class="badge-status pending">Pending</span>
                            @elseif($order['status'] === 'Cancelled')
                                <span class="badge-status cancelled">Cancelled</span>
                            @endif
                        </td>
                        <td style="text-align:center;">{{ $order['items'] }}</td>
                        <td class="fw-semibold">${{ number_format($order['total'] / 100, 2) }}</td>
                        <td>
                            @if($order['payment'] === 'Paid')
                                <span class="badge-status active">Paid</span>
                            @elseif($order['payment'] === 'Pending')
                                <span class="badge-status pending">Pending</span>
                            @elseif($order['payment'] === 'Refunded')
                                <span class="badge-status" style="background:rgba(99,102,241,0.12);color:#6366f1;">Refunded</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.orders.show', 1) }}" class="btn btn-soft-primary btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-soft-warning btn-sm" title="Print">
                                    <i class="fas fa-print"></i>
                                </button>
                                <button class="btn btn-soft-danger btn-sm" title="Delete" onclick="confirmDelete('{{ $order['id'] }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="font-size:13px;color:#6c757d;">Showing 1 to 12 of 342 orders</span>
        <nav>
            <ul class="pagination pagination-sm">
                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">29</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete order ' + id + '?')) {
        alert('Delete functionality will be implemented.');
    }
}
</script>
@endpush
