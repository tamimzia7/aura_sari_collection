@extends('layouts.app')

@section('title', 'My Orders')

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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">My Orders</h4>
                        <p class="text-muted small mb-0">View and track all your orders.</p>
                    </div>
                    <a href="{{ route('collection') }}" class="btn btn-dark btn-sm rounded-pill px-3">
                        <i class="fas fa-plus me-1"></i>Shop More
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        @if(isset($orders) && count($orders) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light small">
                                        <tr>
                                            <th class="ps-4">Order</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th class="text-end pe-4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td class="ps-4 fw-medium">#{{ $order->order_number }}</td>
                                                <td class="text-muted small">{{ $order->created_at->format('d M, Y') }}</td>
                                                <td class="small">{{ $order->items_count ?? $order->items->count() }}</td>
                                                <td class="fw-medium">₹{{ number_format($order->total, 2) }}</td>
                                                <td>
                                                    @php
                                                        $statusClasses = [
                                                            'pending' => 'warning',
                                                            'processing' => 'info',
                                                            'shipped' => 'primary',
                                                            'delivered' => 'success',
                                                            'cancelled' => 'danger',
                                                        ];
                                                        $statusIcons = [
                                                            'pending' => 'fa-clock',
                                                            'processing' => 'fa-spinner',
                                                            'shipped' => 'fa-truck',
                                                            'delivered' => 'fa-check-circle',
                                                            'cancelled' => 'fa-times-circle',
                                                        ];
                                                        $class = $statusClasses[$order->status] ?? 'secondary';
                                                        $icon = $statusIcons[$order->status] ?? 'fa-circle';
                                                    @endphp
                                                    <span class="badge bg-{{ $class }} rounded-pill">
                                                        <i class="fas {{ $icon }} me-1"></i>{{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <a href="{{ route('account.orders.details', $order->id) }}" class="btn btn-outline-dark btn-sm rounded-pill">
                                                        <i class="fas fa-eye me-1"></i>View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if(method_exists($orders, 'links'))
                                <div class="px-4 py-3 border-top">
                                    {{ $orders->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3 text-muted" style="font-size: 4rem;"><i class="fas fa-box-open"></i></div>
                                <h5 class="fw-bold">No orders yet</h5>
                                <p class="text-muted mb-3">You haven't placed any orders yet. Start exploring our collection!</p>
                                <a href="{{ route('collection') }}" class="btn btn-dark rounded-pill px-4">Browse Collection</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
