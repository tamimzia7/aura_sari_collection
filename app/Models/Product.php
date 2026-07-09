<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'collection_id',
        'product_code',
        'name',
        'slug',
        'sku',
        'description',
        'short_description',
        'price',
        'discount_price',
        'fabric',
        'occasion',
        'color',
        'pattern',
        'sizes',
        'weight',
        'stock_quantity',
        'stock_status',
        'is_featured',
        'is_new_arrival',
        'is_best_selling',
        'is_trending',
        'is_discounted',
        'home_section',
        'new_section',
        'status',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_new_arrival' => 'boolean',
            'is_best_selling' => 'boolean',
            'is_trending' => 'boolean',
            'is_discounted' => 'boolean',
            'status' => 'boolean',
            'sizes' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('is_new_arrival', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    public function scopeDiscounted($query)
    {
        return $query->where('is_discounted', true);
    }

    public function scopeBestSelling($query)
    {
        return $query->where('is_best_selling', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getDiscountedPriceAttribute(): float
    {
        return $this->discount_price ?: $this->price;
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->discount_price && $this->price > 0) {
            return (int) round((($this->price - $this->discount_price) / $this->price) * 100);
        }

        return null;
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function getImageUrlAttribute(): ?string
    {
        $primary = $this->images()->where('is_primary', true)->first();

        return $primary?->image_path ?? 'https://placehold.co/600x800?text=No+Image';
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}
