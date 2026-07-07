@extends('admin.layouts.admin')

@section('title', 'Edit Coupon')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Edit Coupon</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Coupons</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-soft-primary">
            <i class="fas fa-arrow-left me-1"></i> Back to Coupons
        </a>
    </div>
</div>

<form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-header">Coupon Information</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ $coupon->code }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="percentage" {{ $coupon->type === 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Value <span class="text-danger">*</span></label>
                    <input type="number" name="value" class="form-control" value="{{ $coupon->value }}" step="0.01" min="0" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Min Order Amount</label>
                    <input type="number" name="min_order_amount" class="form-control" value="{{ $coupon->min_order_amount }}" step="0.01" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Max Uses</label>
                    <input type="number" name="max_uses" class="form-control" value="{{ $coupon->max_uses }}" min="0">
                    <div class="form-text">Leave empty for unlimited uses.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Expires At</label>
                    <input type="date" name="expires_at" class="form-control" value="{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" role="switch" value="1" {{ $coupon->is_active ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Coupon</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</form>
@endsection
