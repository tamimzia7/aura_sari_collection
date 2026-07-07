@extends('layouts.app')

@section('title', 'Order Details')

@push('styles')
<style>
    .dashboard-sidebar .nav-link {
        color: #555;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .dashboard-sidebar .nav-link:hover,
    .dashboard-sidebar .nav-link.active {
        background: #f0f0f0;
        color: #1a1a1a;
    }
    .dashboard-sidebar .nav-link i {
        width: 1.5rem;
    }
    .status-timeline .timeline-item {
        position: relative;
        padding-left: 2rem;
        padding-bottom: 1.5rem;
    }
    .status-timeline .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 0.6rem;
        top: 1.5rem;
        bottom: 0;
        width: 2px;
        background: #e0e0e0;
    }
    .status-timeline .timeline-icon {
        position: absolute;
        left: 0;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6rem;
        color: #fff;
    }
    .status-timeline .timeline-icon.completed {
        background: #198754;
    }
    .status-timeline .timeline-icon.current {
        background: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
    }
    .status-timeline .timeline-icon.pending-state {
        background: #adb5bd;
    }
</style>
@endpush

@section('content')
<div class="bg-light min-vh-100 py-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-dark text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                            <span class="fw-bold fs-5">{{ substr(Auth::user()->name, 0, 2) }}</span>
                        </div>
                        <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                        <p class="text-muted small">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="list-group list-group-flush dashboard-sidebar border-0">
                        <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action border-0 nav-link">
                            <i class="fas fa-columns me-2"></i>Dashboard Overview
                        </a>
                        <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action border-0 nav-link active">
                            <i class="fas fa-box me-2"></i>My Orders
                        </a>
                        <a href="{{ route('account.wishlist') }}" class="list-group-item list-group-item-action border-0 nav-link">
                            <i class="far fa-heart me-2"></i>Wishlist
                        </a>
                        <a href="{{ route('account.addresses') }}" class="list-group-item list-group-item-action border-0 nav-link">
                            <i class="fas fa-map-marker-alt me-2"></i>Addresses
                        </a>
                        <a href="{{ route('account.profile') }}" class="list-group-item list-group-item-action border-0 nav-link">
                            <i class="far fa-user me-2"></i>Profile Settings
                        </a>
                        <a class="list-group-item list-group-item-action border-0 nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <a href="{{ route('account.orders') }}" class="text-decoration-none small text-muted mb-3 d-inline-block">
                    <i class="fas fa-chevron-left me-1"></i>Back to Orders
                </a>

                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">Order #{{ $order->order_number }}</h4>
                        <p class="text-muted small mb-0">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    @php
                        $statusClasses = [
                            'pending' => 'warning',
                            'processing' => 'info',
                            'shipped' => 'primary',
                            'delivered' => 'success',
                            'cancelled' => 'danger',
                        ];
                        $class = $statusClasses[$order->status] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $class }} fs-6 px-3 py-2 rounded-pill">{{ ucfirst($order->status) }}</span>
                </div>

                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white border-0 p-4">
                        <h6 class="fw-bold mb-0"><i class="fas fa-clock me-2"></i>Order Status</h6>
                    </div>
                    <div class="card-body px-4 pb-4 pt-0">
                        @php
                            $steps = ['pending', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($order->status, $steps);
                            if ($order->status === 'cancelled') $currentIndex = -1;
                        @endphp
                        <div class="status-timeline">
                            @foreach($steps as $i => $step)
                                @php
                                    $icon = '';
                                    $label = ucfirst($step);
                                    switch($step) {
                                        case 'pending': $icon = 'fa-receipt'; break;
                                        case 'processing': $icon = 'fa-spinner'; break;
                                        case 'shipped': $icon = 'fa-truck'; break;
                                        case 'delivered': $icon = 'fa-check'; break;
                                    }
                                    if ($order->status === 'cancelled') {
                                        $stateClass = $i <= $currentIndex ? 'completed' : 'pending-state';
                                    } else {
                                        $stateClass = $i < $currentIndex ? 'completed' : ($i === $currentIndex ? 'current' : 'pending-state');
                                    }
                                @endphp
                                <div class="timeline-item">
                                    <div class="timeline-icon {{ $stateClass }}">
                                        <i class="fas {{ $icon }}"></i>
                                    </div>
                                    <div>
                                        <span class="fw-medium small">{{ $label }}</span>
                                        @if($i === $currentIndex && $order->status !== 'cancelled')
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill ms-2 small">Current</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            @if($order->status === 'cancelled')
                                <div class="timeline-item">
                                    <div class="timeline-icon completed" style="background: #dc3545;">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <div>
                                        <span class="fw-medium small text-danger">Cancelled</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</h6>
                                <div class="small">
                                    <p class="fw-medium mb-1">{{ $order->shipping_name }}</p>
                                    <p class="text-muted mb-1">{{ $order->shipping_address_line_1 }}</p>
                                    @if($order->shipping_address_line_2)
                                        <p class="text-muted mb-1">{{ $order->shipping_address_line_2 }}</p>
                                    @endif
                                    <p class="text-muted mb-1">{{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}</p>
                                    <p class="text-muted mb-0">Phone: {{ $order->shipping_phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3"><i class="fas fa-file-invoice me-2"></i>Billing Address</h6>
                                <div class="small">
                                    <p class="fw-medium mb-1">{{ $order->billing_name ?? $order->shipping_name }}</p>
                                    <p class="text-muted mb-1">{{ $order->billing_address_line_1 ?? $order->shipping_address_line_1 }}</p>
                                    @if($order->billing_address_line_2 ?? $order->shipping_address_line_2)
                                        <p class="text-muted mb-1">{{ $order->billing_address_line_2 ?? $order->shipping_address_line_2 }}</p>
                                    @endif
                                    <p class="text-muted mb-1">{{ $order->billing_city ?? $order->shipping_city }}, {{ $order->billing_state ?? $order->shipping_state }} - {{ $order->billing_pincode ?? $order->shipping_pincode }}</p>
                                    <p class="text-muted mb-0">Phone: {{ $order->billing_phone ?? $order->shipping_phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white border-0 p-4">
                        <h6 class="fw-bold mb-0"><i class="fas fa-shopping-bag me-2"></i>Order Items</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th class="ps-4">Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th class="text-end pe-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    @if($item->product && $item->product->primaryImage)
                                                        <img src="{{ $item->product->primaryImage->url }}" alt="{{ $item->product_name }}" class="rounded" style="width: 56px; height: 72px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 56px; height: 72px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div class="small">
                                                        <span class="fw-medium">{{ $item->product_name }}</span>
                                                        @if($item->variant)
                                                            <p class="text-muted mb-0">{{ $item->variant }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="small">₹{{ number_format($item->price, 2) }}</td>
                                            <td class="small">{{ $item->quantity }}</td>
                                            <td class="text-end pe-4 fw-medium">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <div class="row justify-content-end">
                            <div class="col-md-5">
                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-muted">Subtotal</span>
                                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-muted">Shipping</span>
                                    <span>{{ $order->shipping > 0 ? '₹'.number_format($order->shipping, 2) : 'Free' }}</span>
                                </div>
                                @if($order->discount > 0)
                                    <div class="d-flex justify-content-between mb-2 small">
                                        <span class="text-muted">Discount</span>
                                        <span class="text-success">-₹{{ number_format($order->discount, 2) }}</span>
                                    </div>
                                @endif
                                @if($order->tax > 0)
                                    <div class="d-flex justify-content-between mb-2 small">
                                        <span class="text-muted">Tax</span>
                                        <span>₹{{ number_format($order->tax, 2) }}</span>
                                    </div>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span>
                                    <span class="fs-5">₹{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
