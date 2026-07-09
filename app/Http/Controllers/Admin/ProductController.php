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
        $query = Product::with(['category', 'brand']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(20)->withQueryString();

        $categories = Category::where('status', true)->orderBy('sort_order')->get();
        $brands = Brand::where('status', true)->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
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
        $data['status'] = $request->boolean('status', true);

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            $files = is_array($request->file('images')) ? $request->file('images') : [$request->file('images')];

            foreach ($files as $index => $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'storage/'.$path,
                    'is_primary' => $index === 0,
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
        $data['status'] = $request->boolean('status', true);

        $product->update($data);

        if ($request->hasFile('images')) {
            $existingCount = $product->images()->count();
            $files = is_array($request->file('images')) ? $request->file('images') : [$request->file('images')];

            foreach ($files as $index => $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'storage/'.$path,
                    'is_primary' => $existingCount === 0 && $index === 0,
                    'sort_order' => $existingCount + $index + 1,
                ]);
            }
        }

        if ($request->filled('remove_images')) {
            $removeIds = (array) $request->input('remove_images', []);
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
