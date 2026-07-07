@extends('layouts.app')

@section('title', 'Shopping Cart')

@push('styles')
<style>
.cart-page {
    background: #fff;
    min-height: 60vh;
}
.cart-breadcrumb {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 12px 20px;
    margin-bottom: 24px;
}
.cart-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: '\f105';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    color: #999;
}
.cart-breadcrumb .breadcrumb-item a {
    color: #666;
    text-decoration: none;
    font-size: 0.88rem;
    transition: color 0.2s;
}
.cart-breadcrumb .breadcrumb-item a:hover {
    color: #d4af37;
}
.cart-breadcrumb .breadcrumb-item.active {
    color: #d4af37;
    font-weight: 500;
}
.cart-table {
    width: 100%;
}
.cart-table thead th {
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    font-size: 0.78rem;
    letter-spacing: 1px;
    padding: 14px 12px;
    border-bottom: 2px solid #f0f0f0;
    background: #fafafa;
}
.cart-table thead th:first-child {
    border-radius: 10px 0 0 0;
}
.cart-table thead th:last-child {
    border-radius: 0 10px 0 0;
}
.cart-item {
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s;
}
.cart-item:hover {
    background: #fafafa;
}
.cart-item td {
    padding: 16px 12px;
    vertical-align: middle;
}
.cart-item .product-image-wrap {
    width: 80px;
    height: 100px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}
