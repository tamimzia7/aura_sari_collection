<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f8f9fa; padding: 40px; }
        .invoice-box { max-width: 900px; margin: 0 auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); overflow: hidden; }
        .invoice-header { padding: 40px 48px 24px; border-bottom: 2px solid #f0f0f0; }
        .invoice-body { padding: 24px 48px 32px; }
        .invoice-footer { padding: 20px 48px; background: #f8f9fa; border-top: 1px solid #f0f0f0; text-align: center; font-size: 13px; color: #6c757d; }
        .status-badge { display: inline-block; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .status-badge.pending { background: rgba(245,158,11,0.12); color: #d97706; }
        .status-badge.paid { background: rgba(16,185,129,0.12); color: #059669; }
        .status-badge.delivered { background: rgba(16,185,129,0.12); color: #059669; }
        .status-badge.cancelled { background: rgba(239,68,68,0.12); color: #dc2626; }
        .table th { font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; border-bottom: 2px solid #e9ecef; }
        .table td { font-size: 14px; vertical-align: middle; }
        @media print { body { padding: 0; background: #fff; } .invoice-box { box-shadow: none; } .no-print { display: none !important; } }
    </style>
</head>
<body>
    <div class="text-center mb-4 no-print">
        <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print me-1"></i> Print</button>
        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-light"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <div class="invoice-box">
        <div class="invoice-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="fw-bold mb-1" style="letter-spacing: -0.5px;">AURA</h2>
                    <p class="text-muted mb-0" style="font-size: 13px;">Premium Saree Collection</p>
                </div>
                <div class="text-end">
                    <h4 class="fw-bold mb-1">INVOICE</h4>
                    <p class="text-muted mb-0" style="font-size: 13px;">#{{ $order->order_number }}</p>
                </div>
            </div>
        </div>

        <div class="invoice-body">
            <div class="row g-4 mb-4">
                <div class="col-6">
                    <small class="text-muted text-uppercase" style="letter-spacing: 0.5px;">Bill To</small>
                    <div class="fw-semibold mt-1">{{ $order->shippingAddress?->name ?? $order->user?->name }}</div>
                    <div style="font-size: 13px; color: #6c757d;">
                        @if($order->shippingAddress)
                            {{ $order->shippingAddress->address_line1 }}<br>
                            {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->zip_code }}<br>
                        @endif
                        @if($order->user)
                            {{ $order->user->email }}<br>
                            {{ $order->user->phone }}
                        @endif
                    </div>
                </div>
                <div class="col-6 text-end">
                    <small class="text-muted text-uppercase" style="letter-spacing: 0.5px;">Invoice Details</small>
                    <div style="font-size: 13px; color: #6c757d;" class="mt-1">
                        <div>Date: {{ $order->created_at->format('M d, Y') }}</div>
                        <div>Order Status: <span class="status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></div>
                        <div>Payment: <span class="status-badge {{ $order->payment_status === 'paid' ? 'paid' : 'pending' }}">{{ ucfirst($order->payment_status) }}</span></div>
                    </div>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div class="fw-medium">{{ $item->product_name }}</div>
                        </td>
                        <td>₹{{ number_format($item->price, 0) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-end fw-medium">₹{{ number_format($item->total, 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-6 offset-6">
                    <div class="d-flex justify-content-between mb-1 small">
                        <span class="text-muted">Subtotal</span>
                        <span>₹{{ number_format($order->subtotal, 0) }}</span>
                    </div>
                    @if($order->shipping_cost > 0)
                    <div class="d-flex justify-content-between mb-1 small">
                        <span class="text-muted">Delivery Charge</span>
                        <span>₹{{ number_format($order->shipping_cost, 0) }}</span>
                    </div>
                    @endif
                    @if($order->discount > 0)
                    <div class="d-flex justify-content-between mb-1 small">
                        <span class="text-muted">Discount</span>
                        <span class="text-success">-₹{{ number_format($order->discount, 0) }}</span>
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Grand Total</span>
                        <span>₹{{ number_format($order->grand_total, 0) }}</span>
                    </div>
                </div>
            </div>

            @if($order->notes)
            <div class="mt-4 p-3 rounded" style="background: #f8f9fa;">
                <small class="text-muted fw-semibold">Notes:</small>
                <p class="mb-0 small mt-1">{{ $order->notes }}</p>
            </div>
            @endif
        </div>

        <div class="invoice-footer">
            <p class="mb-0">Thank you for shopping with AURA!</p>
            <p class="mb-0 small">For any inquiries, contact {{ $settings['contact_email'] ?? 'hello@aurasaree.com' }}</p>
        </div>
    </div>
</body>
</html>
