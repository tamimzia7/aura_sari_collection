@extends('layouts.app')

@section('title', 'Track Order #' . $order->id)

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Track Order #{{ $order->id }}</h4>
            <p class="text-muted small mb-0">Current Status: <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">{{ ucfirst($order->status) }}</span></p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-dark btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Orders</a>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-5">
            <div class="tracking-timeline">
                @php
                    $steps = [
                        'pending' => ['label' => 'Order Placed', 'icon' => 'fa-file-invoice', 'time' => $order->created_at],
                        'processing' => ['label' => 'Processing', 'icon' => 'fa-spinner', 'time' => $order->updated_at],
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
                        <div class="col-3 text-center position-relative">
                            <div class="step-circle mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle {{ $completed ? 'bg-success text-white' : ($active ? 'bg-primary text-white' : 'bg-light text-muted') }}" style="width:60px;height:60px;font-size:1.5rem;">
                                <i class="fas {{ $step['icon'] }}"></i>
                            </div>
                            <div class="fw-semibold small {{ $active ? 'text-primary' : ($completed ? 'text-success' : 'text-muted') }}">{{ $step['label'] }}</div>
                            @if($key === 'pending' && $order->status !== 'cancelled')
                                <div class="text-muted" style="font-size:0.75rem;">{{ $step['time']->format('d M, h:i A') }}</div>
                            @endif
                        </div>
                        @if(!$loop->last)
                            <div class="col-0 position-absolute" style="top:30px;left:calc(25% * {{ $loop->index + 1 }} - 12.5%);width:25%;height:2px;background:{{ $completed ? '#198754' : '#e9ecef' }};z-index:-1;"></div>
                        @endif
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

    @if(in_array($order->status, ['pending', 'processing']))
        <div class="text-center mt-4">
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                @csrf
                <button type="submit" class="btn btn-outline-danger"><i class="fas fa-ban me-1"></i> Cancel Order</button>
            </form>
        </div>
    @endif
</div>
@endsection
