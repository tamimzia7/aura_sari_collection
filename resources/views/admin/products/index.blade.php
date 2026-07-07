@extends('admin.layouts.admin')

@section('title', 'Products')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Products</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add New Product
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="search-box" style="position:relative;width:100%;">
                    <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#adb5bd;font-size:14px;"></i>
                    <input type="text" class="form-control" placeholder="Search products..." style="padding-left:40px;">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">All Categories</option>
                    <option>Silk Sarees</option>
                    <option>Cotton Sarees</option>
                    <option>Bridal Sarees</option>
                    <option>Designer Sarees</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">All Brands</option>
                    <option>AURA Luxe</option>
                    <option>AURA Silk</option>
                    <option>AURA Cotton</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Draft</option>
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
                        <th style="width:60px;">Image</th>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $products = [
                            ['name' => 'Banarasi Silk Saree', 'sku' => 'SKU-001', 'cat' => 'Silk Sarees', 'price' => 24900, 'stock' => 45, 'status' => 'Active', 'img' => '#'],
                            ['name' => 'Kanjivaram Silk Saree', 'sku' => 'SKU-002', 'cat' => 'Silk Sarees', 'price' => 35900, 'stock' => 28, 'status' => 'Active', 'img' => '#'],
                            ['name' => 'Cotton Printed Saree', 'sku' => 'SKU-003', 'cat' => 'Cotton Sarees', 'price' => 8900, 'stock' => 120, 'status' => 'Active', 'img' => '#'],
                            ['name' => 'Bridal Lehenga Saree', 'sku' => 'SKU-004', 'cat' => 'Bridal Sarees', 'price' => 59900, 'stock' => 10, 'status' => 'Active', 'img' => '#'],
                            ['name' => 'Georgette Designer Saree', 'sku' => 'SKU-005', 'cat' => 'Designer Sarees', 'price' => 15900, 'stock' => 0, 'status' => 'Inactive', 'img' => '#'],
                            ['name' => 'Chiffon Party Wear Saree', 'sku' => 'SKU-006', 'cat' => 'Designer Sarees', 'price' => 12900, 'stock' => 35, 'status' => 'Active', 'img' => '#'],
                            ['name' => 'Organza Saree', 'sku' => 'SKU-007', 'cat' => 'Silk Sarees', 'price' => 19900, 'stock' => 18, 'status' => 'Draft', 'img' => '#'],
                            ['name' => 'Linen Saree', 'sku' => 'SKU-008', 'cat' => 'Cotton Sarees', 'price' => 11900, 'stock' => 60, 'status' => 'Active', 'img' => '#'],
                        ];
                    @endphp

                    @foreach($products as $product)
                    <tr>
                        <td>
                            <div style="width:48px;height:48px;border-radius:8px;background:#f1f3f5;display:flex;align-items:center;justify-content:center;font-size:20px;color:#adb5bd;">
                                <i class="fas fa-tshirt"></i>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="text-decoration-none fw-semibold" style="color:var(--sidebar-bg);">{{ $product['name'] }}</a>
                        </td>
                        <td><span style="font-size:13px;color:#6c757d;">{{ $product['sku'] }}</span></td>
                        <td><span style="font-size:13px;">{{ $product['cat'] }}</span></td>
                        <td class="fw-semibold">${{ number_format($product['price'] / 100, 2) }}</td>
                        <td>
                            @if($product['stock'] > 20)
                                <span class="text-success fw-semibold">{{ $product['stock'] }}</span>
                            @elseif($product['stock'] > 0)
                                <span class="text-warning fw-semibold">{{ $product['stock'] }}</span>
                            @else
                                <span class="text-danger fw-semibold">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            @if($product['status'] === 'Active')
                                <span class="badge-status active">Active</span>
                            @elseif($product['status'] === 'Inactive')
                                <span class="badge-status inactive">Inactive</span>
                            @else
                                <span class="badge-status draft">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.products.edit', 1) }}" class="btn btn-soft-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-soft-warning btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-soft-danger btn-sm" title="Delete" onclick="confirmDelete('{{ $product['name'] }}')">
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
        <span style="font-size:13px;color:#6c757d;">Showing 1 to 8 of 48 products</span>
        <nav>
            <ul class="pagination pagination-sm">
                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(name) {
    if (confirm('Are you sure you want to delete "' + name + '"? This action cannot be undone.')) {
        alert('Delete functionality will be implemented.');
    }
}
</script>
@endpush
