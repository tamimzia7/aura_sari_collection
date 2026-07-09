@props([
    'categories' => collect(),
    'colors' => collect(),
    'fabrics' => collect(),
    'occasions' => collect(),
])

@php
    $colorHex = [
        'red' => '#dc2626', 'blue' => '#2563eb', 'green' => '#16a34a', 'yellow' => '#eab308',
        'black' => '#0f172a', 'white' => '#f8fafc', 'pink' => '#ec4899', 'purple' => '#9333ea',
        'orange' => '#f97316', 'brown' => '#92400e', 'grey' => '#6b7280', 'gray' => '#6b7280',
        'gold' => '#d4af37', 'silver' => '#94a3b8', 'cream' => '#fef3c7', 'navy' => '#1e3a5f',
        'maroon' => '#800020', 'teal' => '#0d9488', 'coral' => '#ff6b6b', 'beige' => '#f5f0e1',
        'mauve' => '#b4689b', 'ivory' => '#fffff0', 'burgundy' => '#800020', 'indigo' => '#4b0082',
        'emerald' => '#50c878', 'magenta' => '#ff00ff', 'turquoise' => '#40e0d0', 'lavender' => '#e6e6fa',
    ];
@endphp

<form id="filter-form" class="filter-form">
    <!-- Categories -->
    <div class="filter-section mb-4">
        <h6 class="filter-title d-flex align-items-center justify-content-between mb-3">
            <span class="fw-semibold text-uppercase small ls-1">Category</span>
            <span class="filter-toggle" data-bs-toggle="collapse" data-bs-target="#filterCategories" role="button">
                <i class="fas fa-chevron-up small text-muted"></i>
            </span>
        </h6>
        <div class="collapse show" id="filterCategories">
            <div class="filter-options" style="max-height: 220px; overflow-y: auto;">
                @forelse($categories as $category)
                    <div class="form-check mb-2">
                        <input class="form-check-input filter-checkbox" type="checkbox"
                               name="categories[]" value="{{ $category->slug }}"
                               id="cat-{{ $category->id }}"
                               {{ in_array($category->slug, (array) request('category', [])) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="cat-{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No categories available</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Color -->
    <div class="filter-section mb-4">
        <h6 class="filter-title d-flex align-items-center justify-content-between mb-3">
            <span class="fw-semibold text-uppercase small ls-1">Color</span>
            <span class="filter-toggle" data-bs-toggle="collapse" data-bs-target="#filterColors" role="button">
                <i class="fas fa-chevron-up small text-muted"></i>
            </span>
        </h6>
        <div class="collapse show" id="filterColors">
            <div class="d-flex flex-wrap gap-2">
                @forelse($colors as $color)
                    @php
                        $colorValue = is_string($color) ? trim($color) : '';
                        $colorLower = strtolower($colorValue);
                        $hex = $colorHex[$colorLower] ?? $colorLower;
                        $isDark = in_array($colorLower, ['black', 'navy', 'maroon', 'purple', 'indigo', 'burgundy', 'darkblue', 'darkgreen']);
                    @endphp
                    <div class="color-swatch-wrapper" data-bs-toggle="tooltip" title="{{ ucfirst($colorValue) }}">
                        <input class="btn-check filter-checkbox color-checkbox" type="checkbox"
                               name="colors[]" value="{{ $colorValue }}"
                               id="color-{{ Str::slug($colorValue) }}"
                               {{ in_array($colorValue, (array) request('color', [])) ? 'checked' : '' }}>
                        <label class="btn btn-sm rounded-circle color-swatch p-0 d-inline-flex align-items-center justify-content-center"
                               for="color-{{ Str::slug($colorValue) }}"
                               style="width: 32px; height: 32px; background-color: {{ $hex }}; border: 2px solid {{ $colorLower === 'white' || $colorLower === 'cream' || $colorLower === 'ivory' ? '#ddd' : $hex }};">
                            @if($isDark)
                                <i class="fas fa-check text-white small" style="opacity: 0;"></i>
                            @else
                                <i class="fas fa-check text-dark small" style="opacity: 0;"></i>
                            @endif
                        </label>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No colors available</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Fabric -->
    <div class="filter-section mb-4">
        <h6 class="filter-title d-flex align-items-center justify-content-between mb-3">
            <span class="fw-semibold text-uppercase small ls-1">Fabric</span>
            <span class="filter-toggle" data-bs-toggle="collapse" data-bs-target="#filterFabrics" role="button">
                <i class="fas fa-chevron-up small text-muted"></i>
            </span>
        </h6>
        <div class="collapse show" id="filterFabrics">
            @forelse($fabrics as $fabric)
                @php $fabricValue = is_string($fabric) ? trim($fabric) : ''; @endphp
                <div class="form-check mb-2">
                    <input class="form-check-input filter-checkbox" type="checkbox"
                           name="fabrics[]" value="{{ $fabricValue }}"
                           id="fabric-{{ Str::slug($fabricValue) }}"
                           {{ in_array($fabricValue, (array) request('fabric', [])) ? 'checked' : '' }}>
                    <label class="form-check-label small" for="fabric-{{ Str::slug($fabricValue) }}">
                        {{ $fabricValue }}
                    </label>
                </div>
            @empty
                <p class="text-muted small mb-0">No fabrics available</p>
            @endforelse
        </div>
    </div>

    <!-- Occasion -->
    <div class="filter-section mb-4">
        <h6 class="filter-title d-flex align-items-center justify-content-between mb-3">
            <span class="fw-semibold text-uppercase small ls-1">Occasion</span>
            <span class="filter-toggle" data-bs-toggle="collapse" data-bs-target="#filterOccasions" role="button">
                <i class="fas fa-chevron-up small text-muted"></i>
            </span>
        </h6>
        <div class="collapse show" id="filterOccasions">
            @forelse($occasions as $occasion)
                @php $occasionValue = is_string($occasion) ? trim($occasion) : ''; @endphp
                <div class="form-check mb-2">
                    <input class="form-check-input filter-checkbox" type="checkbox"
                           name="occasions[]" value="{{ $occasionValue }}"
                           id="occasion-{{ Str::slug($occasionValue) }}"
                           {{ in_array($occasionValue, (array) request('occasion', [])) ? 'checked' : '' }}>
                    <label class="form-check-label small" for="occasion-{{ Str::slug($occasionValue) }}">
                        {{ $occasionValue }}
                    </label>
                </div>
            @empty
                <p class="text-muted small mb-0">No occasions available</p>
            @endforelse
        </div>
    </div>

    <!-- Price Range -->
    <div class="filter-section mb-4">
        <h6 class="filter-title d-flex align-items-center justify-content-between mb-3">
            <span class="fw-semibold text-uppercase small ls-1">Price Range</span>
            <span class="filter-toggle" data-bs-toggle="collapse" data-bs-target="#filterPrice" role="button">
                <i class="fas fa-chevron-up small text-muted"></i>
            </span>
        </h6>
        <div class="collapse show" id="filterPrice">
            @php
                $priceRange = request('price_range', '');
                $priceParts = explode('-', $priceRange);
                $minVal = $priceParts[0] ?? '';
                $maxVal = $priceParts[1] ?? '';
            @endphp
            <div class="d-flex align-items-center gap-2">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0 small px-2">₹</span>
                    <input type="number" class="form-control form-control-sm border-start-0 ps-0 price-input" id="min-price"
                           placeholder="Min" min="0" value="{{ $minVal ?: '' }}" step="100">
                </div>
                <span class="text-muted small">—</span>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0 small px-2">₹</span>
                    <input type="number" class="form-control form-control-sm border-start-0 ps-0 price-input" id="max-price"
                           placeholder="Max" min="0" value="{{ $maxVal ?: '' }}" step="100">
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-dark w-100 mt-2 price-apply-btn">Apply Price</button>
        </div>
    </div>

    <!-- Availability -->
    <div class="filter-section mb-4">
        <h6 class="filter-title d-flex align-items-center justify-content-between mb-3">
            <span class="fw-semibold text-uppercase small ls-1">Availability</span>
            <span class="filter-toggle" data-bs-toggle="collapse" data-bs-target="#filterAvailability" role="button">
                <i class="fas fa-chevron-up small text-muted"></i>
            </span>
        </h6>
        <div class="collapse show" id="filterAvailability">
            <div class="form-check mb-2">
                <input class="form-check-input filter-checkbox" type="checkbox"
                       name="availability[]" value="in_stock" id="filter-in-stock"
                       {{ in_array('in_stock', (array) request('availability', [])) ? 'checked' : '' }}>
                <label class="form-check-label small" for="filter-in-stock">
                    <i class="fas fa-check-circle text-success me-1 small"></i> In Stock
                </label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input filter-checkbox" type="checkbox"
                       name="availability[]" value="out_of_stock" id="filter-out-of-stock"
                       {{ in_array('out_of_stock', (array) request('availability', [])) ? 'checked' : '' }}>
                <label class="form-check-label small" for="filter-out-of-stock">
                    <i class="fas fa-times-circle text-danger me-1 small"></i> Out of Stock
                </label>
            </div>
        </div>
    </div>

    <!-- Special Filters -->
    <div class="filter-section mb-4">
        <h6 class="filter-title d-flex align-items-center justify-content-between mb-3">
            <span class="fw-semibold text-uppercase small ls-1">Special</span>
            <span class="filter-toggle" data-bs-toggle="collapse" data-bs-target="#filterSpecial" role="button">
                <i class="fas fa-chevron-up small text-muted"></i>
            </span>
        </h6>
        <div class="collapse show" id="filterSpecial">
            <div class="form-check mb-2">
                <input class="form-check-input filter-checkbox" type="checkbox"
                       name="featured" value="1" id="filter-featured"
                       {{ request('featured') ? 'checked' : '' }}>
                <label class="form-check-label small" for="filter-featured">
                    <i class="fas fa-star text-warning me-1 small"></i> Featured
                </label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input filter-checkbox" type="checkbox"
                       name="new_arrival" value="1" id="filter-new-arrival"
                       {{ request('new_arrival') ? 'checked' : '' }}>
                <label class="form-check-label small" for="filter-new-arrival">
                    <i class="fas fa-clock text-success me-1 small"></i> New Arrival
                </label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input filter-checkbox" type="checkbox"
                       name="best_selling" value="1" id="filter-best-selling"
                       {{ request('best_selling') ? 'checked' : '' }}>
                <label class="form-check-label small" for="filter-best-selling">
                    <i class="fas fa-fire text-danger me-1 small"></i> Best Selling
                </label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input filter-checkbox" type="checkbox"
                       name="trending" value="1" id="filter-trending"
                       {{ request('trending') ? 'checked' : '' }}>
                <label class="form-check-label small" for="filter-trending">
                    <i class="fas fa-chart-line text-info me-1 small"></i> Trending
                </label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input filter-checkbox" type="checkbox"
                       name="discounted" value="1" id="filter-discounted"
                       {{ request('discounted') ? 'checked' : '' }}>
                <label class="form-check-label small" for="filter-discounted">
                    <i class="fas fa-tag text-warning me-1 small"></i> Discounted
                </label>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="filter-actions d-grid gap-2">
        <button type="submit" class="btn btn-dark btn-sm rounded-pill apply-filters-btn">
            <i class="fas fa-check me-1"></i> Apply Filters
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill clear-filters-btn">
            <i class="fas fa-times me-1"></i> Clear All
        </button>
    </div>
</form>

@push('styles')
<style>
.filter-section + .filter-section {
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
}
.filter-title {
    cursor: pointer;
    user-select: none;
    letter-spacing: 0.05em;
    font-size: 0.75rem;
}
.filter-options::-webkit-scrollbar {
    width: 3px;
}
.filter-options::-webkit-scrollbar-thumb {
    background: #ddd;
    border-radius: 10px;
}
.form-check-input:checked {
    background-color: #1a1a2e;
    border-color: #1a1a2e;
}
.form-check-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(26, 26, 46, 0.15);
    border-color: #1a1a2e;
}
.color-swatch-wrapper .btn-check:checked + .color-swatch {
    box-shadow: 0 0 0 3px #d4af37, 0 0 0 5px #fff;
    border-color: #d4af37 !important;
    transform: scale(1.1);
}
.color-swatch-wrapper .btn-check:checked + .color-swatch i {
    opacity: 1 !important;
}
.color-swatch {
    transition: all 0.2s ease;
    cursor: pointer;
}
.color-swatch:hover {
    transform: scale(1.15);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
.price-input::-webkit-inner-spin-button {
    opacity: 0.5;
}
.price-input:focus {
    border-color: #1a1a2e;
    box-shadow: 0 0 0 0.2rem rgba(26, 26, 46, 0.1);
}
</style>
@endpush
