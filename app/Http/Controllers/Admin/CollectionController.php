<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::orderBy('sort_order')->paginate(20);

        return view('admin.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('admin.collections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:collections',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'integer|min:0',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/collections');
            $validated['image'] = str_replace('public/', 'storage/', $path);
        }

        Collection::create($validated);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection created successfully');
    }

    public function edit(Collection $collection)
    {
        return view('admin.collections.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:collections,slug,'.$collection->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'integer|min:0',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($collection->image) {
                $oldPath = str_replace('storage/', 'public/', $collection->image);
                Storage::delete($oldPath);
            }

            $path = $request->file('image')->store('public/collections');
            $validated['image'] = str_replace('public/', 'storage/', $path);
        }

        $collection->update($validated);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection updated successfully');
    }

    public function destroy(Collection $collection)
    {
        if ($collection->image) {
            $path = str_replace('storage/', 'public/', $collection->image);
            Storage::delete($path);
        }

        $collection->delete();

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection deleted successfully');
    }
}
