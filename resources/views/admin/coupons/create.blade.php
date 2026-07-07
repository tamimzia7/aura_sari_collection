@extends('admin.layouts.admin')

@section('title', 'Add Coupon')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Add Coupon</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Coupons</a></li>
                <li class="breadcrumb-item active">Add New</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-soft-primary">
            <i class="fas fa-arrow-left me-1"></i> Back to Coupons
        </a>
    </div>
</div>

<form action="{{ route('admin.coupons.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-header">Coupon Information</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" placeholder="WELCOME10" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed Amount</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Value <span class="text-danger">*</span></label>
                    <input type="number" name="value" class="form-control" placeholder="10" step="0.01" min="0" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Min Order Amount</label>
                    <input type="number" name="min_order_amount" class="form-control" placeholder="0.00" step="0.01" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Max Uses</label>
                    <input type="number" name="max_uses" class="form-control" placeholder="100" min="0">
                    <div class="form-text">Leave empty for unlimited uses.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Expires At</label>
                    <input type="date" name="expires_at" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" role="switch" value="1" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Coupon</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</form>
@endsection
