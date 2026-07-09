<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->buildProductQuery($request);

        $products = $query->paginate(20)->withQueryString();

        $categories = Category::where('status', true)->orderBy('sort_order')->get();
        $brands = Brand::where('status', true)->get();
        $colors = Product::where('status', true)->whereNotNull('color')->distinct()->pluck('color');
        $fabrics = Product::where('status', true)->whereNotNull('fabric')->distinct()->pluck('fabric');
        $occasions = Product::where('status', true)->whereNotNull('occasion')->distinct()->pluck('occasion');

        return view('products.index', compact('products', 'categories', 'brands', 'colors', 'fabrics', 'occasions'));
    }

    public function collection(Request $request, $slug)
    {
        $collection = Collection::where('slug', $slug)->firstOrFail();

        $query = $this->buildProductQuery($request)
            ->where('collection_id', $collection->id);

        $products = $query->paginate(20)->withQueryString();

        $categories = Category::where('status', true)->orderBy('sort_order')->get();
        $brands = Brand::where('status', true)->get();
        $colors = Product::where('status', true)->whereNotNull('color')->distinct()->pluck('color');
        $fabrics = Product::where('status', true)->whereNotNull('fabric')->distinct()->pluck('fabric');
        $occasions = Product::where('status', true)->whereNotNull('occasion')->distinct()->pluck('occasion');

        return view('products.index', compact('products', 'categories', 'brands', 'colors', 'fabrics', 'occasions', 'collection'));
    }

    private function buildProductQuery(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images'])
            ->where('status', true);

        $query->when($request->has('category'), function ($q) use ($request) {
            $categories = array_filter((array) $request->input('category', []));
            $q->when(! empty($categories), function ($sub) use ($categories) {
                $sub->whereHas('category', fn ($cq) => $cq->whereIn('slug', $categories));
            });
        })
            ->when($request->has('color'), function ($q) use ($request) {
                $colors = array_filter((array) $request->input('color', []));
                $q->when(! empty($colors), fn ($sub) => $sub->whereIn('color', $colors));
            })
            ->when($request->has('fabric'), function ($q) use ($request) {
                $fabrics = array_filter((array) $request->input('fabric', []));
                $q->when(! empty($fabrics), fn ($sub) => $sub->whereIn('fabric', $fabrics));
            })
            ->when($request->has('occasion'), function ($q) use ($request) {
                $occasions = array_filter((array) $request->input('occasion', []));
                $q->when(! empty($occasions), fn ($sub) => $sub->whereIn('occasion', $occasions));
            })
            ->when($request->filled('price_range'), function ($q) use ($request) {
                [$min, $max] = explode('-', $request->price_range);
                $min = (float) $min;
                $max = (float) $max;
                $q->where(fn ($sub) => $sub
                    ->where(fn ($s) => $s->whereNotNull('discount_price')->whereBetween('discount_price', [$min, $max]))
                    ->orWhere(fn ($s) => $s->whereNull('discount_price')->whereBetween('price', [$min, $max]))
                );
            })
            ->when($request->boolean('featured'), fn ($q) => $q->where('is_featured', true))
            ->when($request->boolean('new_arrival'), fn ($q) => $q->where('is_new_arrival', true))
            ->when($request->boolean('best_selling'), fn ($q) => $q->where('is_best_selling', true))
            ->when($request->boolean('trending'), fn ($q) => $q->where('is_trending', true))
            ->when($request->boolean('discounted'), fn ($q) => $q->where('is_discounted', true))
            ->when($request->has('availability'), function ($q) use ($request) {
                $avail = array_filter((array) $request->input('availability', []));
                if (in_array('in_stock', $avail) && ! in_array('out_of_stock', $avail)) {
                    $q->where('stock_quantity', '>', 0);
                } elseif (in_array('out_of_stock', $avail) && ! in_array('in_stock', $avail)) {
                    $q->where('stock_quantity', '<=', 0);
                }
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(fn ($sub) => $sub
                    ->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', fn ($cq) => $cq->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('brand', fn ($bq) => $bq->where('name', 'like', "%{$search}%"))
                );
            });

        $sort = $request->sort;
        match ($sort) {
            'price_low' => $query->orderByRaw('COALESCE(discount_price, price) ASC'),
            'price_high' => $query->orderByRaw('COALESCE(discount_price, price) DESC'),
            'newest' => $query->latest(),
            'oldest' => $query->oldest(),
            'rating' => $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating'),
            'popularity' => $query->withCount('wishlists')->orderByDesc('wishlists_count'),
            default => $query->latest(),
        };

        return $query;
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
