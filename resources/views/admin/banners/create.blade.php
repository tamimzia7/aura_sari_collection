@extends('admin.layouts.admin')

@section('title', 'Add Banner')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Add New Banner</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banners</a></li>
                <li class="breadcrumb-item active">Add New</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter banner title">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Button Text</label>
                    <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text') }}" placeholder="Shop Now">
                    @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Subtitle</label>
                    <textarea name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" rows="2" placeholder="Banner subtitle">{{ old('subtitle') }}</textarea>
                    @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Link URL</label>
                    <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="https://example.com">
                    @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 0) }}" min="0">
                    @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="status" role="switch" value="1" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Banner Image <span class="text-danger">*</span></label>
                    <div class="image-upload-wrapper" onclick="document.getElementById('bannerImage').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Click to upload banner image<br><small>Recommended: 1920x600px, JPG/PNG/WEBP (max 2MB)</small></p>
                    </div>
                    <input type="file" id="bannerImage" name="image" class="d-none" accept="image/*" onchange="previewBannerImage(this)">
                    <div class="image-preview" id="bannerPreview"></div>
                    @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewBannerImage(input) {
    const preview = document.getElementById('bannerPreview');
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
