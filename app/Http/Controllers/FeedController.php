<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeedController extends Controller
{
    public function rss()
    {
        $siteName = Setting::where('key', 'site_name')->first()?->value ?? 'AMERYGO';
        $siteDesc = Setting::where('key', 'seo_description')->first()?->value ?? 'Premium Custom Sportswear';
        $articles = Article::where('is_published', true)->latest('published_at')->take(20)->get();
        
        return response()->view('feed.rss', compact('articles', 'siteName', 'siteDesc'))
                         ->header('Content-Type', 'text/xml');
    }
}
