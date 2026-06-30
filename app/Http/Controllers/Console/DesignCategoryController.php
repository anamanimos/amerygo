<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\DesignCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DesignCategoryController extends Controller
{
    public function index()
    {
        $categories = DesignCategory::all();
        return view('console.design_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('console.design_categories.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $data['slug'] = Str::slug($data['name']);

        DesignCategory::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Kategori desain berhasil ditambahkan.']);
        }

        return redirect()->route('console.design_categories.index')->with('success', 'Kategori desain berhasil ditambahkan.');
    }

    public function edit(DesignCategory $design_category)
    {
        return view('console.design_categories.form', compact('design_category'));
    }

    public function update(Request $request, DesignCategory $design_category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $data['slug'] = Str::slug($data['name']);

        $design_category->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Kategori desain berhasil diperbarui.']);
        }

        return redirect()->route('console.design_categories.index')->with('success', 'Kategori desain berhasil diperbarui.');
    }

    public function destroy(DesignCategory $design_category)
    {
        $design_category->delete();
        return redirect()->route('console.design_categories.index')->with('success', 'Kategori desain berhasil dihapus.');
    }
}
