@extends('layouts.app')

@section('title', 'Collection - AURA')

@push('styles')
<style>
:root {
    --aura-primary: #1a1a2e;
    --aura-accent: #d4af37;
    --aura-text: #333;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    color: var(--aura-text);
    background: #f8f9fa;
}

/* ─── Page Header ─── */
.collection-header h1 {
    font-family: 'Playfair Display', serif;
    color: var(--aura-primary);
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.collection-header p {
    font-size: 0.95rem;
    color: #6b7280 !important;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '›';
    font-size: 1.1rem;
    line-height: 1;
    color: #adb5bd;
}
.breadcrumb-item a:hover {
    color: var(--aura-primary) !important;
}

/* ─── Filter Sidebar ─── */
.filter-sidebar {
    position: sticky;
    top: 100px;
    max-height: calc(100vh - 120px);
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #e5e7eb transparent;
}
.filter-sidebar::-webkit-scrollbar {
    width: 4px;
}
.filter-sidebar::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 10px;
}

/* ─── Product Grid ─── */
.product-grid {
    --bs-gutter-y: 1.5rem;
}

/* ─── Product Card Overrides for Shop Page ─── */
.shop-product-card {
    transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    height: 100%;
}
.shop-product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
}
.shop-product-card .product-card-image {
    overflow: hidden;
    position: relative;
    background: #f9f9f9;
}
.shop-product-card .product-img-front,
.shop-product-card .product-img-hover {
    transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    width: 100%;
    height: 280px;
    object-fit: cover;
}
.shop-product-card:hover .product-img-front,
.shop-product-card:hover .product-img-hover {
    transform: scale(1.06);
}
.shop-product-card .product-card-actions {
    opacity: 0;
    transform: translateX(8px);
    transition: all 0.3s ease;
    z-index: 2;
}
.shop-product-card:hover .product-card-actions {
    opacity: 1;
    transform: translateX(0);
}
.shop-product-card .quick-add-btn {
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s ease;
}
.shop-product-card:hover .quick-add-btn {
    opacity: 1;
    transform: translateY(0);
}
.shop-product-card .product-card-actions .btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(4px);
    border: none;
    transition: all 0.2s;
}
.shop-product-card .product-card-actions .btn:hover {
    background: var(--aura-primary);
    color: #fff;
}
.shop-product-card .product-card-actions .btn.active {
    background: #ef4444;
    color: #fff;
}
.shop-product-card .product-card-actions .btn.active i {
    animation: heartPop 0.3s ease;
}
@keyframes heartPop {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

/* ─── List View ─── */
.product-grid.list-view .col-xl-3,
.product-grid.list-view .col-lg-4,
.product-grid.list-view .col-md-6,
.product-grid.list-view .col-6 {
    width: 100%;
    flex: 0 0 100%;
    max-width: 100%;
}
.product-grid.list-view .shop-product-card {
    display: flex;
    flex-direction: row;
}
.product-grid.list-view .shop-product-card .product-card-image {
    width: 240px;
    min-height: 200px;
    flex-shrink: 0;
}
.product-grid.list-view .shop-product-card .product-img-front,
.product-grid.list-view .shop-product-card .product-img-hover {
    height: 100%;
    min-height: 200px;
}
.product-grid.list-view .shop-product-card .card-body {
    flex: 1;
}
.product-grid.list-view .shop-product-card .card-footer {
    display: flex;
    align-items: flex-end;
}

/* ─── Empty State ─── */
.empty-state {
    padding: 4rem 1rem;
}
.empty-state i {
    color: #d1d5db;
}

/* ─── Pagination ─── */
#pagination-section .pagination .page-link {
    color: var(--aura-text);
    border: 1px solid #e5e7eb;
    padding: 0.5rem 0.9rem;
    font-size: 0.875rem;
    border-radius: 8px !important;
    margin: 0 2px;
    transition: all 0.2s;
    font-weight: 500;
}
#pagination-section .pagination .page-link:hover {
    background: var(--aura-primary);
    border-color: var(--aura-primary);
    color: #fff;
}
#pagination-section .pagination .page-item.active .page-link {
    background: var(--aura-primary);
    border-color: var(--aura-primary);
    color: #fff;
    box-shadow: 0 4px 12px rgba(26, 26, 46, 0.2);
}
#pagination-section .pagination .page-item.disabled .page-link {
    color: #d1d5db;
    border-color: #f0f0f0;
    background: transparent;
}

