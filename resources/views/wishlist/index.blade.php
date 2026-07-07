@extends('layouts.app')

@section('title', 'My Wishlist')

@push('styles')
<style>
.wishlist-page {
    background: #fff;
    min-height: 60vh;
}
.wishlist-breadcrumb {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 12px 20px;
    margin-bottom: 24px;
}
.wishlist-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: '\f105';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    color: #999;
}
.wishlist-breadcrumb .breadcrumb-item a {
    color: #666;
    text-decoration: none;
    font-size: 0.88rem;
    transition: color 0.2s;
}
.wishlist-breadcrumb .breadcrumb-item a:hover {
    color: #d4af37;
}
.wishlist-breadcrumb .breadcrumb-item.active {
    color: #d4af37;
    font-weight: 500;
}
.wishlist-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}
.wishlist-header h4 {
    font-weight: 700;
    margin: 0;
}
.wishlist-header h4 span {
    font-weight: 400;
    color: #999;
    font-size: 0.9rem;
}
.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}
.wishlist-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s;
    position: relative;
}
.wishlist-card:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    transform: translateY(-3px);
    border-color: #e8e0d0;
}
.wishlist-card .card-image-wrap {
    position: relative;
    padding-top: 130%;
    overflow: hidden;
    background: #fafafa;
}
.wishlist-card .card-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}
.wishlist-card:hover .card-image {
    transform: scale(1.05);
}
.wishlist-card .card-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: #d4af37;
    color: #fff;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.wishlist-card .card-stock {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 8px 12px;
    font-size: 0.78rem;
    font-weight: 500;
    text-align: center;
}
.wishlist-card .card-stock.in-stock {
    background: rgba(39, 174, 96, 0.9);
    color: #fff;
}
.wishlist-card .card-stock.out-of-stock {
    background: rgba(231, 76, 60, 0.9);
    color: #fff;
}
.wishlist-card .card-stock.low-stock {
    background: rgba(243, 156, 18, 0.9);
    color: #fff;
}
.wishlist-card .card-remove {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ccc;
    cursor: pointer;
    transition: all 0.2s;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.wishlist-card .card-remove:hover {
    background: #fff;
    color: #e74c3c;
    box-shadow: 0 2px 12px rgba(231, 76, 60, 0.2);
}
.wishlist-card .card-body {
    padding: 16px;
}
.wishlist-card .product-name {
    font-size: 0.92rem;
    font-weight: 500;
    color: #222;
    text-decoration: none;
    display: block;
    margin-bottom: 6px;
    transition: color 0.2s;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.wishlist-card .product-name:hover {
    color: #d4af37;
}
.wishlist-card .product-price {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 14px;
}
.wishlist-card .product-price .current {
    font-weight: 700;
    font-size: 1.05rem;
    color: #222;
}
.wishlist-card .product-price .original {
    font-size: 0.85rem;
    color: #aaa;
    text-decoration: line-through;
}
.wishlist-card .product-price .discount-badge {
    font-size: 0.72rem;
    background: #fff0e0;
    color: #e67e22;
    padding: 2px 8px;
    border-radius: 20px;
    font-weight: 600;
}
.wishlist-card .card-actions {
    display: flex;
    gap: 8px;
}
.wishlist-card .btn-add-cart {
    flex: 1;
    padding: 10px;
    background: #222;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 600;
    transition: all 0.2s;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.wishlist-card .btn-add-cart:hover {
    background: #d4af37;
}
.wishlist-card .btn-add-cart:disabled {
    background: #ddd;
    cursor: not-allowed;
    color: #999;
}
.wishlist-card .btn-share {
    width: 40px;
    border: 1px solid #eee;
    background: #fff;
    border-radius: 8px;
    color: #aaa;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.wishlist-card .btn-share:hover {
    border-color: #d4af37;
    color: #d4af37;
}
.empty-wishlist {
    text-align: center;
    padding: 80px 20px;
}
.empty-wishlist .empty-icon {
    font-size: 5rem;
    color: #ddd;
    margin-bottom: 24px;
}
.empty-wishlist h3 {
    font-weight: 700;
    color: #333;
    margin-bottom: 12px;
}
.empty-wishlist p {
    color: #999;
    font-size: 1rem;
    margin-bottom: 28px;
    max-width: 480px;
    margin-left: auto;
    margin-right: auto;
}
.empty-wishlist .btn-explore {
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
.empty-wishlist .btn-explore:hover {
    background: #d4af37;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
}
.wishlist-toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    background: #27ae60;
    color: #fff;
    padding: 14px 24px;
    border-radius: 8px;
    font-size: 0.88rem;
    font-weight: 500;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    max-width: 380px;
    display: none;
}
.wishlist-toast.error {
    background: #e74c3c;
}
</style>
@endpush

@section('content')
<div class="wishlist-page py-4">
    <div class="container">
        <div class="wishlist-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                </ol>
            </nav>
        </div>

        @if($wishlistItems->count() > 0)
            <div class="wishlist-header">
                <h4>My Wishlist <span>({{ $wishlistItems->count() }} {{ Str::plural('item', $wishlistItems->count()) }})</span></h4>
                <a href="{{ route('collection') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4">
                    <i class="fas fa-store me-1"></i> Continue Shopping
                </a>
            </div>

            <div class="wishlist-grid" id="wishlistGrid">
                @foreach($wishlistItems as $item)
                    @php $product = $item->product; @endphp
                    <div class="wishlist-card" data-wishlist-id="{{ $item->id }}" id="wishlist-card-{{ $item->id }}">
                        <div class="card-image-wrap">
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                <img src="{{ asset($product->images->first()->image_path ?? 'images/placeholder.jpg') }}"
                                     alt="{{ $product->name }}"
                                     class="card-image"
                                     loading="lazy"
                                     onerror="this.src='https://placehold.co/300x390?text=No+Image'">
                            </a>

                            @if($product->discount_percentage)
                                <span class="card-badge">-{{ $product->discount_percentage }}%</span>
                            @endif

                            @if($product->stock_quantity > 0)
                                @if($product->stock_quantity <= 5)
                                    <div class="card-stock low-stock">Only {{ $product->stock_quantity }} left</div>
                                @else
                                    <div class="card-stock in-stock"><i class="fas fa-check-circle me-1"></i>In Stock</div>
                                @endif
                            @else
                                <div class="card-stock out-of-stock"><i class="fas fa-times-circle me-1"></i>Out of Stock</div>
                            @endif

                            <button type="button" class="card-remove" data-wishlist-id="{{ $item->id }}" title="Remove from wishlist">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="card-body">
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="product-name">
                                {{ $product->name }}
                            </a>

                            <div class="product-price">
                                <span class="current">₹{{ number_format($product->discounted_price, 0) }}</span>
                                @if($product->discount_price)
                                    <span class="original">₹{{ number_format($product->price, 0) }}</span>
                                    <span class="discount-badge">-{{ $product->discount_percentage }}%</span>
                                @endif
                            </div>

                            <div class="card-actions">
                                <button type="button" class="btn-add-cart move-to-cart"
                                        data-wishlist-id="{{ $item->id }}"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->discounted_price }}"
                                        data-product-image="{{ asset($product->images->first()->image_path ?? 'images/placeholder.jpg') }}"
                                        {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                                    @if($product->stock_quantity > 0)
                                        <i class="fas fa-shopping-bag"></i> Move to Cart
                                    @else
                                        <i class="fas fa-bell"></i> Notify Me
                                    @endif
                                </button>
                                <button type="button" class="btn-share" data-product-name="{{ $product->name }}" data-product-url="{{ route('products.show', $product->slug ?? $product->id) }}" title="Share">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-wishlist">
                <div class="empty-icon">
                    <i class="far fa-heart"></i>
                </div>
                <h3>Your Wishlist is Empty</h3>
                <p>
                    Save your favorite sarees to your wishlist and they'll appear here.<br>
                    Start exploring our exclusive collection now!
                </p>
                <a href="{{ route('collection') }}" class="btn-explore">
                    <i class="fas fa-store"></i> Explore Collection
                </a>
            </div>
        @endif
    </div>
</div>

<div class="wishlist-toast" id="wishlistToast"></div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    function showToast(message, isError) {
        let toast = $('#wishlistToast');
        toast.text(message).removeClass('error');
        if (isError) toast.addClass('error');
        toast.fadeIn(200);
        setTimeout(() => toast.fadeOut(300), 3000);
    }

    function removeCard(wishlistId) {
        let card = $('#wishlist-card-' + wishlistId);
        card.fadeOut(300, function () {
            $(this).remove();
            let count = $('.wishlist-card').length;
            $('.wishlist-header h4 span').text('(' + count + ' ' + (count === 1 ? 'item' : 'items') + ')');
            if (count === 0) {
                location.reload();
            }
        });
    }

    $('.card-remove').on('click', function () {
        let wishlistId = $(this).data('wishlist-id');

        $.ajax({
            url: '{{ route("wishlist.remove") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                wishlist_id: wishlistId
            },
            success: function (res) {
                if (res.success) {
                    removeCard(wishlistId);
                    showToast('Removed from wishlist');
                }
            },
            error: function () {
                showToast('Failed to remove item', true);
            }
        });
    });

    $('.move-to-cart').on('click', function () {
        let btn = $(this);
        let wishlistId = btn.data('wishlist-id');

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({
            url: '{{ route("wishlist.move-to-cart") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                wishlist_id: wishlistId
            },
            success: function (res) {
                if (res.success) {
                    removeCard(wishlistId);
                    let countEl = $('#cartCount');
                    let current = parseInt(countEl.text()) || 0;
                    countEl.text(current + 1);
                    showToast('Moved to cart!');
                }
            },
            error: function () {
                btn.prop('disabled', false).html('<i class="fas fa-shopping-bag"></i> Move to Cart');
                showToast('Failed to move to cart', true);
            }
        });
    });

    $('.btn-share').on('click', function () {
        let name = $(this).data('product-name');
        let url = $(this).data('product-url');

        if (navigator.share) {
            navigator.share({
                title: name,
                text: 'Check out this saree from AURA!',
                url: url
            }).catch(() => {});
        } else {
            let dummy = $('<textarea>').val(url).appendTo('body').select();
            document.execCommand('copy');
            dummy.remove();
            showToast('Link copied to clipboard!');
        }
    });
});
</script>
@endpush
