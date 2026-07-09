<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['category', 'images'])
            ->active()
            ->featured()
            ->latest()
            ->take(8)
            ->get();

        $newArrivals = Product::with(['category', 'images'])
            ->active()
            ->newArrivals()
            ->latest()
            ->take(8)
            ->get();

        $trendingProducts = Product::with(['category', 'images'])
            ->active()
            ->trending()
            ->latest()
            ->take(8)
            ->get();

        $bestSelling = Product::with(['category', 'images'])
            ->active()
            ->bestSelling()
            ->latest()
            ->take(8)
            ->get();

        $discountedProducts = Product::with(['category', 'images'])
            ->active()
            ->discounted()
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('status', true)
            ->orderBy('sort_order')
            ->get();

        $collections = Collection::where('status', true)
            ->orderBy('sort_order')
            ->get();

        $banners = Banner::where('status', true)
            ->orderBy('sort_order')
            ->get();

        return view('home.index', compact(
            'featuredProducts',
            'newArrivals',
            'trendingProducts',
            'bestSelling',
            'discountedProducts',
            'categories',
            'collections',
            'banners'
        ));
    }
}
