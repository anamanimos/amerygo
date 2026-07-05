<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignCategory;
use App\Models\Color;
use App\Models\Setting;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    public function index(Request $request)
    {
        $query = Design::with(['categories', 'colors'])->where('is_active', true);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->input('category'))
                  ->where('is_active', true);
            });
        }

        // Colors filter (array of hex codes or ids? Let's use ids array from frontend)
        if ($request->filled('colors') && is_array($request->colors)) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->whereIn('colors.id', $request->colors);
            });
        }

        $designs = $query->latest()->paginate(12)->withQueryString();
        $categories = DesignCategory::where('is_active', true)->get();
        $colors = Color::all();
        $whatsappNumber = Setting::where('key', 'whatsapp_number')->value('value') ?? '6281234567890';

        return view('pages.designs.index', compact('designs', 'categories', 'colors', 'whatsappNumber'));
    }

    public function show($slug)
    {
        $design = Design::with(['categories', 'colors'])->where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $categoryIds = $design->categories->pluck('id')->toArray();
        $relatedDesigns = Design::whereHas('categories', function($q) use ($categoryIds) {
                $q->whereIn('design_categories.id', $categoryIds);
            })
            ->where('id', '!=', $design->id)
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        $whatsappNumber = Setting::where('key', 'whatsapp_number')->value('value') ?? '6281234567890';

        return view('pages.designs.show', compact('design', 'relatedDesigns', 'whatsappNumber'));
    }
}
