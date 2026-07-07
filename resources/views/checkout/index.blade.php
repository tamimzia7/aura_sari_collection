@extends('layouts.app')

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
    padding: 16px;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 10px;
    position: relative;
}
.address-card:hover {
    border-color: #ccc;
}
.address-card.active {
    border-color: #d4af37;
    background: #fffdf5;
}
.address-card .address-radio {
    position: absolute;
    opacity: 0;
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

                        @if($addresses->count() > 0)
                            <div class="saved-addresses">
                                <label class="form-label mb-2">Select a saved address</label>
                                @foreach($addresses as $address)
                                    <label class="address-card {{ $loop->first ? 'active' : '' }}">
                                        <input type="radio" name="shipping_address_id" value="{{ $address->id }}"
                                               class="address-radio" {{ $loop->first ? 'checked' : '' }}
                                               onchange="selectAddress(this)">
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
                                    </label>
                                @endforeach
                                <button type="button" class="btn-add-address mt-2" onclick="toggleNewAddress()">
                                    <i class="fas fa-plus"></i> Add New Address
                                </button>
                            </div>
                        @endif

                        <div id="newAddressForm" class="{{ $addresses->count() > 0 ? 'd-none' : '' }}">
                            @if($addresses->count() > 0)
                                <div class="mb-3">
                                    <input type="hidden" name="shipping_address_id" value="new">
                                    <label class="form-label">New Address</label>
                                </div>
                            @endif
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_name" class="form-control" placeholder="John Doe" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" name="shipping_phone" class="form-control" placeholder="+880 1XXX-XXXXXX" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_address_line1" class="form-control" placeholder="House, Street, Area" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" name="shipping_address_line2" class="form-control" placeholder="Apartment, Floor (optional)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_city" class="form-control" placeholder="Dhaka" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_state" class="form-control" placeholder="Dhaka Division" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">ZIP Code <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_zip" class="form-control" placeholder="1205" required>
                                </div>
                            </div>
                        </div>

                        @error('shipping_address_id')
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
                        <div class="payment-method" onclick="selectPayment(this, 'card')">
                            <input type="radio" name="payment_method" value="card" class="payment-radio">
                            <div class="payment-icon" style="color:#1a1f71;"><i class="fas fa-credit-card"></i></div>
                            <div>
                                <div class="payment-label">Credit / Debit Card</div>
                                <div class="small text-muted">Visa, Mastercard, Amex</div>
                            </div>
                            <div class="payment-desc">Secure</div>
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

                        <div class="summary-line">
                            <span>Subtotal</span>
                            <span class="summary-value">₹{{ number_format($subtotal, 0) }}</span>
                        </div>

                        @if($discount > 0)
                            <div class="summary-line">
                                <span>Discount</span>
                                <span class="summary-value text-success">-₹{{ number_format($discount, 0) }}</span>
                            </div>
                        @endif

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
                            <span class="summary-value">₹{{ number_format($grandTotal, 0) }}</span>
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
    function selectAddress(el) {
        document.querySelectorAll('.address-card').forEach(c => c.classList.remove('active'));
        el.closest('.address-card').classList.add('active');

        let isNew = el.value === 'new';
        document.getElementById('newAddressForm').classList.toggle('d-none', !isNew);
    }

    function toggleNewAddress() {
        let form = document.getElementById('newAddressForm');
        let isHidden = form.classList.contains('d-none');
        form.classList.remove('d-none');

        let newRadio = document.querySelector('.address-card .address-radio[value="new"]');
        if (!newRadio) {
            let container = document.querySelector('.saved-addresses');
            let label = document.createElement('label');
            label.className = 'address-card active';
            label.innerHTML = `
                <input type="radio" name="shipping_address_id" value="new" class="address-radio" checked onchange="selectAddress(this)">
                <div>
                    <div class="address-label">New Address</div>
                    <div class="address-detail">Enter a new shipping address below</div>
                </div>
            `;
            container.insertBefore(label, container.lastElementChild);
        } else {
            newRadio.checked = true;
            document.querySelectorAll('.address-card').forEach(c => c.classList.remove('active'));
            newRadio.closest('.address-card').classList.add('active');
        }

        document.querySelector('.btn-add-address').style.display = 'none';
    }

    function toggleBilling(checkbox) {
        document.getElementById('billingFields').style.display = checkbox.checked ? 'none' : 'block';
    }

    function selectPayment(el, value) {
        document.querySelectorAll('.payment-method').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        el.querySelector('.payment-radio').checked = true;
    }

    document.getElementById('checkoutForm').addEventListener('submit', function (e) {
        let btn = document.getElementById('placeOrderBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
    });
</script>
@endpush
