<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'images')->where('is_active', true);
        
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        $products = $query->latest()->paginate(12);
        $categories = ProductCategory::where('is_active', true)->get();
        
        return view('pages.products', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::with('category', 'images')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
                                ->where('id', '!=', $product->id)
                                ->where('is_active', true)
                                ->latest()
                                ->take(4)
                                ->get();
                                
        $whatsappNumber = \App\Models\Setting::where('key', 'whatsapp_number')->value('value') ?? '6281234567890';
                                
        return view('pages.products_show', compact('product', 'relatedProducts', 'whatsappNumber'));
    }
}
