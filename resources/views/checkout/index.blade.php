@extends('layouts.app')

@php
    $setting = fn($key, $default = '') => $settings[$key] ?? $default;
@endphp

@section('title', 'Checkout')

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
    background: #d4af37;
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
    border-color: #d4af37;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.12);
}
.address-card {
    border: 2px solid #dee2e6;
    border-radius: 10px;
    padding: 16px 44px 16px 16px;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 10px;
    position: relative;
    overflow: hidden;
}
.address-card:hover {
    border-color: #d4af37;
    box-shadow: 0 2px 12px rgba(212, 175, 55, 0.12);
}
.address-card.active {
    border-color: #d4af37;
    background: #fffdf5;
    box-shadow: 0 2px 12px rgba(212, 175, 55, 0.15);
}
.address-card .address-radio {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}
.address-card .address-label {
    font-weight: 600;
    font-size: 0.9rem;
    color: #333;
}
.address-card .address-detail {
    font-size: 0.84rem;
    color: #777;
    line-height: 1.6;
}
.address-card .address-badge {
    font-size: 0.72rem;
    padding: 2px 10px;
    border-radius: 20px;
    background: #d4af37;
    color: #fff;
    display: inline-block;
}
.address-card .address-check-icon {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    color: #d4af37;
    font-size: 1.2rem;
    opacity: 0;
    transition: opacity 0.2s;
}
.address-card.active .address-check-icon {
    opacity: 1;
}
.address-selection-error {
    background: #fff5f5;
    border: 1px solid #fcc;
    border-radius: 8px;
    padding: 10px 14px;
    color: #e74c3c;
    font-size: 0.85rem;
    display: none;
    margin-bottom: 10px;
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
    border-color: #d4af37;
    background: #fffdf5;
}
.payment-method .payment-radio {
    width: 18px;
    height: 18px;
    accent-color: #d4af37;
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
.payment-method .payment-desc {
    font-size: 0.8rem;
    color: #999;
    margin-left: auto;
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
.order-summary .item-row {
    display: flex;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f5f5f5;
}
.order-summary .item-row:last-child {
    border-bottom: none;
}
.order-summary .item-img {
    width: 56px;
    height: 70px;
    object-fit: cover;
    border-radius: 6px;
    flex-shrink: 0;
}
.order-summary .item-info {
    flex: 1;
    min-width: 0;
}
.order-summary .item-name {
    font-size: 0.85rem;
    font-weight: 500;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.order-summary .item-qty {
    font-size: 0.78rem;
    color: #999;
}
.order-summary .item-price {
    font-size: 0.88rem;
    font-weight: 600;
    color: #333;
    white-space: nowrap;
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
    color: #d4af37;
}
.btn-place-order {
    width: 100%;
    padding: 16px;
    background: #d4af37;
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
    background: #c9a22f;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
}
.btn-place-order:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
.btn-add-address {
    border: 2px dashed #dee2e6;
    border-radius: 10px;
    padding: 16px;
    background: #fafafa;
    color: #888;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 0.88rem;
    width: 100%;
}
.btn-add-address:hover {
    border-color: #d4af37;
    color: #d4af37;
    background: #fffdf5;
}
.saved-addresses {
    margin-bottom: 16px;
}
.checkout-errors {
    background: #fff5f5;
    border: 1px solid #fcc;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 16px;
    color: #e74c3c;
    font-size: 0.85rem;
}
.checkout-errors ul {
    margin: 4px 0 0;
    padding-left: 18px;
}
.order-items-scroll {
    max-height: 280px;
    overflow-y: auto;
    scrollbar-width: thin;
}
.order-items-scroll::-webkit-scrollbar {
    width: 4px;
}
.order-items-scroll::-webkit-scrollbar-thumb {
    background: #ddd;
    border-radius: 4px;
}

/* ── Coupon Section – Dark Gold Theme ── */
.coupon-section {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid rgba(212, 175, 55, 0.2);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}
.coupon-section .coupon-title {
    color: #D4AF37;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 12px;
}
.coupon-section .coupon-input-group {
    display: flex;
    gap: 8px;
}
.coupon-section .coupon-input-group input {
    flex: 1;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 0.85rem;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: all 0.3s;
    outline: none;
}
.coupon-section .coupon-input-group input:focus {
    border-color: #D4AF37;
    background: rgba(255, 255, 255, 0.12);
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
}
.coupon-section .coupon-input-group input::placeholder {
    color: rgba(255, 255, 255, 0.35);
    text-transform: none;
    letter-spacing: normal;
}
.coupon-section .btn-apply {
    background: #D4AF37;
    color: #1a1a2e;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.3s;
    white-space: nowrap;
}
.coupon-section .btn-apply:hover {
    background: #c9a22f;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
}
.coupon-section .btn-apply:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
.coupon-message {
    font-size: 0.8rem;
    margin-top: 8px;
    padding: 8px 12px;
    border-radius: 6px;
    animation: fadeSlideDown 0.3s ease;
}
.coupon-message.success {
    background: rgba(39, 174, 96, 0.15);
    color: #2ecc71;
    border: 1px solid rgba(39, 174, 96, 0.3);
}
.coupon-message.error {
    background: rgba(231, 76, 60, 0.15);
    color: #e74c3c;
    border: 1px solid rgba(231, 76, 60, 0.3);
}
.coupon-applied-badge {
    background: rgba(39, 174, 96, 0.12);
    border: 1px solid rgba(39, 174, 96, 0.3);
    border-radius: 8px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    animation: fadeSlideDown 0.3s ease;
}
.coupon-applied-badge .coupon-info {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #2ecc71;
    font-size: 0.85rem;
    font-weight: 500;
    flex-wrap: wrap;
}
.coupon-applied-badge .coupon-discount-amount {
    color: #fff;
    background: rgba(39, 174, 96, 0.25);
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
}
.coupon-applied-badge .btn-remove-coupon {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    font-size: 0.78rem;
    padding: 4px 8px;
    border-radius: 4px;
    transition: all 0.2s;
}
.coupon-applied-badge .btn-remove-coupon:hover {
    color: #e74c3c;
    background: rgba(231, 76, 60, 0.15);
}
@keyframes fadeSlideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
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
                    <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
            @csrf

            <div class="row g-4">
                <div class="col-lg-7">
                    {{-- Shipping Address --}}
                    <div class="checkout-section">
                        <div class="section-title">
                            <span class="step-number">1</span>
                            Shipping Address
                        </div>

                        <div id="addressSelectionError" class="address-selection-error">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Please select a shipping address.
                        </div>

                        @if($addresses->count() > 0)
                            <div class="saved-addresses">
                                <label class="form-label mb-2">Select a saved address</label>
                                @foreach($addresses as $address)
                                    <label class="address-card {{ $loop->first ? 'active' : '' }}"
                                           onclick="selectAddressCard(this, {{ $address->id }})">
                                        <input type="radio" name="address_id" value="{{ $address->id }}"
                                               class="address-radio" {{ $loop->first ? 'checked' : '' }}>
                                        <div>
                                            <div class="address-label">
                                                {{ $address->label ?? 'Address' }}
                                                @if($address->is_default)
                                                    <span class="address-badge ms-2">Default</span>
                                                @endif
                                            </div>
                                            <div class="address-detail">
                                                {{ $address->name }}<br>
                                                {{ $address->address_line1 }}{{ $address->address_line2 ? ', ' . $address->address_line2 : '' }}<br>
                                                {{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}<br>
                                                Phone: {{ $address->phone }}
                                            </div>
                                        </div>
                                        <div class="address-check-icon"><i class="fas fa-check-circle"></i></div>
                                    </label>
                                @endforeach
                                <button type="button" class="btn-add-address mt-2" onclick="toggleNewAddress()">
                                    <i class="fas fa-plus"></i> Add New Address
                                </button>
                            </div>
                        @endif
                        <input type="hidden" name="address_id" id="selectedAddressId"
                               value="{{ $addresses->isNotEmpty() ? $addresses->first()->id : '' }}">

                        <div id="newAddressForm" class="{{ $addresses->count() > 0 ? 'd-none' : '' }}">
                            @if($addresses->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label">New Address</label>
                                </div>
                            @endif
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_name" class="form-control" placeholder="John Doe">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" name="shipping_phone" class="form-control" placeholder="+880 1XXX-XXXXXX">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_address_line1" class="form-control" placeholder="House, Street, Area">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" name="shipping_address_line2" class="form-control" placeholder="Apartment, Floor (optional)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_city" class="form-control" placeholder="Dhaka">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_state" class="form-control" placeholder="Dhaka Division">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">ZIP Code <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_zip" class="form-control" placeholder="1205">
                                </div>
                            </div>
                        </div>

                        @error('address_id')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Billing Info --}}
                    <div class="checkout-section">
                        <div class="section-title">
                            <span class="step-number">2</span>
                            Billing Information
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="sameAsShipping" checked onchange="toggleBilling(this)">
                            <label class="form-check-label" for="sameAsShipping">
                                Same as shipping address
                            </label>
                        </div>
                        <div id="billingFields" style="display: none;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="billing_name" class="form-control" placeholder="John Doe">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" name="billing_phone" class="form-control" placeholder="+880 1XXX-XXXXXX">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" name="billing_address_line1" class="form-control" placeholder="House, Street, Area">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" name="billing_address_line2" class="form-control" placeholder="Apartment, Floor">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" name="billing_city" class="form-control" placeholder="Dhaka">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" name="billing_state" class="form-control" placeholder="Dhaka Division">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">ZIP Code</label>
                                    <input type="text" name="billing_zip" class="form-control" placeholder="1205">
                                </div>
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
                            <div class="payment-desc">Most Popular</div>
                        </div>
                        <div class="payment-method" onclick="selectPayment(this, 'bkash')">
                            <input type="radio" name="payment_method" value="bkash" class="payment-radio">
                            <div class="payment-icon" style="color:#e2136e;"><i class="fas fa-mobile-alt"></i></div>
                            <div>
                                <div class="payment-label">bKash</div>
                                <div class="small text-muted">Send money to bKash number</div>
                            </div>
                            <div class="payment-desc">Instant</div>
                        </div>
                        <div class="payment-method" onclick="selectPayment(this, 'nagad')">
                            <input type="radio" name="payment_method" value="nagad" class="payment-radio">
                            <div class="payment-icon" style="color:#e84e1b;"><i class="fas fa-mobile-alt"></i></div>
                            <div>
                                <div class="payment-label">Nagad</div>
                                <div class="small text-muted">Send money to Nagad number</div>
                            </div>
                            <div class="payment-desc">Instant</div>
                        </div>
                        <div class="payment-method" onclick="selectPayment(this, 'rocket')">
                            <input type="radio" name="payment_method" value="rocket" class="payment-radio">
                            <div class="payment-icon" style="color:#e2136e;"><i class="fas fa-rocket"></i></div>
                            <div>
                                <div class="payment-label">Rocket</div>
                                <div class="small text-muted">Send money to Rocket number</div>
                            </div>
                            <div class="payment-desc">Instant</div>
                        </div>

                        {{-- Advance Payment Fields --}}
                        <div id="advancePaymentFields" class="d-none mt-3 p-3 rounded" style="background: #f8f9fa; border: 1px solid #e9ecef;">
                            <div class="mb-3">
                                <label class="form-label">Send Payment To:</label>
                                <div id="paymentNumberDisplay" class="fw-semibold text-muted"></div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Transaction ID <span class="text-danger">*</span></label>
                                    <input type="text" name="transaction_id" class="form-control" placeholder="Enter transaction ID" id="transactionId">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sender Number</label>
                                    <input type="text" name="sender_number" class="form-control" placeholder="Your mobile number">
                                </div>
                            </div>
                            <div class="small text-muted mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Your order will be placed after payment verification.
                            </div>
                        </div>
                    </div>

                    {{-- Order Notes --}}
                    <div class="checkout-section">
                        <div class="section-title">
                            <span class="step-number">4</span>
                            Order Notes <span class="text-muted fw-normal small">(Optional)</span>
                        </div>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Special instructions for delivery..."></textarea>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="order-summary">
                        <h5><i class="fas fa-receipt me-2"></i>Order Summary</h5>

                        <div class="order-items-scroll">
                            @foreach($cartItems as $item)
                                <div class="item-row">
                                    <img src="{{ asset($item->product->images->first()->image_path ?? 'images/placeholder.jpg') }}"
                                         alt="{{ $item->product->name }}"
                                         class="item-img"
                                         loading="lazy"
                                         onerror="this.src='https://placehold.co/100x130?text=No+Image'">
                                    <div class="item-info">
                                        <div class="item-name">{{ $item->product->name }}</div>
                                        <div class="item-qty">Qty: {{ $item->quantity }}</div>
                                    </div>
                                    <div class="item-price">₹{{ number_format($item->product->discounted_price * $item->quantity, 0) }}</div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Coupon Section --}}
                        <div class="coupon-section" id="checkoutCouponSection">
                            <div class="coupon-title"><i class="fas fa-ticket-alt me-2"></i>Coupon Code</div>

                            <div id="checkoutCouponForm" @if($couponCode) style="display:none;" @endif>
                                <div class="coupon-input-group">
                                    <input type="text" id="checkoutCouponInput" placeholder="Enter coupon code" maxlength="20" autocomplete="off">
                                    <button type="button" class="btn-apply" id="checkoutApplyCoupon">Apply</button>
                                </div>
                                <div id="checkoutCouponMessage" class="coupon-message" style="display: none;"></div>
                            </div>

                            <div id="checkoutCouponApplied" class="coupon-applied-badge" @if(!$couponCode) style="display:none;" @endif>
                                <div class="coupon-info">
                                    <i class="fas fa-check-circle"></i>
                                    <span id="checkoutAppliedCode">{{ $couponCode ? strtoupper($couponCode) : '' }}</span>
                                    <span class="coupon-discount-amount" id="checkoutAppliedDiscount">-₹{{ number_format($discount, 0) }}</span>
                                </div>
                                <button type="button" class="btn-remove-coupon" id="checkoutRemoveCoupon">
                                    <i class="fas fa-times me-1"></i>Remove
                                </button>
                            </div>
                        </div>

                        <div class="summary-line">
                            <span>Subtotal</span>
                            <span class="summary-value" id="checkoutSubtotal">₹{{ number_format($subtotal, 0) }}</span>
                        </div>

                        <div class="summary-line" id="checkoutDiscountRow" @if($discount <= 0) style="display:none;" @endif>
                            <span>Discount</span>
                            <span class="summary-value text-success" id="checkoutDiscountValue">-₹{{ number_format($discount, 0) }}</span>
                        </div>

                        <div class="summary-line">
                            <span>Shipping</span>
                            <span class="summary-value" id="checkoutShipping">
                                @if($shippingCost > 0)
                                    ₹{{ number_format($shippingCost, 0) }}
                                @else
                                    <span class="text-success">FREE</span>
                                @endif
                            </span>
                        </div>

                        @if($tax > 0)
                            <div class="summary-line">
                                <span>Tax</span>
                                <span class="summary-value">₹{{ number_format($tax, 0) }}</span>
                            </div>
                        @endif

                        <div class="summary-line total">
                            <span>Grand Total</span>
                            <span class="summary-value" id="checkoutGrandTotal">₹{{ number_format($grandTotal, 0) }}</span>
                        </div>

                        <button type="submit" class="btn-place-order mt-4" id="placeOrderBtn">
                            <i class="fas fa-lock me-2"></i>Place Order
                        </button>

                        <div class="text-center mt-3">
                            <p class="small text-muted mb-2">
                                <i class="fas fa-shield-alt me-1"></i>
                                Your information is secure and encrypted
                            </p>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <span class="badge bg-light text-dark border"><i class="fab fa-cc-visa me-1"></i>Visa</span>
                                <span class="badge bg-light text-dark border"><i class="fab fa-cc-mastercard me-1"></i>Mastercard</span>
                                <span class="badge bg-light text-dark border"><i class="fas fa-mobile-alt me-1"></i>bKash</span>
                                <span class="badge bg-light text-dark border"><i class="fas fa-mobile-alt me-1"></i>Nagad</span>
                            </div>
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
    // ── Address Selection ──
    function el(id) { return document.getElementById(id); }

    const newAddressFields = [
        'shipping_name', 'shipping_phone', 'shipping_address_line1',
        'shipping_city', 'shipping_state', 'shipping_zip',
    ];

    function setNewAddressRequired(required) {
        newAddressFields.forEach(function (name) {
            let field = document.querySelector('[name="' + name + '"]');
            if (field) {
                if (required) {
                    field.setAttribute('required', 'required');
                } else {
                    field.removeAttribute('required');
                }
            }
        });
    }

    function selectAddressCard(card, addressId) {
        document.querySelectorAll('.address-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');

        let radio = card.querySelector('.address-radio');
        if (radio) radio.checked = true;

        let sid = el('selectedAddressId');
        if (sid) sid.value = addressId;

        let err = el('addressSelectionError');
        if (err) err.style.display = 'none';

        let btn = el('placeOrderBtn');
        if (btn) btn.disabled = false;

        let naf = el('newAddressForm');
        if (naf) naf.classList.add('d-none');

        setNewAddressRequired(false);
    }

    function toggleNewAddress() {
        let form = el('newAddressForm');
        if (form) form.classList.remove('d-none');

        let newRadio = document.querySelector('.address-card .address-radio[value="new"]');
        if (!newRadio) {
            let container = document.querySelector('.saved-addresses');
            if (container) {
                let label = document.createElement('label');
                label.className = 'address-card active';
                label.setAttribute('onclick', "selectNewAddressCard(this)");
                label.innerHTML = `
                    <input type="radio" name="address_id" value="new" class="address-radio" checked>
                    <div>
                        <div class="address-label">New Address</div>
                        <div class="address-detail">Enter a new shipping address below</div>
                    </div>
                    <div class="address-check-icon"><i class="fas fa-check-circle"></i></div>
                `;
                container.insertBefore(label, container.lastElementChild);
            }
        } else {
            newRadio.checked = true;
            document.querySelectorAll('.address-card').forEach(c => c.classList.remove('active'));
            let card = newRadio.closest('.address-card');
            if (card) card.classList.add('active');
        }

        let sid = el('selectedAddressId');
        if (sid) sid.value = 'new';

        let err = el('addressSelectionError');
        if (err) err.style.display = 'none';

        let btn = el('placeOrderBtn');
        if (btn) btn.disabled = false;

        let addBtn = document.querySelector('.btn-add-address');
        if (addBtn) addBtn.style.display = 'none';

        setNewAddressRequired(true);
    }

    function selectNewAddressCard(card) {
        document.querySelectorAll('.address-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        let radio = card.querySelector('.address-radio');
        if (radio) radio.checked = true;

        let sid = el('selectedAddressId');
        if (sid) sid.value = 'new';

        let err = el('addressSelectionError');
        if (err) err.style.display = 'none';

        let btn = el('placeOrderBtn');
        if (btn) btn.disabled = false;

        let naf = el('newAddressForm');
        if (naf) naf.classList.remove('d-none');

        setNewAddressRequired(true);
    }

    function toggleBilling(checkbox) {
        document.getElementById('billingFields').style.display = checkbox.checked ? 'none' : 'block';
    }

    const paymentNumbers = {
        bkash: '{{ $setting("payment_bkash_number", "01XXXXXXXXX") }}',
        nagad: '{{ $setting("payment_nagad_number", "01XXXXXXXXX") }}',
        rocket: '{{ $setting("payment_rocket_number", "01XXXXXXXXX") }}',
    };

    function selectPayment(el, value) {
        document.querySelectorAll('.payment-method').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        el.querySelector('.payment-radio').checked = true;

        const advanceFields = document.getElementById('advancePaymentFields');
        const txField = document.getElementById('transactionId');

        if (value === 'cod') {
            advanceFields.classList.add('d-none');
            txField.removeAttribute('required');
        } else {
            advanceFields.classList.remove('d-none');
            txField.setAttribute('required', 'required');
            const display = document.getElementById('paymentNumberDisplay');
            display.textContent = paymentNumbers[value] || '01XXXXXXXXX';
        }
    }

    // ── Init: set address_id on page load ──
    (function initCheckout() {
        let firstRadio = document.querySelector('.address-radio:checked');
        let sid = document.getElementById('selectedAddressId');
        if (firstRadio) {
            if (sid) sid.value = firstRadio.value;
        } else {
            // No saved addresses — default to new address
            if (sid) sid.value = 'new';
            setNewAddressRequired(true);
        }
        let btn = document.getElementById('placeOrderBtn');
        if (btn) btn.disabled = false;
    })();

    // ── Form Submit (validate address, disable, show spinner) ──
    document.getElementById('checkoutForm').addEventListener('submit', function (e) {
        let sid = document.getElementById('selectedAddressId');
        let err = document.getElementById('addressSelectionError');

        if (!sid || !sid.value) {
            if (err) {
                err.style.display = 'block';
                err.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            e.preventDefault();
            return;
        }

        let btn = document.getElementById('placeOrderBtn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        }
    });

    // ── Coupon Apply ──
    $('#checkoutApplyCoupon').on('click', function () {
        let code = $('#checkoutCouponInput').val().trim();
        let msgEl = $('#checkoutCouponMessage');
        msgEl.hide();

        if (!code) {
            msgEl.removeClass('success').addClass('error').text('Please enter a coupon code').fadeIn(200);
            return;
        }

        let btn = $(this);
        btn.prop('disabled', true).text('Applying...');

        $.ajax({
            url: '{{ route("checkout.apply-coupon") }}',
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', code: code },
            success: function (res) {
                if (res.success) {
                    msgEl.hide();
                    $('#checkoutCouponForm').fadeOut(200);
                    $('#checkoutAppliedCode').text(code.toUpperCase());
                    let fmt = Number(res.discount).toLocaleString('en-IN');
                    $('#checkoutAppliedDiscount').text('-₹' + fmt);
                    $('#checkoutCouponApplied').fadeIn(200);

                    $('#checkoutSubtotal').text('₹' + Number(res.subtotal).toLocaleString('en-IN'));
                    $('#checkoutDiscountValue').text('-₹' + Number(res.discount).toLocaleString('en-IN'));
                    $('#checkoutDiscountRow').fadeIn(200);
                    $('#checkoutGrandTotal').text('₹' + Number(res.grand_total).toLocaleString('en-IN'));
                } else {
                    msgEl.removeClass('success').addClass('error').text(res.message).fadeIn(200);
                }
            },
            error: function () {
                msgEl.removeClass('success').addClass('error').text('Failed to apply coupon. Please try again.').fadeIn(200);
            },
            complete: function () {
                btn.prop('disabled', false).text('Apply');
            }
        });
    });

    // ── Coupon Enter key ──
    $('#checkoutCouponInput').on('keydown', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#checkoutApplyCoupon').trigger('click');
        }
    });

    // ── Coupon Remove ──
    $('#checkoutRemoveCoupon').on('click', function () {
        $.ajax({
            url: '{{ route("checkout.remove-coupon") }}',
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function (res) {
                if (res.success) {
                    $('#checkoutCouponApplied').fadeOut(200, function () {
                        $('#checkoutCouponForm').fadeIn(200);
                        $('#checkoutCouponInput').val('');
                        $('#checkoutCouponMessage').hide();

                        $('#checkoutSubtotal').text('₹' + Number(res.subtotal).toLocaleString('en-IN'));
                        $('#checkoutDiscountRow').fadeOut(200);
                        $('#checkoutGrandTotal').text('₹' + Number(res.grand_total).toLocaleString('en-IN'));
                    });
                }
            },
            error: function () {
                showToast('Failed to remove coupon.', 'error');
            }
        });
    });
</script>
@endpush
