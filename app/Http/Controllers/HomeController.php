<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['category', 'brand', 'images'])
            ->where('is_featured', true)
            ->where('status', true)
            ->latest()
            ->take(8)
            ->get();

        $newArrivals = Product::with(['category', 'brand', 'images'])
            ->where('is_new_arrival', true)
            ->where('status', true)
            ->latest()
            ->take(8)
            ->get();

        $bestSelling = Product::with(['category', 'brand', 'images'])
            ->where('is_best_selling', true)
            ->where('status', true)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('status', true)
            ->orderBy('sort_order')
            ->get();

        return view('home.index', compact('featuredProducts', 'newArrivals', 'bestSelling', 'categories'));
    }
}
