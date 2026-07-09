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
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add User
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Orders</th>
                        <th>Joined</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    @php
                        $colors = ['#8B5CF6','#3b82f6','#10b981','#f59e0b','#ef4444','#6366f1','#ec4899','#14b8a6'];
                        $bg = $colors[$loop->index % count($colors)];
                        $initials = collect(explode(' ', $user->name))->map(fn($p) => strtoupper(substr($p, 0, 1)))->implode('');
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-sm" style="background:{{ $bg }};">{{ $initials }}</div>
                                <div>
                                    <div class="fw-semibold" style="font-size:14px;">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px;">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger" style="font-weight:500;">Admin</span>
                            @else
                                <span class="badge bg-secondary" style="font-weight:500;">{{ ucfirst($user->role) }}</span>
                            @endif
                        </td>
                        <td><span class="badge bg-light text-dark">{{ $user->orders_count }}</span></td>
                        <td style="font-size:13px;color:#6c757d;">{{ $user->created_at->format('M j, Y') }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-soft-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-soft-danger btn-sm" title="Delete" onclick="confirmDelete('{{ $user->name }}', {{ $user->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="font-size:13px;color:#6c757d;">
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
        </span>
        {{ $users->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(name, id) {
    if (confirm('Are you sure you want to delete user "' + name + '"?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush