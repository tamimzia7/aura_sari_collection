@extends('layouts.app')

@section('title', 'My Wishlist')

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
                        <a href="{{ route('dashboard.orders') }}" class="list-group-item list-group-item-action border-0 nav-link">
                            <i class="fas fa-box me-2"></i>My Orders
                        </a>
                        <a href="{{ route('dashboard.wishlist') }}" class="list-group-item list-group-item-action border-0 nav-link active">
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
                        <h4 class="fw-bold mb-1">My Wishlist</h4>
                        <p class="text-muted small mb-0">Products you've saved for later.</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        @if($wishlistItems->count() > 0)
                            <div class="row g-3">
                                @foreach($wishlistItems as $item)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-3 p-3 border rounded-3">
                                            <div style="width:80px;height:100px;background:#f8f9fa;border-radius:8px;overflow:hidden;flex-shrink:0;">
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" style="width:100%;height:100%;object-fit:cover;">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-1">{{ $item->product->name }}</h6>
                                                <div class="text-primary fw-bold mb-2">${{ number_format($item->product->discounted_price, 2) }}</div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-dark btn-sm rounded-pill"><i class="fas fa-shopping-bag me-1"></i>Add to Cart</button>
                                                    <button class="btn btn-outline-danger btn-sm rounded-pill"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3 text-muted" style="font-size: 4rem;"><i class="far fa-heart"></i></div>
                                <h5 class="fw-bold">Your wishlist is empty</h5>
                                <p class="text-muted mb-3">Save items you love to your wishlist.</p>
                                <a href="{{ route('products.index') }}" class="btn btn-dark rounded-pill px-4">Browse Collection</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
