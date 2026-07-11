@extends('admin.layouts.admin')

@section('title', 'Notifications')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Notifications</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Notifications</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <form method="POST" action="{{ route('admin.notifications.read-all') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-soft-primary">
                <i class="fas fa-check-double me-1"></i> Mark All as Read
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-8">
                <form method="GET" class="d-flex gap-2 flex-wrap">
                    <div class="input-group" style="max-width:300px;">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search notifications..." value="{{ request('search') }}">
                    </div>
                    <select name="filter" class="form-select" style="width:auto;" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="unread" {{ request('filter') === 'unread' ? 'selected' : '' }}>Unread</option>
                        <option value="read" {{ request('filter') === 'read' ? 'selected' : '' }}>Read</option>
                        <option value="today" {{ request('filter') === 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('filter') === 'week' ? 'selected' : '' }}>This Week</option>
                    </select>
                </form>
            </div>
        </div>

        @if($notifications->count() > 0)
            <div class="list-group list-group-flush">
                @foreach($notifications as $notification)
                <div class="list-group-item d-flex align-items-start gap-3 px-4 py-3 {{ !$notification->is_read ? 'list-group-item-primary bg-opacity-10' : '' }}">
                    <div class="flex-shrink-0 mt-1">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:40px;height:40px;background:{{ !$notification->is_read ? 'rgba(139,92,246,0.12)' : '#f1f3f5' }};">
                            <i class="fas {{ str_contains($notification->title, 'Order') ? 'fa-shopping-cart' : 'fa-bell' }}"
                               style="color:{{ !$notification->is_read ? '#8B5CF6' : '#6c757d' }};"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1 {{ !$notification->is_read ? 'fw-bold' : '' }}">{{ $notification->title }}</h6>
                            <small class="text-muted text-nowrap ms-2">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 text-muted small">{{ $notification->message }}</p>
                        @if($notification->order_id)
                            <a href="{{ route('admin.orders.show', $notification->order_id) }}" class="small text-decoration-none">
                                <i class="fas fa-external-link-alt me-1"></i>View Order
                            </a>
                        @endif
                    </div>
                    <div class="flex-shrink-0 d-flex gap-2">
                        @if(!$notification->is_read)
                            <form method="POST" action="{{ route('admin.notifications.read', $notification->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-soft-primary" title="Mark as Read">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.notifications.destroy', $notification->id) }}" class="d-inline" onsubmit="return confirm('Delete this notification?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-soft-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-3">
                {{ $notifications->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-bell fa-3x mb-3" style="color: #d1d5db;"></i>
                <h5>No notifications</h5>
                <p class="mb-0">No notifications found matching your criteria.</p>
            </div>
        @endif
    </div>
</div>
@endsection
