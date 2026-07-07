@extends('admin.layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Categories</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fas fa-plus me-1"></i> Add Category
        </button>
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
                        <th>Parent Category</th>
                        <th style="text-align:center;">Products</th>
                        <th>Status</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $categories = [
                            ['id' => 1, 'name' => 'Silk Sarees', 'slug' => 'silk-sarees', 'parent' => 'None', 'count' => 48, 'status' => 'Active'],
                            ['id' => 2, 'name' => 'Cotton Sarees', 'slug' => 'cotton-sarees', 'parent' => 'None', 'count' => 35, 'status' => 'Active'],
                            ['id' => 3, 'name' => 'Bridal Sarees', 'slug' => 'bridal-sarees', 'parent' => 'Silk Sarees', 'count' => 22, 'status' => 'Active'],
                            ['id' => 4, 'name' => 'Designer Sarees', 'slug' => 'designer-sarees', 'parent' => 'None', 'count' => 28, 'status' => 'Active'],
                            ['id' => 5, 'name' => 'Casual Sarees', 'slug' => 'casual-sarees', 'parent' => 'Cotton Sarees', 'count' => 15, 'status' => 'Active'],
                            ['id' => 6, 'name' => 'Party Wear', 'slug' => 'party-wear', 'parent' => 'Designer Sarees', 'count' => 18, 'status' => 'Active'],
                            ['id' => 7, 'name' => 'Festival Collection', 'slug' => 'festival-collection', 'parent' => 'Silk Sarees', 'count' => 12, 'status' => 'Inactive'],
                            ['id' => 8, 'name' => 'Office Wear', 'slug' => 'office-wear', 'parent' => 'Cotton Sarees', 'count' => 9, 'status' => 'Active'],
                        ];
                    @endphp

                    @foreach($categories as $cat)
                    <tr>
                        <td>{{ $cat['id'] }}</td>
                        <td class="fw-semibold">{{ $cat['name'] }}</td>
                        <td><span style="font-size:13px;color:#6c757d;">{{ $cat['slug'] }}</span></td>
                        <td>{{ $cat['parent'] }}</td>
                        <td style="text-align:center;"><span class="badge bg-light text-dark">{{ $cat['count'] }}</span></td>
                        <td>
                            @if($cat['status'] === 'Active')
                                <span class="badge-status active">Active</span>
                            @else
                                <span class="badge-status inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-soft-danger btn-sm" title="Delete" onclick="confirmDelete('{{ $cat['name'] }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="font-size:13px;color:#6c757d;">Showing 1 to 8 of 8 categories</span>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter category name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" placeholder="category-slug">
                        <div class="form-text">Auto-generated from name if left empty.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parent Category</label>
                        <select class="form-select">
                            <option value="">None (Top Level)</option>
                            <option>Silk Sarees</option>
                            <option>Cotton Sarees</option>
                            <option>Bridal Sarees</option>
                            <option>Designer Sarees</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" placeholder="Category description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="Silk Sarees" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" value="silk-sarees">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parent Category</label>
                        <select class="form-select">
                            <option value="">None (Top Level)</option>
                            <option selected>Silk Sarees</option>
                            <option>Cotton Sarees</option>
                            <option>Bridal Sarees</option>
                            <option>Designer Sarees</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3">Premium silk sarees handcrafted with traditional techniques.</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(name) {
    if (confirm('Are you sure you want to delete the category "' + name + '"?')) {
        alert('Delete functionality will be implemented.');
    }
}
</script>
@endpush
