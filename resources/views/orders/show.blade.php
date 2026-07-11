@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)

@push('styles')
<style>
.status-timeline {
    position: relative;
    padding: 10px 0;
}
.status-timeline .tl-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding-bottom: 24px;
    position: relative;
}
.status-timeline .tl-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 32px;
    bottom: 0;
    width: 2px;
    background: #e0e0e0;
}
.status-timeline .tl-item:last-child { padding-bottom: 0; }
.status-timeline .tl-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    color: #fff;
    flex-shrink: 0;
    z-index: 1;
}
.status-timeline .tl-icon.completed { background: #198754; }
.status-timeline .tl-icon.current { background: #0d6efd; box-shadow: 0 0 0 4px rgba(13,110,253,0.15); }
.status-timeline .tl-icon.pending-state { background: #adb5bd; }
.status-timeline .tl-icon.cancelled { background: #dc3545; }
</style>
@endpush

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
            {{-- Order Timeline --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white fw-semibold"><i class="fas fa-clock me-2"></i>Order Status</div>
                <div class="card-body">
                    <div class="status-timeline">
                        @php
                            $steps = ['pending' => ['label' => 'Order Placed', 'icon' => 'fa-receipt'],
                                       'confirmed' => ['label' => 'Confirmed', 'icon' => 'fa-check'],
                                       'processing' => ['label' => 'Processing', 'icon' => 'fa-spinner'],
                                       'shipped' => ['label' => 'Shipped', 'icon' => 'fa-truck'],
                                       'delivered' => ['label' => 'Delivered', 'icon' => 'fa-check-circle']];
                            $currentIdx = array_search($order->status, array_keys($steps));
                            if ($order->status === 'cancelled') $currentIdx = -1;
                        @endphp
                        @foreach($steps as $key => $step)
                            @php
                                $idx = array_search($key, array_keys($steps));
                                if ($order->status === 'cancelled') {
                                    $cls = $idx <= $currentIdx ? 'completed' : 'pending-state';
                                } else {
                                    $cls = $idx < $currentIdx ? 'completed' : ($idx === $currentIdx ? 'current' : 'pending-state');
                                }
                            @endphp
                            <div class="tl-item">
                                <div class="tl-icon {{ $cls }}"><i class="fas {{ $step['icon'] }}"></i></div>
                                <div>
                                    <div class="fw-medium small">{{ $step['label'] }}</div>
                                    @if($idx === $currentIdx && $order->status !== 'cancelled')
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill small">Current</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @if($order->status === 'cancelled')
                            <div class="tl-item">
                                <div class="tl-icon cancelled"><i class="fas fa-times"></i></div>
                                <div><div class="fw-medium small text-danger">Cancelled</div></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

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
