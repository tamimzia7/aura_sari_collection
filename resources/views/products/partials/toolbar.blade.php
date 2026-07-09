@props([
    'products' => null,
    'total' => 0,
    'from' => 0,
    'to' => 0,
])

@php
    if ($products) {
        $total = $products->total();
        $from = $products->firstItem() ?: 0;
        $to = $products->lastItem() ?: 0;
    }
    $viewMode = request('view', 'grid');
@endphp

<div class="toolbar d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 p-3 bg-white rounded-3 border">
    <!-- Results Count -->
    <div id="toolbar-stats" class="d-flex align-items-center gap-2">
        <span class="text-muted small">
            Showing <strong class="text-dark">{{ $total > 0 ? $from : 0 }}</strong>–<strong class="text-dark">{{ $to }}</strong> of <strong class="text-dark">{{ number_format($total) }}</strong> results
        </span>
        @if(request()->anyFilled(['search', 'category', 'color', 'fabric', 'occasion', 'featured', 'new_arrival', 'best_selling', 'trending', 'discounted', 'availability', 'price_range']))
            <span class="badge bg-dark rounded-pill filter-active-badge d-none d-md-inline-flex align-items-center gap-1 px-3 py-1">
                <i class="fas fa-filter fa-xs"></i> Filters Active
                <button type="button" class="btn-close btn-close-white ms-1 clear-filters-btn" style="font-size: 0.5rem;" aria-label="Clear filters"></button>
            </span>
        @endif
    </div>

    <div class="d-flex align-items-center gap-2 ms-auto">
        <!-- Search -->
        <div class="position-relative toolbar-search">
            <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 0.8rem;"></i>
            <input type="text" id="search-input" class="form-control form-control-sm bg-light border-0 ps-5 rounded-pill"
                   placeholder="Search products..." value="{{ request('search') }}"
                   style="width: 200px; font-size: 0.85rem;" autocomplete="off">
            @if(request('search'))
                <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y border-0 text-muted clear-search-btn p-0 me-2" style="font-size: 0.7rem;">
                    <i class="fas fa-times"></i>
                </button>
            @endif
        </div>

        <!-- Sort -->
        <div class="toolbar-sort">
            <select id="sort-select" class="form-select form-select-sm bg-light border-0 rounded-pill" style="font-size: 0.85rem; padding-right: 2rem;">
                <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Best Rated</option>
                <option value="popularity" {{ request('sort') === 'popularity' ? 'selected' : '' }}>Popularity</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
            </select>
        </div>

        <!-- View Toggle -->
        <div class="btn-group btn-group-sm border rounded-pill overflow-hidden" role="group" aria-label="View toggle">
            <input type="radio" class="btn-check" name="view-toggle" id="view-grid" value="grid" autocomplete="off" {{ $viewMode === 'grid' ? 'checked' : '' }}>
            <label class="btn btn-sm px-3 {{ $viewMode === 'grid' ? 'btn-dark' : 'btn-light' }}" for="view-grid" title="Grid View">
                <i class="fas fa-th"></i>
            </label>
            <input type="radio" class="btn-check" name="view-toggle" id="view-list" value="list" autocomplete="off" {{ $viewMode === 'list' ? 'checked' : '' }}>
            <label class="btn btn-sm px-3 {{ $viewMode === 'list' ? 'btn-dark' : 'btn-light' }}" for="view-list" title="List View">
                <i class="fas fa-list"></i>
            </label>
        </div>
    </div>
</div>

@push('styles')
<style>
.toolbar {
    border-color: #f0f0f0 !important;
}
.toolbar-search .form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(26, 26, 46, 0.1);
    background: #fff !important;
    border-color: #1a1a2e;
}
.toolbar-sort .form-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(26, 26, 46, 0.1);
    border-color: #1a1a2e;
}
#sort-select {
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23333' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
}
.filter-active-badge {
    font-size: 0.75rem;
}
.btn-check:checked + .btn-dark {
    background-color: #1a1a2e;
    border-color: #1a1a2e;
}
</style>
@endpush
