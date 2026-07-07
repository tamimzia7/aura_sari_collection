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
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCouponModal">
            <i class="fas fa-plus me-1"></i> Add Coupon
        </button>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-ticket-alt"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Coupons</div>
                <div class="stat-value">18</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-label">Active Coupons</div>
                <div class="stat-value">12</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-times-circle"></i></div>
            <div class="stat-info">
                <div class="stat-label">Expired</div>
                <div class="stat-value">4</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-dollar-sign"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Discount Given</div>
                <div class="stat-value">$4,280</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="search-box" style="position:relative;width:100%;">
                    <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#adb5bd;font-size:14px;"></i>
                    <input type="text" class="form-control" placeholder="Search coupons..." style="padding-left:40px;">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Expired</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">Discount Type</option>
                    <option>All</option>
                    <option>Percentage</option>
                    <option>Fixed Amount</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-soft-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button>
            </div>
        </div>

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
                    @php
                        $coupons = [
                            ['code' => 'WELCOME10', 'discount' => '10%', 'type' => 'Percentage', 'uses' => '45/100', 'min' => '$50', 'expiry' => 'Dec 31, 2026', 'status' => 'Active'],
                            ['code' => 'SAVE50', 'discount' => '$50', 'type' => 'Fixed', 'uses' => '12/50', 'min' => '$200', 'expiry' => 'Aug 15, 2026', 'status' => 'Active'],
                            ['code' => 'FESTIVE20', 'discount' => '20%', 'type' => 'Percentage', 'uses' => '89/200', 'min' => '$100', 'expiry' => 'Nov 1, 2026', 'status' => 'Active'],
                            ['code' => 'NEWUSER', 'discount' => '15%', 'type' => 'Percentage', 'uses' => '200/500', 'min' => '$0', 'expiry' => 'Dec 31, 2026', 'status' => 'Active'],
                            ['code' => 'FREESHIP', 'discount' => '$0', 'type' => 'Free Shipping', 'uses' => '34/100', 'min' => '$75', 'expiry' => 'Sep 30, 2026', 'status' => 'Active'],
                            ['code' => 'SUMMER25', 'discount' => '25%', 'type' => 'Percentage', 'uses' => '50/50', 'min' => '$150', 'expiry' => 'Jun 30, 2026', 'status' => 'Expired'],
                            ['code' => 'FLASH30', 'discount' => '30%', 'type' => 'Percentage', 'uses' => '100/100', 'min' => '$100', 'expiry' => 'May 15, 2026', 'status' => 'Expired'],
                            ['code' => 'VIP100', 'discount' => '$100', 'type' => 'Fixed', 'uses' => '3/10', 'min' => '$500', 'expiry' => 'Jan 15, 2027', 'status' => 'Active'],
                        ];
                    @endphp

                    @foreach($coupons as $coupon)
                    <tr>
                        <td>
                            <span class="fw-semibold" style="font-family:monospace;font-size:14px;color:var(--sidebar-bg);">{{ $coupon['code'] }}</span>
                            <button class="btn btn-sm btn-link p-0 ms-1" onclick="copyCode('{{ $coupon['code'] }}')" title="Copy Code">
                                <i class="far fa-copy" style="color:#9ca3af;"></i>
                            </button>
                        </td>
                        <td class="fw-semibold">{{ $coupon['discount'] }}</td>
                        <td><span style="font-size:13px;">{{ $coupon['type'] }}</span></td>
                        <td><span style="font-size:13px;">{{ $coupon['uses'] }}</span></td>
                        <td>{{ $coupon['min'] }}</td>
                        <td style="font-size:13px;">{{ $coupon['expiry'] }}</td>
                        <td>
                            @if($coupon['status'] === 'Active')
                                <span class="badge-status active">Active</span>
                            @elseif($coupon['status'] === 'Expired')
                                <span class="badge-status inactive">Expired</span>
                            @else
                                <span class="badge-status draft">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCouponModal" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-soft-danger btn-sm" title="Delete" onclick="confirmDelete('{{ $coupon['code'] }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="font-size:13px;color:#6c757d;">Showing 1 to 8 of 18 coupons</span>
        <nav>
            <ul class="pagination pagination-sm">
                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>

<!-- Add Coupon Modal -->
<div class="modal fade" id="addCouponModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Coupon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="e.g. SUMMER20" required>
                                <button class="btn btn-soft-primary" type="button" onclick="alert('Generate random code')"><i class="fas fa-random"></i></button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                            <select class="form-select" required>
                                <option>Percentage</option>
                                <option>Fixed Amount</option>
                                <option>Free Shipping</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" placeholder="10" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Minimum Order Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" placeholder="0.00" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Max Uses</label>
                            <input type="number" class="form-control" placeholder="100" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Max Uses Per User</label>
                            <input type="number" class="form-control" placeholder="1" min="1" value="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Coupon Modal -->
<div class="modal fade" id="editCouponModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Coupon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="WELCOME10" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Discount Type</label>
                            <select class="form-select">
                                <option selected>Percentage</option>
                                <option>Fixed Amount</option>
                                <option>Free Shipping</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Discount Value</label>
                            <input type="number" class="form-control" value="10" min="0" step="0.01">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Minimum Order Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" value="50" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Max Uses</label>
                            <input type="number" class="form-control" value="100" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Max Uses Per User</label>
                            <input type="number" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" value="2026-01-01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" value="2026-12-31">
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyCode(code) {
    navigator.clipboard.writeText(code).then(function() {
        alert('Copied: ' + code);
    });
}

function confirmDelete(code) {
    if (confirm('Are you sure you want to delete coupon "' + code + '"?')) {
        alert('Delete functionality will be implemented.');
    }
}
</script>
@endpush
