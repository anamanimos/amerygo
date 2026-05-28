<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->latest('published_at')->get();
        $currentCount = $articles->count();
        $limit = 20;
        return view('console.articles.index', compact('articles', 'currentCount', 'limit'));
    }

    public function create()
    {
        if (Article::count() >= 20) {
            return redirect()->route('console.articles.index')->with('error', 'Batas maksimal 20 artikel telah tercapai.');
        }
        $categories = ArticleCategory::all();
        return view('console.articles.form', compact('categories'));
    }

    public function store(Request $request)
    {
        if (Article::count() >= 20) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Batas maksimal 20 artikel telah tercapai.'], 403);
            }
            return redirect()->route('console.articles.index')->with('error', 'Batas maksimal 20 artikel telah tercapai.');
        }
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'article_category_id' => 'required|exists:article_categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['is_published'] = $request->has('is_published');
        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/articles');
            $data['image'] = str_replace('public/', 'storage/', $path);
        }

        Article::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Artikel berhasil ditambahkan.']);
        }

        return redirect()->route('console.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        $categories = ArticleCategory::all();
        return view('console.articles.form', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'article_category_id' => 'required|exists:article_categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['is_published'] = $request->has('is_published');
        
        if ($data['is_published'] && !$article->is_published) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::delete(str_replace('storage/', 'public/', $article->image));
            }
            $path = $request->file('image')->store('public/articles');
            $data['image'] = str_replace('public/', 'storage/', $path);
        } elseif ($request->input('avatar_remove') == '1') {
            if ($article->image) {
                Storage::delete(str_replace('storage/', 'public/', $article->image));
            }
            $data['image'] = null;
        }

        $article->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Artikel berhasil diperbarui.']);
        }

        return redirect()->route('console.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('console.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
