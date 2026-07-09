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
        $sections = [
            'Hero Collection',
            'Featured Collection',
            'Premium Collection',
            'Luxury Collection',
            'Wedding Collection',
            'Festive Collection',
            'Trending Collection',
            "Editor's Choice",
        ];

        $sectionProducts = [];
        foreach ($sections as $section) {
            $sectionProducts[$section] = Product::with(['category', 'images'])
                ->active()
                ->where('home_section', $section)
                ->latest()
                ->take(8)
                ->get();
        }

        $newArrivals = Product::with(['category', 'images'])
            ->active()
            ->where('new_section', 'New Arrivals')
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
            'sectionProducts',
            'newArrivals',
            'categories',
            'collections',
            'banners'
        ));
    }
}
