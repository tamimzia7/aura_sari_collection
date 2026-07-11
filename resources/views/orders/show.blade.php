@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Order #{{ $order->order_number }}</h4>
            <p class="text-muted small mb-0">Placed on {{ $order->created_at->format('d M, Y \a\t h:i A') }}</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-dark btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Orders</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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
                                                    @if($item->product_image)
                                                        <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fas fa-tshirt text-muted\'></i>'">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center h-100"><i class="fas fa-tshirt text-muted"></i></div>
                                                    @endif
                                                </div>
                                                <span class="fw-medium">{{ $item->product_name }}</span>
                                            </div>
                                        </td>
                                        <td>₹{{ number_format($item->price, 0) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end pe-4">₹{{ number_format($item->total, 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white fw-semibold"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</div>
                <div class="card-body">
                    @if($order->shippingAddress)
                        <p class="fw-medium mb-1">{{ $order->shippingAddress->name }}</p>
                        <p class="text-muted mb-1">{{ $order->shippingAddress->address_line1 }}</p>
                        @if($order->shippingAddress->address_line2)
                            <p class="text-muted mb-1">{{ $order->shippingAddress->address_line2 }}</p>
                        @endif
                        <p class="text-muted mb-1">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->zip_code }}</p>
                        @if($order->shippingAddress->phone)
                            <p class="text-muted mb-0">Phone: {{ $order->shippingAddress->phone }}</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white fw-semibold">Order Summary</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>₹{{ number_format($order->subtotal, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Delivery Charge</span>
                        <span>{{ $order->shipping_cost > 0 ? '₹'.number_format($order->shipping_cost, 0) : 'FREE' }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Discount</span>
                            <span class="text-danger">-₹{{ number_format($order->discount, 0) }}</span>
                        </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>₹{{ number_format($order->grand_total, 0) }}</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white fw-semibold">Payment Information</div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="text-muted small">Method:</span>
                        <span class="fw-medium">
                            @php
                                $methodLabels = ['cod' => 'Cash on Delivery', 'bkash' => 'bKash', 'nagad' => 'Nagad', 'rocket' => 'Rocket'];
                            @endphp
                            {{ $methodLabels[$order->payment_method] ?? ucfirst($order->payment_method) }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Status:</span>
                        @php $ps = $order->payment_status; @endphp
                        @if($ps === 'paid')
                            <span class="badge bg-success">Paid</span>
                        @elseif($ps === 'cash_on_delivery')
                            <span class="badge bg-info text-dark">Cash on Delivery</span>
                        @elseif($ps === 'pending_verification')
                            <span class="badge bg-warning text-dark">Pending Verification</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($ps) }}</span>
                        @endif
                    </div>
                    @if($order->transaction_id)
                    <div class="mb-2">
                        <span class="text-muted small">Transaction ID:</span>
                        <span class="fw-medium">{{ $order->transaction_id }}</span>
                    </div>
                    @endif
                    @if($order->sender_number)
                    <div class="mb-2">
                        <span class="text-muted small">Sender Number:</span>
                        <span>{{ $order->sender_number }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white fw-semibold">Status</div>
                <div class="card-body">
                    <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }} fs-6">{{ ucfirst($order->status) }}</span>
                </div>
            </div>

            @if(in_array($order->status, ['pending', 'confirmed', 'processing']))
                <div class="text-center">
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100"><i class="fas fa-ban me-1"></i> Cancel Order</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
