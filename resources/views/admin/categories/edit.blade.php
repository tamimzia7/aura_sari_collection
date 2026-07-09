@extends('admin.layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Edit Category</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-soft-primary">
            <i class="fas fa-arrow-left me-1"></i> Back to Categories
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" placeholder="Enter category name" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $category->slug) }}" placeholder="category-slug">
                    <div class="form-text">Auto-generated from name if left empty.</div>
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Parent Category</label>
                    <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">None (Top Level)</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                    @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="status" role="switch" value="1" {{ old('status', $category->status) ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Category description">{{ old('description', $category->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Image</label>

                    @if($category->image)
                    <div class="mb-3">
                        <p class="form-text mb-2">Current Image:</p>
                        <div style="max-width:300px;border-radius:8px;overflow:hidden;border:1px solid #e9ecef;">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="width:100%;height:auto;display:block;">
                        </div>
                    </div>
                    @endif

                    <div class="image-upload-wrapper" onclick="document.getElementById('categoryImage').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Click to upload new image<br><small>Leave empty to keep current image. Recommended: 800x800px, JPG/PNG/WEBP (max 2MB)</small></p>
                    </div>
                    <input type="file" id="categoryImage" name="image" class="d-none" accept="image/*" onchange="previewCategoryImage(this)">
                    <div class="image-preview" id="categoryPreview"></div>
                    @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewCategoryImage(input) {
    const preview = document.getElementById('categoryPreview');
    preview.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const item = document.createElement('div');
            item.className = 'preview-item';
            item.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
            preview.appendChild(item);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
