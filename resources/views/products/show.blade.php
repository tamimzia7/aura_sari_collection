@extends('layouts.app')

@section('title', $product->name . ' - AURA')

@push('styles')
<style>
.product-gallery {
    position: relative;
}
.product-gallery .main-image {
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    cursor: crosshair;
    position: relative;
    background: #f8f9fa;
}
.product-gallery .main-image img {
    width: 100%;
    display: block;
    transition: transform 0.3s;
}
.product-gallery .main-image:hover img {
    transform: scale(1.5);
}
.thumbnail-list {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    flex-wrap: wrap;
}
.thumbnail-list .thumb {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s;
    flex-shrink: 0;
}
.thumbnail-list .thumb.active {
    border-color: #d4af37;
}
.thumbnail-list .thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.product-info .price-current {
    font-size: 2rem;
    font-weight: 700;
    color: #d4af37;
}
.product-info .price-original {
    font-size: 1.2rem;
    color: #999;
    text-decoration: line-through;
    margin-left: 10px;
}
.product-info .discount-badge {
    display: inline-block;
    background: #dc3545;
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    margin-left: 10px;
    vertical-align: middle;
}
.color-swatch {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s;
    display: inline-block;
    margin-right: 8px;
    position: relative;
}
.color-swatch:hover, .color-swatch.active {
    border-color: #333;
    transform: scale(1.1);
}
.color-swatch.active::after {
    content: '\f00c';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-size: 12px;
    text-shadow: 0 0 3px rgba(0,0,0,0.5);
}
.quantity-selector {
    display: flex;
    align-items: center;
    gap: 0;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    width: fit-content;
}
.quantity-selector button {
    border: none;
    background: #f8f9fa;
    padding: 8px 16px;
    cursor: pointer;
    font-size: 1.2rem;
    transition: background 0.2s;
}
.quantity-selector button:hover {
    background: #e9ecef;
}
.quantity-selector input {
    width: 60px;
    text-align: center;
    border: none;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    padding: 8px;
    outline: none;
}
.sticky-cart {
    position: sticky;
    top: 90px;
}
.product-tabs .nav-tabs .nav-link {
    color: #666;
    font-weight: 600;
    border: none;
    border-bottom: 2px solid transparent;
    padding: 12px 20px;
    transition: all 0.2s;
}
.product-tabs .nav-tabs .nav-link:hover {
    color: #1a1a2e;
    border-bottom-color: #ddd;
}
.product-tabs .nav-tabs .nav-link.active {
    color: #1a1a2e;
    border-bottom-color: #d4af37;
    background: none;
}
.product-tabs .tab-content {
    padding: 30px 0;
    border-top: 1px solid #eee;
    margin-top: -1px;
}
.specs-table td {
    padding: 10px 15px;
    border-bottom: 1px solid #f0f0f0;
}
.specs-table td:first-child {
    font-weight: 600;
    color: #555;
    width: 200px;
}
.star-rating .fa-star,
.star-rating .fa-star-half-alt,
.star-rating .fa-star-o {
    color: #f59e0b;
}
.review-item {
    border-bottom: 1px solid #f0f0f0;
    padding: 20px 0;
}
.review-item:last-child {
    border-bottom: none;
}
.breadcrumb-item + .breadcrumb-item::before {
    content: '\f105';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    font-size: 12px;
}
.breadcrumb a {
    color: #666;
    text-decoration: none;
    transition: color 0.2s;
}
.breadcrumb a:hover {
    color: #d4af37;
}
.related-product-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border-radius: 12px;
    overflow: hidden;
}
.related-product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}
.payment-icons i {
    font-size: 2rem;
    color: #666;
    margin-right: 10px;
}
.shipping-badge {
    background: #f0fdf4;
    border: 1px solid #86efac;
    border-radius: 8px;
    padding: 10px 15px;
    color: #166534;
}
.stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}
.stock-badge.in-stock {
    background: #f0fdf4;
    color: #166534;
}
.stock-badge.out-of-stock {
    background: #fef2f2;
    color: #991b1b;
}
.stock-badge i {
    font-size: 0.7rem;
}
.rating-summary {
    background: #f9fafb;
    border-radius: 12px;
    padding: 20px;
}
</style>
@endpush

@section('content')
<div class="product-details-page py-4">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-white p-0 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}"><i class="fas fa-home me-1"></i>Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index') }}">Collection</a>
                </li>
                @if($product->category)
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.index') }}">
                            {{ $product->category->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Product Main Section -->
        <div class="row mt-3">
            <!-- Left: Gallery -->
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="product-gallery">
                    <div class="main-image" id="mainImageContainer">
                        <img src="{{ asset($product->imageUrl) }}"
                             alt="{{ $product->name }}"
                             id="mainProductImage"
                             data-zoom-image="{{ asset($product->imageUrl) }}">
                    </div>
                    @if($product->images->count() > 0)
                        <div class="thumbnail-list">
                            @foreach($product->images as $image)
                                <div class="thumb {{ $image->is_primary ? 'active' : '' }}"
                                     onclick="changeImage(this, '{{ asset($image->image_path) }}')">
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="col-lg-5">
                <div class="sticky-cart">
                    <div class="product-info">
                        <!-- Badges -->
                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                            @if($product->category)
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1 rounded-pill">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                            @if($product->brand)
                                <span class="badge bg-dark px-3 py-1 rounded-pill">
                                    {{ $product->brand->name }}
                                </span>
                            @endif
                            @if($product->is_new_arrival)
                                <span class="badge bg-info px-3 py-1 rounded-pill">New Arrival</span>
                            @endif
                            @if($product->is_best_selling)
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill">Best Seller</span>
                            @endif
                        </div>

                        <!-- Product Name -->
                        <h1 class="product-name fw-bold mb-2" style="font-family: 'Playfair Display', serif; font-size: 1.75rem;">
                            {{ $product->name }}
                        </h1>

                        <!-- SKU -->
                        @if($product->sku)
                            <p class="text-muted small mb-2">SKU: {{ $product->sku }}</p>
                        @endif

                        <!-- Rating -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="star-rating me-2">
                                @php
                                    $avgRating = $product->reviews->avg('rating') ?? 0;
                                    $reviewCount = $product->reviews->count();
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($avgRating))
                                        <i class="fas fa-star" style="color: #f59e0b; font-size: 0.9rem;"></i>
                                    @elseif($i - 0.5 <= $avgRating)
                                        <i class="fas fa-star-half-alt" style="color: #f59e0b; font-size: 0.9rem;"></i>
                                    @else
                                        <i class="far fa-star" style="color: #f59e0b; font-size: 0.9rem;"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-muted small">
                                {{ number_format($avgRating, 1) }}
                                <span class="ms-1">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span>
                            </span>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            @if($product->discount_price)
                                <span class="price-current">₹{{ number_format($product->discount_price) }}</span>
                                <span class="price-original">₹{{ number_format($product->price) }}</span>
                                @if($product->discountPercentage)
                                    <span class="discount-badge">-{{ $product->discountPercentage }}%</span>
                                @endif
                                <p class="text-muted small mt-1 mb-0">You save ₹{{ number_format($product->price - $product->discount_price) }}</p>
                            @else
                                <span class="price-current">₹{{ number_format($product->price) }}</span>
                            @endif
                        </div>

                        <!-- Short Description -->
                        @if($product->short_description)
                            <p class="text-muted mb-3">{{ $product->short_description }}</p>
                        @endif

                        <!-- Color Selection -->
                        @php
                            $uniqueColors = $product->variants->pluck('color')->unique()->filter();
                            $productColors = $uniqueColors->isNotEmpty() ? $uniqueColors : collect([$product->color])->filter();
                        @endphp
                        @if($productColors->isNotEmpty())
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-uppercase mb-2">Color: <span id="selectedColor" class="fw-normal text-muted">{{ $productColors->first() }}</span></label>
                                <div>
                                    @foreach($productColors as $color)
                                        @php
                                            $colorMap = [
                                                'Red' => '#dc2626', 'Blue' => '#2563eb', 'Green' => '#16a34a',
                                                'Black' => '#1a1a1a', 'White' => '#f5f5f5', 'Gold' => '#d4af37',
                                                'Silver' => '#c0c0c0', 'Pink' => '#ec4899', 'Purple' => '#9333ea',
                                                'Yellow' => '#eab308', 'Orange' => '#f97316', 'Brown' => '#78350f',
                                                'Navy' => '#1e3a5f', 'Maroon' => '#800000', 'Teal' => '#0d9488',
                                                'Cream' => '#fef3c7', 'Beige' => '#f5e6d3', 'Grey' => '#6b7280',
                                            ];
                                            $hexColor = $colorMap[$color] ?? '#6b7280';
                                        @endphp
                                        <span class="color-swatch {{ $loop->first ? 'active' : '' }}"
                                              style="background-color: {{ $hexColor }};"
                                              data-color="{{ $color }}"
                                              onclick="selectColor(this)"
                                              title="{{ $color }}"
                                              {{ $loop->first ? 'tabindex="0"' : '' }}>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Size Selection -->
                        @php
                            $sizes = is_array($product->sizes) ? $product->sizes : collect();
                        @endphp
                        @if($sizes->isNotEmpty())
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-uppercase mb-2">Size: <span id="selectedSize" class="fw-normal text-muted">{{ $sizes->first() }}</span></label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach($sizes as $size)
                                        <button type="button"
                                                class="btn btn-outline-dark btn-sm rounded-pill size-btn {{ $loop->first ? 'active' : '' }}"
                                                data-size="{{ $size }}"
                                                onclick="selectSize(this)">
                                            {{ $size }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-uppercase mb-2">Quantity</label>
                            <div class="quantity-selector">
                                <button type="button" onclick="decrementQty()" aria-label="Decrease quantity">−</button>
                                <input type="number" id="qtyInput" value="1" min="1" max="{{ $product->stock_quantity }}" readonly>
                                <button type="button" onclick="incrementQty()" aria-label="Increase quantity">+</button>
                            </div>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-3">
                            @if($product->isInStock)
                                <span class="stock-badge in-stock">
                                    <i class="fas fa-circle"></i> In Stock
                                </span>
                                @if($product->stock_quantity <= 5)
                                    <span class="text-warning ms-2 small fw-semibold">Only {{ $product->stock_quantity }} left</span>
                                @endif
                            @else
                                <span class="stock-badge out-of-stock">
                                    <i class="fas fa-circle"></i> Out of Stock
                                </span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mb-3">
                            @if($product->isInStock)
                                <button class="btn btn-dark btn-lg flex-grow-1 rounded-pill add-to-cart-btn"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->discount_price ?? $product->price }}"
                                        data-product-image="{{ asset($product->imageUrl) }}"
                                        onclick="addToCart(this)">
                                    <i class="fas fa-shopping-bag me-2"></i> Add to Cart
                                </button>
                                <a href="{{ route('checkout.direct', $product->id) }}"
                                   class="btn btn-success btn-lg flex-grow-1 rounded-pill">
                                    <i class="fas fa-check-circle me-2"></i> Confirm Order
                                </a>
                            @else
                                <button class="btn btn-secondary btn-lg flex-grow-1 rounded-pill" disabled>
                                    <i class="fas fa-bell me-2"></i> Notify Me
                                </button>
                            @endif
                            <button class="btn btn-outline-dark btn-lg rounded-circle d-flex align-items-center justify-content-center wishlist-btn"
                                    style="width: 52px; height: 52px;"
                                    data-product-id="{{ $product->id }}"
                                    onclick="toggleWishlist(this)"
                                    aria-label="Add to Wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="btn btn-outline-secondary btn-lg rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 52px; height: 52px;"
                                    onclick="shareProduct()"
                                    aria-label="Share product">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </div>

                        <!-- Payment & Shipping -->
                        <div class="mb-3">
                            <div class="payment-icons mb-2">
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fab fa-cc-amex"></i>
                                <i class="fab fa-cc-paypal"></i>
                                <i class="fab fa-google-pay"></i>
                                <i class="fab fa-apple-pay"></i>
                            </div>
                            <div class="shipping-badge d-flex align-items-center gap-2">
                                <i class="fas fa-truck"></i>
                                <span>Free shipping on orders above ₹499</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="product-tabs mt-5">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">
                        <i class="fas fa-align-left me-2"></i>Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">
                        <i class="fas fa-list me-2"></i>Specifications
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
                        <i class="fas fa-star me-2"></i>Reviews ({{ $reviewCount }})
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="productTabsContent">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="description-content lh-lg">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                    <div class="row">
                        <div class="col-lg-8">
                            <table class="specs-table w-100">
                                @if($product->fabric)
                                    <tr>
                                        <td>Fabric</td>
                                        <td>{{ $product->fabric }}</td>
                                    </tr>
                                @endif
                                @if($product->occasion)
                                    <tr>
                                        <td>Occasion</td>
                                        <td>{{ $product->occasion }}</td>
                                    </tr>
                                @endif
                                @if($product->color)
                                    <tr>
                                        <td>Color</td>
                                        <td>{{ $product->color }}</td>
                                    </tr>
                                @endif
                                @if($product->pattern)
                                    <tr>
                                        <td>Pattern</td>
                                        <td>{{ $product->pattern }}</td>
                                    </tr>
                                @endif
                                @if($product->sizes)
                                    <tr>
                                        <td>Available Sizes</td>
                                        <td>{{ is_array($product->sizes) ? implode(', ', $product->sizes) : $product->sizes }}</td>
                                    </tr>
                                @endif
                                @if($product->weight)
                                    <tr>
                                        <td>Weight</td>
                                        <td>{{ $product->weight }}</td>
                                    </tr>
                                @endif
                                @if($product->sku)
                                    <tr>
                                        <td>SKU</td>
                                        <td>{{ $product->sku }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <div class="row">
                        <div class="col-lg-3 mb-4 mb-lg-0">
                            <div class="rating-summary text-center">
                                <div class="display-4 fw-bold mb-1">{{ number_format($avgRating, 1) }}</div>
                                <div class="star-rating mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($avgRating))
                                            <i class="fas fa-star" style="color: #f59e0b;"></i>
                                        @elseif($i - 0.5 <= $avgRating)
                                            <i class="fas fa-star-half-alt" style="color: #f59e0b;"></i>
                                        @else
                                            <i class="far fa-star" style="color: #f59e0b;"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-muted mb-0">{{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            @if($reviewCount > 0)
                                @php
                                    $approvedReviews = $product->reviews->where('is_approved', true);
                                @endphp
                                @forelse($approvedReviews as $review)
                                    <div class="review-item">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                                                <div class="star-rating mt-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star" style="color: #f59e0b; font-size: 0.85rem;"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0 text-muted">{{ $review->review_text }}</p>
                                    </div>
                                @empty
                                    <p class="text-muted">No approved reviews yet.</p>
                                @endforelse
                            @else
                                <div class="text-center py-5">
                                    <i class="far fa-star fa-3x text-muted mb-3"></i>
                                    <h5>No reviews yet</h5>
                                    <p class="text-muted">Be the first to review this product.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <section class="related-products mt-5 pt-3">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold mb-0" style="font-family: 'Playfair Display', serif;">You May Also Like</h3>
                    <a href="{{ $product->category ? route('products.index', ['category' => $product->category->slug]) : '#' }}" class="text-decoration-none small fw-semibold" style="color: #d4af37;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="row g-4">
                    @foreach($relatedProducts as $related)
                        <div class="col-6 col-md-4 col-lg-3">
                            @include('partials.product-card', ['product' => $related])
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image Thumbnail Change
    function changeImage(element, imageUrl) {
        document.querySelectorAll('.thumb').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        const mainImg = document.getElementById('mainProductImage');
        mainImg.src = imageUrl;
        mainImg.setAttribute('data-zoom-image', imageUrl);
    }

    // Color Selection
    function selectColor(element) {
        document.querySelectorAll('.color-swatch').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('selectedColor').textContent = element.getAttribute('data-color');
    }

    // Size Selection
    function selectSize(element) {
        document.querySelectorAll('.size-btn').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('selectedSize').textContent = element.getAttribute('data-size');
    }

    // Quantity Controls
    function incrementQty() {
        const input = document.getElementById('qtyInput');
        const max = parseInt(input.getAttribute('max'));
        let val = parseInt(input.value);
        if (val < max) {
            input.value = val + 1;
        }
    }

    function decrementQty() {
        const input = document.getElementById('qtyInput');
        let val = parseInt(input.value);
        if (val > 1) {
            input.value = val - 1;
        }
    }

    // Add to Cart
    function addToCart(button) {
        const id = button.getAttribute('data-product-id');
        const name = button.getAttribute('data-product-name');
        const price = button.getAttribute('data-product-price');
        const image = button.getAttribute('data-product-image');
        const qty = document.getElementById('qtyInput').value;

        const originalHtml = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Adding...';

        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: id,
                quantity: qty
            },
            success: function(response) {
                if (response.in_cart) {
                    button.innerHTML = '<i class="fas fa-check me-2"></i> Remove from Cart';
                    button.classList.add('in-cart');
                    if (typeof showToast === 'function') showToast('Added to Cart', 'success');
                } else {
                    button.innerHTML = originalHtml;
                    button.classList.remove('in-cart');
                    if (typeof showToast === 'function') showToast('Removed from Cart', 'info');
                }
                setTimeout(() => {
                    button.disabled = false;
                }, 2000);
                if (response.cart_count !== undefined) {
                    setCartBadge(response.cart_count);
                }
                document.dispatchEvent(new CustomEvent('cart-updated', { detail: response }));
            },
            error: function(xhr) {
                button.innerHTML = originalHtml;
                button.disabled = false;
                if (xhr.status === 401) {
                    window.location.href = '{{ route("login") }}';
                } else {
                    alert('Failed to add to cart. Please try again.');
                }
            }
        });
    }

    // Wishlist Toggle
    function toggleWishlist(button) {
        const icon = button.querySelector('i');
        const productId = button.getAttribute('data-product-id');

        $.ajax({
            url: '{{ route("wishlist.toggle") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId
            },
            success: function(response) {
                icon.className = response.in_wishlist ? 'fas fa-heart' : 'far fa-heart';
                button.classList.toggle('active', response.in_wishlist);
                if (response.wishlist_count !== undefined) {
                    setWishlistBadge(response.wishlist_count);
                }
                if (typeof showToast === 'function') showToast(response.in_wishlist ? 'Added to Wishlist' : 'Removed from Wishlist', response.in_wishlist ? 'success' : 'info');
                document.dispatchEvent(new CustomEvent('wishlist-updated', { detail: response }));
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = '{{ route("login") }}';
                }
            }
        });
    }

    // Share Product
    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $product->name }}',
                text: '{{ strip_tags($product->short_description ?? $product->name) }}',
                url: window.location.href
            }).catch(() => {});
        } else {
            const dummy = document.createElement('input');
            document.body.appendChild(dummy);
            dummy.value = window.location.href;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
            alert('Link copied to clipboard!');
        }
    }

    // Product image zoom effect on mousemove
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('mainImageContainer');
        const img = document.getElementById('mainProductImage');

        if (container && img) {
            container.addEventListener('mousemove', function(e) {
                const rect = container.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                img.style.transformOrigin = x + '% ' + y + '%';
                img.style.transform = 'scale(1.5)';
            });

            container.addEventListener('mouseleave', function() {
                img.style.transformOrigin = 'center center';
                img.style.transform = 'scale(1)';
            });
        }
    });
</script>
@endpush
