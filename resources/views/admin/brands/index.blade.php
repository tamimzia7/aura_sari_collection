@extends('admin.layouts.admin')

@section('title', 'Brands')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Brands</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">Brands</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
            <i class="fas fa-plus me-1"></i> Add Brand
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="search-box" style="position:relative;width:100%;">
                    <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#adb5bd;font-size:14px;"></i>
                    <input type="text" class="form-control" placeholder="Search brands..." style="padding-left:40px;">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
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
                        <th>#</th>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th style="text-align:center;">Products</th>
                        <th>Status</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $brands = [
                            ['id' => 1, 'name' => 'AURA Luxe', 'slug' => 'aura-luxe', 'count' => 32, 'status' => 'Active'],
                            ['id' => 2, 'name' => 'AURA Silk', 'slug' => 'aura-silk', 'count' => 48, 'status' => 'Active'],
                            ['id' => 3, 'name' => 'AURA Cotton', 'slug' => 'aura-cotton', 'count' => 28, 'status' => 'Active'],
                            ['id' => 4, 'name' => 'AURA Heritage', 'slug' => 'aura-heritage', 'count' => 18, 'status' => 'Active'],
                            ['id' => 5, 'name' => 'AURA Bridal', 'slug' => 'aura-bridal', 'count' => 22, 'status' => 'Active'],
                            ['id' => 6, 'name' => 'AURA Casual', 'slug' => 'aura-casual', 'count' => 15, 'status' => 'Inactive'],
                        ];
                    @endphp

                    @foreach($brands as $brand)
                    <tr>
                        <td>{{ $brand['id'] }}</td>
                        <td>
                            <div style="width:40px;height:40px;border-radius:8px;background:#f1f3f5;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:var(--primary-color);">
                                {{ substr($brand['name'], 0, 2) }}
                            </div>
                        </td>
                        <td class="fw-semibold">{{ $brand['name'] }}</td>
                        <td><span style="font-size:13px;color:#6c757d;">{{ $brand['slug'] }}</span></td>
                        <td style="text-align:center;"><span class="badge bg-light text-dark">{{ $brand['count'] }}</span></td>
                        <td>
                            @if($brand['status'] === 'Active')
                                <span class="badge-status active">Active</span>
                            @else
                                <span class="badge-status inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editBrandModal" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-soft-danger btn-sm" title="Delete" onclick="confirmDelete('{{ $brand['name'] }}')">
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
        <span style="font-size:13px;color:#6c757d;">Showing 1 to 6 of 6 brands</span>
    </div>
</div>

<!-- Add Brand Modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <div style="width:80px;height:80px;border-radius:12px;background:#f1f3f5;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;color:#adb5bd;cursor:pointer;border:2px dashed #e2e8f0;" onclick="document.getElementById('brandLogo').click()">
                            +
                        </div>
                        <p style="font-size:12px;color:#6c757d;margin:0;">Upload Brand Logo</p>
                        <input type="file" id="brandLogo" style="display:none;" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Brand Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter brand name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" placeholder="brand-slug">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" placeholder="Brand description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Brand</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Brand Modal -->
<div class="modal fade" id="editBrandModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <div style="width:80px;height:80px;border-radius:12px;background:#f1f3f5;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;color:var(--primary-color);">
                            AL
                        </div>
                        <p style="font-size:12px;color:#6c757d;margin:0;">Click to change logo</p>
                        <input type="file" style="display:none;" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Brand Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="AURA Luxe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" value="aura-luxe">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3">Premium luxury sarees for discerning customers.</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Brand</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(name) {
    if (confirm('Are you sure you want to delete the brand "' + name + '"?')) {
        alert('Delete functionality will be implemented.');
    }
}
</script>
@endpush
