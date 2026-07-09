<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class NewCollectionController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->get('section', 'New Arrivals');

        $validSections = ['New Arrivals', 'Just Added', 'Latest Collection', 'Fresh Picks', 'New This Week', 'New This Month'];

        if (! in_array($section, $validSections)) {
            $section = 'New Arrivals';
        }

        $query = Product::with(['category', 'brand', 'images'])
            ->active()
            ->where('new_section', $section);

        $sort = $request->sort;
        match ($sort) {
            'price_low' => $query->orderByRaw('COALESCE(discount_price, price) ASC'),
            'price_high' => $query->orderByRaw('COALESCE(discount_price, price) DESC'),
            'newest' => $query->latest(),
            'oldest' => $query->oldest(),
            default => $query->latest(),
        };

        $products = $query->paginate(20)->withQueryString();

        return view('new.index', compact('products', 'section', 'validSections'));
    }
}
