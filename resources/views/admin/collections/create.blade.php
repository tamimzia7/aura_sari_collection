@extends('admin.layouts.admin')

@section('title', 'Add Collection')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Add Collection</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.collections.index') }}">Collections</a></li>
                <li class="breadcrumb-item active">Add New</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.collections.index') }}" class="btn btn-soft-primary">
            <i class="fas fa-arrow-left me-1"></i> Back to Collections
        </a>
    </div>
</div>

<form action="{{ route('admin.collections.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">Collection Information</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter collection name" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="collection-slug">
                    <div class="form-text">Auto-generated from name if left empty.</div>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Collection description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 0) }}" min="0">
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" role="switch" value="1" {{ old('status', '1') ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="image-preview" id="imagePreview"></div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Collection</button>
            <a href="{{ route('admin.collections.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const container = document.getElementById('imagePreview');
    container.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const item = document.createElement('div');
            item.className = 'preview-item';
            item.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
            container.appendChild(item);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush