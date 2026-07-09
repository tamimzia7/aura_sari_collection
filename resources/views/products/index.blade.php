@extends('layouts.app')

@section('title', isset($collection) ? $collection->name . ' - AURA' : 'The Canvas - AURA')

@push('styles')
<style>
:root {
    --aura-bg: #0a0a1a;
    --aura-surface: #111128;
    --aura-card: #151530;
    --aura-border: #1e1e3a;
    --aura-gold: #d4af37;
    --aura-gold-dim: #b8962e;
    --aura-gold-glow: rgba(212, 175, 55, 0.15);
    --aura-text: #e8e8f0;
    --aura-text-muted: #8888a0;
    --aura-input-bg: #1a1a35;
}

body {
    background: var(--aura-bg);
    color: var(--aura-text);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* ─── Hero Banner ─── */
.collection-hero {
    position: relative;
    background: linear-gradient(135deg, #0a0a1a 0%, #151530 50%, #0a0a1a 100%);
    padding: 5rem 0 4rem;
    overflow: hidden;
    border-bottom: 1px solid var(--aura-border);
}
.collection-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(212, 175, 55, 0.04) 0%, transparent 70%);
    pointer-events: none;
}
.collection-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(212, 175, 55, 0.03) 0%, transparent 70%);
    pointer-events: none;
}
.collection-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 3.2rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.15;
    position: relative;
}
.collection-hero h1 span.gold {
    color: var(--aura-gold);
}
.collection-hero .gold-line {
    width: 60px;
    height: 3px;
    background: var(--aura-gold);
    margin-top: 1rem;
}
.collection-hero p {
    color: var(--aura-text-muted);
    font-size: 1.05rem;
    max-width: 500px;
    margin-top: 0.75rem;
}
.collection-hero .hero-stats {
    margin-top: 1.5rem;
    display: flex;
    gap: 2rem;
}
.collection-hero .hero-stats .stat {
    text-align: center;
}
.collection-hero .hero-stats .stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--aura-gold);
    font-family: 'Playfair Display', serif;
}
.collection-hero .hero-stats .stat-label {
    font-size: 0.75rem;
    color: var(--aura-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-top: 0.15rem;
}

/* ─── Breadcrumb ─── */
.aura-breadcrumb {
    padding: 0.75rem 0;
    background: var(--aura-bg);
    border-bottom: 1px solid var(--aura-border);
}
.aura-breadcrumb .breadcrumb {
    margin: 0;
    background: transparent;
}
.aura-breadcrumb .breadcrumb-item {
    font-size: 0.8rem;
}
.aura-breadcrumb .breadcrumb-item a {
    color: var(--aura-text-muted);
    text-decoration: none;
    transition: color 0.2s;
}
.aura-breadcrumb .breadcrumb-item a:hover {
    color: var(--aura-gold);
}
.aura-breadcrumb .breadcrumb-item.active {
    color: var(--aura-text);
}
.aura-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: '›';
    color: var(--aura-text-muted);
}

/* ─── Filter Sidebar ─── */
.filter-sidebar {
    position: sticky;
    top: 100px;
    max-height: calc(100vh - 120px);
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--aura-border) transparent;
}
.filter-sidebar::-webkit-scrollbar {
    width: 4px;
}
.filter-sidebar::-webkit-scrollbar-thumb {
    background: var(--aura-border);
    border-radius: 10px;
}
.filter-sidebar .filter-card {
    background: var(--aura-surface);
    border: 1px solid var(--aura-border);
    border-radius: 12px;
}
.filter-sidebar .filter-card .filter-header {
    border-bottom: 1px solid var(--aura-border);
    padding: 1rem 1.25rem;
}
.filter-sidebar .filter-card .filter-header h6 {
    color: var(--aura-text);
    font-size: 0.7rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
}
.filter-sidebar .filter-card .filter-header .clear-filters-btn {
    color: var(--aura-text-muted);
    font-size: 0.75rem;
    text-decoration: none;
    transition: color 0.2s;
}
.filter-sidebar .filter-card .filter-header .clear-filters-btn:hover {
    color: var(--aura-gold);
}

