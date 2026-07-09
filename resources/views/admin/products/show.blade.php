@extends('admin.layouts.admin')

@section('title', $product->name)

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4>{{ $product->name }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Edit Product
        </a>
        <button class="btn btn-soft-danger" onclick="confirmDelete({{ $product->id }})">
            <i class="fas fa-trash me-1"></i> Delete
        </button>
        <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Product Images</div>
            <div class="card-body">
                @if($product->images->count() > 0)
                    <div class="image-preview">
                        @foreach($product->images as $image)
                            <div class="preview-item" style="width:120px;height:120px;">
                                <img src="{{ asset($image->image_path) }}" alt="Product Image" onerror="this.src='https://placehold.co/150x150?text=No+Image'">
                                @if($image->is_primary)
                                    <span class="badge bg-warning text-dark" style="position:absolute;bottom:4px;left:4px;font-size:10px;">Primary</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-image fa-3x mb-2" style="color:#ddd;"></i>
                        <p class="mb-0">No images uploaded.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">Description</div>
            <div class="card-body">
                @if($product->short_description)
                    <h6 class="text-muted mb-2">Short Description</h6>
                    <p class="mb-3">{{ $product->short_description }}</p>
                @endif
                <h6 class="text-muted mb-2">Full Description</h6>
                <p class="mb-0">{{ $product->description ?: 'No description provided.' }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Product Information</div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:14px;">
                    <tr>
                        <td class="text-muted" style="width:45%;">Product Code</td>
                        <td class="fw-semibold">{{ $product->product_code ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">SKU</td>
                        <td class="fw-semibold">{{ $product->sku }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Slug</td>
                        <td class="fw-semibold" style="word-break:break-all;">{{ $product->slug }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Category</td>
                        <td class="fw-semibold">{{ $product->category?->name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Collection</td>
                        <td class="fw-semibold">{{ $product->collection?->name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Brand</td>
                        <td class="fw-semibold">{{ $product->brand?->name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Price</td>
                        <td class="fw-semibold">
                            @if($product->discount_price)
                                <span class="text-muted text-decoration-line-through">₹{{ number_format($product->price, 0) }}</span>
                                <span class="text-danger">₹{{ number_format($product->discount_price, 0) }}</span>
                                @if($product->discount_percentage)
                                    <span class="badge bg-danger ms-1">-{{ $product->discount_percentage }}%</span>
                                @endif
                            @else
                                ₹{{ number_format($product->price, 0) }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Stock Quantity</td>
                        <td class="fw-semibold">{{ $product->stock_quantity }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Stock Status</td>
                        <td>
                            @if($product->stock_status === 'in_stock')
                                <span class="badge-status active">In Stock</span>
                            @else
                                <span class="badge-status inactive">Out of Stock</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            @if($product->status)
                                <span class="badge-status active">Active</span>
                            @else
                                <span class="badge-status inactive">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Home Page Section</td>
                        <td class="fw-semibold">{{ $product->home_section ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">New Page Section</td>
                        <td class="fw-semibold">{{ $product->new_section ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Created</td>
                        <td class="fw-semibold">{{ $product->created_at->format('M j, Y g:i A') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Last Updated</td>
                        <td class="fw-semibold">{{ $product->updated_at->format('M j, Y g:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Special Choices</div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @if($product->is_featured)
                        <span class="badge bg-primary">Featured Product</span>
                    @endif
                    @if($product->is_new_arrival)
                        <span class="badge bg-success">New Arrival</span>
                    @endif
                    @if($product->is_best_selling)
                        <span class="badge bg-warning text-dark">Best Selling</span>
                    @endif
                    @if($product->is_trending)
                        <span class="badge bg-info">Trending</span>
                    @endif
                    @if($product->is_discounted)
                        <span class="badge bg-danger">Discounted Product</span>
                    @endif
                    @if(!$product->is_featured && !$product->is_new_arrival && !$product->is_best_selling && !$product->is_trending && !$product->is_discounted)
                        <span class="text-muted small">No special choices assigned</span>
                    @endif
                </div>
            </div>
        </div>

        @if($product->fabric || $product->occasion || $product->color || $product->pattern)
        <div class="card">
            <div class="card-header">Attributes</div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:14px;">
                    @if($product->fabric)
                    <tr>
                        <td class="text-muted" style="width:45%;">Fabric</td>
                        <td class="fw-semibold">{{ $product->fabric }}</td>
                    </tr>
                    @endif
                    @if($product->occasion)
                    <tr>
                        <td class="text-muted">Occasion</td>
                        <td class="fw-semibold">{{ $product->occasion }}</td>
                    </tr>
                    @endif
                    @if($product->color)
                    <tr>
                        <td class="text-muted">Color</td>
                        <td class="fw-semibold">{{ $product->color }}</td>
                    </tr>
                    @endif
                    @if($product->pattern)
                    <tr>
                        <td class="text-muted">Pattern</td>
                        <td class="fw-semibold">{{ $product->pattern }}</td>
                    </tr>
                    @endif
                    @if($product->weight)
                    <tr>
                        <td class="text-muted">Weight</td>
                        <td class="fw-semibold">{{ $product->weight }} g</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete "{{ $product->name }}"? This action cannot be undone.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
