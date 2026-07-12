@extends('admin.layouts.admin')

@section('title', 'Coupons')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Coupons</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Coupons</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Coupon
        </a>
    </div>
</div>

@php
    $couponStats = (object) [
        'total' => $coupons->total(),
        'active' => \App\Models\Coupon::where('is_active', true)->where(function($q) { $q->whereNull('expires_at')->orWhere('expires_at', '>', now()); })->count(),
        'expired' => \App\Models\Coupon::where('is_active', true)->where('expires_at', '<', now())->count(),
    ];
@endphp

<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-ticket-alt"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Coupons</div>
                <div class="stat-value">{{ $couponStats->total }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-label">Active Coupons</div>
                <div class="stat-value">{{ $couponStats->active }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-label">Expired</div>
                <div class="stat-value">{{ $couponStats->expired }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Type</th>
                        <th>Uses</th>
                        <th>Min Order</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                    @php
                        $expired = $coupon->expires_at && $coupon->expires_at->isPast();
                    @endphp
                    <tr>
                        <td>
                            <span class="fw-semibold" style="font-family:monospace;font-size:14px;color:var(--sidebar-bg);">{{ $coupon->code }}</span>
                        </td>
                        <td class="fw-semibold">
                            @if($coupon->type === 'percentage')
                                {{ $coupon->value }}%
                            @else
                                ₹{{ number_format($coupon->value, 0) }}
                            @endif
                        </td>
                        <td><span style="font-size:13px;">{{ ucfirst($coupon->type) }}</span></td>
                        <td><span style="font-size:13px;">{{ $coupon->used_count ?? 0 }}{{ $coupon->max_uses ? '/'.$coupon->max_uses : '' }}</span></td>
                        <td>₹{{ number_format($coupon->min_order_amount ?? 0, 0) }}</td>
                        <td style="font-size:13px;">{{ $coupon->expires_at ? $coupon->expires_at->format('M j, Y') : 'Never' }}</td>
                        <td>
                            @if($expired)
                                <span class="badge-status inactive">Expired</span>
                            @elseif($coupon->is_active)
                                <span class="badge-status active">Active</span>
                            @else
                                <span class="badge-status draft">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-soft-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete coupon ' + @js($coupon->code) + '?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-soft-danger btn-sm" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-ticket-alt" style="font-size:3rem;color:#ddd;"></i>
                            <p class="mt-3 text-muted">No coupons found</p>
                            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm">Add Your First Coupon</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($coupons->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="font-size:13px;color:#6c757d;">
            Showing {{ $coupons->firstItem() }} to {{ $coupons->lastItem() }} of {{ $coupons->total() }} coupons
        </span>
        {{ $coupons->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

