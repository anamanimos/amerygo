<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $pricings = \App\Models\Pricing::all();
    
    $heroKeys = [
        'hero_title', 'hero_description', 'hero_btn1_text', 'hero_btn1_url',
        'hero_btn2_text', 'hero_btn2_url', 'hero_badge1', 'hero_badge2', 'hero_image'
    ];
    $heroSettings = \App\Models\Setting::whereIn('key', $heroKeys)->pluck('value', 'key')->toArray();

    $iconList = \App\Models\Menu::where('location', 'home_icon_list')->orderBy('order')->get();
    
    $aboutKeys = [
        'about_title', 'about_description', 
        'about_stat1_value', 'about_stat1_label',
        'about_stat2_value', 'about_stat2_label',
        'about_stat3_value', 'about_stat3_label',
        'about_stat4_value', 'about_stat4_label'
    ];
    $aboutSettings = \App\Models\Setting::whereIn('key', $aboutKeys)->pluck('value', 'key')->toArray();
    $aboutChecklist = \App\Models\Menu::where('location', 'home_about_checklist')->orderBy('order')->get();
    
    $howToOrderKeys = ['how_to_order_title', 'how_to_order_description'];
    $howToOrderSettings = \App\Models\Setting::whereIn('key', $howToOrderKeys)->pluck('value', 'key')->toArray();
    $howToOrderSteps = \App\Models\Menu::where('location', 'home_how_to_order')->orderBy('order')->get();

    $reviews = \App\Models\Review::where('is_active', true)->get();
    
    $articles = \App\Models\Article::where('is_published', true)->with('category')->latest('published_at')->take(3)->get();
    
    $featuredProducts = \App\Models\Product::where('is_active', true)->where('is_featured', true)->with('category', 'images')->latest()->take(4)->get();

    return view('pages.home', compact('pricings', 'heroSettings', 'iconList', 'aboutSettings', 'aboutChecklist', 'howToOrderSettings', 'howToOrderSteps', 'reviews', 'articles', 'featuredProducts'));
})->name('home');

