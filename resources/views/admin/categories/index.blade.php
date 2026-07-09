@extends('admin.layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Categories</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Category
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
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent</th>
                        <th style="text-align:center;">Products</th>
                        <th>Status</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            @if($category->image)
                                <div style="width:40px;height:40px;border-radius:8px;overflow:hidden;border:1px solid #e9ecef;">
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                            @else
                                <div style="width:40px;height:40px;border-radius:8px;background:#f1f3f5;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:var(--primary-color);">
                                    {{ substr($category->name, 0, 2) }}
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td><span style="font-size:13px;color:#6c757d;">{{ $category->slug }}</span></td>
                        <td>{{ $category->parent?->name ?? 'None' }}</td>
                        <td style="text-align:center;"><span class="badge bg-light text-dark">{{ $category->products()->count() }}</span></td>
                        <td>
                            @if($category->status)
                                <span class="badge-status active">Active</span>
                            @else
                                <span class="badge-status inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-soft-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete the category &quot;{{ $category->name }}&quot;?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-soft-danger btn-sm" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-folder-open" style="font-size:32px;color:#d1d5db;display:block;margin-bottom:8px;"></i>
                            <p style="color:#6c757d;margin:0;">No categories found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories->hasPages())
    <div class="card-footer">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