/* ─── Filter Section ─── */
.filter-section + .filter-section {
    padding-top: 1rem;
    border-top: 1px solid var(--aura-border);
}
.filter-section .filter-title {
    cursor: pointer;
    user-select: none;
    font-size: 0.72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--aura-text);
}
.filter-section .filter-title .filter-toggle {
    color: var(--aura-text-muted);
    transition: transform 0.3s;
}
.filter-section .filter-title .filter-toggle.collapsed i {
    transform: rotate(-90deg);
}
.filter-section .filter-title .filter-toggle i {
    transition: transform 0.3s;
    font-size: 0.65rem;
}

.form-check-input {
    background-color: var(--aura-input-bg);
    border-color: var(--aura-border);
}
.form-check-input:checked {
    background-color: var(--aura-gold);
    border-color: var(--aura-gold);
}
.form-check-input:focus {
    box-shadow: 0 0 0 0.2rem var(--aura-gold-glow);
    border-color: var(--aura-gold);
}
.form-check-label {
    color: var(--aura-text);
    font-size: 0.85rem;
}

.price-input {
    background: var(--aura-input-bg) !important;
    border: 1px solid var(--aura-border) !important;
    color: var(--aura-text) !important;
    font-size: 0.8rem !important;
}
.price-input:focus {
    border-color: var(--aura-gold) !important;
    box-shadow: 0 0 0 0.2rem var(--aura-gold-glow) !important;
}
.price-input::placeholder {
    color: var(--aura-text-muted);
}
.input-group-text {
    background: var(--aura-input-bg);
    border: 1px solid var(--aura-border);
    color: var(--aura-text-muted);
    font-size: 0.8rem;
}
.btn-outline-gold {
    color: var(--aura-gold);
    border: 1px solid var(--aura-gold);
    background: transparent;
    transition: all 0.3s;
    font-size: 0.8rem;
}
.btn-outline-gold:hover {
    background: var(--aura-gold);
    color: #0a0a1a;
    border-color: var(--aura-gold);
}
.btn-aura {
    background: var(--aura-gold);
    color: #0a0a1a;
    border: none;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-aura:hover {
    background: var(--aura-gold-dim);
    color: #0a0a1a;
    box-shadow: 0 4px 15px var(--aura-gold-glow);
}
.btn-aura-outline {
    background: transparent;
    color: var(--aura-text);
    border: 1px solid var(--aura-border);
    transition: all 0.3s;
}
.btn-aura-outline:hover {
    border-color: var(--aura-gold);
    color: var(--aura-gold);
    background: var(--aura-gold-glow);
}

/* ─── Offcanvas ─── */
.offcanvas {
    background: var(--aura-surface);
    color: var(--aura-text);
}
.offcanvas .offcanvas-header {
    border-bottom-color: var(--aura-border);
}
.offcanvas .btn-close {
    filter: invert(0.8);
}

/* ─── Toolbar ─── */
.aura-toolbar {
    background: var(--aura-surface);
    border: 1px solid var(--aura-border);
    border-radius: 12px;
    padding: 0.75rem 1.25rem;
}
.aura-toolbar .toolbar-text {
    color: var(--aura-text-muted);
    font-size: 0.85rem;
}
.aura-toolbar .toolbar-text strong {
    color: var(--aura-text);
}
.aura-select {
    background: var(--aura-input-bg) !important;
    border: 1px solid var(--aura-border) !important;
    color: var(--aura-text) !important;
    font-size: 0.8rem !important;
    border-radius: 50px !important;
    padding: 0.35rem 1rem !important;
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%238888a0' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 0.75rem center !important;
    background-size: 12px !important;
    appearance: none !important;
}
.aura-select:focus {
    border-color: var(--aura-gold) !important;
    box-shadow: 0 0 0 0.2rem var(--aura-gold-glow) !important;
}
.aura-search-input {
    background: var(--aura-input-bg) !important;
    border: 1px solid var(--aura-border) !important;
    color: var(--aura-text) !important;
    font-size: 0.8rem !important;
    border-radius: 50px !important;
    padding: 0.35rem 1rem 0.35rem 2.5rem !important;
}
.aura-search-input:focus {
    border-color: var(--aura-gold) !important;
    box-shadow: 0 0 0 0.2rem var(--aura-gold-glow) !important;
}
.aura-search-input::placeholder {
    color: var(--aura-text-muted);
}
.aura-search-icon {
    color: var(--aura-text-muted);
    font-size: 0.75rem;
}
.filter-active-badge {
    background: var(--aura-gold) !important;
    color: #0a0a1a !important;
    font-size: 0.7rem;
}

/* ─── Product Grid ─── */
.product-grid {
    --bs-gutter-y: 1.5rem;
}

/* ─── Product Card ─── */
.aura-product-card {
    background: var(--aura-card);
    border: 1px solid var(--aura-border);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    height: 100%;
    position: relative;
}
.aura-product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    border-color: rgba(212, 175, 55, 0.2);
}
.aura-product-card .product-card-image {
    overflow: hidden;
    position: relative;
    background: var(--aura-bg);
    aspect-ratio: 3/4;
}
.aura-product-card .product-img-front,
.aura-product-card .product-img-hover {
    transition: transform 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.aura-product-card:hover .product-img-front,
.aura-product-card:hover .product-img-hover {
    transform: scale(1.08);
}
.aura-product-card .product-card-actions {
    opacity: 0;
    transform: translateX(8px);
    transition: all 0.3s ease;
    z-index: 2;
}
.aura-product-card:hover .product-card-actions {
    opacity: 1;
    transform: translateX(0);
}
.aura-product-card .action-btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    background: rgba(21, 21, 48, 0.9);
    backdrop-filter: blur(4px);
    border: 1px solid var(--aura-border);
    color: var(--aura-text);
    border-radius: 50%;
    transition: all 0.2s;
}
.aura-product-card .action-btn:hover {
    background: var(--aura-gold);
    color: #0a0a1a;
    border-color: var(--aura-gold);
}
.aura-product-card .action-btn.active {
    background: #dc2626;
    color: #fff;
    border-color: #dc2626;
}
.aura-product-card .action-btn.active i {
    animation: heartPop 0.3s ease;
}
@keyframes heartPop {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}
.aura-product-card .product-badge {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    z-index: 3;
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 0.25rem 0.65rem;
    border-radius: 50px;
}
.aura-product-card .product-badge.discount {
    background: #dc2626;
    color: #fff;
}
.aura-product-card .product-badge.new {
    background: var(--aura-gold);
    color: #0a0a1a;
}
.aura-product-card .stock-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    text-align: center;
    padding: 0.4rem;
    font-size: 0.72rem;
    font-weight: 500;
    z-index: 3;
}
.aura-product-card .stock-overlay.out-of-stock {
    background: rgba(0, 0, 0, 0.8);
    color: #ef4444;
}
.aura-product-card .stock-overlay.low-stock {
    background: rgba(212, 175, 55, 0.2);
    color: var(--aura-gold);
}

