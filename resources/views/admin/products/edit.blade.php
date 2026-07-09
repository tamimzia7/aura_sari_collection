@extends('admin.layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Edit Product</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-soft-primary">
            <i class="fas fa-arrow-left me-1"></i> Back to Products
        </a>
    </div>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Basic Information</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Product Code</label>
                            <input type="text" class="form-control" value="{{ old('product_code', $product->product_code ?? 'PRD-' . strtoupper(Str::random(6))) }}" readonly>
                            <input type="hidden" name="product_code" value="{{ old('product_code', $product->product_code ?? 'PRD-' . strtoupper(Str::random(6))) }}">
                            @error('product_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter product name" value="{{ old('name', $product->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="product-slug" value="{{ old('slug', $product->slug) }}">
                            <div class="form-text">Auto-generated from name if left empty.</div>
                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" placeholder="SKU-001" value="{{ old('sku', $product->sku) }}" required>
                            @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2" placeholder="Brief product description">{{ old('short_description', $product->short_description) }}</textarea>
                            @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Full product description">{{ old('description', $product->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Pricing</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Regular Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="0.00" step="0.01" value="{{ old('price', $product->price) }}" required>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Discount Price (₹)</label>
                            <input type="number" name="discount_price" class="form-control @error('discount_price') is-invalid @enderror" placeholder="0.00" step="0.01" value="{{ old('discount_price', $product->discount_price) }}">
                            <div class="form-text">Leave empty if no discount.</div>
                            @error('discount_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stock Status <span class="text-danger">*</span></label>
                            <select name="stock_status" class="form-select @error('stock_status') is-invalid @enderror">
                                <option value="in_stock" {{ old('stock_status', $product->stock_status ?? 'in_stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                <option value="out_of_stock" {{ old('stock_status', $product->stock_status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                            @error('stock_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Attributes</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Fabric</label>
                            <select name="fabric" class="form-select">
                                <option value="">Select Fabric</option>
                                @foreach(['Silk','Cotton','Georgette','Chiffon','Organza','Linen','Velvet','Net','Satin','Jacquard'] as $fabric)
                                    <option value="{{ $fabric }}" {{ old('fabric', $product->fabric) === $fabric ? 'selected' : '' }}>{{ $fabric }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Occasion</label>
                            <select name="occasion" class="form-select">
                                <option value="">Select Occasion</option>
                                @foreach(['Wedding','Festival','Party','Casual','Office','Formal','Daily Wear','Evening'] as $occasion)
                                    <option value="{{ $occasion }}" {{ old('occasion', $product->occasion) === $occasion ? 'selected' : '' }}>{{ $occasion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Color</label>
                            <select name="color" class="form-select">
                                <option value="">Select Color</option>
                                @foreach(['Red','Blue','Green','Gold','White','Black','Pink','Purple','Orange','Yellow','Teal','Maroon','Navy','Emerald','Silver'] as $color)
                                    <option value="{{ $color }}" {{ old('color', $product->color) === $color ? 'selected' : '' }}>{{ $color }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Pattern</label>
                            <select name="pattern" class="form-select">
                                <option value="">Select Pattern</option>
                                @foreach(['Solid','Printed','Embroidered','Zari Work','Sequins','Handloom','Block Print','Digital Print','Stone Work'] as $pattern)
                                    <option value="{{ $pattern }}" {{ old('pattern', $product->pattern) === $pattern ? 'selected' : '' }}>{{ $pattern }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Product Images</div>
                <div class="card-body">
                    @if($product->images->count() > 0)
                        <div class="image-preview mb-3" id="existingImages">
                            @foreach($product->images as $image)
                                <div class="preview-item" data-image-id="{{ $image->id }}">
                                    <img src="{{ asset($image->image_path) }}" alt="Product Image" onerror="this.src='https://placehold.co/150x150?text=No+Image'">
                                    <button type="button" class="remove-btn" onclick="removeExistingImage(this, {{ $image->id }})" title="Remove image">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @if($image->is_primary)
                                        <span class="badge bg-warning text-dark" style="position:absolute;bottom:4px;left:4px;font-size:10px;">Primary</span>
                                    @else
                                        <button type="button" class="badge bg-secondary" style="position:absolute;bottom:4px;left:4px;font-size:10px;cursor:pointer;border:none;" onclick="setPrimary({{ $image->id }}, this)" title="Set as primary">Set Primary</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="remove_images" id="removeImagesInput" value="">
                        <input type="hidden" name="primary_image_id" id="primaryImageInput" value="">
                    @endif

                    <div class="image-upload-wrapper" onclick="document.getElementById('productImages').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p><strong>Click to upload</strong> or drag and drop more images</p>
                        <p style="font-size:12px;color:#9ca3af;">PNG, JPG, WEBP up to 5MB each</p>
                        <input type="file" name="images[]" id="productImages" multiple accept="image/*" style="display:none;" onchange="handleImagePreview(this)">
                    </div>
                    <div class="image-preview" id="newImagePreview"></div>
                    @error('images') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                    @error('images.*') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Organization</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Collection</label>
                        <select name="collection_id" class="form-select @error('collection_id') is-invalid @enderror">
                            <option value="">Select Collection</option>
                            @foreach($collections as $collection)
                                <option value="{{ $collection->id }}" {{ old('collection_id', $product->collection_id) == $collection->id ? 'selected' : '' }}>{{ $collection->name }}</option>
                            @endforeach
                        </select>
                        @error('collection_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Brand</label>
                        <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Inventory</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" placeholder="0" min="0" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                        @error('stock_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Weight (g)</label>
                        <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" placeholder="500" min="0" step="0.01" value="{{ old('weight', $product->weight) }}">
                        @error('weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Product Status</div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0">Active</label>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="status" role="switch" value="1" {{ old('status', $product->status) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0">Featured</label>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="is_featured" role="switch" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0">New Arrival</label>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="is_new_arrival" role="switch" value="1" {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0">Best Selling</label>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="is_best_selling" role="switch" value="1" {{ old('is_best_selling', $product->is_best_selling) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_trending" role="switch" value="1" {{ old('is_trending', $product->is_trending) ? 'checked' : '' }}>
                            <label class="form-check-label">Trending Product</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Update</div>
                <div class="card-body">
                    <p class="small text-muted mb-3">Review your changes before updating this product.</p>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Product
                        </button>
                        <button type="button" class="btn btn-soft-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash me-1"></i> Delete Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="delete-form" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
let imagesToRemove = [];

function handleImagePreview(input) {
    const preview = document.getElementById('newImagePreview');
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const item = document.createElement('div');
                item.className = 'preview-item';
                item.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-btn" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                `;
                preview.appendChild(item);
            };
            reader.readAsDataURL(file);
        });
    }
}

function removeExistingImage(btn, imageId) {
    btn.closest('.preview-item').remove();
    imagesToRemove.push(imageId);
    document.getElementById('removeImagesInput').value = imagesToRemove.join(',');
}

function setPrimary(imageId, btnElement) {
    document.querySelectorAll('#existingImages .preview-item').forEach(el => {
        const badges = el.querySelectorAll('.badge');
        badges.forEach(b => {
            if (b.textContent === 'Primary' || b.textContent === 'Set Primary') {
                b.textContent = 'Set Primary';
                b.className = 'badge bg-secondary';
                b.style.cssText = 'position:absolute;bottom:4px;left:4px;font-size:10px;cursor:pointer;border:none;';
                const pid = el.dataset.imageId;
                b.onclick = function() { setPrimary(pid, this); };
            }
        });
    });

    const btn = btnElement;
    btn.textContent = 'Primary';
    btn.className = 'badge bg-warning text-dark';
    btn.style.cssText = 'position:absolute;bottom:4px;left:4px;font-size:10px;';
    btn.onclick = null;

    document.getElementById('primaryImageInput').value = imageId;
}

function confirmDelete() {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush
