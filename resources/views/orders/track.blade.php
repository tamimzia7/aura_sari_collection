@extends('layouts.app')

@section('title', 'Track Order #' . $order->order_number)

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Track Order #{{ $order->order_number }}</h4>
            <p class="text-muted small mb-0">
                Current Status:
                <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>
        <div>
            @if($order->payment_status === 'pending_verification')
                <span class="badge bg-warning text-dark me-2"><i class="fas fa-clock me-1"></i>Payment Pending Verification</span>
            @endif
            <a href="{{ route('orders.index') }}" class="btn btn-outline-dark btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Orders</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-5">
            <div class="tracking-timeline">
                @php
                    $steps = [
                        'pending' => ['label' => 'Order Placed', 'icon' => 'fa-file-invoice', 'time' => $order->created_at],
                        'confirmed' => ['label' => 'Confirmed', 'icon' => 'fa-check', 'time' => null],
                        'processing' => ['label' => 'Processing', 'icon' => 'fa-spinner', 'time' => null],
                        'shipped' => ['label' => 'Shipped', 'icon' => 'fa-truck', 'time' => null],
                        'delivered' => ['label' => 'Delivered', 'icon' => 'fa-check-circle', 'time' => null],
                    ];
                    $currentIndex = array_search($order->status, array_keys($steps));
                @endphp

                <div class="row">
                    @foreach($steps as $key => $step)
                        @php
                            $completed = array_search($key, array_keys($steps)) <= $currentIndex && $order->status !== 'cancelled';
                            $active = array_search($key, array_keys($steps)) === $currentIndex && $order->status !== 'cancelled';
                        @endphp
                        <div class="col position-relative text-center">
                            <div class="step-circle mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle {{ $completed ? 'bg-success text-white' : ($active ? 'bg-primary text-white' : 'bg-light text-muted') }}" style="width:60px;height:60px;font-size:1.5rem;">
                                <i class="fas {{ $step['icon'] }}"></i>
                            </div>
                            <div class="fw-semibold small {{ $active ? 'text-primary' : ($completed ? 'text-success' : 'text-muted') }}">{{ $step['label'] }}</div>
                            @if($key === 'pending' && $order->status !== 'cancelled')
                                <div class="text-muted" style="font-size:0.75rem;">{{ $step['time']->format('d M, h:i A') }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if($order->status === 'cancelled')
                    <div class="text-center mt-5">
                        <span class="badge bg-danger fs-6 p-3"><i class="fas fa-times-circle me-2"></i>This order has been cancelled</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 mt-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2"></i>Order Details</h6>
            <div class="row g-3">
                <div class="col-md-3">
                    <span class="text-muted small">Order #</span>
                    <div class="fw-medium">{{ $order->order_number }}</div>
                </div>
                <div class="col-md-3">
                    <span class="text-muted small">Payment Method</span>
                    <div class="fw-medium">
                        @php
                            $methodLabels = ['cod' => 'Cash on Delivery', 'bkash' => 'bKash', 'nagad' => 'Nagad', 'rocket' => 'Rocket'];
                        @endphp
                        {{ $methodLabels[$order->payment_method] ?? ucfirst($order->payment_method) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <span class="text-muted small">Payment Status</span>
                    <div>
                        @php $ps = $order->payment_status; @endphp
                        @if($ps === 'paid')
                            <span class="badge bg-success">Paid</span>
                        @elseif($ps === 'cash_on_delivery')
                            <span class="badge bg-info text-dark">COD</span>
                        @elseif($ps === 'pending_verification')
                            <span class="badge bg-warning text-dark">Pending Verification</span>
                        @else
                            <span class="badge bg-secondary">{{ $ps }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <span class="text-muted small">Total</span>
                    <div class="fw-medium fs-5">₹{{ number_format($order->grand_total, 0) }}</div>
                </div>
            </div>
        </div>
    </div>

    @if(in_array($order->status, ['pending', 'confirmed', 'processing']))
        <div class="text-center mt-4">
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                @csrf
                <button type="submit" class="btn btn-outline-danger"><i class="fas fa-ban me-1"></i> Cancel Order</button>
            </form>
        </div>
    @endif
</div>
@endsection
