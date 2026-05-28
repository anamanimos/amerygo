<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleCategoryController extends Controller
{
    public function index()
    {
        $categories = ArticleCategory::all();
        return view('console.article_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('console.article_categories.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $data['slug'] = Str::slug($data['name']);

        ArticleCategory::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil ditambahkan.']);
        }

        return redirect()->route('console.article_categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(ArticleCategory $article_category)
    {
        return view('console.article_categories.form', compact('article_category'));
    }

    public function update(Request $request, ArticleCategory $article_category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $data['slug'] = Str::slug($data['name']);

        $article_category->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil diperbarui.']);
        }

        return redirect()->route('console.article_categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(ArticleCategory $article_category)
    {
        $article_category->delete();
        return redirect()->route('console.article_categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
