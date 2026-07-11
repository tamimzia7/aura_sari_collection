@extends('admin.layouts.admin')

@section('title', 'Order #'.$order->order_number)

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Order #{{ $order->order_number }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                <li class="breadcrumb-item active">#{{ $order->order_number }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-soft-success" target="_blank">
            <i class="fas fa-file-invoice me-1"></i> Invoice
        </a>
        <a href="{{ route('admin.orders.print', $order->id) }}" class="btn btn-soft-primary" target="_blank">
            <i class="fas fa-print me-1"></i> Print
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-light"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Top Action Buttons --}}
<div class="row g-2 mb-4">
    <div class="col-12">
        <div class="d-flex gap-2 flex-wrap">
            @if($order->status === 'pending')
                <form method="POST" action="{{ route('admin.orders.confirm', $order->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fas fa-check me-1"></i> Confirm Order</button>
                </form>
                <form method="POST" action="{{ route('admin.orders.reject', $order->id) }}" class="d-inline" onsubmit="return confirm('Reject this order?')">
                    @csrf
                    <button type="submit" class="btn btn-danger"><i class="fas fa-times me-1"></i> Reject Order</button>
                </form>
            @endif
            @if($order->payment_status === 'pending_verification')
                <form method="POST" action="{{ route('admin.orders.verify-payment', $order->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle me-1"></i> Verify Payment</button>
                </form>
            @endif
            @if($order->payment_status !== 'paid' && $order->payment_status !== 'cash_on_delivery')
                <form method="POST" action="{{ route('admin.orders.mark-paid', $order->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-info text-white"><i class="fas fa-money-bill me-1"></i> Mark as Paid</button>
                </form>
            @endif
            @if(!in_array($order->status, ['delivered', 'cancelled']))
                <form method="POST" action="{{ route('admin.orders.cancel', $order->id) }}" class="d-inline" onsubmit="return confirm('Cancel this order?')">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-ban me-1"></i> Cancel Order</button>
                </form>
            @endif
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        {{-- Order Items --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-shopping-bag me-2"></i>Ordered Products</span>
                <span class="badge-status {{ $order->status === 'cancelled' ? 'cancelled' : ($order->status === 'delivered' ? 'delivered' : ($order->status === 'confirmed' ? 'active' : $order->status)) }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold" style="font-size:14px;">{{ $item->product_name }}</div>
                            </td>
                            <td>
                                <div style="width:48px;height:48px;border-radius:8px;background:#f1f3f5;display:flex;align-items:center;justify-content:center;font-size:18px;color:#adb5bd;flex-shrink:0;overflow:hidden;">
                                    @if($item->product_image)
                                        <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}" style="width:100%;height:100%;object-fit:cover;" onerror="this.parentElement.innerHTML='<i class=\'fas fa-tshirt\'></i>'">
                                    @else
                                        <i class="fas fa-tshirt"></i>
                                    @endif
                                </div>
                            </td>
                            <td>₹{{ number_format($item->price, 0) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td style="text-align:right;font-weight:600;">₹{{ number_format($item->total, 0) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No items found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Order Timeline --}}
        <div class="card mb-4">
            <div class="card-header">
                <span><i class="fas fa-clock me-2"></i>Order Timeline</span>
            </div>
            <div class="card-body">
                <div class="order-timeline">
                    @php
                        $statusSteps = [
                            'pending' => ['label' => 'Order Placed', 'icon' => 'fa-receipt'],
                            'confirmed' => ['label' => 'Confirmed', 'icon' => 'fa-check'],
                            'processing' => ['label' => 'Processing', 'icon' => 'fa-spinner'],
                            'shipped' => ['label' => 'Shipped', 'icon' => 'fa-truck'],
                            'delivered' => ['label' => 'Delivered', 'icon' => 'fa-check-circle'],
                        ];
                        $currentIndex = array_search($order->status, array_keys($statusSteps));
                        if ($order->status === 'cancelled') $currentIndex = -1;
                    @endphp

                    @foreach($statusSteps as $stepKey => $step)
                        @php
                            $stepIndex = array_search($stepKey, array_keys($statusSteps));
                            if ($order->status === 'cancelled') {
                                $stateClass = $stepIndex <= $currentIndex ? 'completed' : '';
                            } else {
                                $stateClass = $stepIndex < $currentIndex ? 'completed' : ($stepIndex === $currentIndex ? 'current' : '');
                            }
                        @endphp
                        <div class="timeline-item">
                            <div class="timeline-icon {{ $stateClass }}">
                                <i class="fas {{ $step['icon'] }}"></i>
                            </div>
                            <div class="timeline-text">{{ $step['label'] }}</div>
                            @if($stepIndex === $currentIndex && $order->status !== 'cancelled')
                                <div class="timeline-time">Current</div>
                            @endif
                        </div>
                    @endforeach
                    @if($order->status === 'cancelled')
                        <div class="timeline-item">
                            <div class="timeline-icon completed" style="background:#dc3545;border-color:#dc3545;">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="timeline-text" style="color:#dc3545;">Cancelled</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Order Notes --}}
        @if($order->notes)
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-sticky-note me-2"></i>Order Notes</div>
            <div class="card-body">
                <p class="mb-0">{{ $order->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        {{-- Order Information / Status Update --}}
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-info-circle me-2"></i>Order Information</div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Order #</div>
                        <div class="fw-semibold">{{ $order->order_number }}</div>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Order Date</div>
                        <div>{{ $order->created_at->format('M j, Y \a\t g:i A') }}</div>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Order Status</div>
                        <div>
                            <span class="badge-status {{ $order->status === 'cancelled' ? 'cancelled' : ($order->status === 'delivered' ? 'delivered' : ($order->status === 'confirmed' ? 'active' : $order->status)) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    @if($order->payment_method)
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Payment Method</div>
                        <div class="fw-semibold">
                            @php
                                $methodLabels = ['cod' => 'Cash on Delivery', 'bkash' => 'bKash', 'nagad' => 'Nagad', 'rocket' => 'Rocket'];
                            @endphp
                            {{ $methodLabels[$order->payment_method] ?? ucfirst($order->payment_method) }}
                        </div>
                    </div>
                    @endif
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Payment Status</div>
                        <div>
                            @php $ps = $order->payment_status; @endphp
                            @if($ps === 'paid')
                                <span class="badge-status active">Paid</span>
                            @elseif($ps === 'cash_on_delivery')
                                <span class="badge-status" style="background:rgba(16,185,129,0.12);color:#059669;">Cash on Delivery</span>
                            @elseif($ps === 'pending_verification')
                                <span class="badge-status pending">Pending Verification</span>
                            @else
                                <span class="badge-status {{ $ps }}">{{ ucfirst($ps) }}</span>
                            @endif
                        </div>
                    </div>
                    @if($order->transaction_id)
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Transaction ID</div>
                        <div class="fw-semibold">{{ $order->transaction_id }}</div>
                    </div>
                    @endif
                    @if($order->sender_number)
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Sender Number</div>
                        <div>{{ $order->sender_number }}</div>
                    </div>
                    @endif
                    @if($order->coupon_code)
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Coupon</div>
                        <div><span class="badge bg-light text-dark">{{ $order->coupon_code }}</span></div>
                    </div>
                    @endif
                </div>

                <hr>

                {{-- Total Summary --}}
                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">Subtotal</span>
                    <span>₹{{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->shipping_cost > 0)
                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">Delivery Charge</span>
                    <span>₹{{ number_format($order->shipping_cost, 0) }}</span>
                </div>
                @endif
                @if($order->discount > 0)
                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">Discount</span>
                    <span class="text-success">-₹{{ number_format($order->discount, 0) }}</span>
                </div>
                @endif
                <div class="d-flex justify-content-between fw-bold fs-6">
                    <span>Total</span>
                    <span>₹{{ number_format($order->grand_total, 0) }}</span>
                </div>

                <hr>

                {{-- Status Update Form --}}
                <form method="POST" action="{{ route('admin.orders.status', $order->id) }}">
                    @csrf
                    <label class="form-label">Update Order Status</label>
                    <div class="input-group mb-2">
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                    <label class="form-label">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        <option value="">No change</option>
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="pending_verification" {{ $order->payment_status === 'pending_verification' ? 'selected' : '' }}>Pending Verification</option>
                        <option value="cash_on_delivery" {{ $order->payment_status === 'cash_on_delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </form>
            </div>
        </div>

        {{-- Customer Information --}}
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-user me-2"></i>Customer Information</div>
            <div class="card-body">
                @if($order->user)
                @php
                    $colors = ['#8B5CF6', '#10b981', '#f59e0b', '#ef4444', '#6366f1'];
                    $bg = $colors[$order->user->id % count($colors)];
                    $initials = collect(explode(' ', $order->user->name))->map(fn($p) => strtoupper(substr($p, 0, 1)))->implode('');
                @endphp
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="avatar-md" style="background:{{ $bg }};">{{ $initials }}</div>
                    <div>
                        <div class="fw-semibold">{{ $order->user->name }}</div>
                        <div style="font-size:13px;color:#6c757d;">{{ $order->user->email }}</div>
                    </div>
                </div>
                @if($order->user->phone)
                <div style="font-size:13px;">
                    <div class="mb-2">
                        <i class="fas fa-phone me-2" style="color:#9ca3af;width:16px;"></i> {{ $order->user->phone }}
                    </div>
                </div>
                @endif
                <hr>
                <div style="font-size:13px;">
                    <div class="mb-1"><span class="text-muted">Total Orders:</span> <strong>{{ $order->user->orders()->count() }}</strong></div>
                    <div class="mb-1"><span class="text-muted">Customer Since:</span> <strong>{{ $order->user->created_at->format('M Y') }}</strong></div>
                </div>
                @else
                <p class="text-muted mb-0">Guest checkout</p>
                @endif
            </div>
        </div>

        {{-- Shipping Address --}}
        @if($order->shippingAddress)
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</div>
            <div class="card-body">
                <div class="fw-semibold mb-1">{{ $order->shippingAddress->name }}</div>
                <div style="font-size:13px;color:#6c757d;">
                    <div>{{ $order->shippingAddress->address_line1 }}</div>
                    @if($order->shippingAddress->address_line2)
                    <div>{{ $order->shippingAddress->address_line2 }}</div>
                    @endif
                    <div>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->zip_code }}</div>
                    @if($order->shippingAddress->phone)
                    <div>Phone: {{ $order->shippingAddress->phone }}</div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Billing Address --}}
        @if($order->billingAddress && $order->billingAddress->id !== $order->shippingAddress?->id)
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-file-invoice me-2"></i>Billing Address</div>
            <div class="card-body">
                <div class="fw-semibold mb-1">{{ $order->billingAddress->name }}</div>
                <div style="font-size:13px;color:#6c757d;">
                    <div>{{ $order->billingAddress->address_line1 }}</div>
                    @if($order->billingAddress->address_line2)
                    <div>{{ $order->billingAddress->address_line2 }}</div>
                    @endif
                    <div>{{ $order->billingAddress->city }}, {{ $order->billingAddress->state }} {{ $order->billingAddress->zip_code }}</div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
