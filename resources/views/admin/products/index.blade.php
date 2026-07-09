@extends('admin.layouts.admin')

@section('title', 'Products')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Products</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="search-box" style="position:relative;width:100%;">
                    <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#adb5bd;font-size:14px;"></i>
                    <input type="text" name="search" class="form-control" placeholder="Search products..." style="padding-left:40px;" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="collection" class="form-select">
                    <option value="">All Collections</option>
                    @foreach($collections ?? [] as $col)
                        <option value="{{ $col->id }}" {{ request('collection') == $col->id ? 'selected' : '' }}>{{ $col->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-1">
                <select name="stock" class="form-select">
                    <option value="">Stock</option>
                    <option value="in_stock" {{ request('stock') === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="out_of_stock" {{ request('stock') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-soft-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width:60px;">Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Collection</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="width:140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <div style="width:48px;height:48px;border-radius:8px;overflow:hidden;background:#f1f3f5;display:flex;align-items:center;justify-content:center;">
                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}"
                                     style="width:100%;height:100%;object-fit:cover;"
                                     onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fas fa-tshirt\' style=\'color:#adb5bd;font-size:20px;\'></i>'">
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.show', $product) }}" class="text-decoration-none fw-semibold" style="color:var(--sidebar-bg);">{{ $product->name }}</a>
                            @if($product->product_code)
                                <br><span style="font-size:11px;color:#9ca3af;">{{ $product->product_code }}</span>
                            @endif
                        </td>
                        <td><span style="font-size:13px;">{{ $product->category?->name }}</span></td>
                        <td><span style="font-size:13px;">{{ $product->collection?->name ?? '—' }}</span></td>
                        <td class="fw-semibold">
                            @if($product->discount_price)
                                <span class="text-muted text-decoration-line-through small">₹{{ number_format($product->price, 0) }}</span>
                                <span class="text-danger">₹{{ number_format($product->discount_price, 0) }}</span>
                            @else
                                ₹{{ number_format($product->price, 0) }}
                            @endif
                        </td>
                        <td>
                            @if($product->stock_quantity > 20)
                                <span class="text-success fw-semibold">{{ $product->stock_quantity }}</span>
                            @elseif($product->stock_quantity > 0)
                                <span class="text-warning fw-semibold">{{ $product->stock_quantity }}</span>
                            @else
                                <span class="text-danger fw-semibold">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            @if($product->status)
                                <span class="badge-status active">Active</span>
                            @else
                                <span class="badge-status inactive">Inactive</span>
                            @endif
                        </td>
                        <td style="font-size:13px;color:#6c757d;white-space:nowrap;">
                            {{ $product->created_at->format('M j, Y') }}
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-soft-primary btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-soft-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-soft-danger btn-sm" title="Delete" onclick="confirmDelete('{{ addslashes($product->name) }}', {{ $product->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="fas fa-box-open" style="font-size:3rem;color:#ddd;"></i>
                            <p class="mt-3 text-muted">No products found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="font-size:13px;color:#6c757d;">
            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products
        </span>
        {{ $products->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(name, id) {
    if (confirm('Are you sure you want to delete "' + name + '"? This action cannot be undone.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