/* ─── Quick View Modal ─── */
.modal-quickview .modal-content {
    border: none;
    border-radius: 16px;
}
.quickview-image {
    width: 100%;
    height: 100%;
    min-height: 400px;
    object-fit: cover;
    border-radius: 16px 0 0 16px;
}
.quickview-thumb {
    width: 64px;
    height: 64px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s;
    opacity: 0.6;
}
.quickview-thumb.active,
.quickview-thumb:hover {
    border-color: var(--aura-accent);
    opacity: 1;
}

/* ─── Skeleton Loading ─── */
.skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s ease-in-out infinite;
    border-radius: 8px;
}
@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ─── Utility ─── */
.ls-1 { letter-spacing: 0.05em; }
.opacity-50 { opacity: 0.5; }
.transition-all { transition: all 0.3s ease; }
.pointer-events-none { pointer-events: none; }

/* ─── Responsive ─── */
@media (max-width: 991.98px) {
    .collection-header h1 {
        font-size: 1.75rem;
    }
}
@media (max-width: 767.98px) {
    .shop-product-card .product-img-front,
    .shop-product-card .product-img-hover {
        height: 200px;
    }
    .shop-product-card .product-card-actions {
        opacity: 1;
        transform: translateX(0);
    }
    .product-grid.list-view .shop-product-card {
        flex-direction: column;
    }
    .product-grid.list-view .shop-product-card .product-card-image {
        width: 100%;
    }
}
</style>
@endpush