.cart-item .product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cart-item .product-name {
    font-weight: 500;
    font-size: 0.95rem;
    color: #222;
    text-decoration: none;
    transition: color 0.2s;
}
.cart-item .product-name:hover {
    color: #d4af37;
}
.cart-item .product-meta {
    font-size: 0.8rem;
    color: #999;
}
.quantity-control {
    display: inline-flex;
    align-items: center;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    overflow: hidden;
    background: #fff;
}
.quantity-control button {
    border: none;
    background: #fff;
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    color: #555;
    font-size: 0.8rem;
}
.quantity-control button:hover {
    background: #f5f5f5;
    color: #d4af37;
}
.quantity-control button:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}
.quantity-control input {
    width: 48px;
    height: 34px;
    text-align: center;
    border: none;
    border-left: 1px solid #dee2e6;
    border-right: 1px solid #dee2e6;
    padding: 0;
    font-size: 0.88rem;
    font-weight: 500;
    color: #333;
}
.quantity-control input:focus {
    outline: none;
}
.item-price, .item-subtotal {
    font-weight: 600;
    font-size: 0.95rem;
    color: #222;
}
.btn-remove-item {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1px solid #eee;
    background: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #ccc;
    transition: all 0.2s;
    cursor: pointer;
}
.btn-remove-item:hover {
    border-color: #e74c3c;
    color: #e74c3c;
    background: #fff5f5;
}
.cart-summary {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 28px;
    position: sticky;
    top: 90px;
}
.cart-summary h5 {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 2px solid #e8e8e8;
}
.cart-summary .summary-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 0.92rem;
    color: #555;
}
.cart-summary .summary-row.total {
    border-top: 2px solid #e0e0e0;
    margin-top: 8px;
    padding-top: 16px;
    font-size: 1.1rem;
    font-weight: 700;
    color: #222;
}
.cart-summary .summary-row.total .summary-value {
    color: #d4af37;
}
.coupon-wrap {
    background: #fff;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 20px;
    border: 1px dashed #ddd;
}
.coupon-wrap .coupon-input-group {
    display: flex;
    gap: 8px;
}
.coupon-wrap input {
    flex: 1;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.coupon-wrap input:focus {
    outline: none;
    border-color: #d4af37;
    box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.15);
}
.coupon-wrap .btn-apply {
    background: #222;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 8px 18px;
    font-size: 0.82rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.2s;
    white-space: nowrap;
}
.coupon-wrap .btn-apply:hover {
    background: #d4af37;
}
.btn-proceed-checkout {
    width: 100%;
    padding: 14px;
    background: #d4af37;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}
.btn-proceed-checkout:hover {
    background: #c9a22f;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
}
.btn-continue-shopping {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #666;
    text-decoration: none;
    font-size: 0.88rem;
    transition: color 0.2s;
}
.btn-continue-shopping:hover {
    color: #d4af37;
}
.empty-cart {
    text-align: center;
    padding: 80px 20px;
}
.empty-cart .empty-icon {
    font-size: 5rem;
    color: #ddd;
    margin-bottom: 24px;
}
.empty-cart h3 {
    font-weight: 700;
    color: #333;
    margin-bottom: 12px;
}
.empty-cart p {
    color: #999;
    font-size: 1rem;
    margin-bottom: 28px;
}
.empty-cart .btn-shop-now {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 36px;
    background: #222;
    color: #fff;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
}
.empty-cart .btn-shop-now:hover {
    background: #d4af37;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
}
.coupon-applied {
    background: #eafaf1;
    border: 1px solid #27ae60;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 0.82rem;
    color: #27ae60;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.coupon-applied .remove-coupon {
    background: none;
    border: none;
    color: #e74c3c;
    cursor: pointer;
    font-size: 0.82rem;
}
.coupon-error {
    color: #e74c3c;
    font-size: 0.8rem;
    margin-top: 6px;
}
.cart-loading {
    opacity: 0.5;
    pointer-events: none;
}
.spinner-overlay {
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    z-index: 2;
}
.free-shipping-note {
    background: #fff8e1;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 0.82rem;
    color: #b8860b;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
</style>
@endpush

@section('content')
<div class="cart-page py-4">
    <div class="container">
        <div class="cart-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>

        @if($cartItems->count() > 0)
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="fw-bold mb-0">Shopping Cart <span class="text-muted fw-normal fs-6">({{ $cartCount }} {{ Str::plural('item', $cartCount) }})</span></h4>
                        <a href="{{ route('collection') }}" class="btn-continue-shopping">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>

                    <div class="table-responsive" id="cartTableWrap">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Product</th>
                                    <th style="width: 15%;">Price</th>
                                    <th style="width: 20%;">Quantity</th>
                                    <th style="width: 15%;">Subtotal</th>
                                    <th style="width: 10%;"></th>
                                </tr>
                            </thead>
                            <tbody id="cartItemsBody">
                                @foreach($cartItems as $item)
                                    @php $product = $item->product; @endphp
                                    <tr class="cart-item" data-cart-id="{{ $item->id }}" id="cart-row-{{ $item->id }}">
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="product-image-wrap">
                                                    <img src="{{ asset($product->images->first()->image_path ?? 'images/placeholder.jpg') }}"
                                                         alt="{{ $product->name }}"
                                                         class="product-image"
                                                         loading="lazy"
                                                         onerror="this.src='https://placehold.co/200x250?text=No+Image'">
                                                </a>
                                                <div>
                                                    <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="product-name">
                                                        {{ $product->name }}
                                                    </a>
                                                    @if($item->variant_id && $product->variants)
                                                        @php $variant = $product->variants->find($item->variant_id); @endphp
                                                        @if($variant)
                                                            <div class="product-meta mt-1">{{ $variant->name }}</div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="item-price" id="price-{{ $item->id }}">
                                                ₹{{ number_format($product->discounted_price, 0) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="quantity-control">
                                                <button type="button" class="qty-decrease" data-cart-id="{{ $item->id }}" data-action="decrease" aria-label="Decrease quantity">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="text" class="qty-input" id="qty-{{ $item->id }}"
                                                       value="{{ $item->quantity }}" readonly
                                                       data-cart-id="{{ $item->id }}">
                                                <button type="button" class="qty-increase" data-cart-id="{{ $item->id }}" data-action="increase" aria-label="Increase quantity">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="item-subtotal" id="subtotal-{{ $item->id }}">
                                                ₹{{ number_format($product->discounted_price * $item->quantity, 0) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn-remove-item" data-cart-id="{{ $item->id }}" aria-label="Remove item" title="Remove">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('collection') }}" class="btn-continue-shopping">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                        <button type="button" class="btn btn-link text-muted text-decoration-none" id="clearCartBtn" style="font-size: 0.85rem;">
                            <i class="fas fa-trash-alt me-1"></i> Clear Cart
                        </button>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-summary position-relative" id="cartSummary">
                        <div id="summarySpinner" class="spinner-overlay" style="display: none;">
                            <div class="spinner-border text-dark" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <h5>Order Summary</h5>

                        <div class="free-shipping-note">
                            <i class="fas fa-truck"></i>
                            <span>Free shipping on orders above ₹2,000</span>
                        </div>

                        <div class="coupon-wrap" id="couponWrap">
                            <div id="couponApplied" style="display: none;" class="coupon-applied">
                                <span><i class="fas fa-check-circle me-1"></i> <span id="appliedCouponCode"></span></span>
                                <button type="button" class="remove-coupon" id="removeCouponBtn">Remove</button>
                            </div>
                            <div id="couponForm">
                                <label class="text-muted small fw-semibold mb-2">COUPON CODE</label>
                                <div class="coupon-input-group">
                                    <input type="text" id="couponInput" placeholder="Enter coupon" maxlength="20" autocomplete="off">
                                    <button type="button" class="btn-apply" id="applyCouponBtn">Apply</button>
                                </div>
                                <div id="couponMessage" class="coupon-error" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value" id="summarySubtotal">₹{{ number_format($subtotal, 0) }}</span>
                        </div>
                        <div class="summary-row" id="discountRow" style="display: none;">
                            <span class="summary-label">Discount</span>
                            <span class="summary-value text-success" id="summaryDiscount">-₹0</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Shipping</span>
                            <span class="summary-value" id="summaryShipping">
                                @if($subtotal >= 2000)
                                    <span class="text-success">FREE</span>
                                @else
                                    ₹150
                                @endif
                            </span>
                        </div>
                        <div class="summary-row total">
                            <span>Grand Total</span>
                            <span class="summary-value" id="summaryTotal">
                                @php
                                    $shipping = $subtotal >= 2000 ? 0 : 150;
                                @endphp
                                ₹{{ number_format($subtotal + $shipping, 0) }}
                            </span>
                        </div>

                        <a href="{{ route('checkout') }}" class="btn-proceed-checkout mt-4">
                            <i class="fas fa-lock me-2"></i>Proceed to Checkout
                        </a>

                        <div class="text-center mt-3">
                            <img src="https://placehold.co/250x30/eee/999?text=Secure+Payment" alt="Secure Payment" class="img-fluid" style="max-height: 26px;" onerror="this.style.display='none'">
                            <div class="d-flex justify-content-center gap-2 mt-2 flex-wrap">
                                <span class="badge bg-light text-dark border"><i class="fab fa-cc-visa me-1"></i>Visa</span>
                                <span class="badge bg-light text-dark border"><i class="fab fa-cc-mastercard me-1"></i>Mastercard</span>
                                <span class="badge bg-light text-dark border"><i class="fas fa-mobile-alt me-1"></i>bKash</span>
                                <span class="badge bg-light text-dark border"><i class="fas fa-mobile-alt me-1"></i>Nagad</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h3>Your Cart is Empty</h3>
                <p>Looks like you haven't added any sarees to your cart yet.<br>Explore our exclusive collection and find your perfect drape.</p>
                <a href="{{ route('collection') }}" class="btn-shop-now">
                    <i class="fas fa-store"></i> Shop Now
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    let updating = false;

    function getCartId(btn) {
        return $(btn).data('cart-id');
    }

    function showLoading() {
        $('#cartTableWrap').addClass('cart-loading');
        $('#summarySpinner').show();
    }

    function hideLoading() {
        $('#cartTableWrap').removeClass('cart-loading');
        $('#summarySpinner').hide();
    }

    function updateCartItem(cartId, quantity) {
        if (updating) return;
        updating = true;
        showLoading();

        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart_id: cartId,
                quantity: quantity
            },
            success: function (res) {
                if (res.success) {
                    $('#cartCount').text(res.cart_count);
                    $('#summarySubtotal').text('₹' + Number(res.subtotal).toLocaleString('en-IN'));

                    let shipping = res.subtotal >= 2000 ? 0 : 150;
                    let discount = parseFloat($('#summaryDiscount').data('discount') || 0);
                    let total = res.subtotal - discount + shipping;
                    $('#summaryTotal').text('₹' + Number(total).toLocaleString('en-IN'));

                    if (shipping === 0) {
                        $('#summaryShipping').html('<span class="text-success">FREE</span>');
                    } else {
                        $('#summaryShipping').text('₹150');
                    }

                    let price = parseFloat($('#price-' + cartId).text().replace(/[₹,]/g, ''));
                    let newSubtotal = price * quantity;
                    $('#subtotal-' + cartId).text('₹' + Number(newSubtotal).toLocaleString('en-IN'));
                    $('#qty-' + cartId).val(quantity);
                }
            },
            error: function () {
                alert('Failed to update cart. Please try again.');
            },
            complete: function () {
                updating = false;
                hideLoading();
            }
        });
    }

    $(document).on('click', '.qty-increase', function () {
        let cartId = getCartId(this);
        let input = $('#qty-' + cartId);
        let val = parseInt(input.val());
        if (val < 10) {
            updateCartItem(cartId, val + 1);
        }
    });

    $(document).on('click', '.qty-decrease', function () {
        let cartId = getCartId(this);
        let input = $('#qty-' + cartId);
        let val = parseInt(input.val());
        if (val > 1) {
            updateCartItem(cartId, val - 1);
        }
    });

    $(document).on('click', '.btn-remove-item', function () {
        if (!confirm('Remove this item from your cart?')) return;

        let cartId = getCartId(this);
        showLoading();

        $.ajax({
            url: '{{ route("cart.remove") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart_id: cartId
            },
            success: function (res) {
                if (res.success) {
                    $('#cart-row-' + cartId).fadeOut(300, function () {
                        $(this).remove();
                        $('#cartCount').text(res.cart_count);
                        if ($('.cart-item').length === 0) {
                            location.reload();
                        }
                    });
                }
            },
            error: function () {
                alert('Failed to remove item.');
            },
            complete: function () {
                hideLoading();
            }
        });
    });

    $('#applyCouponBtn').on('click', function () {
        let code = $('#couponInput').val().trim();
        if (!code) {
            $('#couponMessage').text('Please enter a coupon code').show();
            return;
        }

        let btn = $(this);
        btn.prop('disabled', true).text('Applying...');

        $.ajax({
            url: '{{ route("cart.apply-coupon") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                code: code
            },
            success: function (res) {
                if (res.success) {
                    let subtotal = parseFloat($('#summarySubtotal').text().replace(/[₹,]/g, ''));
                    let discount = res.discount;
                    let shipping = subtotal >= 2000 ? 0 : 150;
                    let total = subtotal - discount + shipping;

                    $('#summaryDiscount').data('discount', discount);
                    $('#summaryDiscount').text('-₹' + Number(discount).toLocaleString('en-IN'));
                    $('#discountRow').show();
                    $('#summaryTotal').text('₹' + Number(total).toLocaleString('en-IN'));

                    $('#appliedCouponCode').text(code.toUpperCase() + ' applied');
                    $('#couponForm').hide();
                    $('#couponApplied').show();
                    $('#couponInput').val('');
                    $('#couponMessage').hide();
                    showToast('Coupon applied successfully!', 'success');
                } else {
                    $('#couponMessage').text(res.message).show();
                }
            },
            error: function () {
                $('#couponMessage').text('Invalid or expired coupon code').show();
            },
            complete: function () {
                btn.prop('disabled', false).text('Apply');
            }
        });
    });

    $('#removeCouponBtn').on('click', function () {
        let subtotal = parseFloat($('#summarySubtotal').text().replace(/[₹,]/g, ''));
        let shipping = subtotal >= 2000 ? 0 : 150;
        let total = subtotal + shipping;

        $('#discountRow').hide();
        $('#summaryDiscount').data('discount', 0);
        $('#summaryTotal').text('₹' + Number(total).toLocaleString('en-IN'));
        $('#couponApplied').hide();
        $('#couponForm').show();
        $('#couponMessage').hide();
    });

    $('#clearCartBtn').on('click', function () {
        if (!confirm('Are you sure you want to clear your entire cart?')) return;
        showLoading();

        let ids = [];
        $('.btn-remove-item').each(function () {
            ids.push(getCartId(this));
        });

        let deleted = 0;
        let total = ids.length;
        if (total === 0) return;

        ids.forEach(function (id) {
            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', cart_id: id },
                success: function () {
                    deleted++;
                    if (deleted === total) {
                        location.reload();
                    }
                }
            });
        });
    });

    function showToast(message, type) {
        let bg = type === 'success' ? '#27ae60' : '#e74c3c';
        let toast = $('<div>').css({
            position: 'fixed', bottom: '20px', right: '20px', zIndex: 9999,
            background: bg, color: '#fff', padding: '14px 24px',
            borderRadius: '8px', fontSize: '0.88rem', fontWeight: '500',
            boxShadow: '0 4px 20px rgba(0,0,0,0.15)', maxWidth: '380px'
        }).text(message).appendTo('body');
        setTimeout(() => {
            toast.fadeOut(300, () => toast.remove());
        }, 3500);
    }
});
</script>
@endpush
