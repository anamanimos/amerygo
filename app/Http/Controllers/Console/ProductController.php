<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'images')->latest()->get();
        $currentCount = $products->count();
        $limit = 20;
        return view('console.products.index', compact('products', 'currentCount', 'limit'));
    }

    public function create()
    {
        if (Product::count() >= 20) {
            return redirect()->route('console.products.index')->with('error', 'Batas maksimal 20 produk telah tercapai.');
        }
        $categories = ProductCategory::where('is_active', true)->get();
        return view('console.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        if (Product::count() >= 20) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Batas maksimal 20 produk telah tercapai.'], 403);
            }
            return redirect()->route('console.products.index')->with('error', 'Batas maksimal 20 produk telah tercapai.');
        }

        $request->validate([
            'name' => 'required|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'images.*' => 'image|max:2048'
        ]);

        $data = $request->except('images');
        $data['slug'] = Str::slug($request->name);
        
        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $count = 1;
        while (Product::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        $product = Product::create($data);

        // Handle Images
        if ($request->hasFile('images')) {
            $sortOrder = 0;
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'storage/' . $path,
                    'sort_order' => $sortOrder++
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan!'
            ]);
        }

        return redirect()->route('console.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('is_active', true)->get();
        return view('console.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'images.*' => 'image|max:2048'
        ]);

        $data = $request->except('images', 'deleted_images', 'image_order');
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        $product->update($data);

        // Handle deleted images
        if ($request->filled('deleted_images')) {
            $deletedIds = explode(',', $request->deleted_images);
            $imagesToDelete = ProductImage::whereIn('id', $deletedIds)->where('product_id', $product->id)->get();
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete(str_replace('storage/', '', $img->image_path));
                $img->delete();
            }
        }

        // Handle image order
        if ($request->filled('image_order')) {
            $orderIds = explode(',', $request->image_order);
            foreach ($orderIds as $index => $imgId) {
                ProductImage::where('id', $imgId)->where('product_id', $product->id)->update(['sort_order' => $index]);
            }
        }

        // Handle new images
        if ($request->hasFile('images')) {
            $maxSort = $product->images()->max('sort_order') ?? -1;
            foreach ($request->file('images') as $file) {
                $maxSort++;
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'storage/' . $path,
                    'sort_order' => $maxSort
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui!'
            ]);
        }

        return redirect()->route('console.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            Storage::disk('public')->delete(str_replace('storage/', '', $img->image_path));
        }
        
        $product->delete();

        return redirect()->route('console.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
