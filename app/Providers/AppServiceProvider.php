<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share header settings to all frontend views and global settings to console views
        View::composer(['layouts.app', 'console.layouts.app'], function ($view) {
            $headerMenus = Menu::where('location', 'header')->orderBy('order')->get();
            $headerLogo = Setting::where('key', 'header_logo')->first()?->value;
            $ctaText = Setting::where('key', 'header_cta_text')->first()?->value ?? 'Order Now';
            $ctaUrl = Setting::where('key', 'header_cta_url')->first()?->value ?? '#';
            $ctaNewTab = Setting::where('key', 'header_cta_new_tab')->first()?->value === '1';

            // Footer Data
            $footerLogo = Setting::where('key', 'footer_logo')->first()?->value;
            $footerDesc = Setting::where('key', 'footer_description')->first()?->value;
            $footerMenu1Title = Setting::where('key', 'footer_menu_1_title')->first()?->value ?? 'Produk Kami';
            $footerMenu2Title = Setting::where('key', 'footer_menu_2_title')->first()?->value ?? 'Informasi';
            $footerContactTitle = Setting::where('key', 'footer_contact_title')->first()?->value ?? 'Hubungi Kami';
            $footerMenu1 = Menu::where('location', 'footer_1')->orderBy('order')->get();
            $footerMenu2 = Menu::where('location', 'footer_2')->orderBy('order')->get();
            $footerContact = Menu::where('location', 'footer_contact')->orderBy('order')->get();
            $footerSocial = Menu::where('location', 'footer_social')->orderBy('order')->get();

            // Global SEO & Identity
            $globalKeys = ['site_name', 'site_favicon', 'seo_title', 'seo_description', 'seo_keywords'];
            $globalSettings = Setting::whereIn('key', $globalKeys)->pluck('value', 'key')->toArray();

            $view->with(compact(
                'headerMenus', 'headerLogo', 'ctaText', 'ctaUrl', 'ctaNewTab',
                'footerLogo', 'footerDesc', 'footerMenu1Title', 'footerMenu2Title', 'footerContactTitle',
                'footerMenu1', 'footerMenu2', 'footerContact', 'footerSocial', 'globalSettings'
            ));
        });
    }
}
