@extends('layouts.app')

@section('title', $section . ' - AURA')

@push('styles')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
.collection-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 3.2rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.15;
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
}

.section-tabs {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-top: 1rem;
}
.section-tab {
    padding: 0.4rem 1.2rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    background: transparent;
    border: 1px solid var(--aura-border);
    color: var(--aura-text-muted);
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}
.section-tab:hover {
    border-color: var(--aura-gold);
    color: var(--aura-gold);
}
.section-tab.active {
    background: var(--aura-gold);
    color: #0a0a1a;
    border-color: var(--aura-gold);
}

.aura-breadcrumb {
    padding: 80px 0 0.75rem;
    background: var(--aura-bg);
    border-bottom: 1px solid var(--aura-border);
}
.aura-breadcrumb .breadcrumb { margin: 0; background: transparent; }
.aura-breadcrumb .breadcrumb-item { font-size: 0.8rem; }
.aura-breadcrumb .breadcrumb-item a { color: var(--aura-text-muted); text-decoration: none; }
.aura-breadcrumb .breadcrumb-item a:hover { color: var(--aura-gold); }
.aura-breadcrumb .breadcrumb-item.active { color: var(--aura-text); }
.aura-breadcrumb .breadcrumb-item+.breadcrumb-item::before { content: '›'; color: var(--aura-text-muted); }

.product-grid { --bs-gutter-y: 1.5rem; }

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
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    border-color: rgba(212,175,55,0.2);
}
.aura-product-card .product-card-image {
    overflow: hidden;
    position: relative;
    background: var(--aura-bg);
    aspect-ratio: 3/4;
}
.aura-product-card .product-img-front {
    transition: transform 0.7s cubic-bezier(0.25,0.46,0.45,0.94);
    width: 100%; height: 100%; object-fit: cover;
}
.aura-product-card:hover .product-img-front {
    transform: scale(1.08);
}
.aura-product-card .product-badge.new {
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
    background: var(--aura-gold);
    color: #0a0a1a;
}
.aura-product-card .card-body { padding: 1rem 1.1rem; }
.aura-product-card .product-name {
    font-size: 0.88rem;
    font-weight: 600;
    margin-bottom: 0.35rem;
    line-height: 1.3;
}
.aura-product-card .product-name a { color: var(--aura-text); text-decoration: none; }
.aura-product-card .product-name a:hover { color: var(--aura-gold); }
.aura-product-card .product-category {
    font-size: 0.72rem;
    color: var(--aura-text-muted);
    margin-bottom: 0.5rem;
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
    cursor: pointer;
}
.aura-product-card .add-to-cart-btn:hover {
    background: var(--aura-gold);
    color: #0a0a1a;
}

.aura-pagination .pagination { gap: 0.25rem; }
.aura-pagination .page-link {
    background: var(--aura-surface);
    border: 1px solid var(--aura-border);
    color: var(--aura-text);
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
    border-radius: 8px !important;
    transition: all 0.2s;
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
}
.empty-state { padding: 4rem 1rem; text-align: center; }
.empty-state i { color: var(--aura-border); font-size: 3rem; }
.empty-state h5 { color: var(--aura-text); margin-top: 1rem; }
.empty-state p { color: var(--aura-text-muted); }

@media (max-width: 991.98px) {
    .collection-hero { padding: 3.5rem 0 2.5rem; }
    .collection-hero h1 { font-size: 2.2rem; }
}
@media (max-width: 767.98px) {
    .collection-hero { padding: 2.5rem 0 2rem; }
    .collection-hero h1 { font-size: 1.8rem; }
}
</style>
@endpush

@section('content')
<div class="aura-breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">New</li>
            </ol>
        </nav>
    </div>
</div>

<div class="collection-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1>New <span class="gold">Collection</span></h1>
                <p>Discover the latest additions to our collection, curated fresh for you.</p>
                <div class="gold-line"></div>
                <div class="section-tabs">
                    @foreach($validSections as $sec)
                        <a href="{{ route('new.index', ['section' => $sec]) }}" class="section-tab {{ $section === $sec ? 'active' : '' }}">{{ $sec }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <p class="mb-0" style="color: var(--aura-text-muted); font-size: 0.85rem;">
                    Showing <strong>{{ $products->total() }}</strong> {{ Str::plural('product', $products->total()) }}
                </p>
                <div>
                    <select class="form-select form-select-sm aura-select" id="sort-select" onchange="window.location.href=this.value" style="width: auto; display: inline-block;">
                        <option value="{{ route('new.index', array_merge(request()->except('sort'), ['section' => $section, 'sort' => 'newest'])) }}" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="{{ route('new.index', array_merge(request()->except('sort'), ['section' => $section, 'sort' => 'oldest'])) }}" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="{{ route('new.index', array_merge(request()->except('sort'), ['section' => $section, 'sort' => 'price_low'])) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="{{ route('new.index', array_merge(request()->except('sort'), ['section' => $section, 'sort' => 'price_high'])) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </div>

            <div class="row product-grid g-3">
                @forelse($products as $product)
                    @php
                        $primaryImg = $product->images[0]->image_path ?? 'images/placeholder.jpg';
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                        <div class="aura-product-card">
                            <div class="product-card-image position-relative overflow-hidden">
                                <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                    <img src="{{ asset($primaryImg) }}" alt="{{ $product->name }}" class="product-img-front w-100" loading="lazy" onerror="this.src='https://placehold.co/300x400?text=No+Image'">
                                </a>
                                <span class="product-badge new">New</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                @if($product->category)
                                    <p class="product-category">{{ $product->category->name }}</p>
                                @endif
                                <h6 class="product-name">
                                    <a href="{{ route('products.show', $product->slug ?? $product->id) }}">{{ $product->name }}</a>
                                </h6>
                                <div class="product-price mt-auto pt-2">
                                    @if($product->discount_price)
                                        <span class="current-price">₹{{ number_format($product->discounted_price, 0) }}</span>
                                        <span class="original-price">₹{{ number_format($product->price, 0) }}</span>
                                    @else
                                        <span class="current-price">₹{{ number_format($product->price, 0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <h5>No products found</h5>
                            <p>There are no products in this section yet. Check back later.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($products->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    <div class="aura-pagination">
                        {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection