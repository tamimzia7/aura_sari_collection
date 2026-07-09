@extends('admin.layouts.admin')

@section('title', 'Customers')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Customers</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Customers</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th style="text-align:center;">Orders</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    @php
                        $colors = ['#8B5CF6','#10b981','#f59e0b','#3b82f6','#ef4444','#6366f1','#ec4899','#14b8a6','#f97316','#06b6d4'];
                        $bg = $colors[$loop->index % count($colors)];
                        $initials = collect(explode(' ', $customer->name))->map(fn($p) => strtoupper(substr($p, 0, 1)))->implode('');
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-sm" style="background:{{ $bg }};">{{ $initials }}</div>
                                <div>
                                    <div class="fw-semibold" style="font-size:14px;">{{ $customer->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px;">{{ $customer->email }}</td>
                        <td style="font-size:13px;">{{ $customer->phone ?? 'N/A' }}</td>
                        <td style="text-align:center;"><span class="badge bg-light text-dark">{{ $customer->orders_count }}</span></td>
                        <td style="font-size:13px;color:#6c757d;">{{ $customer->created_at->format('M j, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No customers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($customers->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="font-size:13px;color:#6c757d;">
            Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} customers
        </span>
        {{ $customers->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection