<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignCategory;
use App\Models\Color;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
    private function getLimit()
    {
        return (int) (Setting::where('key', 'limit_designs')->value('value') ?? 20);
    }

    public function index()
    {
        $designs = Design::with(['categories', 'colors'])->latest()->get();
        $currentCount = $designs->count();
        $limit = $this->getLimit();
        return view('console.designs.index', compact('designs', 'currentCount', 'limit'));
    }

    public function create()
    {
        $limit = $this->getLimit();
        if (Design::count() >= $limit) {
            return redirect()->route('console.designs.index')->with('error', 'Batas maksimal ' . $limit . ' desain telah tercapai.');
        }
        $categories = DesignCategory::where('is_active', true)->get();
        $colors = Color::all();
        return view('console.designs.form', compact('categories', 'colors'));
    }

    public function store(Request $request)
    {
        $limit = $this->getLimit();
        if (Design::count() >= $limit) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Batas maksimal ' . $limit . ' desain telah tercapai.'], 403);
            }
            return redirect()->route('console.designs.index')->with('error', 'Batas maksimal ' . $limit . ' desain telah tercapai.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:design_categories,id',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'description' => 'nullable|string',
            'cropped_image' => 'required|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['name']);
        
        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $count = 1;
        while (Design::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        $data['is_active'] = $request->has('is_active');

        if ($request->filled('cropped_image')) {
            $base64Image = $request->input('cropped_image');
            $imageParts = explode(";base64,", $base64Image);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1];
            $imageBase64 = base64_decode($imageParts[1]);
            
            $filename = uniqid() . '.' . $imageType;
            
            Storage::disk('public')->put('designs/' . $filename, $imageBase64);
            $data['image'] = 'storage/designs/' . $filename;
        }

        $design = Design::create($data);

        $design->categories()->sync($request->categories);
        if ($request->has('colors')) {
            $design->colors()->sync($request->colors);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Desain jersey berhasil ditambahkan.']);
        }

        return redirect()->route('console.designs.index')->with('success', 'Desain jersey berhasil ditambahkan.');
    }

    public function edit(Design $design)
    {
        $categories = DesignCategory::where('is_active', true)->get();
        $colors = Color::all();
        return view('console.designs.form', compact('design', 'categories', 'colors'));
    }

    public function update(Request $request, Design $design)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:design_categories,id',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'description' => 'nullable|string',
            'cropped_image' => 'nullable|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['name']);
        
        // Ensure slug is unique (ignoring current)
        $originalSlug = $data['slug'];
        $count = 1;
        while (Design::where('slug', $data['slug'])->where('id', '!=', $design->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        $data['is_active'] = $request->has('is_active');

        if ($request->filled('cropped_image')) {
            if ($design->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $design->image));
            }
            $base64Image = $request->input('cropped_image');
            $imageParts = explode(";base64,", $base64Image);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1];
            $imageBase64 = base64_decode($imageParts[1]);
            
            $filename = uniqid() . '.' . $imageType;
            
            Storage::disk('public')->put('designs/' . $filename, $imageBase64);
            $data['image'] = 'storage/designs/' . $filename;
        } elseif ($request->input('avatar_remove') == '1') {
            if ($design->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $design->image));
            }
            $data['image'] = null;
        }

        $design->update($data);

        $design->categories()->sync($request->categories);
        if ($request->has('colors')) {
            $design->colors()->sync($request->colors);
        } else {
            $design->colors()->detach();
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Desain jersey berhasil diperbarui.']);
        }

        return redirect()->route('console.designs.index')->with('success', 'Desain jersey berhasil diperbarui.');
    }

    public function destroy(Design $design)
    {
        if ($design->image) {
            Storage::disk('public')->delete(str_replace('storage/', '', $design->image));
        }
        $design->delete();
        return redirect()->route('console.designs.index')->with('success', 'Desain jersey berhasil dihapus.');
    }
}
