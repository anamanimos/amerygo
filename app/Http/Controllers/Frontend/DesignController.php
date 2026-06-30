<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignCategory;
use App\Models\Setting;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    public function index(Request $request)
    {
        $query = Design::with('category')->where('is_active', true);

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
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'))
                  ->where('is_active', true);
            });
        }

        $designs = $query->latest()->paginate(12)->withQueryString();
        $categories = DesignCategory::where('is_active', true)->get();

        return view('pages.designs.index', compact('designs', 'categories'));
    }

    public function show($slug)
    {
        $design = Design::with('category')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $relatedDesigns = Design::where('design_category_id', $design->design_category_id)
            ->where('id', '!=', $design->id)
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        $whatsappNumber = Setting::where('key', 'whatsapp_number')->value('value') ?? '6281234567890';

        return view('pages.designs.show', compact('design', 'relatedDesigns', 'whatsappNumber'));
    }
}
