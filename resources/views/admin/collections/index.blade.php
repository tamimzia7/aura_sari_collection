@extends('admin.layouts.admin')

@section('title', 'Collections')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Collections</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">Collections</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.collections.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Collection
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th style="text-align:center;">Products</th>
                        <th style="text-align:center;">Sort Order</th>
                        <th>Status</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($collections as $collection)
                    <tr>
                        <td>
                            @if($collection->image)
                                <div style="width:40px;height:40px;border-radius:8px;overflow:hidden;border:1px solid #e9ecef;">
                                    <img src="{{ asset('storage/' . $collection->image) }}" alt="{{ $collection->name }}" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                            @else
                                <div style="width:40px;height:40px;border-radius:8px;background:#f1f3f5;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:var(--primary-color);">
                                    {{ substr($collection->name, 0, 2) }}
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $collection->name }}</td>
                        <td><span style="font-size:13px;color:#6c757d;">{{ $collection->slug }}</span></td>
                        <td style="text-align:center;"><span class="badge bg-light text-dark">{{ $collection->products()->count() }}</span></td>
                        <td style="text-align:center;">{{ $collection->sort_order }}</td>
                        <td>
                            @if($collection->status)
                                <span class="badge-status active">Active</span>
                            @else
                                <span class="badge-status inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.collections.edit', $collection) }}" class="btn btn-soft-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-soft-danger btn-sm" title="Delete" onclick="confirmDelete('{{ $collection->name }}', '{{ route('admin.collections.destroy', $collection) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-folder-open" style="font-size:32px;color:#d1d5db;display:block;margin-bottom:8px;"></i>
                            <p style="color:#6c757d;margin:0;">No collections found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($collections->hasPages())
    <div class="card-footer">
        {{ $collections->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(name, url) {
    if (confirm('Are you sure you want to delete the collection "' + name + '"?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.innerHTML = '@csrf @method('DELETE')'.replace(/@csrf/g, '<input type="hidden" name="_token" value="' + document.querySelector('meta[name="csrf-token"]').content + '">').replace(/@method\('DELETE'\)/g, '<input type="hidden" name="_method" value="DELETE">');
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush