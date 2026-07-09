@props([
    'product',
    'inWishlist' => false,
])

@php
    $primaryImage = optional($product->images->first())->image_path ?? 'images/placeholder.jpg';
    $hoverImage = optional($product->images->skip(1)->first())->image_path ?? null;
    $brandName = optional($product->brand)->name ?? '';
    $stock = $product->stock_quantity ?? 0;
@endphp

<div class="card product-card border-0 shadow-sm h-100">
    <div class="product-card-image position-relative overflow-hidden">
        <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
            <img src="{{ asset($primaryImage) }}"
                 alt="{{ $product->name }}"
                 class="card-img-top product-img-front"
                 loading="lazy"
                 onerror="this.src='https://placehold.co/300x400?text=No+Image'">
            @if($hoverImage)
                <img src="{{ asset($hoverImage) }}"
                     alt="{{ $product->name }}"
                     class="card-img-top product-img-hover position-absolute top-0 start-0"
                     loading="lazy"
                     onerror="this.style.display='none'">
            @endif
        </a>

        <div class="product-card-actions position-absolute top-0 end-0 p-2 d-flex flex-column gap-1">
            <button class="btn btn-light btn-sm rounded-circle shadow-sm wishlist-btn {{ $inWishlist ? 'active' : '' }}"
                    data-product-id="{{ $product->id }}"
                    data-bs-toggle="tooltip"
                    title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
                    aria-label="Toggle wishlist">
                <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart"></i>
            </button>

            <button class="btn btn-light btn-sm rounded-circle shadow-sm quick-view-btn"
                    data-product-id="{{ $product->id }}"
                    data-bs-toggle="tooltip"
                    title="Quick View"
                    aria-label="Quick view">
                <i class="fas fa-eye"></i>
            </button>
        </div>

        @if($product->discount_percentage)
            <span class="position-absolute top-0 start-0 badge bg-danger m-2">
                -{{ $product->discount_percentage }}%
            </span>
        @endif

        @if($stock < 1)
            <div class="position-absolute bottom-0 start-0 w-100 bg-dark bg-opacity-75 text-white text-center py-1 small">
                Out of Stock
            </div>
        @elseif($stock <= 5)
            <div class="position-absolute bottom-0 start-0 w-100 bg-warning bg-opacity-75 text-dark text-center py-1 small">
                Only {{ $stock }} left
            </div>
        @endif
    </div>

    <div class="card-body d-flex flex-column">
        @if($brandName)
            <p class="product-brand small text-muted text-uppercase mb-1">{{ $brandName }}</p>
        @endif

        <h6 class="product-name mb-1">
            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="text-decoration-none text-dark stretched-link">
                {{ $product->name }}
            </a>
        </h6>

        @if($product->rating ?? false)
            <div class="product-rating mb-1">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= round($product->rating) ? 'text-warning' : 'text-muted' }}" style="font-size: 0.75rem;"></i>
                @endfor
                <span class="small text-muted ms-1">({{ $product->reviews_count ?? 0 }})</span>
            </div>
        @endif

        <div class="product-price mt-auto pt-2 d-flex align-items-center gap-2">
            @if($product->discount_price)
                <span class="fw-bold text-dark">₹{{ number_format($product->discounted_price, 0) }}</span>
                <span class="text-muted text-decoration-line-through small">₹{{ number_format($product->price, 0) }}</span>
            @else
                <span class="fw-bold text-dark">₹{{ number_format($product->price, 0) }}</span>
            @endif
        </div>
    </div>

    <div class="card-footer bg-white border-0 pt-0 px-3 pb-3">
        @if($stock > 0)
            <button class="btn btn-dark btn-sm w-100 rounded-pill add-to-cart-btn"
                    data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}"
                    data-product-price="{{ $product->discounted_price }}"
                    data-product-image="{{ asset($primaryImage) }}">
                <i class="fas fa-shopping-bag me-1"></i> Add to Cart
            </button>
        @else
            <button class="btn btn-outline-secondary btn-sm w-100 rounded-pill" disabled>
                <i class="fas fa-bell me-1"></i> Notify Me
            </button>
        @endif
    </div>
</div>
