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
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-light"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Order Items</span>
                <span class="badge-status {{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:48px;height:48px;border-radius:8px;background:#f1f3f5;display:flex;align-items:center;justify-content:center;font-size:18px;color:#adb5bd;flex-shrink:0;overflow:hidden;">
                                        @if($item->product_image)
                                            <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}" style="width:100%;height:100%;object-fit:cover;">
                                        @else
                                            <i class="fas fa-tshirt"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="font-size:14px;">{{ $item->product_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>₹{{ number_format($item->price, 0) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td style="text-align:right;font-weight:600;">₹{{ number_format($item->total, 0) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No items found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align:right;font-weight:500;">Subtotal:</td>
                            <td style="text-align:right;">₹{{ number_format($order->subtotal, 0) }}</td>
                        </tr>
                        @if($order->shipping_cost > 0)
                        <tr>
                            <td colspan="3" style="text-align:right;font-weight:500;">Shipping:</td>
                            <td style="text-align:right;">₹{{ number_format($order->shipping_cost, 0) }}</td>
                        </tr>
                        @endif
                        @if($order->discount > 0)
                        <tr>
                            <td colspan="3" style="text-align:right;font-weight:500;">Discount:</td>
                            <td style="text-align:right;color:#10b981;">-₹{{ number_format($order->discount, 0) }}</td>
                        </tr>
                        @endif
                        @if($order->tax > 0)
                        <tr>
                            <td colspan="3" style="text-align:right;font-weight:500;">Tax:</td>
                            <td style="text-align:right;">₹{{ number_format($order->tax, 0) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3" style="text-align:right;font-weight:600;font-size:16px;">Total:</td>
                            <td style="text-align:right;font-weight:700;font-size:16px;color:var(--sidebar-bg);">₹{{ number_format($order->grand_total, 0) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @if($order->notes)
        <div class="card mb-4">
            <div class="card-header">Order Notes</div>
            <div class="card-body">
                <p class="mb-0">{{ $order->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">Order Information</div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Order #</div>
                        <div class="fw-semibold">{{ $order->order_number }}</div>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Date</div>
                        <div>{{ $order->created_at->format('M j, Y \a\t g:i A') }}</div>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Status</div>
                        <div>
                            <span class="badge-status {{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                    @if($order->payment_method)
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Payment Method</div>
                        <div>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</div>
                    </div>
                    @endif
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Payment Status</div>
                        <div><span class="badge-status {{ $order->payment_status === 'paid' ? 'active' : $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></div>
                    </div>
                    @if($order->coupon_code)
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Coupon</div>
                        <div><span class="badge bg-light text-dark">{{ $order->coupon_code }}</span></div>
                    </div>
                    @endif
                </div>

                <hr>

                <form method="POST" action="{{ route('admin.orders.status', $order->id) }}">
                    @csrf
                    <label class="form-label">Update Status</label>
                    <div class="input-group">
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="">No change</option>
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Customer Information</div>
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
                </div>
                @else
                <p class="text-muted mb-0">Guest checkout</p>
                @endif
            </div>
        </div>

        @if($order->shippingAddress)
        <div class="card">
            <div class="card-header">Shipping Address</div>
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

        @if($order->billingAddress && $order->billingAddress->id !== $order->shippingAddress?->id)
        <div class="card mt-4">
            <div class="card-header">Billing Address</div>
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