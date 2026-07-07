@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Order #{{ $order->id }}</h4>
            <p class="text-muted small mb-0">Placed on {{ $order->created_at->format('d M, Y \a\t h:i A') }}</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-dark btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Orders</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white fw-semibold">Order Items</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th class="ps-4">Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div style="width:50px;height:60px;background:#f8f9fa;border-radius:6px;overflow:hidden;">
                                                    <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}" style="width:100%;height:100%;object-fit:cover;">
                                                </div>
                                                <span class="fw-medium">{{ $item->product_name }}</span>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end pe-4">${{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white fw-semibold">Order Summary</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span>${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tax</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Discount</span>
                            <span class="text-danger">-${{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>${{ number_format($order->grand_total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white fw-semibold">Status</div>
                <div class="card-body">
                    <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }} fs-6">{{ ucfirst($order->status) }}</span>
                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'secondary' }} fs-6 ms-2">{{ ucfirst($order->payment_status) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