Route::get('/products', [\App\Http\Controllers\Frontend\ProductController::class, 'index'])->name('products');
Route::get('/products/{slug}', [\App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('products.show');

Route::get('/designs', [\App\Http\Controllers\Frontend\DesignController::class, 'index'])->name('designs');
Route::get('/designs/{slug}', [\App\Http\Controllers\Frontend\DesignController::class, 'show'])->name('designs.show');

Route::get('/articles', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles');
Route::get('/articles/{slug}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');

Route::get('/feed', [\App\Http\Controllers\FeedController::class, 'rss'])->name('feed');


Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/faq', function () {
    return view('pages.faq');
})->name('faq');

Route::get('/404', function () {
    return view('errors.404');
})->name('404');

// Fallback for custom 404
use App\Http\Controllers\Console\AuthController;

Route::get('/pages/{slug}', [\App\Http\Controllers\Frontend\PageController::class, 'show'])->name('pages.show');

Route::prefix('console')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->name('console.login.post')->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout'])->name('console.logout')->middleware('auth');

    Route::middleware('auth')->group(function () {
        Route::get('/', [\App\Http\Controllers\Console\DashboardController::class, 'index'])->name('console.dashboard');

        Route::prefix('settings')->name('console.settings.')->group(function () {
            Route::get('/global', [\App\Http\Controllers\Console\SettingController::class, 'global'])->name('global');
            Route::post('/global', [\App\Http\Controllers\Console\SettingController::class, 'updateGlobal'])->name('global.update');
        });

        Route::prefix('tampilan')->name('console.tampilan.')->group(function () {
            Route::get('/', function () {
                return redirect()->route('console.tampilan.header');
            })->name('index');
            
            Route::get('/header', [\App\Http\Controllers\Console\AppearanceController::class, 'header'])->name('header');
            Route::post('/header', [\App\Http\Controllers\Console\AppearanceController::class, 'updateHeader'])->name('header.update');
            
            Route::get('/hero', [\App\Http\Controllers\Console\AppearanceController::class, 'hero'])->name('hero');
            Route::post('/hero', [\App\Http\Controllers\Console\AppearanceController::class, 'updateHero'])->name('hero.update');
            Route::get('/icon-list', [\App\Http\Controllers\Console\AppearanceController::class, 'iconList'])->name('icon-list');
            Route::get('/short-about', [\App\Http\Controllers\Console\AppearanceController::class, 'shortAbout'])->name('short-about');
            Route::post('/short-about', [\App\Http\Controllers\Console\AppearanceController::class, 'updateShortAbout'])->name('short-about.update');
            Route::get('/how-to-order', [\App\Http\Controllers\Console\AppearanceController::class, 'howToOrder'])->name('how-to-order');
            Route::post('/how-to-order', [\App\Http\Controllers\Console\AppearanceController::class, 'updateHowToOrder'])->name('how-to-order.update');

            Route::get('/footer', [\App\Http\Controllers\Console\AppearanceController::class, 'footer'])->name('footer');
            Route::post('/footer', [\App\Http\Controllers\Console\AppearanceController::class, 'updateFooter'])->name('footer.update');
            
            Route::post('/menu', [\App\Http\Controllers\Console\MenuController::class, 'store'])->name('menu.store');
            Route::post('/menu/update-all', [\App\Http\Controllers\Console\MenuController::class, 'updateAll'])->name('menu.updateAll');
            Route::delete('/menu/{id}', [\App\Http\Controllers\Console\MenuController::class, 'destroy'])->name('menu.destroy');
            Route::post('/menu/reorder', [\App\Http\Controllers\Console\MenuController::class, 'reorder'])->name('menu.reorder');
            
        });

        Route::resource('pricings', \App\Http\Controllers\Console\PricingController::class)->names([
            'index' => 'console.pricings.index',
            'create' => 'console.pricings.create',
            'store' => 'console.pricings.store',
            'show' => 'console.pricings.show',
            'edit' => 'console.pricings.edit',
            'update' => 'console.pricings.update',
            'destroy' => 'console.pricings.destroy',
        ]);

        Route::resource('reviews', \App\Http\Controllers\Console\ReviewController::class)->names([
            'index' => 'console.reviews.index',
            'create' => 'console.reviews.create',
            'store' => 'console.reviews.store',
            'show' => 'console.reviews.show',
            'edit' => 'console.reviews.edit',
            'update' => 'console.reviews.update',
            'destroy' => 'console.reviews.destroy',
        ]);

        Route::resource('article-categories', \App\Http\Controllers\Console\ArticleCategoryController::class)->names([
            'index' => 'console.article_categories.index',
            'create' => 'console.article_categories.create',
            'store' => 'console.article_categories.store',
            'show' => 'console.article_categories.show',
            'edit' => 'console.article_categories.edit',
            'update' => 'console.article_categories.update',
            'destroy' => 'console.article_categories.destroy',
        ]);

        Route::resource('articles', \App\Http\Controllers\Console\ArticleController::class)->names([
            'index' => 'console.articles.index',
            'create' => 'console.articles.create',
            'store' => 'console.articles.store',
            'show' => 'console.articles.show',
            'edit' => 'console.articles.edit',
            'update' => 'console.articles.update',
            'destroy' => 'console.articles.destroy',
        ]);

        Route::resource('pages', \App\Http\Controllers\Console\PageController::class)->except(['show'])->names([
            'index' => 'console.pages.index',
            'create' => 'console.pages.create',
            'store' => 'console.pages.store',
            'edit' => 'console.pages.edit',
            'update' => 'console.pages.update',
            'destroy' => 'console.pages.destroy',
        ]);

        Route::resource('product-categories', \App\Http\Controllers\Console\ProductCategoryController::class)->names([
            'index' => 'console.product_categories.index',
            'create' => 'console.product_categories.create',
            'store' => 'console.product_categories.store',
            'show' => 'console.product_categories.show',
            'edit' => 'console.product_categories.edit',
            'update' => 'console.product_categories.update',
            'destroy' => 'console.product_categories.destroy',
        ]);

        Route::resource('products', \App\Http\Controllers\Console\ProductController::class)->names([
            'index' => 'console.products.index',
            'create' => 'console.products.create',
            'store' => 'console.products.store',
            'show' => 'console.products.show',
            'edit' => 'console.products.edit',
            'update' => 'console.products.update',
            'destroy' => 'console.products.destroy',
        ]);

        Route::resource('design-categories', \App\Http\Controllers\Console\DesignCategoryController::class)->names([
            'index' => 'console.design_categories.index',
            'create' => 'console.design_categories.create',
            'store' => 'console.design_categories.store',
            'show' => 'console.design_categories.show',
            'edit' => 'console.design_categories.edit',
            'update' => 'console.design_categories.update',
            'destroy' => 'console.design_categories.destroy',
        ]);

        Route::resource('colors', \App\Http\Controllers\Console\ColorController::class)->names([
            'index' => 'console.colors.index',
            'create' => 'console.colors.create',
            'store' => 'console.colors.store',
            'show' => 'console.colors.show',
            'edit' => 'console.colors.edit',
            'update' => 'console.colors.update',
            'destroy' => 'console.colors.destroy',
        ]);

        Route::post('designs/bulk-action', \App\Http\Controllers\Console\DesignController::class . '@bulkAction')->name('console.designs.bulk-action');
        Route::resource('designs', \App\Http\Controllers\Console\DesignController::class)->names([
            'index' => 'console.designs.index',
            'create' => 'console.designs.create',
            'store' => 'console.designs.store',
            'show' => 'console.designs.show',
            'edit' => 'console.designs.edit',
            'update' => 'console.designs.update',
            'destroy' => 'console.designs.destroy',
        ]);
        
        Route::resource('users', \App\Http\Controllers\Console\UserController::class)->except(['show'])->names([
            'index' => 'console.users.index',
            'create' => 'console.users.create',
            'store' => 'console.users.store',
            'edit' => 'console.users.edit',
            'update' => 'console.users.update',
            'destroy' => 'console.users.destroy',
        ]);
    });
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
