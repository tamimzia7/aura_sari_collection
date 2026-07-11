@extends('layouts.app')

@php
    $setting = fn($key, $default = '') => $settings[$key] ?? $default;
@endphp

@section('title', 'Confirm Order')

@push('styles')
<style>
.checkout-page {
    background: #f5f5f5;
    min-height: 60vh;
}
.checkout-breadcrumb {
    background: #fff;
    border-radius: 12px;
    padding: 12px 20px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.checkout-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: '\f105';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    color: #999;
}
.checkout-breadcrumb .breadcrumb-item a {
    color: #666;
    text-decoration: none;
    font-size: 0.88rem;
    transition: color 0.2s;
}
.checkout-breadcrumb .breadcrumb-item a:hover {
    color: #d4af37;
}
.checkout-breadcrumb .breadcrumb-item.active {
    color: #d4af37;
    font-weight: 500;
}
.checkout-section {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    border: 1px solid #f0f0f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.checkout-section .section-title {
    font-size: 1.05rem;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.checkout-section .section-title .step-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    background: #198754;
    color: #fff;
    border-radius: 50%;
    font-size: 0.8rem;
    font-weight: 700;
}
.form-label {
    font-size: 0.85rem;
    font-weight: 500;
    color: #555;
    margin-bottom: 6px;
}
.form-control, .form-select {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 0.9rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-control:focus, .form-select:focus {
    border-color: #198754;
    box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.12);
}
.order-summary {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    position: sticky;
    top: 90px;
    border: 1px solid #f0f0f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.order-summary h5 {
    font-weight: 700;
    font-size: 1.05rem;
    margin-bottom: 18px;
    padding-bottom: 14px;
    border-bottom: 2px solid #f0f0f0;
}
.order-summary .summary-line {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 0.9rem;
    color: #555;
}
.order-summary .summary-line.total {
    border-top: 2px solid #e0e0e0;
    margin-top: 6px;
    padding-top: 16px;
    font-size: 1.05rem;
    font-weight: 700;
    color: #222;
}
.order-summary .summary-line.total .summary-value {
    color: #198754;
}
.btn-place-order {
    width: 100%;
    padding: 16px;
    background: #198754;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s;
}
.btn-place-order:hover {
    background: #157347;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
}
.btn-place-order:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
.payment-method {
    border: 2px solid #dee2e6;
    border-radius: 10px;
    padding: 14px 18px;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.payment-method:hover {
    border-color: #ccc;
}
.payment-method.active {
    border-color: #198754;
    background: #f0fdf4;
}
.payment-method .payment-radio {
    width: 18px;
    height: 18px;
    accent-color: #198754;
    cursor: pointer;
}
.payment-method .payment-icon {
    width: 36px;
    text-align: center;
    font-size: 1.4rem;
    color: #555;
}
.payment-method .payment-label {
    font-weight: 500;
    font-size: 0.92rem;
    color: #333;
}
.product-preview {
    display: flex;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid #f0f0f0;
}
.product-preview .product-img {
    width: 80px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
    background: #f8f9fa;
}
.product-preview .product-info {
    flex: 1;
}
.product-preview .product-name {
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
}
.product-preview .product-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #198754;
}
.quantity-control {
    display: flex;
    align-items: center;
    gap: 0;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    width: fit-content;
}
.quantity-control button {
    border: none;
    background: #f8f9fa;
    padding: 6px 14px;
    cursor: pointer;
    font-size: 1.1rem;
    transition: background 0.2s;
}
.quantity-control button:hover {
    background: #e9ecef;
}
.quantity-control input {
    width: 50px;
    text-align: center;
    border: none;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    padding: 6px;
    outline: none;
}
@media (max-width: 767px) {
    .order-summary {
        position: static;
    }
}
</style>
@endpush

