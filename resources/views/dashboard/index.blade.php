@extends('layouts.app')

@section('title', 'Dashboard')

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
    .stat-card {
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
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
                        <a href="{{ route('dashboard.index') }}" class="list-group-item list-group-item-action border-0 nav-link active">
                            <i class="fas fa-columns me-2"></i>Dashboard Overview
                        </a>
                        <a href="{{ route('dashboard.orders') }}" class="list-group-item list-group-item-action border-0 nav-link">
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">Welcome back, {{ Auth::user()->name }}!</h4>
                        <p class="text-muted small mb-0">Here's what's happening with your account today.</p>
                    </div>
                    <a href="{{ route('collection') }}" class="btn btn-dark btn-sm rounded-pill px-3">
                        <i class="fas fa-plus me-1"></i>Start Shopping
                    </a>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm rounded-3 stat-card h-100">
                            <div class="card-body text-center p-3">
                                <div class="rounded-circle bg-dark bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
                                    <i class="fas fa-shopping-bag text-dark"></i>
                                </div>
                                <h3 class="fw-bold mb-0">{{ $totalOrders ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Total Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm rounded-3 stat-card h-100">
                            <div class="card-body text-center p-3">
                                <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
                                    <i class="fas fa-clock text-warning"></i>
                                </div>
                                <h3 class="fw-bold mb-0">{{ $pendingOrders ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm rounded-3 stat-card h-100">
                            <div class="card-body text-center p-3">
                                <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
                                    <i class="far fa-heart text-danger"></i>
                                </div>
                                <h3 class="fw-bold mb-0">{{ $wishlistCount ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Wishlist</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm rounded-3 stat-card h-100">
                            <div class="card-body text-center p-3">
                                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <h3 class="fw-bold mb-0">{{ $deliveredOrders ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Delivered</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                        <h6 class="fw-bold mb-0"><i class="fas fa-clock me-2"></i>Recent Orders</h6>
                        <a href="{{ route('dashboard.orders') }}" class="small text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                    <div class="card-body p-0">
                        @if(isset($recentOrders) && count($recentOrders) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light small">
                                        <tr>
                                            <th class="ps-4">Order</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th class="text-end pe-4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentOrders as $order)
                                            <tr>
                                                <td class="ps-4 fw-medium">#{{ $order->order_number }}</td>
                                                <td class="text-muted small">{{ $order->created_at->format('d M, Y') }}</td>
                                                <td>
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
                                                    <span class="badge bg-{{ $class }} rounded-pill">{{ ucfirst($order->status) }}</span>
                                                </td>
                                                <td class="fw-medium">₹{{ number_format($order->total, 2) }}</td>
                                                <td class="text-end pe-4">
                                                    <a href="{{ route('dashboard.order-details', $order->id) }}" class="btn btn-outline-dark btn-sm rounded-pill">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3 text-muted" style="font-size: 3rem;"><i class="fas fa-box-open"></i></div>
                                <h6 class="fw-bold">No orders yet</h6>
                                <p class="text-muted small mb-3">Start exploring our collection and place your first order.</p>
                                <a href="{{ route('collection') }}" class="btn btn-dark rounded-pill btn-sm">Browse Collection</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3"><i class="fas fa-link me-2"></i>Quick Links</h6>
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('collection') }}" class="text-decoration-none text-dark d-flex align-items-center p-2 rounded bg-light bg-opacity-50">
                                        <i class="fas fa-tshirt me-3 text-muted"></i>
                                        <div>
                                            <span class="fw-medium small">Browse Collection</span>
                                            <p class="text-muted small mb-0">Explore our latest saree collection</p>
                                        </div>
                                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                                    </a>
                                    <a href="{{ route('dashboard.orders') }}" class="text-decoration-none text-dark d-flex align-items-center p-2 rounded bg-light bg-opacity-50">
                                        <i class="fas fa-box me-3 text-muted"></i>
                                        <div>
                                            <span class="fw-medium small">Track Orders</span>
                                            <p class="text-muted small mb-0">Check your order status</p>
                                        </div>
                                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                                    </a>
                                    <a href="{{ route('dashboard.wishlist') }}" class="text-decoration-none text-dark d-flex align-items-center p-2 rounded bg-light bg-opacity-50">
                                        <i class="far fa-heart me-3 text-muted"></i>
                                        <div>
                                            <span class="fw-medium small">Wishlist</span>
                                            <p class="text-muted small mb-0">Items you've saved</p>
                                        </div>
                                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                                    </a>
                                    <a href="{{ route('dashboard.profile') }}" class="text-decoration-none text-dark d-flex align-items-center p-2 rounded bg-light bg-opacity-50">
                                        <i class="far fa-user me-3 text-muted"></i>
                                        <div>
                                            <span class="fw-medium small">Profile Settings</span>
                                            <p class="text-muted small mb-0">Update your information</p>
                                        </div>
                                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3"><i class="fas fa-map-marker-alt me-2"></i>Saved Addresses</h6>
                                @if(isset($addresses) && count($addresses) > 0)
                                    @foreach($addresses->take(2) as $address)
                                        <div class="d-flex align-items-start mb-2 p-2 rounded bg-light bg-opacity-50">
                                            <i class="fas fa-map-pin me-2 mt-1 text-muted"></i>
                                            <div class="small">
                                                <span class="fw-medium">{{ $address->label ?? 'Address' }}</span>
                                                <p class="text-muted mb-0">{{ $address->address_line_1 }}, {{ $address->city }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if(count($addresses) > 2)
                                        <a href="{{ route('dashboard.addresses') }}" class="small text-decoration-none">+{{ count($addresses) - 2 }} more addresses</a>
                                    @endif
                                @else
                                    <p class="text-muted small mb-3">No saved addresses yet.</p>
                                    <a href="{{ route('dashboard.addresses') }}" class="btn btn-outline-dark btn-sm rounded-pill">Add Address</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
