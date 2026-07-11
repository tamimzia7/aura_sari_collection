@extends('layouts.app')

@section('title', 'Notifications')

@push('styles')
<style>
.notif-page .notif-header {
    background: #fff;
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.notif-page .notif-item {
    background: #fff;
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 12px;
    border: 1px solid #f0f0f0;
    transition: all 0.2s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.notif-page .notif-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    transform: translateY(-1px);
}
.notif-page .notif-item.unread {
    border-left: 4px solid #d4af37;
    background: #fdfcf5;
}
.notif-page .notif-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.notif-page .notif-icon.status-update {
    background: rgba(13,110,253,0.1);
    color: #0d6efd;
}
.notif-page .notif-icon.payment {
    background: rgba(25,135,84,0.1);
    color: #198754;
}
.notif-page .notif-icon.cancelled {
    background: rgba(220,53,69,0.1);
    color: #dc3545;
}
.notif-page .notif-icon.default {
    background: rgba(212,175,55,0.1);
    color: #d4af37;
}
</style>
@endpush

@section('content')
<div class="notif-page bg-light min-vh-100 py-4">
    <div class="container">
        <div class="notif-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-1"><i class="fas fa-bell me-2"></i>Notifications</h5>
                <p class="text-muted small mb-0">Stay updated with your orders</p>
            </div>
            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('notifications.read-all') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark btn-sm rounded-pill">
                        <i class="fas fa-check-double me-1"></i> Mark All Read
                    </button>
                </form>
            </div>
        </div>

        <div class="mb-3">
            <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
                <div class="input-group" style="max-width:280px;">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search notifications..." value="{{ request('search') }}">
                </div>
                <select name="filter" class="form-select" style="width:auto;min-width:140px;" onchange="this.form.submit()">
                    <option value="">All Notifications</option>
                    <option value="unread" {{ request('filter') === 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ request('filter') === 'read' ? 'selected' : '' }}>Read</option>
                    <option value="today" {{ request('filter') === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ request('filter') === 'week' ? 'selected' : '' }}>This Week</option>
                </select>
            </form>
        </div>

        @forelse($notifications as $notification)
            <div class="notif-item d-flex align-items-start gap-3 {{ !$notification->is_read ? 'unread' : '' }}">
                <div class="notif-icon
                    @if(str_contains($notification->title, 'Verified') || str_contains($notification->title, 'Paid')) payment
                    @elseif(str_contains($notification->title, 'Cancelled')) cancelled
                    @elseif(str_contains($notification->title, 'Order')) status-update
                    @else default
                    @endif">
                    <i class="fas
                        @if(str_contains($notification->title, 'Delivered')) fa-check-circle
                        @elseif(str_contains($notification->title, 'Shipped')) fa-truck
                        @elseif(str_contains($notification->title, 'Confirmed')) fa-check
                        @elseif(str_contains($notification->title, 'Processing')) fa-spinner
                        @elseif(str_contains($notification->title, 'Cancelled')) fa-times-circle
                        @elseif(str_contains($notification->title, 'Verified') || str_contains($notification->title, 'Paid')) fa-money-bill-wave
                        @else fa-bell
                        @endif"></i>
                </div>
                <div class="flex-grow-1 min-width-0">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1 {{ !$notification->is_read ? 'fw-bold' : '' }}">{{ $notification->title }}</h6>
                            <p class="mb-1 text-muted small">{{ $notification->message }}</p>
                        </div>
                        <small class="text-muted text-nowrap ms-3">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        @if($notification->order_id)
                            <a href="{{ route('orders.show', $notification->order_id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                <i class="fas fa-external-link-alt me-1"></i> View Order
                            </a>
                        @endif
                        @if(!$notification->is_read)
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-link text-decoration-none text-muted p-0">
                                    <i class="fas fa-check me-1"></i>Mark as Read
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-link text-decoration-none text-danger p-0">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-bell fa-3x text-muted mb-3"></i>
                <h5 class="fw-bold">No notifications</h5>
                <p class="text-muted">You're all caught up!</p>
            </div>
        @endforelse

        <div class="mt-3">
            {{ $notifications->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