@section('content')
<div class="collection-page py-4">
    <div class="container">
        <!-- ═══ Breadcrumb ═══ -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent p-0 mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="text-decoration-none text-muted small">Home</a>
                </li>
                <li class="breadcrumb-item active small" aria-current="page" style="color: var(--aura-primary);">Collection</li>
            </ol>
        </nav>

        <!-- ═══ Page Header ═══ -->
        <div class="collection-header mb-4 pb-2">
            <h1 class="display-5 fw-bold mb-1">The Collection</h1>
            <p class="text-muted mb-0">Discover our curated selection of premium sarees</p>
        </div>

        <!-- ═══ Mobile Filter Button ═══ -->
        <div class="d-lg-none mb-3">
            <button class="btn btn-outline-dark w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                <i class="fas fa-sliders-h"></i>
                <span class="fw-medium">Filters</span>
                @if(request()->anyFilled(['category', 'color', 'fabric', 'occasion', 'price_range', 'featured', 'new_arrival', 'best_selling']))
                    <span class="badge bg-dark rounded-pill ms-1">{{ collect(request()->only(['category', 'color', 'fabric', 'occasion', 'price_range', 'featured', 'new_arrival', 'best_selling']))->filter()->count() }}</span>
                @endif
            </button>
        </div>

        <div class="row">
            <!-- ═══ Filter Sidebar - Desktop ═══ -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="filter-sidebar pe-2">
                    <div class="bg-white rounded-3 border p-3">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <h6 class="fw-bold mb-0 small text-uppercase ls-1">
                                <i class="fas fa-filter me-1"></i> Filters
                            </h6>
                            <button type="button" class="btn btn-link btn-sm text-decoration-none text-muted p-0 clear-filters-btn">
                                Clear all
                            </button>
                        </div>
                        @include('products.partials.filters')
                    </div>
                </div>
            </div>

            <!-- ═══ Filter Offcanvas - Mobile ═══ -->
            <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="filterOffcanvas" aria-label="Filters">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title fw-bold">
                        <i class="fas fa-filter me-1"></i> Filters
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Refine your search</span>
                        <button type="button" class="btn btn-link btn-sm text-decoration-none text-muted p-0 clear-filters-btn">
                            Clear all
                        </button>
                    </div>
                    @include('products.partials.filters')
                </div>
            </div>

            <!-- ═══ Main Content ═══ -->
            <div class="col-lg-9">
                <!-- Toolbar -->
                @include('products.partials.toolbar')

                <!-- Product Grid Wrapper -->
                <div id="product-grid-wrapper">
                    <div id="product-grid" class="row product-grid g-3 @if(request('view') === 'list') list-view @endif">
                        @forelse($products as $product)
                            @php
                                $primaryImg = $product->images[0]->image_path ?? 'images/placeholder.jpg';
                                $hoverImg = $product->images[1]->image_path ?? null;
                            @endphp
                            <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                <div class="shop-product-card">
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

                                        <!-- Action Buttons -->
                                        <div class="product-card-actions position-absolute top-0 end-0 p-2 d-flex flex-column gap-1">
                                            @auth
                                                <button class="btn btn-light rounded-circle shadow-sm wishlist-btn @if($product->wishlists()->where('user_id', auth()->id())->exists()) active @endif"
                                                        data-product-id="{{ $product->id }}"
                                                        data-bs-toggle="tooltip"
                                                        title="@if($product->wishlists()->where('user_id', auth()->id())->exists()) Remove from Wishlist @else Add to Wishlist @endif"
                                                        aria-label="Toggle wishlist">
                                                    <i class="@if($product->wishlists()->where('user_id', auth()->id())->exists()) fas @else far @endif fa-heart"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-light rounded-circle shadow-sm wishlist-btn"
                                                        data-product-id="{{ $product->id }}"
                                                        data-bs-toggle="tooltip"
                                                        title="Add to Wishlist"
                                                        aria-label="Add to wishlist">
                                                    <i class="far fa-heart"></i>
                                                </button>
                                            @endif
                                            <button class="btn btn-light rounded-circle shadow-sm quick-view-btn"
                                                    data-product-id="{{ $product->id }}"
                                                    data-bs-toggle="tooltip"
                                                    title="Quick View"
                                                    aria-label="Quick view">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>

                                        <!-- Badges -->
                                        @if($product->discount_percentage)
                                            <span class="position-absolute top-0 start-0 badge bg-danger m-2 rounded-pill px-2 py-1 fw-medium">
                                                -{{ $product->discount_percentage }}%
                                            </span>
                                        @endif
                                        @if($product->is_new_arrival && !$product->discount_percentage)
                                            <span class="position-absolute top-0 start-0 badge m-2 rounded-pill px-2 py-1 fw-medium" style="background: var(--aura-primary);">
                                                New
                                            </span>
                                        @endif

                                        <!-- Stock Status -->
                                        @if(!$product->is_in_stock)
                                            <div class="position-absolute bottom-0 start-0 w-100 bg-dark bg-opacity-75 text-white text-center py-1 small fw-medium">
                                                Out of Stock
                                            </div>
                                        @elseif($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                                            <div class="position-absolute bottom-0 start-0 w-100 bg-warning bg-opacity-75 text-dark text-center py-1 small fw-medium">
                                                Only {{ $product->stock_quantity }} left
                                            </div>
                                        @endif
                                    </div>

                                    <div class="card-body d-flex flex-column p-3">
                                        @if($product->brand ?? false)
                                            <p class="small text-muted text-uppercase mb-1 ls-1 fw-medium" style="font-size: 0.7rem; letter-spacing: 0.08em;">
                                                {{ $product->brand->name ?? $product->brand }}
                                            </p>
                                        @endif

                                        <h6 class="product-name mb-1" style="font-size: 0.9rem;">
                                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}"
                                               class="text-decoration-none text-dark stretched-link">
                                                {{ $product->name }}
                                            </a>
                                        </h6>

                                        @if($product->rating ?? false)
                                            <div class="product-rating mb-1 d-flex align-items-center gap-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= round($product->rating) ? 'text-warning' : 'text-muted' }}" style="font-size: 0.65rem;"></i>
                                                @endfor
                                                <span class="small text-muted ms-1">({{ $product->reviews_count ?? $product->reviews->count() ?? 0 }})</span>
                                            </div>
                                        @endif

                                        <div class="product-price mt-auto pt-2 d-flex align-items-center gap-2">
                                            @if($product->discount_price)
                                                <span class="fw-bold" style="color: var(--aura-primary); font-size: 1.05rem;">₹{{ number_format($product->discounted_price, 0) }}</span>
                                                <span class="text-muted text-decoration-line-through small">₹{{ number_format($product->price, 0) }}</span>
                                            @else
                                                <span class="fw-bold" style="color: var(--aura-primary); font-size: 1.05rem;">₹{{ number_format($product->price, 0) }}</span>
                                            @endif
                                        </div>

                                        <!-- Color Variants Indicator -->
                                        @if($product->variants && $product->variants->count() > 0)
                                            <div class="mt-2 d-flex gap-1">
                                                @foreach($product->variants->take(4) as $variant)
                                                    @if($variant->color)
                                                        <span class="d-inline-block rounded-circle"
                                                              style="width: 14px; height: 14px; background: {{ $variant->color }}; border: 1px solid #e5e7eb;"></span>
                                                    @endif
                                                @endforeach
                                                @if($product->variants->count() > 4)
                                                    <span class="small text-muted">+{{ $product->variants->count() - 4 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="card-footer bg-white border-0 pt-0 px-3 pb-3">
                                        @if($product->is_in_stock)
                                            <button class="btn btn-dark btn-sm w-100 rounded-pill add-to-cart-btn d-flex align-items-center justify-content-center gap-1 py-2 quick-add-btn"
                                                    data-product-id="{{ $product->id }}"
                                                    data-product-name="{{ $product->name }}"
                                                    data-product-price="{{ $product->discounted_price }}"
                                                    data-product-image="{{ asset($primaryImg) }}">
                                                <i class="fas fa-shopping-bag"></i>
                                                <span>Add to Cart</span>
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2" disabled>
                                                <i class="fas fa-bell me-1"></i> Notify Me
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state text-center">
                                    <div class="mb-4">
                                        <i class="fas fa-search fa-4x"></i>
                                    </div>
                                    <h5 class="fw-semibold mb-2">No products found</h5>
                                    <p class="text-muted mb-3" style="max-width: 400px; margin: 0 auto;">
                                        We couldn't find any sarees matching your criteria. Try adjusting your filters or search terms.
                                    </p>
                                    <button class="btn btn-dark rounded-pill px-4 clear-filters-btn">
                                        <i class="fas fa-times me-2"></i> Clear All Filters
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                <div id="pagination-section" class="mt-4 pt-2">
                    @if($products->hasPages())
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div class="small text-muted">
                                Showing page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                            </div>
                            <div>
                                {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    @elseif($products->total() > 0)
                        <div class="text-center small text-muted">
                            Showing all {{ $products->total() }} {{ Str::plural('product', $products->total()) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══ Quick View Modal ═══ -->
<div class="modal fade modal-quickview" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header border-0 p-0 position-absolute top-0 end-0 z-3">
                <button type="button" class="btn btn-light btn-sm rounded-circle m-3 shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="width: 36px; height: 36px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-0" id="quickViewContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-dark" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted small mt-2 mb-0">Loading product details...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    'use strict';

    const $grid = $('#product-grid');
    const $wrapper = $('#product-grid-wrapper');
    const $pagination = $('#pagination-section');
    const $toolbarStats = $('#toolbar-stats');
    const $searchInput = $('#search-input');
    const $sortSelect = $('#sort-select');

    /* ─── Helpers ─── */

    function debounce(fn, delay) {
        let timer;
        return function(...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    function collectParams(page) {
        const params = new URLSearchParams();

        // Categories (use [] suffix for array params)
        $('input[name="categories[]"]:checked').each(function() {
            params.append('category[]', $(this).val());
        });
        // Colors
        $('input[name="colors[]"]:checked').each(function() {
            params.append('color[]', $(this).val());
        });
        // Fabrics
        $('input[name="fabrics[]"]:checked').each(function() {
            params.append('fabric[]', $(this).val());
        });
        // Occasions
        $('input[name="occasions[]"]:checked').each(function() {
            params.append('occasion[]', $(this).val());
        });

        // Price range
        const minPrice = $('#min-price').val();
        const maxPrice = $('#max-price').val();
        if (minPrice || maxPrice) {
            params.set('price_range', (minPrice || '0') + '-' + (maxPrice || '999999'));
        }

        // Special toggles
        if ($('#filter-featured').is(':checked')) params.set('featured', '1');
        if ($('#filter-new-arrival').is(':checked')) params.set('new_arrival', '1');
        if ($('#filter-best-selling').is(':checked')) params.set('best_selling', '1');

        // Sort
        const sortVal = $sortSelect.val();
        if (sortVal && sortVal !== 'newest') params.set('sort', sortVal);

        // Search
        const searchVal = $searchInput.val().trim();
        if (searchVal) params.set('search', searchVal);

        // View mode
        const viewMode = $('input[name="view-toggle"]:checked').val();
        if (viewMode === 'list') params.set('view', 'list');

        // Page
        if (page && page > 1) params.set('page', page);

        return params;
    }

    function loadProducts(page) {
        const params = collectParams(page);
        const queryString = params.toString();
        const url = window.location.pathname + (queryString ? '?' + queryString : '');

        $wrapper.addClass('opacity-50 pointer-events-none');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(html) {
                const $html = $(html);

                // Extract and replace grid
                const $newGrid = $html.find('#product-grid');
                if ($newGrid.length) {
                    const viewMode = $('input[name="view-toggle"]:checked').val();
                    if (viewMode === 'list') {
                        $newGrid.addClass('list-view');
                    }
                    $grid.replaceWith($newGrid);
                }

                // Extract and replace pagination
                const $newPagination = $html.find('#pagination-section');
                if ($newPagination.length) {
                    $pagination.html($newPagination.html());
                }

                // Extract and replace toolbar stats
                const $newToolbar = $html.find('#toolbar-stats');
                if ($newToolbar.length) {
                    $toolbarStats.html($newToolbar.html());
                }

                // Update browser URL
                if (queryString) {
                    window.history.pushState({ filters: queryString }, '', url);
                } else {
                    window.history.pushState({}, '', window.location.pathname);
                }

                // Re-init tooltips
                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    $('[data-bs-toggle="tooltip"]').each(function() {
                        try { new bootstrap.Tooltip(this); } catch(e) {}
                    });
                }
            },
            error: function() {
                console.error('Failed to load products.');
            },
            complete: function() {
                $wrapper.removeClass('opacity-50 pointer-events-none');
            }
        });
    }

    /* ─── Filter Change Events ─── */

    // Checkbox filters — auto-submit on change
    $(document).on('change', '.filter-checkbox', function() {
        loadProducts(1);
    });

    // Price apply button
    $(document).on('click', '.price-apply-btn', function(e) {
        e.preventDefault();
        loadProducts(1);
    });

    // Price inputs — submit on Enter
    $(document).on('keydown', '.price-input', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            loadProducts(1);
        }
    });

    // Sort change
    $sortSelect.on('change', function() {
        loadProducts(1);
    });

    // Search with debounce
    const debouncedSearch = debounce(function() {
        loadProducts(1);
    }, 500);
    $searchInput.on('input', debouncedSearch);

    // Clear search button
    $(document).on('click', '.clear-search-btn', function() {
        $searchInput.val('');
        loadProducts(1);
    });

    // Clear all filters
    $(document).on('click', '.clear-filters-btn', function(e) {
        e.preventDefault();
        // Uncheck all checkboxes
        $('#filter-form').find('input[type="checkbox"]').prop('checked', false);
        // Clear price inputs
        $('.price-input').val('');
        // Clear search
        $searchInput.val('');
        // Reset sort to default
        $sortSelect.val('newest');
        // Close mobile offcanvas
        const offcanvasEl = document.getElementById('filterOffcanvas');
        if (offcanvasEl) {
            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
            if (offcanvas) offcanvas.hide();
        }
        loadProducts(1);
    });

    // View toggle
    $(document).on('change', 'input[name="view-toggle"]', function() {
        const isList = $(this).val() === 'list' && $(this).is(':checked');
        $grid.toggleClass('list-view', isList);
        // Persist view preference via URL
        const params = collectParams(1);
        const queryString = params.toString();
        const url = window.location.pathname + (queryString ? '?' + queryString : '');
        window.history.replaceState({}, '', url);
    });

    // Pagination links — delegated
    $(document).on('click', '#pagination-section .page-link', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        if (!href) return;
        const urlParams = new URL(href, window.location.origin);
        const page = urlParams.searchParams.get('page') || 1;
        loadProducts(parseInt(page));
    });

    /* ─── Quick View ─── */

    $(document).on('click', '.quick-view-btn', function(e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        const $modal = $('#quickViewModal');
        const $content = $('#quickViewContent');

        $content.html(`
            <div class="text-center py-5">
                <div class="spinner-border text-dark" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted small mt-2 mb-0">Loading product details...</p>
            </div>
        `);

        $modal.modal('show');

        $.ajax({
            url: '/products/' + productId + '/quick-view',
            type: 'GET',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(res) {
                if (!res.success) {
                    $content.html('<div class="text-center py-5 text-muted"><p>Failed to load product.</p></div>');
                    return;
                }
                const p = res.product;
                const imageUrl = res.imageUrl || 'https://placehold.co/600x800?text=No+Image';
                const price = res.discountedPrice || p.price;
                const originalPrice = p.discount_price ? p.price : null;
                const inStock = res.isInStock;

                $content.html(`
                    <div class="row g-0">
                        <div class="col-md-6">
                            <div class="position-relative h-100">
                                <img src="${imageUrl}" alt="${p.name}" class="quickview-image w-100">
                                ${res.discountPercentage ? `<span class="position-absolute top-0 start-0 badge bg-danger m-3 rounded-pill px-2 py-1">-${res.discountPercentage}%</span>` : ''}
                            </div>
                        </div>
                        <div class="col-md-6 d-flex flex-column">
                            <div class="p-4 d-flex flex-column h-100">
                                ${p.brand ? `<p class="small text-muted text-uppercase ls-1 fw-medium mb-2">${p.brand.name || p.brand}</p>` : ''}
                                <h4 class="fw-bold mb-2">${p.name}</h4>

                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="fs-4 fw-bold" style="color: var(--aura-primary);">₹${Number(price).toLocaleString('en-IN')}</span>
                                    ${originalPrice ? `<span class="text-muted text-decoration-line-through">₹${Number(originalPrice).toLocaleString('en-IN')}</span>` : ''}
                                </div>

                                ${p.description ? `<p class="text-muted small mb-3">${p.description.substring(0, 200)}${p.description.length > 200 ? '...' : ''}</p>` : ''}

                                ${p.short_description ? `<p class="text-muted small mb-3">${p.short_description}</p>` : ''}

                                <div class="mb-3">
                                    <span class="small text-muted d-block mb-1">Availability:</span>
                                    ${inStock
                                        ? `<span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1"><i class="fas fa-check-circle me-1"></i> In Stock</span>`
                                        : `<span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1"><i class="fas fa-times-circle me-1"></i> Out of Stock</span>`
                                    }
                                </div>

                                <div class="mt-auto pt-3 border-top">
                                    <div class="d-flex gap-2">
                                        ${inStock
                                            ? `<button class="btn btn-dark flex-grow-1 rounded-pill py-2 add-to-cart-btn"
                                                   data-product-id="${p.id}"
                                                   data-product-name="${p.name}"
                                                   data-product-price="${price}"
                                                   data-product-image="${imageUrl}">
                                                   <i class="fas fa-shopping-bag me-1"></i> Add to Cart
                                               </button>`
                                            : `<button class="btn btn-outline-secondary flex-grow-1 rounded-pill py-2" disabled>
                                                   <i class="fas fa-bell me-1"></i> Notify Me
                                               </button>`
                                        }
                                        <button class="btn btn-outline-dark rounded-pill py-2 wishlist-btn" data-product-id="${p.id}">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            },
            error: function() {
                $content.html('<div class="text-center py-5 text-muted"><i class="fas fa-exclamation-circle fa-2x mb-2"></i><p>Failed to load product details. Please try again.</p></div>');
            }
        });
    });

    // Clean up tooltips when modal hides
    $('#quickViewModal').on('hidden.bs.modal', function() {
        $(this).find('[data-bs-toggle="tooltip"]').each(function() {
            const tooltip = bootstrap.Tooltip.getInstance(this);
            if (tooltip) tooltip.dispose();
        });
    });

    /* ─── Add to Cart ─── */

    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const productName = $btn.data('product-name');
        const productPrice = $btn.data('product-price');
        const productImage = $btn.data('product-image');

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status"></span> Adding...');

        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                product_id: productId,
                quantity: 1,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(res) {
                if (res.success) {
                    $btn.html('<i class="fas fa-check me-1"></i> Added!').removeClass('btn-dark').addClass('btn-success');
                    setTimeout(function() {
                        $btn.html('<i class="fas fa-shopping-bag me-1"></i> Add to Cart').removeClass('btn-success').addClass('btn-dark').prop('disabled', false);
                    }, 2000);

                    // Update cart count in navbar
                    if (res.cartCount !== undefined) {
                        $('.cart-count').text(res.cartCount).removeClass('d-none');
                    }

                    // Toast notification
                    showToast('success', 'Added to Cart', productName + ' has been added to your cart.');
                } else {
                    $btn.html('<i class="fas fa-shopping-bag me-1"></i> Add to Cart').prop('disabled', false);
                    showToast('danger', 'Error', res.message || 'Could not add to cart.');
                }
            },
            error: function(xhr) {
                $btn.html('<i class="fas fa-shopping-bag me-1"></i> Add to Cart').prop('disabled', false);
                if (xhr.status === 401) {
                    showToast('warning', 'Login Required', 'Please log in to add items to your cart.');
                } else {
                    showToast('danger', 'Error', 'Something went wrong. Please try again.');
                }
            }
        });
    });

    /* ─── Wishlist Toggle ─── */

    $(document).on('click', '.wishlist-btn', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const wasActive = $btn.hasClass('active');

        $btn.prop('disabled', true);

        $.ajax({
            url: wasActive ? '/wishlist/remove' : '/wishlist/toggle',
            type: 'POST',
            data: {
                product_id: productId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(res) {
                if (res.success) {
                    $btn.toggleClass('active', !wasActive);
                    $btn.find('i').toggleClass('far fas');
                    const label = wasActive ? 'Add to Wishlist' : 'Remove from Wishlist';
                    $btn.attr('title', label).attr('aria-label', label);
                    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                        const tooltip = bootstrap.Tooltip.getInstance($btn[0]);
                        if (tooltip) tooltip.dispose();
                        new bootstrap.Tooltip($btn[0]);
                    }
                    showToast('success', wasActive ? 'Removed' : 'Added', wasActive
                        ? 'Product removed from your wishlist.'
                        : 'Product added to your wishlist!');
                } else {
                    showToast('danger', 'Error', res.message || 'Could not update wishlist.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    showToast('warning', 'Login Required', 'Please log in to manage your wishlist.');
                } else {
                    showToast('danger', 'Error', 'Something went wrong.');
                }
            },
            complete: function() {
                $btn.prop('disabled', false);
            }
        });
    });

    /* ─── Toast Notification ─── */

    function showToast(type, title, message) {
        const toastId = 'toast-' + Date.now();
        const bgClass = type === 'success' ? 'bg-success' : type === 'danger' ? 'bg-danger' : type === 'warning' ? 'bg-warning text-dark' : 'bg-dark';
        const icon = type === 'success' ? 'fa-check-circle' : type === 'danger' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';

        const html = `
            <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1080;">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="fas ${icon}"></i>
                        <div>
                            <strong class="d-block small">${title}</strong>
                            <span class="small">${message}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

        const $container = $('.toast-container');
        if (!$container.length) {
            $('body').append('<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;"></div>');
        }
        $('.toast-container').append(html);

        const toastEl = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();

        toastEl.addEventListener('hidden.bs.toast', function() {
            $(this).remove();
        });
    }

    /* ─── Initialisation ─── */

    // Bootstrap tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        $('[data-bs-toggle="tooltip"]').each(function() {
            try { new bootstrap.Tooltip(this); } catch(e) {}
        });
    }

    // Handle browser back/forward
    window.addEventListener('popstate', function() {
        location.reload();
    });
});
</script>
@endpush
