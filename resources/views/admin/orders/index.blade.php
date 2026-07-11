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

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="search-box" style="position:relative;width:100%;">
                    <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#adb5bd;font-size:14px;"></i>
                    <input type="text" name="search" class="form-control" placeholder="Search order #, customer, email, phone..." style="padding-left:40px;" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="payment_status" class="form-select">
                    <option value="">Payment Status</option>
                    <option value="cash_on_delivery" {{ request('payment_status') === 'cash_on_delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                    <option value="pending_verification" {{ request('payment_status') === 'pending_verification' ? 'selected' : '' }}>Pending Verification</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="payment_method" class="form-select">
                    <option value="">Payment Method</option>
                    <option value="cod" {{ request('payment_method') === 'cod' ? 'selected' : '' }}>COD</option>
                    <option value="bkash" {{ request('payment_method') === 'bkash' ? 'selected' : '' }}>bKash</option>
                    <option value="nagad" {{ request('payment_method') === 'nagad' ? 'selected' : '' }}>Nagad</option>
                    <option value="rocket" {{ request('payment_method') === 'rocket' ? 'selected' : '' }}>Rocket</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-soft-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Phone / Email</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary-custom text-decoration-none fw-semibold">
                                #{{ $order->order_number }}
                            </a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @php
                                    $colors = ['#8B5CF6','#10b981','#f59e0b','#3b82f6','#ef4444','#6366f1','#ec4899','#14b8a6','#f97316','#8b5cf6','#06b6d4','#a855f7'];
                                    $bg = $colors[crc32($order->user?->name ?? $order->id) % count($colors)];
                                    $initials = $order->user ? collect(explode(' ', $order->user->name))->map(fn($p) => strtoupper(substr($p, 0, 1)))->implode('') : 'G';
                                @endphp
                                <div class="avatar-sm" style="background:{{ $bg }};">{{ $initials }}</div>
                                <span>{{ $order->user?->name ?? 'Guest' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <div>{{ $order->user?->phone ?? 'N/A' }}</div>
                                <div class="text-muted">{{ $order->user?->email ?? 'N/A' }}</div>
                            </div>
                        </td>
                        <td style="font-size:13px;color:#6c757d;white-space:nowrap;">{{ $order->created_at->format('M j, Y') }}</td>
                        <td style="text-align:center;">
                            <span class="badge bg-light text-dark">{{ $order->items->count() }}</span>
                        </td>
                        <td class="fw-semibold">₹{{ number_format($order->grand_total, 0) }}</td>
                        <td>
                            @php
                                $methodLabels = ['cod' => 'COD', 'bkash' => 'bKash', 'nagad' => 'Nagad', 'rocket' => 'Rocket'];
                                $method = $methodLabels[$order->payment_method] ?? ucfirst($order->payment_method);
                            @endphp
                            <span class="badge bg-light text-dark">{{ $method }}</span>
                        </td>
                        <td>
                            @php $ps = $order->payment_status; @endphp
                            @if($ps === 'paid')
                                <span class="badge-status active">Paid</span>
                            @elseif($ps === 'cash_on_delivery')
                                <span class="badge-status" style="background:rgba(16,185,129,0.12);color:#059669;">COD</span>
                            @elseif($ps === 'pending_verification')
                                <span class="badge-status" style="background:rgba(245,158,11,0.12);color:#d97706;">Pending Verif.</span>
                            @elseif($ps === 'pending')
                                <span class="badge-status pending">Pending</span>
                            @elseif($ps === 'refunded')
                                <span class="badge-status" style="background:rgba(99,102,241,0.12);color:#6366f1;">Refunded</span>
                            @elseif($ps === 'failed')
                                <span class="badge-status cancelled">Failed</span>
                            @else
                                <span class="badge-status">{{ ucfirst($ps) }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-status {{ $order->status === 'cancelled' ? 'cancelled' : ($order->status === 'delivered' ? 'delivered' : ($order->status === 'confirmed' ? 'active' : $order->status)) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-soft-primary btn-sm" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-soft-success btn-sm" title="Invoice" target="_blank">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="font-size:13px;color:#6c757d;">
            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
        </span>
        {{ $orders->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
