@extends('layouts.app')

@section('title', 'My Addresses')

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
    .address-card .card-body {
        transition: border-color 0.2s;
    }
    .address-card:hover .card-body {
        border-color: #1a1a1a;
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
                        <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action border-0 nav-link">
                            <i class="fas fa-box me-2"></i>My Orders
                        </a>
                        <a href="{{ route('account.wishlist') }}" class="list-group-item list-group-item-action border-0 nav-link">
                            <i class="far fa-heart me-2"></i>Wishlist
                        </a>
                        <a href="{{ route('account.addresses') }}" class="list-group-item list-group-item-action border-0 nav-link active">
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
                        <h4 class="fw-bold mb-1">My Addresses</h4>
                        <p class="text-muted small mb-0">Manage your shipping and billing addresses.</p>
                    </div>
                    <button type="button" class="btn btn-dark rounded-pill btn-sm px-3" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        <i class="fas fa-plus me-1"></i>Add New Address
                    </button>
                </div>

                @if(isset($addresses) && count($addresses) > 0)
                    <div class="row g-3">
                        @foreach($addresses as $address)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm rounded-3 address-card h-100">
                                    <div class="card-body p-4 position-relative border border-2 border-transparent rounded-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <span class="fw-medium">{{ $address->label ?? 'Address' }}</span>
                                                @if($address->is_default)
                                                    <span class="badge bg-dark rounded-pill ms-2 small">Default</span>
                                                @endif
                                                @if($address->type === 'billing')
                                                    <span class="badge bg-secondary rounded-pill ms-1 small">Billing</span>
                                                @endif
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end rounded-3 shadow-sm border-0">
                                                    <li>
                                                        <button class="dropdown-item small" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">
                                                            <i class="far fa-edit me-2"></i>Edit
                                                        </button>
                                                    </li>
                                                    @if(!$address->is_default)
                                                        <li>
                                                            <form method="POST" action="{{ route('account.addresses.default', $address->id) }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="dropdown-item small">
                                                                    <i class="fas fa-check-circle me-2"></i>Set as Default
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form method="POST" action="{{ route('account.addresses.destroy', $address->id) }}" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item small text-danger">
                                                                <i class="far fa-trash-alt me-2"></i>Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="small">
                                            <p class="fw-medium mb-1">{{ $address->name }}</p>
                                            <p class="text-muted mb-1">{{ $address->address_line_1 }}</p>
                                            @if($address->address_line_2)
                                                <p class="text-muted mb-1">{{ $address->address_line_2 }}</p>
                                            @endif
                                            <p class="text-muted mb-1">{{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}</p>
                                            <p class="text-muted mb-0">Phone: {{ $address->phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(false)
                            <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow rounded-4">
                                        <div class="modal-header border-0 p-4 pb-0">
                                            <h5 class="modal-title fw-bold">Edit Address</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form method="POST" action="{{ route('account.addresses.update', $address->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label class="form-label small fw-medium">Label</label>
                                                    <input type="text" class="form-control" name="label" value="{{ $address->label }}" placeholder="e.g. Home, Office">
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-medium">Full Name</label>
                                                        <input type="text" class="form-control" name="name" value="{{ $address->name }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-medium">Phone</label>
                                                        <input type="tel" class="form-control" name="phone" value="{{ $address->phone }}" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-medium">Address Line 1</label>
                                                    <input type="text" class="form-control" name="address_line_1" value="{{ $address->address_line_1 }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-medium">Address Line 2</label>
                                                    <input type="text" class="form-control" name="address_line_2" value="{{ $address->address_line_2 }}">
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label small fw-medium">City</label>
                                                        <input type="text" class="form-control" name="city" value="{{ $address->city }}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small fw-medium">State</label>
                                                        <input type="text" class="form-control" name="state" value="{{ $address->state }}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small fw-medium">Pincode</label>
                                                        <input type="text" class="form-control" name="pincode" value="{{ $address->pincode }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="is_default" id="editDefault{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }}>
                                                    <label class="form-check-label small" for="editDefault{{ $address->id }}">Set as default address</label>
                                                </div>
                                                <button type="submit" class="btn btn-dark w-100 rounded-pill">Update Address</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body text-center py-5">
                            <div class="mb-3 text-muted" style="font-size: 4rem;"><i class="fas fa-map-marker-alt"></i></div>
                            <h5 class="fw-bold">No addresses saved</h5>
                            <p class="text-muted mb-3">Add a delivery address to start shopping.</p>
                            <button type="button" class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="fas fa-plus me-1"></i>Add Address
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2"></i>Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route('account.addresses.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Label</label>
                        <input type="text" class="form-control @error('label') is-invalid @enderror" name="label" value="{{ old('label') }}" placeholder="e.g. Home, Office">
                        @error('label') <span class="invalid-feedback small">{{ $message }}</span> @enderror
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                            @error('name') <span class="invalid-feedback small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Phone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>
                            @error('phone') <span class="invalid-feedback small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Address Line 1</label>
                        <input type="text" class="form-control @error('address_line_1') is-invalid @enderror" name="address_line_1" value="{{ old('address_line_1') }}" required>
                        @error('address_line_1') <span class="invalid-feedback small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Address Line 2</label>
                        <input type="text" class="form-control @error('address_line_2') is-invalid @enderror" name="address_line_2" value="{{ old('address_line_2') }}">
                        @error('address_line_2') <span class="invalid-feedback small">{{ $message }}</span> @enderror
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-medium">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required>
                            @error('city') <span class="invalid-feedback small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-medium">State</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" required>
                            @error('state') <span class="invalid-feedback small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-medium">Pincode</label>
                            <input type="text" class="form-control @error('pincode') is-invalid @enderror" name="pincode" value="{{ old('pincode') }}" required>
                            @error('pincode') <span class="invalid-feedback small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_default" id="addDefault">
                        <label class="form-check-label small" for="addDefault">Set as default address</label>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 rounded-pill">Save Address</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
