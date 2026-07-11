<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Order #{{ $order->order_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Courier New', monospace; font-size: 12px; padding: 20px; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: 700; }
        .border-bottom { border-bottom: 1px dashed #000; }
        .mb-1 { margin-bottom: 4px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .mt-3 { margin-top: 12px; }
        .mt-4 { margin-top: 16px; }
        .small { font-size: 10px; }
        .w-100 { width: 100%; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 4px 8px; text-align: left; }
        th { border-bottom: 1px solid #000; }
        .text-end { text-align: right; }
        .text-muted { opacity: 0.7; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="text-center no-print mb-3">
        <button class="btn btn-primary" onclick="window.print()">Print</button>
        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-light">Back</a>
    </div>

    <div class="text-center mb-3">
        <h3 class="fw-bold mb-1">AURA</h3>
        <div class="small">Premium Saree Collection</div>
        <div class="small">Order Receipt</div>
    </div>

    <div class="border-bottom mb-3"></div>

    <div class="mb-3">
        <div><strong>Order #:</strong> {{ $order->order_number }}</div>
        <div><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</div>
        <div><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
        <div><strong>Payment:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
        <div><strong>Payment Status:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</div>
    </div>

    @if($order->user)
    <div class="mb-3">
        <strong>Customer:</strong> {{ $order->user->name }}<br>
        <strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}<br>
        <strong>Email:</strong> {{ $order->user->email }}
    </div>
    @endif

    @if($order->shippingAddress)
    <div class="mb-3">
        <strong>Shipping Address:</strong><br>
        {{ $order->shippingAddress->name }}<br>
        {{ $order->shippingAddress->address_line1 }}<br>
        {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->zip_code }}<br>
        Phone: {{ $order->shippingAddress->phone }}
    </div>
    @endif

    <div class="border-bottom mb-3"></div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-end">Price</th>
                <th class="text-end">Qty</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td class="text-end">₹{{ number_format($item->price, 0) }}</td>
                <td class="text-end">{{ $item->quantity }}</td>
                <td class="text-end">₹{{ number_format($item->total, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="border-bottom mb-3"></div>

    <div class="text-end">
        <div>Subtotal: ₹{{ number_format($order->subtotal, 0) }}</div>
        @if($order->shipping_cost > 0)
        <div>Delivery: ₹{{ number_format($order->shipping_cost, 0) }}</div>
        @endif
        @if($order->discount > 0)
        <div>Discount: -₹{{ number_format($order->discount, 0) }}</div>
        @endif
        <div class="fw-bold mt-3" style="font-size:14px;">Grand Total: ₹{{ number_format($order->grand_total, 0) }}</div>
    </div>

    @if($order->notes)
    <div class="mt-3">
        <strong>Notes:</strong><br>
        {{ $order->notes }}
    </div>
    @endif

    <div class="border-bottom mb-3 mt-4"></div>

    <div class="text-center small mt-3">
        Thank you for your purchase!<br>
        AURA - Premium Saree Collection
    </div>
</body>
</html>
