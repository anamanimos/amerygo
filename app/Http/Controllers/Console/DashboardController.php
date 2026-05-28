<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Article;
use App\Models\Page;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'articles' => Article::count(),
            'pages' => Page::count(),
            'reviews' => Review::count(),
        ];

        $recentProducts = Product::with('category')->latest()->take(5)->get();
        $recentArticles = Article::with('category')->latest('published_at')->take(5)->get();

        return view('console.dashboard', compact('stats', 'recentProducts', 'recentArticles'));
    }
}
