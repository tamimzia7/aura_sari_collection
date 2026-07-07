@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">My Orders</h2>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th class="ps-4">Order</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="ps-4 fw-medium">#{{ $order->id }}</td>
                                    <td class="text-muted small">{{ $order->created_at->format('d M, Y') }}</td>
                                    <td><span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">{{ ucfirst($order->status) }}</span></td>
                                    <td class="fw-medium">${{ number_format($order->grand_total, 2) }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-dark btn-sm">View</a>
                                        <a href="{{ route('orders.track', $order->id) }}" class="btn btn-outline-primary btn-sm">Track</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-top">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3 text-muted" style="font-size: 4rem;"><i class="fas fa-box-open"></i></div>
                    <h5 class="fw-bold">No orders yet</h5>
                    <p class="text-muted mb-3">You haven't placed any orders yet.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-dark rounded-pill px-4">Browse Collection</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
