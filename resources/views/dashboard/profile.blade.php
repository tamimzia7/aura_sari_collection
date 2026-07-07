@extends('layouts.app')

@section('title', 'Profile Settings')

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
                        <a href="{{ route('dashboard.index') }}" class="list-group-item list-group-item-action border-0 nav-link">
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
                        <a href="{{ route('dashboard.profile') }}" class="list-group-item list-group-item-action border-0 nav-link active">
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
                <div class="mb-4">
                    <h4 class="fw-bold mb-1">Profile Settings</h4>
                    <p class="text-muted small mb-0">Manage your personal information and password.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-3 alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white border-0 p-4">
                        <h6 class="fw-bold mb-0"><i class="far fa-user me-2"></i>Personal Information</h6>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <form method="POST" action="{{ route('dashboard.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label small fw-medium">Full Name</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                    @error('name') <span class="invalid-feedback small"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label small fw-medium">Email Address</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email') <span class="invalid-feedback small"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label small fw-medium">Phone Number</label>
                                    <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                                    @error('phone') <span class="invalid-feedback small"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-dark rounded-pill px-4">
                                    <i class="fas fa-save me-1"></i>Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-0 p-4">
                        <h6 class="fw-bold mb-0"><i class="fas fa-lock me-2"></i>Change Password</h6>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <form method="POST" action="{{ route('dashboard.password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="current_password" class="form-label small fw-medium">Current Password</label>
                                    <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current-password">
                                    @error('current_password') <span class="invalid-feedback small"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="new_password" class="form-label small fw-medium">New Password</label>
                                    <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new-password">
                                    @error('new_password') <span class="invalid-feedback small"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="new_password_confirmation" class="form-label small fw-medium">Confirm New Password</label>
                                    <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mt-3 small text-muted">
                                <i class="fas fa-info-circle me-1"></i>Password must be at least 8 characters long.
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-dark rounded-pill px-4">
                                    <i class="fas fa-key me-1"></i>Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