@section('content')
<div class="checkout-page py-4">
    <div class="container">
        <div class="checkout-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Confirm Order</li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('checkout.direct.store') }}" method="POST" id="directCheckoutForm">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" id="hiddenQty" value="1">

            <div class="row g-4">
                <div class="col-lg-7">
                    {{-- Product Preview --}}
                    <div class="checkout-section">
                        <div class="section-title">
                            <span class="step-number">1</span>
                            Product Details
                        </div>
                        <div class="product-preview">
                            <img src="{{ asset($product->imageUrl) }}"
                                 alt="{{ $product->name }}"
                                 class="product-img"
                                 onerror="this.src='https://placehold.co/200x250?text=No+Image'">
                            <div class="product-info">
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="text-muted small mb-2">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                <div class="product-price">₹{{ number_format($price, 0) }}</div>
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <span class="text-muted small">Qty:</span>
                                    <div class="quantity-control">
                                        <button type="button" onclick="decrementQty()" aria-label="Decrease">−</button>
                                        <input type="number" id="qtyInput" value="1" min="1" max="{{ $product->stock_quantity }}" readonly>
                                        <button type="button" onclick="incrementQty()" aria-label="Increase">+</button>
                                    </div>
                                    @if($product->stock_quantity <= 5)
                                        <span class="text-warning small">Only {{ $product->stock_quantity }} left</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Customer Information --}}
                    <div class="checkout-section">
                        <div class="section-title">
                            <span class="step-number">2</span>
                            Customer Information
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Your full name" value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control" placeholder="01XXXXXXXXX" value="{{ old('phone', Auth::user()->phone) }}" required>
                                @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alternative Number</label>
                                <input type="tel" name="alt_phone" class="form-control" placeholder="Optional" value="{{ old('alt_phone') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Division <span class="text-danger">*</span></label>
                                <input type="text" name="division" class="form-control" placeholder="Division" value="{{ old('division') }}" required>
                                @error('division') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">District <span class="text-danger">*</span></label>
                                <input type="text" name="district" class="form-control" placeholder="District" value="{{ old('district') }}" required>
                                @error('district') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upazila / Area <span class="text-danger">*</span></label>
                                <input type="text" name="area" class="form-control" placeholder="Upazila / Area" value="{{ old('area') }}" required>
                                @error('area') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Full Address <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" rows="3" placeholder="House, road, village, post office..." required>{{ old('address') }}</textarea>
                                @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Order Note (Optional)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Special instructions...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="checkout-section">
                        <div class="section-title">
                            <span class="step-number">3</span>
                            Payment Method
                        </div>

                        <div class="payment-method active" onclick="selectPayment(this, 'cod')">
                            <input type="radio" name="payment_method" value="cod" class="payment-radio" checked>
                            <div class="payment-icon"><i class="fas fa-money-bill-wave"></i></div>
                            <div>
                                <div class="payment-label">Cash on Delivery</div>
                                <div class="small text-muted">Pay when you receive</div>
                            </div>
                        </div>

                        <div class="payment-method" onclick="selectPayment(this, 'bkash')">
                            <input type="radio" name="payment_method" value="bkash" class="payment-radio">
                            <div class="payment-icon" style="color:#e2136e;"><i class="fas fa-mobile-alt"></i></div>
                            <div>
                                <div class="payment-label">bKash</div>
                                <div class="small text-muted">Send money to bKash number</div>
                            </div>
                        </div>

                        <div class="payment-method" onclick="selectPayment(this, 'nagad')">
                            <input type="radio" name="payment_method" value="nagad" class="payment-radio">
                            <div class="payment-icon" style="color:#e84e1b;"><i class="fas fa-mobile-alt"></i></div>
                            <div>
                                <div class="payment-label">Nagad</div>
                                <div class="small text-muted">Send money to Nagad number</div>
                            </div>
                        </div>

                        <div class="payment-method" onclick="selectPayment(this, 'rocket')">
                            <input type="radio" name="payment_method" value="rocket" class="payment-radio">
                            <div class="payment-icon" style="color:#e2136e;"><i class="fas fa-rocket"></i></div>
                            <div>
                                <div class="payment-label">Rocket</div>
                                <div class="small text-muted">Send money to Rocket number</div>
                            </div>
                        </div>

                        {{-- Advance Payment Fields --}}
                        <div id="advancePaymentFields" class="d-none mt-3 p-3 rounded" style="background: #f8f9fa; border: 1px solid #e9ecef;">
                            <div class="mb-3">
                                <label class="form-label">Send Payment To:</label>
                                <div id="paymentNumberDisplay" class="fw-semibold text-muted"></div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Sender Number</label>
                                    <input type="text" name="sender_number" class="form-control" placeholder="Your mobile number">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Transaction ID <span class="text-danger">*</span></label>
                                    <input type="text" name="transaction_id" class="form-control" placeholder="Enter transaction ID" id="transactionId">
                                </div>
                            </div>
                            <div class="small text-muted mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Your order will be placed after payment verification.
                            </div>
                        </div>

                        @error('transaction_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        @error('payment_method') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="order-summary">
                        <h5><i class="fas fa-receipt me-2"></i>Order Summary</h5>

                        <div class="summary-line">
                            <span>Price (per unit)</span>
                            <span class="summary-value">₹{{ number_format($price, 0) }}</span>
                        </div>
                        <div class="summary-line">
                            <span>Quantity</span>
                            <span class="summary-value" id="displayQty">1</span>
                        </div>
                        <div class="summary-line">
                            <span>Subtotal</span>
                            <span class="summary-value" id="displaySubtotal">₹{{ number_format($subtotal, 0) }}</span>
                        </div>
                        <div class="summary-line">
                            <span>Delivery Charge</span>
                            <span class="summary-value">
                                @if($shippingCost > 0)
                                    ₹{{ number_format($shippingCost, 0) }}
                                @else
                                    <span class="text-success">FREE</span>
                                @endif
                            </span>
                        </div>
                        @if($discount > 0)
                        <div class="summary-line">
                            <span>Discount</span>
                            <span class="summary-value text-success">-₹{{ number_format($discount, 0) }}</span>
                        </div>
                        @endif
                        <div class="summary-line total">
                            <span>Grand Total</span>
                            <span class="summary-value" id="displayTotal">₹{{ number_format($grandTotal, 0) }}</span>
                        </div>

                        <button type="submit" class="btn-place-order mt-4" id="placeOrderBtn">
                            <i class="fas fa-lock me-2"></i>Place Order
                        </button>

                        <div class="text-center mt-3">
                            <p class="small text-muted mb-0">
                                <i class="fas fa-shield-alt me-1"></i>
                                Your information is secure and encrypted
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const paymentNumbers = {
        bkash: '{{ $setting("payment_bkash_number", "01XXXXXXXXX") }}',
        nagad: '{{ $setting("payment_nagad_number", "01XXXXXXXXX") }}',
        rocket: '{{ $setting("payment_rocket_number", "01XXXXXXXXX") }}',
    };

    const unitPrice = {{ $price }};

    function selectPayment(el, value) {
        document.querySelectorAll('.payment-method').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        el.querySelector('.payment-radio').checked = true;

        const advanceFields = document.getElementById('advancePaymentFields');
        const txField = document.getElementById('transactionId');

        if (value === 'cod') {
            advanceFields.classList.add('d-none');
            if (txField) txField.removeAttribute('required');
        } else {
            advanceFields.classList.remove('d-none');
            if (txField) txField.setAttribute('required', 'required');
            const display = document.getElementById('paymentNumberDisplay');
            display.textContent = paymentNumbers[value] || '01XXXXXXXXX';
        }
    }

    function updateTotals() {
        const qty = parseInt(document.getElementById('qtyInput').value) || 1;
        const subtotal = unitPrice * qty;

        document.getElementById('hiddenQty').value = qty;
        document.getElementById('displayQty').textContent = qty;
        document.getElementById('displaySubtotal').textContent = '₹' + subtotal.toLocaleString('en-IN');
        document.getElementById('displayTotal').textContent = '₹' + subtotal.toLocaleString('en-IN');
    }

    function incrementQty() {
        const input = document.getElementById('qtyInput');
        const max = parseInt(input.getAttribute('max'));
        let val = parseInt(input.value);
        if (val < max) {
            input.value = val + 1;
            updateTotals();
        }
    }

    function decrementQty() {
        const input = document.getElementById('qtyInput');
        let val = parseInt(input.value);
        if (val > 1) {
            input.value = val - 1;
            updateTotals();
        }
    }

    document.getElementById('directCheckoutForm').addEventListener('submit', function (e) {
        let btn = document.getElementById('placeOrderBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
    });
</script>
@endpush