/* ─── Product Card Body ─── */
.aura-product-card .card-body {
    padding: 1rem 1.1rem;
}
.aura-product-card .product-brand {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--aura-text-muted);
    margin-bottom: 0.25rem;
}
.aura-product-card .product-name {
    font-size: 0.88rem;
    font-weight: 600;
    margin-bottom: 0.35rem;
    line-height: 1.3;
}
.aura-product-card .product-name a {
    color: var(--aura-text);
    text-decoration: none;
    transition: color 0.2s;
}
.aura-product-card .product-name a:hover {
    color: var(--aura-gold);
}
.aura-product-card .product-rating {
    display: flex;
    align-items: center;
    gap: 0.15rem;
    margin-bottom: 0.4rem;
}
.aura-product-card .product-rating i {
    font-size: 0.65rem;
}
.aura-product-card .product-rating .star-filled {
    color: var(--aura-gold);
}
.aura-product-card .product-rating .star-empty {
    color: var(--aura-border);
}
.aura-product-card .product-rating .rating-count {
    color: var(--aura-text-muted);
    font-size: 0.7rem;
    margin-left: 0.25rem;
}
.aura-product-card .product-category {
    font-size: 0.72rem;
    color: var(--aura-text-muted);
    margin-bottom: 0.5rem;
}
.aura-product-card .product-price {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.aura-product-card .product-price .current-price {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--aura-gold);
}
.aura-product-card .product-price .original-price {
    font-size: 0.8rem;
    color: var(--aura-text-muted);
    text-decoration: line-through;
}
.aura-product-card .card-footer {
    background: transparent;
    border-top: 1px solid var(--aura-border);
    padding: 0.75rem 1.1rem;
}
.aura-product-card .add-to-cart-btn {
    width: 100%;
    padding: 0.5rem;
    font-size: 0.78rem;
    font-weight: 600;
    border-radius: 50px;
    border: 1px solid var(--aura-gold);
    background: transparent;
    color: var(--aura-gold);
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    cursor: pointer;
}
.aura-product-card .add-to-cart-btn:hover {
    background: var(--aura-gold);
    color: #0a0a1a;
    box-shadow: 0 4px 15px var(--aura-gold-glow);
}
.aura-product-card .add-to-cart-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* ─── Pagination ─── */
.aura-pagination .pagination {
    gap: 0.25rem;
}
.aura-pagination .page-link {
    background: var(--aura-surface);
    border: 1px solid var(--aura-border);
    color: var(--aura-text);
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
    border-radius: 8px !important;
    transition: all 0.2s;
    font-weight: 500;
}
.aura-pagination .page-link:hover {
    background: var(--aura-gold);
    border-color: var(--aura-gold);
    color: #0a0a1a;
}
.aura-pagination .page-item.active .page-link {
    background: var(--aura-gold);
    border-color: var(--aura-gold);
    color: #0a0a1a;
    box-shadow: 0 4px 12px var(--aura-gold-glow);
}
.aura-pagination .page-item.disabled .page-link {
    background: var(--aura-surface);
    border-color: var(--aura-border);
    color: var(--aura-text-muted);
    opacity: 0.5;
}

