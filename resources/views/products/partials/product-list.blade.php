<!-- Product Grid -->
<div id="product-grid" class="row product-grid g-3 @if(request('view') === 'list') list-view @endif">
    @forelse($products as $product)
        @php
            $primaryImg = $product->images[0]->image_path ?? 'images/placeholder.jpg';
            $hoverImg = $product->images[1]->image_path ?? null;
            $brandName = $product->brand->name ?? '';
        @endphp
        <div class="col-xl-3 col-lg-4 col-md-6 col-6">
            <div class="aura-product-card">
                <div class="product-card-image position-relative overflow-hidden">
                    <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                        <img src="{{ asset($primaryImg) }}"
                             alt="{{ $product->name }}"
                             class="product-img-front w-100"
                             loading="lazy"
                             onerror="this.src='https://placehold.co/300x400?text=No+Image'">
                        @if($hoverImg)
                            <img src="{{ asset($hoverImg) }}"
                                 alt="{{ $product->name }}"
                                 class="product-img-hover position-absolute top-0 start-0 w-100"
                                 loading="lazy"
                                 onerror="this.style.display='none'">
                        @endif
                    </a>

                    <div class="product-card-actions position-absolute top-0 end-0 p-2 d-flex flex-column gap-1">
                        @auth
                            <button class="action-btn wishlist-btn @if($product->wishlists()->where('user_id', auth()->id())->exists()) active @endif"
                                    data-product-id="{{ $product->id }}"
                                    data-bs-toggle="tooltip"
                                    title="@if($product->wishlists()->where('user_id', auth()->id())->exists()) Remove from Wishlist @else Add to Wishlist @endif"
                                    aria-label="Toggle wishlist">
                                <i class="@if($product->wishlists()->where('user_id', auth()->id())->exists()) fas @else far @endif fa-heart"></i>
                            </button>
                        @else
                            <button class="action-btn wishlist-btn"
                                    data-product-id="{{ $product->id }}"
                                    data-bs-toggle="tooltip"
                                    title="Add to Wishlist"
                                    aria-label="Add to wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                        @endif
                        <button class="action-btn quick-view-btn"
                                data-product-id="{{ $product->id }}"
                                data-bs-toggle="tooltip"
                                title="Quick View"
                                aria-label="Quick view">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    @if($product->discount_percentage)
                        <span class="product-badge discount">
                            -{{ $product->discount_percentage }}%
                        </span>
                    @elseif($product->is_new_arrival)
                        <span class="product-badge new">New</span>
                    @endif

                    @if(!$product->is_in_stock)
                        <div class="stock-overlay out-of-stock">
                            <i class="fas fa-times-circle me-1"></i> Out of Stock
                        </div>
                    @elseif($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                        <div class="stock-overlay low-stock">
                            <i class="fas fa-exclamation-circle me-1"></i> Only {{ $product->stock_quantity }} left
                        </div>
                    @endif
                </div>

                <div class="card-body d-flex flex-column">
                    @if($brandName)
                        <p class="product-brand">{{ $brandName }}</p>
                    @endif

                    <h6 class="product-name">
                        <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                            {{ $product->name }}
                        </a>
                    </h6>

                    @if($product->category)
                        <p class="product-category">{{ $product->category->name }}</p>
                    @endif

                    @if($product->rating ?? false)
                        <div class="product-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($product->rating) ? 'star-filled' : 'star-empty' }}"></i>
                            @endfor
                            <span class="rating-count">({{ $product->reviews_count ?? $product->reviews->count() ?? 0 }})</span>
                        </div>
                    @endif

                    <div class="product-price mt-auto pt-2">
                        @if($product->discount_price)
                            <span class="current-price">₹{{ number_format($product->discounted_price, 0) }}</span>
                            <span class="original-price">₹{{ number_format($product->price, 0) }}</span>
                        @else
                            <span class="current-price">₹{{ number_format($product->price, 0) }}</span>
                        @endif
                    </div>
                </div>

                <div class="card-footer">
                    @if($product->is_in_stock)
                        <button class="add-to-cart-btn"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-product-price="{{ $product->discounted_price }}"
                                data-product-image="{{ asset($primaryImg) }}">
                            <i class="fas fa-shopping-bag"></i>
                            <span>Add to Cart</span>
                        </button>
                    @else
                        <button class="add-to-cart-btn" style="opacity: 0.5; cursor: not-allowed;" disabled>
                            <i class="fas fa-bell"></i>
                            <span>Notify Me</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state">
                <div class="mb-3">
                    <i class="fas fa-search"></i>
                </div>
                <h5 class="fw-semibold">No products found</h5>
                <p>We couldn't find any sarees matching your criteria. Try adjusting your filters or search terms.</p>
                <button class="btn btn-aura rounded-pill px-4 clear-filters-btn">
                    <i class="fas fa-times me-2"></i> Clear All Filters
                </button>
            </div>
        </div>
    @endforelse
</div>

<!-- Toolbar Stats -->
<div id="toolbar-stats" class="d-flex align-items-center gap-2">
    <span class="text-muted small">
        Showing <strong class="text-dark">{{ $products->total() > 0 ? $products->firstItem() : 0 }}</strong>–<strong class="text-dark">{{ $products->lastItem() }}</strong> of <strong class="text-dark">{{ number_format($products->total()) }}</strong> results
    </span>
    @if(request()->anyFilled(['search', 'category', 'color', 'fabric', 'occasion', 'featured', 'new_arrival', 'best_selling', 'trending', 'discounted', 'availability', 'price_range']))
        <span class="badge bg-dark rounded-pill filter-active-badge d-none d-md-inline-flex align-items-center gap-1 px-3 py-1">
            <i class="fas fa-filter fa-xs"></i> Filters Active
            <button type="button" class="btn-close btn-close-white ms-1 clear-filters-btn" style="font-size: 0.5rem;" aria-label="Clear filters"></button>
        </span>
    @endif
</div>

<!-- Pagination -->
<div id="pagination-section" class="mt-4 pt-2">
    @if($products->hasPages())
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="small" style="color: var(--aura-text-muted);">
                Showing page {{ $products->currentPage() }} of {{ $products->lastPage() }}
            </div>
            <div class="aura-pagination">
                {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    @elseif($products->total() > 0)
        <div class="text-center small" style="color: var(--aura-text-muted);">
            Showing all {{ $products->total() }} {{ Str::plural('product', $products->total()) }}
        </div>
    @endif
</div>
