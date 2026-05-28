<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::where('is_published', true)->with('category');
        
        if ($request->has('category')) {
            $category = ArticleCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('article_category_id', $category->id);
            }
        }
        
        $articles = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = ArticleCategory::all();
        
        return view('pages.articles.index', compact('articles', 'categories'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->where('is_published', true)->with('category')->firstOrFail();
        
        $related_articles = Article::where('article_category_id', $article->article_category_id)
            ->where('id', '!=', $article->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();
            
        return view('pages.articles.show', compact('article', 'related_articles'));
    }
}
