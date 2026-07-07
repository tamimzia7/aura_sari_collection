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

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('color')) {
            $query->where('color', $request->color);
        }

        if ($request->filled('fabric')) {
            $query->where('fabric', $request->fabric);
        }

        if ($request->filled('occasion')) {
            $query->where('occasion', $request->occasion);
        }

        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->price_range);
            $query->where(function ($q) use ($min, $max) {
                $q->whereBetween('price', [(float) $min, (float) $max])
                    ->orWhereBetween('discount_price', [(float) $min, (float) $max]);
            });
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        if ($request->boolean('new_arrival')) {
            $query->where('is_new_arrival', true);
        }

        if ($request->boolean('best_selling')) {
            $query->where('is_best_selling', true);
        }

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

        $sort = $request->sort;
        match ($sort) {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
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
