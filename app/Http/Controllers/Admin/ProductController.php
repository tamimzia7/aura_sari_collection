<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'collection', 'brand']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('collection')) {
            $query->where('collection_id', $request->collection);
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'in_stock') {
                $query->where('stock_quantity', '>', 0);
            } elseif ($request->stock === 'out_of_stock') {
                $query->where('stock_quantity', '=', 0);
            } elseif ($request->stock === 'low') {
                $query->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 5);
            }
        }

        $products = $query->latest()->paginate(20)->withQueryString();

        $categories = Category::where('status', true)->orderBy('sort_order')->get();
        $collections = Collection::where('status', true)->orderBy('sort_order')->get();
        $brands = Brand::where('status', true)->get();

        return view('admin.products.index', compact('products', 'categories', 'collections', 'brands'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'collection', 'brand', 'images']);

        return view('admin.products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->orderBy('sort_order')->get();
        $brands = Brand::where('status', true)->get();
        $collections = Collection::where('status', true)->orderBy('sort_order')->get();

        return view('admin.products.create', compact('categories', 'brands', 'collections'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_new_arrival'] = $request->boolean('is_new_arrival');
        $data['is_best_selling'] = $request->boolean('is_best_selling');
        $data['is_trending'] = $request->boolean('is_trending');
        $data['is_discounted'] = $request->boolean('is_discounted');
        $data['status'] = $request->boolean('status', true);

        if (empty($data['product_code'])) {
            $data['product_code'] = 'PRD-'.strtoupper(substr(md5(uniqid()), 0, 6));
        }

        $product = Product::create($data);

        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'storage/'.$path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        if ($request->hasFile('images')) {
            $files = is_array($request->file('images')) ? $request->file('images') : [$request->file('images')];

            foreach ($files as $index => $image) {
                $path = $image->store('products', 'public');

                $isPrimary = ! $request->hasFile('main_image') && $index === 0;

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'storage/'.$path,
                    'is_primary' => $isPrimary,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $product->load('images');

        $categories = Category::where('status', true)->orderBy('sort_order')->get();
        $brands = Brand::where('status', true)->get();
        $collections = Collection::where('status', true)->orderBy('sort_order')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'collections'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_new_arrival'] = $request->boolean('is_new_arrival');
        $data['is_best_selling'] = $request->boolean('is_best_selling');
        $data['is_trending'] = $request->boolean('is_trending');
        $data['is_discounted'] = $request->boolean('is_discounted');
        $data['status'] = $request->boolean('status', true);

        $product->update($data);

        $primaryImage = $product->images()->where('is_primary', true)->first();

        if ($request->hasFile('main_image')) {
            if ($primaryImage) {
                $relativePath = str_replace('storage/', '', $primaryImage->image_path);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
                $primaryImage->delete();
            }

            $path = $request->file('main_image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'storage/'.$path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        if ($request->hasFile('images')) {
            $existingCount = $product->images()->count();
            $files = is_array($request->file('images')) ? $request->file('images') : [$request->file('images')];

            foreach ($files as $index => $image) {
                $path = $image->store('products', 'public');

                $isPrimary = ! $request->hasFile('main_image') && ! $primaryImage && $index === 0;

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'storage/'.$path,
                    'is_primary' => $isPrimary,
                    'sort_order' => $existingCount + $index + 1,
                ]);
            }
        }

        if ($request->filled('remove_images')) {
            $removeIds = explode(',', $request->input('remove_images', ''));
            $images = ProductImage::whereIn('id', $removeIds)->where('product_id', $product->id)->get();

            foreach ($images as $image) {
                $relativePath = str_replace('storage/', '', $image->image_path);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
                $image->delete();
            }
        }

        if ($request->has('primary_image_id')) {
            ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
            ProductImage::where('id', $request->primary_image_id)
                ->where('product_id', $product->id)
                ->update(['is_primary' => true]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            $relativePath = str_replace('storage/', '', $image->image_path);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
}
