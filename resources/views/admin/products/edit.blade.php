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

<form action="#" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Basic Information</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="Banarasi Silk Saree" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Slug</label>
                            <input type="text" class="form-control" value="banarasi-silk-saree">
                            <div class="form-text">Auto-generated from name if left empty.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="SKU-001" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Short Description</label>
                            <textarea class="form-control" rows="2">Handwoven Banarasi silk saree with intricate zari work, perfect for weddings and festive occasions.</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="5">Immerse yourself in the timeless elegance of our handwoven Banarasi Silk Saree. Crafted by master artisans from Varanasi, this saree features intricate zari work, a richly woven pallu, and a luxurious silk texture that drapes beautifully. Perfect for weddings, festive celebrations, and special occasions.</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Pricing</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Regular Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" value="249.00" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Discount Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" value="199.00" step="0.01">
                            </div>
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
                            <select class="form-select">
                                <option value="">Select Fabric</option>
                                <option selected>Silk</option>
                                <option>Cotton</option>
                                <option>Georgette</option>
                                <option>Chiffon</option>
                                <option>Organza</option>
                                <option>Linen</option>
                                <option>Velvet</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Occasion</label>
                            <select class="form-select">
                                <option value="">Select Occasion</option>
                                <option selected>Wedding</option>
                                <option>Festival</option>
                                <option>Party</option>
                                <option>Casual</option>
                                <option>Office</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Color</label>
                            <select class="form-select">
                                <option value="">Select Color</option>
                                <option>Red</option>
                                <option selected>Blue</option>
                                <option>Green</option>
                                <option>Gold</option>
                                <option>White</option>
                                <option>Black</option>
                                <option>Pink</option>
                                <option>Purple</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Pattern</label>
                            <select class="form-select">
                                <option value="">Select Pattern</option>
                                <option>Solid</option>
                                <option>Printed</option>
                                <option selected>Embroidered</option>
                                <option>Zari Work</option>
                                <option>Sequins</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Product Images</div>
                <div class="card-body">
                    <div class="image-preview mb-3" id="existingImages">
                        <div class="preview-item">
                            <img src="#" alt="Product Image" style="background:#f1f3f5;">
                            <button class="remove-btn" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="preview-item">
                            <img src="#" alt="Product Image" style="background:#f1f3f5;">
                            <button class="remove-btn" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="preview-item">
                            <img src="#" alt="Product Image" style="background:#f1f3f5;">
                            <button class="remove-btn" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                        </div>
                    </div>

                    <div class="image-upload-wrapper" onclick="document.getElementById('productImages').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p><strong>Click to upload</strong> or drag and drop more images</p>
                        <p style="font-size:12px;color:#9ca3af;">PNG, JPG, WEBP up to 5MB each</p>
                        <input type="file" id="productImages" multiple accept="image/*" style="display:none;" onchange="handleImagePreview(this)">
                    </div>
                    <div class="image-preview" id="newImagePreview"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Organization</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select" required>
                            <option value="">Select Category</option>
                            <option selected>Silk Sarees</option>
                            <option>Cotton Sarees</option>
                            <option>Bridal Sarees</option>
                            <option>Designer Sarees</option>
                            <option>Casual Sarees</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Brand</label>
                        <select class="form-select">
                            <option value="">Select Brand</option>
                            <option selected>AURA Luxe</option>
                            <option>AURA Silk</option>
                            <option>AURA Cotton</option>
                            <option>AURA Heritage</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Inventory</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" value="45" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Weight (g)</label>
                        <input type="number" class="form-control" value="350" min="0" step="1">
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
                                <input class="form-check-input" type="checkbox" role="switch" checked>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0">Featured</label>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" checked>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0">New Arrival</label>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0">Best Selling</label>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" checked>
                            </div>
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
                        <button type="button" class="btn btn-soft-warning">
                            <i class="fas fa-copy me-1"></i> Duplicate Product
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
@endsection

@push('scripts')
<script>
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
                    <button class="remove-btn" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                `;
                preview.appendChild(item);
            };
            reader.readAsDataURL(file);
        });
    }
}

function confirmDelete() {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        alert('Delete functionality will be implemented.');
    }
}
</script>
@endpush
