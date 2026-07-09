@extends('admin.layouts.admin')

@section('title', 'Banners')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Banners</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Banners</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add New Banner
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width:80px;">Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr>
                        <td>
                            <div style="width:80px;height:50px;border-radius:6px;overflow:hidden;background:#f1f3f5;">
                                @if($banner->image)
                                <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#adb5bd;font-size:20px;"><i class="fas fa-image"></i></div>
                                @endif
                            </div>
                        </td>
                        <td class="fw-semibold">{{ $banner->title ?? 'N/A' }}</td>
                        <td style="font-size:13px;color:#6c757d;">{{ Str::limit($banner->subtitle, 40) ?? 'N/A' }}</td>
                        <td><span class="badge bg-light text-dark">{{ $banner->sort_order }}</span></td>
                        <td>
                            @if($banner->status)
                                <span class="badge-status active">Active</span>
                            @else
                                <span class="badge-status inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-soft-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-soft-danger btn-sm" title="Delete" onclick="confirmDelete({{ $banner->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $banner->id }}" action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-image" style="font-size:3rem;color:#ddd;"></i>
                            <p class="mt-3 text-muted">No banners found</p>
                            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm">Add Your First Banner</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($banners->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="font-size:13px;color:#6c757d;">Showing {{ $banners->firstItem() }} to {{ $banners->lastItem() }} of {{ $banners->total() }} banners</span>
        {{ $banners->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this banner?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
