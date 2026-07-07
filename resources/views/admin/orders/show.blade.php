@extends('admin.layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Order #ORD-001</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                <li class="breadcrumb-item active">#ORD-001</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-soft-warning"><i class="fas fa-print me-1"></i> Print Invoice</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-light"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Order Items</span>
                <span class="badge-status delivered">Delivered</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $items = [
                                ['name' => 'Banarasi Silk Saree - Blue', 'sku' => 'SKU-001', 'price' => 24900, 'qty' => 1],
                                ['name' => 'Cotton Printed Saree - Red', 'sku' => 'SKU-003', 'price' => 8900, 'qty' => 2],
                            ];
                        @endphp

                        @foreach($items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:48px;height:48px;border-radius:8px;background:#f1f3f5;display:flex;align-items:center;justify-content:center;font-size:18px;color:#adb5bd;flex-shrink:0;">
                                        <i class="fas fa-tshirt"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="font-size:14px;">{{ $item['name'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:13px;color:#6c757d;">{{ $item['sku'] }}</td>
                            <td>${{ number_format($item['price'] / 100, 2) }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td style="text-align:right;font-weight:600;">${{ number_format($item['price'] * $item['qty'] / 100, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right;font-weight:500;">Subtotal:</td>
                            <td style="text-align:right;">$427.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:right;font-weight:500;">Shipping:</td>
                            <td style="text-align:right;">$10.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:right;font-weight:500;">Discount:</td>
                            <td style="text-align:right;color:#10b981;">-$50.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:right;font-weight:600;font-size:16px;">Total:</td>
                            <td style="text-align:right;font-weight:700;font-size:16px;color:var(--sidebar-bg);">$387.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Order Timeline</div>
            <div class="card-body">
                <div class="order-timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon completed"><i class="fas fa-check"></i></div>
                        <div class="timeline-text">Order Delivered</div>
                        <div class="timeline-time">July 5, 2026 at 2:30 PM</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon completed"><i class="fas fa-check"></i></div>
                        <div class="timeline-text">In Transit</div>
                        <div class="timeline-time">July 4, 2026 at 9:15 AM</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon completed"><i class="fas fa-check"></i></div>
                        <div class="timeline-text">Shipped</div>
                        <div class="timeline-time">July 3, 2026 at 4:45 PM</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon completed"><i class="fas fa-check"></i></div>
                        <div class="timeline-text">Processing Order</div>
                        <div class="timeline-time">July 2, 2026 at 11:20 AM</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon completed"><i class="fas fa-check"></i></div>
                        <div class="timeline-text">Payment Confirmed</div>
                        <div class="timeline-time">July 1, 2026 at 3:10 PM</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon completed"><i class="fas fa-check"></i></div>
                        <div class="timeline-text">Order Placed</div>
                        <div class="timeline-time">July 1, 2026 at 2:55 PM</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">Order Information</div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Order #</div>
                        <div class="fw-semibold">ORD-001</div>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Date</div>
                        <div>July 1, 2026 at 2:55 PM</div>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Status</div>
                        <div>
                            <span class="badge-status delivered">Delivered</span>
                        </div>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Payment Method</div>
                        <div>Credit Card (Visa ending in 4242)</div>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Payment Status</div>
                        <div><span class="badge-status active">Paid</span></div>
                    </div>
                </div>

                <hr>

                <form class="mb-0">
                    <label class="form-label">Update Status</label>
                    <div class="input-group">
                        <select class="form-select" id="orderStatus">
                            <option>Pending</option>
                            <option>Processing</option>
                            <option>Shipped</option>
                            <option selected>Delivered</option>
                            <option>Cancelled</option>
                        </select>
                        <button class="btn btn-primary" type="button" onclick="updateStatus()">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Customer Information</div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="avatar-md" style="background:#8B5CF6;">PS</div>
                    <div>
                        <div class="fw-semibold">Priya Sharma</div>
                        <div style="font-size:13px;color:#6c757d;">priya.sharma@example.com</div>
                    </div>
                </div>
                <div style="font-size:13px;">
                    <div class="mb-2">
                        <i class="fas fa-phone me-2" style="color:#9ca3af;width:16px;"></i> +91 98765 43210
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt me-2" style="color:#9ca3af;width:16px;"></i> 42, MG Road, Indiranagar
                    </div>
                    <div>
                        <i class="fas fa-city me-2" style="color:#9ca3af;width:16px;"></i> Bangalore, Karnataka 560038
                    </div>
                </div>
                <hr>
                <div style="font-size:13px;">
                    <div class="mb-1"><span class="text-muted">Total Orders:</span> <strong>12</strong></div>
                    <div><span class="text-muted">Total Spent:</span> <strong>$3,892.00</strong></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Shipping Address</div>
            <div class="card-body">
                <div class="fw-semibold mb-1">Priya Sharma</div>
                <div style="font-size:13px;color:#6c757d;">
                    <div>42, MG Road, Indiranagar</div>
                    <div>Bangalore, Karnataka 560038</div>
                    <div>Phone: +91 98765 43210</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateStatus() {
    const status = document.getElementById('orderStatus').value;
    if (confirm('Update order status to "' + status + '"?')) {
        alert('Status update to "' + status + '" - AJAX implementation pending.');
    }
}
</script>
@endpush
