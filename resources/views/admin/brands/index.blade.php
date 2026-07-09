@extends('admin.layouts.admin')

@section('title', 'Brands')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Brands</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Brands</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Brand
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                    <tr>
                        <td>{{ $brand->id }}</td>
                        <td class="fw-semibold">{{ $brand->name }}</td>
                        <td><span style="font-size:13px;color:#6c757d;">{{ $brand->slug }}</span></td>
                        <td>
                            @if($brand->status)
                                <span class="badge-status active">Active</span>
                            @else
                                <span class="badge-status inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-soft-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-soft-danger btn-sm" title="Delete" onclick="confirmDelete({{ $brand->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $brand->id }}" action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-copyright" style="font-size:3rem;color:#ddd;"></i>
                            <p class="mt-3 text-muted">No brands found</p>
                            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary btn-sm">Add Your First Brand</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($brands->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="font-size:13px;color:#6c757d;">Showing {{ $brands->firstItem() }} to {{ $brands->lastItem() }} of {{ $brands->total() }} brands</span>
        {{ $brands->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this brand?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
