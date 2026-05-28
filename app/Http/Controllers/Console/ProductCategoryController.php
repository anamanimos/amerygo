<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::latest()->get();
        return view('console.product_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('console.product_categories.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('product_categories', 'public');
            $data['image'] = 'storage/' . $data['image'];
        }

        ProductCategory::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!'
            ]);
        }

        return redirect()->route('console.product_categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(ProductCategory $productCategory)
    {
        return view('console.product_categories.form', compact('productCategory'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->has('avatar_remove') && $request->avatar_remove == "1") {
            if ($productCategory->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $productCategory->image));
                $data['image'] = null;
            }
        }

        if ($request->hasFile('image')) {
            if ($productCategory->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $productCategory->image));
            }
            $data['image'] = $request->file('image')->store('product_categories', 'public');
            $data['image'] = 'storage/' . $data['image'];
        }

        $productCategory->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui!'
            ]);
        }

        return redirect()->route('console.product_categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
        }

        if ($productCategory->image) {
            Storage::disk('public')->delete(str_replace('storage/', '', $productCategory->image));
        }
        $productCategory->delete();

        return redirect()->route('console.product_categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
