<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images'])
            ->where('status', true);

        // Category filter (supports multiple via category[] array)
        if ($request->has('category')) {
            $categories = (array) $request->input('category', []);
            $categories = array_filter($categories);
            if (!empty($categories)) {
                $query->whereHas('category', function ($q) use ($categories) {
                    $q->whereIn('slug', $categories);
                });
            }
        }

        // Color filter (supports multiple via color[] array)
        if ($request->has('color')) {
            $colors = (array) $request->input('color', []);
            $colors = array_filter($colors);
            if (!empty($colors)) {
                $query->whereIn('color', $colors);
            }
        }

        // Fabric filter (supports multiple via fabric[] array)
        if ($request->has('fabric')) {
            $fabrics = (array) $request->input('fabric', []);
            $fabrics = array_filter($fabrics);
            if (!empty($fabrics)) {
                $query->whereIn('fabric', $fabrics);
            }
        }

        // Occasion filter (supports multiple via occasion[] array)
        if ($request->has('occasion')) {
            $occasions = (array) $request->input('occasion', []);
            $occasions = array_filter($occasions);
            if (!empty($occasions)) {
                $query->whereIn('occasion', $occasions);
            }
        }

        // Price range filter - uses discounted_price logic
        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->price_range);
            $min = (float) $min;
            $max = (float) $max;

            $query->where(function ($q) use ($min, $max) {
                $q->where(function ($sub) use ($min, $max) {
                    $sub->whereNotNull('discount_price')
                        ->where('discount_price', '>=', $min)
                        ->where('discount_price', '<=', $max);
                })->orWhere(function ($sub) use ($min, $max) {
                    $sub->whereNull('discount_price')
                        ->where('price', '>=', $min)
                        ->where('price', '<=', $max);
                });
            });
        }

        // Special filters
        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        if ($request->boolean('new_arrival')) {
            $query->where('is_new_arrival', true);
        }

        if ($request->boolean('best_selling')) {
            $query->where('is_best_selling', true);
        }

        // Availability filter
        if ($request->filled('availability')) {
            if ($request->availability === 'in_stock') {
                $query->where('stock_quantity', '>', 0);
            } elseif ($request->availability === 'out_of_stock') {
                $query->where('stock_quantity', '<=', 0);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('brand', function ($bq) use ($search) {
                        $bq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Sorting
        $sort = $request->sort;
        match ($sort) {
            'price_low' => $query->orderByRaw('COALESCE(discount_price, price) ASC'),
            'price_high' => $query->orderByRaw('COALESCE(discount_price, price) DESC'),
            'newest' => $query->latest(),
            'rating' => $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating'),
            'popularity' => $query->withCount('wishlists')->orderByDesc('wishlists_count'),
            default => $query->latest(),
        };

        $products = $query->paginate(20)->withQueryString();

        $categories = Category::where('status', true)->orderBy('sort_order')->get();
        $brands = Brand::where('status', true)->get();
        $colors = Product::where('status', true)->whereNotNull('color')->distinct()->pluck('color');
        $fabrics = Product::where('status', true)->whereNotNull('fabric')->distinct()->pluck('fabric');
        $occasions = Product::where('status', true)->whereNotNull('occasion')->distinct()->pluck('occasion');

        return view('products.index', compact('products', 'categories', 'brands', 'colors', 'fabrics', 'occasions'));
    }

    public function show($slug)
    {
        $product = Product::with([
            'category',
            'brand',
            'images' => fn ($q) => $q->orderBy('sort_order'),
            'variants',
            'reviews.user',
        ])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $relatedProducts = Product::with(['images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function quickView($id)
    {
        $product = Product::with(['images' => fn ($q) => $q->orderBy('sort_order'), 'variants'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'product' => $product,
            'imageUrl' => $product->image_url,
            'discountedPrice' => $product->discounted_price,
            'discountPercentage' => $product->discount_percentage,
            'isInStock' => $product->is_in_stock,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('q');

        $products = Product::with(['images', 'category', 'brand'])
            ->where('status', true)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('brand', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products,
            'total' => $products->count(),
        ]);
    }
}
