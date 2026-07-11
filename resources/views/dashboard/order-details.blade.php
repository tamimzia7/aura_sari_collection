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
                        <a href="{{ route('dashboard.index') }}" class="list-group-item list-group-item-action border-0 nav-link">
                            <i class="fas fa-columns me-2"></i>Dashboard Overview
                        </a>
                        <a href="{{ route('dashboard.orders') }}" class="list-group-item list-group-item-action border-0 nav-link active">
                            <i class="fas fa-box me-2"></i>My Orders
                        </a>
                        <a href="{{ route('dashboard.wishlist') }}" class="list-group-item list-group-item-action border-0 nav-link">
                            <i class="far fa-heart me-2"></i>Wishlist
                        </a>
                        <a href="{{ route('dashboard.addresses') }}" class="list-group-item list-group-item-action border-0 nav-link">
                            <i class="fas fa-map-marker-alt me-2"></i>Addresses
                        </a>
                        <a href="{{ route('dashboard.profile') }}" class="list-group-item list-group-item-action border-0 nav-link">
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
                <a href="{{ route('dashboard.orders') }}" class="text-decoration-none small text-muted mb-3 d-inline-block">
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
                            'confirmed' => 'info',
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
                            $steps = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
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
                                        case 'confirmed': $icon = 'fa-check'; break;
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
                                <h6 class="fw-bold mb-3"><i class="fas fa-user me-2"></i>Customer Information</h6>
                                <div class="small">
                                    <p class="fw-medium mb-1">{{ $order->user->name }}</p>
                                    <p class="text-muted mb-1">{{ $order->user->email }}</p>
                                    @if($order->user->phone)
                                        <p class="text-muted mb-0">Phone: {{ $order->user->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</h6>
                                <div class="small">
                                    @if($order->shippingAddress)
                                        <p class="fw-medium mb-1">{{ $order->shippingAddress->name }}</p>
                                        <p class="text-muted mb-1">{{ $order->shippingAddress->address_line1 }}</p>
                                        @if($order->shippingAddress->address_line2)
                                            <p class="text-muted mb-1">{{ $order->shippingAddress->address_line2 }}</p>
                                        @endif
                                        <p class="text-muted mb-1">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->zip_code }}</p>
                                        <p class="text-muted mb-0">Phone: {{ $order->shippingAddress->phone }}</p>
                                    @endif
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
                                        <th>Image</th>
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
                                                    <span class="fw-medium">{{ $item->product_name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($item->product_image)
                                                    <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}" class="rounded" style="width: 56px; height: 72px; object-fit: cover;" onerror="this.style.display='none'">
                                                @else
                                                    <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 56px; height: 72px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="small">₹{{ number_format($item->price, 0) }}</td>
                                            <td class="small">{{ $item->quantity }}</td>
                                            <td class="text-end pe-4 fw-medium">₹{{ number_format($item->total, 0) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3"><i class="fas fa-credit-card me-2"></i>Payment Information</h6>
                                <div class="small">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Method:</span>
                                        <span class="fw-medium">
                                            @php
                                                $methodLabels = ['cod' => 'Cash on Delivery', 'bkash' => 'bKash', 'nagad' => 'Nagad', 'rocket' => 'Rocket'];
                                            @endphp
                                            {{ $methodLabels[$order->payment_method] ?? ucfirst($order->payment_method) }}
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Status:</span>
                                        @php $ps = $order->payment_status; @endphp
                                        @if($ps === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($ps === 'cash_on_delivery')
                                            <span class="badge bg-info text-dark">Cash on Delivery</span>
                                        @elseif($ps === 'pending_verification')
                                            <span class="badge bg-warning text-dark">Pending Verification</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $ps }}</span>
                                        @endif
                                    </div>
                                    @if($order->transaction_id)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Transaction ID:</span>
                                        <span class="fw-medium">{{ $order->transaction_id }}</span>
                                    </div>
                                    @endif
                                    @if($order->sender_number)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Sender Number:</span>
                                        <span>{{ $order->sender_number }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3"><i class="fas fa-receipt me-2"></i>Order Summary</h6>
                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-muted">Subtotal</span>
                                    <span>₹{{ number_format($order->subtotal, 0) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-muted">Delivery Charge</span>
                                    <span>{{ $order->shipping_cost > 0 ? '₹'.number_format($order->shipping_cost, 0) : 'Free' }}</span>
                                </div>
                                @if($order->discount > 0)
                                    <div class="d-flex justify-content-between mb-2 small">
                                        <span class="text-muted">Discount</span>
                                        <span class="text-success">-₹{{ number_format($order->discount, 0) }}</span>
                                    </div>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span>
                                    <span class="fs-5">₹{{ number_format($order->grand_total, 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(in_array($order->status, ['pending', 'confirmed', 'processing']))
                    <div class="text-center mt-4">
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-ban me-1"></i> Cancel Order</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
