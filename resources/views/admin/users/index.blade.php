@extends('admin.layouts.admin')

@section('title', 'Users')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Users</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus me-1"></i> Add User
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="search-box" style="position:relative;width:100%;">
                    <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#adb5bd;font-size:14px;"></i>
                    <input type="text" class="form-control" placeholder="Search users..." style="padding-left:40px;">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">All Roles</option>
                    <option>Super Admin</option>
                    <option>Admin</option>
                    <option>Manager</option>
                    <option>Staff</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Suspended</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-soft-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Active</th>
                        <th>Joined</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $users = [
                            ['name' => 'Arjun Mehta', 'email' => 'arjun@aurasaree.com', 'role' => 'Super Admin', 'status' => 'Active', 'last' => 'Just now', 'joined' => 'Jan 1, 2024'],
                            ['name' => 'Sneha Kapoor', 'email' => 'sneha@aurasaree.com', 'role' => 'Admin', 'status' => 'Active', 'last' => '2 mins ago', 'joined' => 'Mar 15, 2024'],
                            ['name' => 'Vikram Singh', 'email' => 'vikram@aurasaree.com', 'role' => 'Manager', 'status' => 'Active', 'last' => '1 hour ago', 'joined' => 'Jun 20, 2024'],
                            ['name' => 'Divya Sharma', 'email' => 'divya@aurasaree.com', 'role' => 'Staff', 'status' => 'Active', 'last' => '3 hours ago', 'joined' => 'Sep 5, 2024'],
                            ['name' => 'Rahul Verma', 'email' => 'rahul@aurasaree.com', 'role' => 'Staff', 'status' => 'Active', 'last' => 'Yesterday', 'joined' => 'Nov 12, 2024'],
                            ['name' => 'Priya Nair', 'email' => 'priya@aurasaree.com', 'role' => 'Manager', 'status' => 'Inactive', 'last' => '3 days ago', 'joined' => 'Feb 28, 2025'],
                            ['name' => 'Amit Patel', 'email' => 'amit@aurasaree.com', 'role' => 'Staff', 'status' => 'Active', 'last' => '5 hours ago', 'joined' => 'Apr 10, 2025'],
                            ['name' => 'Kiran Joshi', 'email' => 'kiran@aurasaree.com', 'role' => 'Staff', 'status' => 'Suspended', 'last' => '1 week ago', 'joined' => 'Aug 3, 2024'],
                        ];
                    @endphp

                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-sm" style="background:{{ ['#8B5CF6','#3b82f6','#10b981','#f59e0b','#ef4444','#6366f1','#ec4899','#14b8a6'][$loop->index % 8] }};">
                                    {{ preg_replace('/[^A-Z]/', '', $user['name']) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size:14px;">{{ $user['name'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px;">{{ $user['email'] }}</td>
                        <td>
                            @if($user['role'] === 'Super Admin')
                                <span class="badge bg-danger" style="font-weight:500;">Super Admin</span>
                            @elseif($user['role'] === 'Admin')
                                <span class="badge bg-primary" style="font-weight:500;">Admin</span>
                            @elseif($user['role'] === 'Manager')
                                <span class="badge bg-info text-dark" style="font-weight:500;">Manager</span>
                            @else
                                <span class="badge bg-secondary" style="font-weight:500;">Staff</span>
                            @endif
                        </td>
                        <td>
                            @if($user['status'] === 'Active')
                                <span class="badge-status active">Active</span>
                            @elseif($user['status'] === 'Inactive')
                                <span class="badge-status draft">Inactive</span>
                            @else
                                <span class="badge-status inactive">Suspended</span>
                            @endif
                        </td>
                        <td style="font-size:13px;color:#6c757d;">{{ $user['last'] }}</td>
                        <td style="font-size:13px;color:#6c757d;">{{ $user['joined'] }}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-soft-danger btn-sm" title="Delete" onclick="confirmDelete('{{ $user['name'] }}')">
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
        <span style="font-size:13px;color:#6c757d;">Showing 1 to 8 of 12 users</span>
        <nav>
            <ul class="pagination pagination-sm">
                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter full name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" placeholder="email@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" placeholder="Create a password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" placeholder="Confirm password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select" required>
                            <option value="">Select Role</option>
                            <option>Super Admin</option>
                            <option>Admin</option>
                            <option selected>Manager</option>
                            <option>Staff</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="Arjun Mehta" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" value="arjun@aurasaree.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" placeholder="Leave blank to keep current">
                        <div class="form-text">Leave blank to keep current password.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select" required>
                            <option>Super Admin</option>
                            <option>Admin</option>
                            <option>Manager</option>
                            <option>Staff</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(name) {
    if (confirm('Are you sure you want to delete user "' + name + '"?')) {
        alert('Delete functionality will be implemented.');
    }
}
</script>
@endpush