/* ─── Empty State ─── */
.empty-state {
    padding: 4rem 1rem;
    text-align: center;
}
.empty-state i {
    color: var(--aura-border);
    font-size: 3rem;
}
.empty-state h5 {
    color: var(--aura-text);
    margin-top: 1rem;
}
.empty-state p {
    color: var(--aura-text-muted);
    max-width: 400px;
    margin: 0.5rem auto 1.5rem;
}

/* ─── Skeleton ─── */
.skeleton {
    background: linear-gradient(90deg, var(--aura-card) 25%, var(--aura-surface) 50%, var(--aura-card) 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s ease-in-out infinite;
    border-radius: 8px;
}
@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ─── Quick View Modal ─── */
.modal-quickview .modal-content {
    background: var(--aura-surface);
    border: 1px solid var(--aura-border);
    border-radius: 16px;
    color: var(--aura-text);
}
.modal-quickview .modal-header {
    border: none;
}
.modal-quickview .btn-close-custom {
    background: var(--aura-card);
    border: 1px solid var(--aura-border);
    color: var(--aura-text);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}
.modal-quickview .btn-close-custom:hover {
    background: var(--aura-gold);
    color: #0a0a1a;
}
.quickview-image {
    width: 100%;
    height: 100%;
    min-height: 400px;
    object-fit: cover;
    border-radius: 16px 0 0 16px;
}

/* ─── View Toggle ─── */
.view-toggle-group {
    display: flex;
    border: 1px solid var(--aura-border);
    border-radius: 50px;
    overflow: hidden;
}
.view-toggle-group .btn-view {
    padding: 0.3rem 0.6rem;
    font-size: 0.75rem;
    background: transparent;
    border: none;
    color: var(--aura-text-muted);
    cursor: pointer;
    transition: all 0.2s;
}
.view-toggle-group .btn-view.active {
    background: var(--aura-gold);
    color: #0a0a1a;
}
.view-toggle-group .btn-view:not(.active):hover {
    color: var(--aura-gold);
}

/* ─── Responsive ─── */
@media (max-width: 991.98px) {
    .collection-hero {
        padding: 3.5rem 0 2.5rem;
    }
    .collection-hero h1 {
        font-size: 2.2rem;
    }
    .filter-sidebar {
        position: static;
        max-height: none;
    }
}
@media (max-width: 767.98px) {
    .collection-hero {
        padding: 2.5rem 0 2rem;
    }
    .collection-hero h1 {
        font-size: 1.8rem;
    }
    .collection-hero .hero-stats {
        gap: 1rem;
    }
    .collection-hero .hero-stats .stat-value {
        font-size: 1.2rem;
    }
    .aura-product-card .product-img-front,
    .aura-product-card .product-img-hover {
        height: auto;
    }
    .aura-product-card .product-card-actions {
        opacity: 1;
        transform: translateX(0);
    }
    .product-grid.list-view .aura-product-card {
        flex-direction: column;
    }
    .product-grid.list-view .aura-product-card .product-card-image {
        width: 100%;
    }
}

/* ─── Utility ─── */
.ls-1 { letter-spacing: 0.05em; }
.opacity-50 { opacity: 0.5; }
.transition-all { transition: all 0.3s ease; }
.pointer-events-none { pointer-events: none; }
.text-gold { color: var(--aura-gold); }
</style>
@endpush

@section('content')
<div class="collection-page">
    <!-- ═══ Breadcrumb ═══ -->
    <div class="aura-breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    @if(isset($collection))
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">The Canvas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $collection->name }}</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">The Canvas</li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>

    <!-- ═══ Hero Banner ═══ -->
    <div class="collection-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    @if(isset($collection))
                        <h1>{{ $collection->name }}</h1>
                        @if($collection->description)
                            <p>{{ $collection->description }}</p>
                        @endif
                    @else
                        <h1>The <span class="gold">Canvas</span></h1>
                        <p>Discover our curated selection of premium sarees, where tradition meets contemporary elegance.</p>
                    @endif
                    <div class="gold-line"></div>
                    <div class="hero-stats">
                        <div class="stat">
                            <div class="stat-value">{{ $products->total() }}</div>
                            <div class="stat-label">Products</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value">{{ $categories->count() }}</div>
                            <div class="stat-label">Categories</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <!-- ═══ Mobile Filter Button ═══ -->
        <div class="d-lg-none mb-3">
            <button class="btn btn-aura-outline w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                <i class="fas fa-sliders-h"></i>
                <span class="fw-medium">Filters</span>
                @if(request()->anyFilled(['category', 'color', 'fabric', 'occasion', 'price_range', 'featured', 'new_arrival', 'best_selling']))
                    <span class="badge rounded-pill ms-1" style="background: var(--aura-gold); color: #0a0a1a;">{{ collect(request()->only(['category', 'color', 'fabric', 'occasion', 'price_range', 'featured', 'new_arrival', 'best_selling']))->filter()->count() }}</span>
                @endif
            </button>
        </div>

        <div class="row">
            <!-- ═══ Filter Sidebar - Desktop ═══ -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="filter-sidebar pe-2">
                    <div class="filter-card">
                        <div class="filter-header d-flex align-items-center justify-content-between">
                            <h6 class="fw-bold mb-0"><i class="fas fa-filter me-1"></i> Filters</h6>
                            <button type="button" class="clear-filters-btn btn btn-link btn-sm p-0">Clear all</button>
                        </div>
                        <div class="p-3">
                            @include('products.partials.filters')
                        </div>
                    </div>
                </div>
            </div>

            <!-- ═══ Filter Offcanvas - Mobile ═══ -->
            <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="filterOffcanvas" aria-label="Filters">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title fw-bold"><i class="fas fa-filter me-1"></i> Filters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Refine your search</span>
                        <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 clear-filters-btn" style="color: var(--aura-gold);">Clear all</button>
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

                                        <!-- Action Buttons -->
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

                                        <!-- Badges -->
                                        @if($product->discount_percentage)
                                            <span class="product-badge discount">
                                                -{{ $product->discount_percentage }}%
                                            </span>
                                        @elseif($product->is_new_arrival)
                                            <span class="product-badge new">New</span>
                                        @endif

                                        <!-- Stock Status -->
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
            </div>
        </div>
    </div>
</div>

<!-- ═══ Quick View Modal ═══ -->
<div class="modal fade modal-quickview" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 p-0 position-absolute top-0 end-0 z-3">
                <button type="button" class="btn-close-custom m-3 shadow-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-0" id="quickViewContent">
                <div class="text-center py-5">
                    <div class="spinner-border" role="status" style="color: var(--aura-gold);">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 mb-0" style="color: var(--aura-text-muted); font-size: 0.85rem;">Loading product details...</p>
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

        $('input[name="categories[]"]:checked').each(function() {
            params.append('category[]', $(this).val());
        });
        $('input[name="colors[]"]:checked').each(function() {
            params.append('color[]', $(this).val());
        });
        $('input[name="fabrics[]"]:checked').each(function() {
            params.append('fabric[]', $(this).val());
        });
        $('input[name="occasions[]"]:checked').each(function() {
            params.append('occasion[]', $(this).val());
        });

        const minPrice = $('#min-price').val();
        const maxPrice = $('#max-price').val();
        if (minPrice || maxPrice) {
            params.set('price_range', (minPrice || '0') + '-' + (maxPrice || '999999'));
        }

        if ($('#filter-featured').is(':checked')) params.set('featured', '1');
        if ($('#filter-new-arrival').is(':checked')) params.set('new_arrival', '1');
        if ($('#filter-best-selling').is(':checked')) params.set('best_selling', '1');

        const sortVal = $sortSelect.val();
        if (sortVal && sortVal !== 'newest') params.set('sort', sortVal);

        const searchVal = $searchInput.val().trim();
        if (searchVal) params.set('search', searchVal);

        const viewMode = $('input[name="view-toggle"]:checked').val();
        if (viewMode === 'list') params.set('view', 'list');

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

                const $newGrid = $html.find('#product-grid');
                if ($newGrid.length) {
                    const viewMode = $('input[name="view-toggle"]:checked').val();
                    if (viewMode === 'list') {
                        $newGrid.addClass('list-view');
                    }
                    $grid.replaceWith($newGrid);
                }

                const $newPagination = $html.find('#pagination-section');
                if ($newPagination.length) {
                    $pagination.html($newPagination.html());
                }

                const $newToolbar = $html.find('#toolbar-stats');
                if ($newToolbar.length) {
                    $toolbarStats.html($newToolbar.html());
                }

                if (queryString) {
                    window.history.pushState({ filters: queryString }, '', url);
                } else {
                    window.history.pushState({}, '', window.location.pathname);
                }

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

    $(document).on('change', '.filter-checkbox', function() {
        loadProducts(1);
    });

    $(document).on('click', '.price-apply-btn', function(e) {
        e.preventDefault();
        loadProducts(1);
    });

    $(document).on('keydown', '.price-input', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            loadProducts(1);
        }
    });

    $sortSelect.on('change', function() {
        loadProducts(1);
    });

    const debouncedSearch = debounce(function() {
        loadProducts(1);
    }, 500);
    $searchInput.on('input', debouncedSearch);

    $(document).on('click', '.clear-search-btn', function() {
        $searchInput.val('');
        loadProducts(1);
    });

    $(document).on('click', '.clear-filters-btn', function(e) {
        e.preventDefault();
        $('#filter-form').find('input[type="checkbox"]').prop('checked', false);
        $('.price-input').val('');
        $searchInput.val('');
        $sortSelect.val('newest');
        const offcanvasEl = document.getElementById('filterOffcanvas');
        if (offcanvasEl) {
            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
            if (offcanvas) offcanvas.hide();
        }
        loadProducts(1);
    });

    $(document).on('change', 'input[name="view-toggle"]', function() {
        const isList = $(this).val() === 'list' && $(this).is(':checked');
        $grid.toggleClass('list-view', isList);
        const params = collectParams(1);
        const queryString = params.toString();
        const url = window.location.pathname + (queryString ? '?' + queryString : '');
        window.history.replaceState({}, '', url);
    });

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
                <div class="spinner-border" role="status" style="color: var(--aura-gold);">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 mb-0" style="color: var(--aura-text-muted); font-size: 0.85rem;">Loading product details...</p>
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
                    $content.html('<div class="text-center py-5" style="color: var(--aura-text-muted);"><p>Failed to load product.</p></div>');
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
                                <img src="${imageUrl}" alt="${p.name}" class="quickview-image w-100" style="border-radius: 16px 0 0 16px;">
                                ${res.discountPercentage ? `<span class="product-badge discount" style="top: 1rem; left: 1rem;">-${res.discountPercentage}%</span>` : ''}
                            </div>
                        </div>
                        <div class="col-md-6 d-flex flex-column">
                            <div class="p-4 d-flex flex-column h-100">
                                ${p.brand ? `<p class="product-brand" style="font-size: 0.7rem;">${p.brand.name || p.brand}</p>` : ''}
                                <h4 class="fw-bold mb-2" style="color: #fff; font-family: 'Playfair Display', serif;">${p.name}</h4>

                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="fs-4 fw-bold text-gold">₹${Number(price).toLocaleString('en-IN')}</span>
                                    ${originalPrice ? `<span class="text-muted text-decoration-line-through" style="color: var(--aura-text-muted) !important;">₹${Number(originalPrice).toLocaleString('en-IN')}</span>` : ''}
                                </div>

                                ${p.description ? `<p class="mb-3" style="color: var(--aura-text-muted); font-size: 0.85rem;">${p.description.substring(0, 200)}${p.description.length > 200 ? '...' : ''}</p>` : ''}
                                ${p.short_description ? `<p class="mb-3" style="color: var(--aura-text-muted); font-size: 0.85rem;">${p.short_description}</p>` : ''}

                                <div class="mb-3">
                                    <span class="d-block mb-1" style="color: var(--aura-text-muted); font-size: 0.8rem;">Availability:</span>
                                    ${inStock
                                        ? `<span class="badge rounded-pill px-3 py-1" style="background: rgba(212, 175, 55, 0.15); color: var(--aura-gold); font-size: 0.75rem;"><i class="fas fa-check-circle me-1"></i> In Stock</span>`
                                        : `<span class="badge rounded-pill px-3 py-1" style="background: rgba(220, 38, 38, 0.15); color: #ef4444; font-size: 0.75rem;"><i class="fas fa-times-circle me-1"></i> Out of Stock</span>`
                                    }
                                </div>

                                <div class="mt-auto pt-3 border-top" style="border-color: var(--aura-border) !important;">
                                    <div class="d-flex gap-2">
                                        ${inStock
                                            ? `<button class="btn flex-grow-1 rounded-pill py-2 add-to-cart-btn"
                                                   data-product-id="${p.id}"
                                                   data-product-name="${p.name}"
                                                   data-product-price="${price}"
                                                   data-product-image="${imageUrl}"
                                                   style="background: var(--aura-gold); color: #0a0a1a; font-weight: 600; border: none;">
                                                   <i class="fas fa-shopping-bag me-1"></i> Add to Cart
                                               </button>`
                                            : `<button class="btn flex-grow-1 rounded-pill py-2" style="background: transparent; border: 1px solid var(--aura-border); color: var(--aura-text-muted);" disabled>
                                                   <i class="fas fa-bell me-1"></i> Notify Me
                                               </button>`
                                        }
                                        <button class="btn rounded-pill py-2 wishlist-btn" data-product-id="${p.id}"
                                                style="background: transparent; border: 1px solid var(--aura-border); color: var(--aura-text);">
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
                $content.html('<div class="text-center py-5" style="color: var(--aura-text-muted);"><i class="fas fa-exclamation-circle fa-2x mb-2"></i><p>Failed to load product details.</p></div>');
            }
        });
    });

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
                    $btn.html('<i class="fas fa-check me-1"></i> Added!').css({'background': '#16a34a', 'color': '#fff', 'border-color': '#16a34a'});
                    setTimeout(function() {
                        $btn.html('<i class="fas fa-shopping-bag me-1"></i> Add to Cart').css({'background': 'transparent', 'color': 'var(--aura-gold)', 'border': '1px solid var(--aura-gold)'}).prop('disabled', false);
                    }, 2000);

                    if (res.cartCount !== undefined) {
                        $('.cart-count').text(res.cartCount).removeClass('d-none');
                    }

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
        let bgClass, icon;
        switch(type) {
            case 'success': bgClass = '#16a34a'; icon = 'fa-check-circle'; break;
            case 'danger': bgClass = '#dc2626'; icon = 'fa-exclamation-circle'; break;
            case 'warning': bgClass = 'var(--aura-gold)'; icon = 'fa-exclamation-triangle'; break;
            default: bgClass = 'var(--aura-surface)'; icon = 'fa-info-circle';
        }

        const html = `
            <div id="${toastId}" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true"
                 style="z-index: 1080; background: ${bgClass}; color: ${type === 'warning' ? '#0a0a1a' : '#fff'}; border-radius: 12px;">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="fas ${icon}"></i>
                        <div>
                            <strong class="d-block small">${title}</strong>
                            <span class="small">${message}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close ${type === 'warning' ? '' : 'btn-close-white'} me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
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

    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        $('[data-bs-toggle="tooltip"]').each(function() {
            try { new bootstrap.Tooltip(this); } catch(e) {}
        });
    }

    window.addEventListener('popstate', function() {
        location.reload();
    });
});
</script>
@endpush
