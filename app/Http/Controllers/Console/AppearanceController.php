<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Menu;

class AppearanceController extends Controller
{
    public function header()
    {
        $menus = Menu::where('location', 'header')->orderBy('order')->get();
        $logo = Setting::where('key', 'header_logo')->first()?->value;
        $ctaText = Setting::where('key', 'header_cta_text')->first()?->value;
        $ctaUrl = Setting::where('key', 'header_cta_url')->first()?->value;
        $ctaNewTab = Setting::where('key', 'header_cta_new_tab')->first()?->value;

        return view('console.tampilan.header', compact('menus', 'logo', 'ctaText', 'ctaUrl', 'ctaNewTab'));
    }

    public function updateHeader(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'cta_text' => 'nullable|string|max:255',
            'cta_url' => 'nullable|string|max:255',
        ]);

        // Handle cropped logo (base64)
        if ($request->filled('logo_cropped')) {
            $data = $request->logo_cropped;
            if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                $data = substr($data, strpos($data, ',') + 1);
                $ext = strtolower($type[1]);
                if ($ext === 'jpeg') $ext = 'jpg';
                $data = base64_decode($data);

                $filename = 'logo_' . time() . '.' . $ext;
                $path = 'logos/' . $filename;

                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $data);

                Setting::updateOrCreate(
                    ['key' => 'header_logo'],
                    ['value' => 'storage/' . $path]
                );
            }
        }
        // Fallback: traditional file upload
        elseif ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/logos');
            Setting::updateOrCreate(
                ['key' => 'header_logo'],
                ['value' => str_replace('public/', 'storage/', $path)]
            );
        }

        Setting::updateOrCreate(['key' => 'header_cta_text'], ['value' => $request->cta_text]);
        Setting::updateOrCreate(['key' => 'header_cta_url'], ['value' => $request->cta_url]);
        Setting::updateOrCreate(['key' => 'header_cta_new_tab'], ['value' => $request->has('cta_new_tab') || $request->cta_new_tab == '1' || $request->cta_new_tab === true ? '1' : '0']);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pengaturan header berhasil disimpan.']);
        }
        return redirect()->route('console.tampilan.header')->with('success', 'Pengaturan header berhasil disimpan.');
    }

    public function hero()
    {
        $keys = [
            'hero_title', 'hero_description', 'hero_btn1_text', 'hero_btn1_url',
            'hero_btn2_text', 'hero_btn2_url', 'hero_badge1', 'hero_badge2', 'hero_image'
        ];
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();

        return view('console.tampilan.hero', compact('settings'));
    }

    public function updateHero(Request $request)
    {
        $request->validate([
            'hero_title' => 'nullable|string',
            'hero_description' => 'nullable|string',
            'hero_btn1_text' => 'nullable|string|max:255',
            'hero_btn1_url' => 'nullable|string|max:255',
            'hero_btn2_text' => 'nullable|string|max:255',
            'hero_btn2_url' => 'nullable|string|max:255',
            'hero_badge1' => 'nullable|string|max:255',
            'hero_badge2' => 'nullable|string|max:255',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $keys = [
            'hero_title', 'hero_description', 'hero_btn1_text', 'hero_btn1_url',
            'hero_btn2_text', 'hero_btn2_url', 'hero_badge1', 'hero_badge2'
        ];

        foreach ($keys as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $request->$key]);
        }

        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('public/hero');
            Setting::updateOrCreate(
                ['key' => 'hero_image'],
                ['value' => str_replace('public/', 'storage/', $path)]
            );
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pengaturan hero berhasil disimpan.']);
        }
        return redirect()->route('console.tampilan.hero')->with('success', 'Pengaturan hero berhasil disimpan.');
    }

    public function iconList()
    {
        $iconList = Menu::where('location', 'home_icon_list')->orderBy('order')->get();
        return view('console.tampilan.icon_list', compact('iconList'));
    }

    public function shortAbout()
    {
        $keys = [
            'about_title', 'about_description', 
            'about_stat1_value', 'about_stat1_label',
            'about_stat2_value', 'about_stat2_label',
            'about_stat3_value', 'about_stat3_label',
            'about_stat4_value', 'about_stat4_label'
        ];
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();
        $checklist = Menu::where('location', 'home_about_checklist')->orderBy('order')->get();

        return view('console.tampilan.short_about', compact('settings', 'checklist'));
    }

    public function updateShortAbout(Request $request)
    {
        $keys = [
            'about_title', 'about_description', 
            'about_stat1_value', 'about_stat1_label',
            'about_stat2_value', 'about_stat2_label',
            'about_stat3_value', 'about_stat3_label',
            'about_stat4_value', 'about_stat4_label'
        ];

        foreach ($keys as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $request->$key]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pengaturan Short About berhasil disimpan.']);
        }
        return redirect()->route('console.tampilan.short-about')->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function howToOrder()
    {
        $keys = ['how_to_order_title', 'how_to_order_description'];
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();
        $steps = Menu::where('location', 'home_how_to_order')->orderBy('order')->get();

        return view('console.tampilan.how_to_order', compact('settings', 'steps'));
    }

    public function updateHowToOrder(Request $request)
    {
        $keys = ['how_to_order_title', 'how_to_order_description'];

        foreach ($keys as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $request->$key]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pengaturan Cara Pemesanan berhasil disimpan.']);
        }
        return redirect()->route('console.tampilan.how-to-order')->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function footer()
    {
        $footerMenu1 = Menu::where('location', 'footer_1')->orderBy('order')->get();
        $footerMenu2 = Menu::where('location', 'footer_2')->orderBy('order')->get();
        $footerContact = Menu::where('location', 'footer_contact')->orderBy('order')->get();
        $footerSocial = Menu::where('location', 'footer_social')->orderBy('order')->get();
        
        $logo = Setting::where('key', 'footer_logo')->first()?->value;
        $description = Setting::where('key', 'footer_description')->first()?->value;
        $menu1Title = Setting::where('key', 'footer_menu_1_title')->first()?->value ?? 'Produk Kami';
        $menu2Title = Setting::where('key', 'footer_menu_2_title')->first()?->value ?? 'Informasi';
        $contactTitle = Setting::where('key', 'footer_contact_title')->first()?->value ?? 'Hubungi Kami';
        $copyright = Setting::where('key', 'footer_copyright')->first()?->value ?? '© ' . date('Y') . ' AMERYGO SPORT. ALL RIGHTS RESERVED.';

        return view('console.tampilan.footer', compact(
            'footerMenu1', 'footerMenu2', 'footerContact', 'footerSocial',
            'logo', 'description', 'menu1Title', 'menu2Title', 'contactTitle', 'copyright'
        ));
    }

    public function updateFooter(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'nullable|string',
            'menu_1_title' => 'nullable|string|max:255',
            'menu_2_title' => 'nullable|string|max:255',
            'contact_title' => 'nullable|string|max:255',
            'copyright' => 'nullable|string|max:255',
        ]);

        if ($request->filled('logo_cropped')) {
            $data = $request->logo_cropped;
            if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                $data = substr($data, strpos($data, ',') + 1);
                $ext = strtolower($type[1]);
                if ($ext === 'jpeg') $ext = 'jpg';
                $data = base64_decode($data);

                $filename = 'footer_logo_' . time() . '.' . $ext;
                $path = 'logos/' . $filename;

                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $data);

                Setting::updateOrCreate(
                    ['key' => 'footer_logo'],
                    ['value' => 'storage/' . $path]
                );
            }
        } elseif ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/logos');
            Setting::updateOrCreate(
                ['key' => 'footer_logo'],
                ['value' => str_replace('public/', 'storage/', $path)]
            );
        }

        Setting::updateOrCreate(['key' => 'footer_description'], ['value' => $request->description]);
        Setting::updateOrCreate(['key' => 'footer_menu_1_title'], ['value' => $request->menu_1_title]);
        Setting::updateOrCreate(['key' => 'footer_menu_2_title'], ['value' => $request->menu_2_title]);
        Setting::updateOrCreate(['key' => 'footer_contact_title'], ['value' => $request->contact_title]);
        Setting::updateOrCreate(['key' => 'footer_copyright'], ['value' => $request->copyright]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pengaturan footer berhasil disimpan.']);
        }
        return redirect()->route('console.tampilan.footer')->with('success', 'Pengaturan footer berhasil disimpan.');
    }
}
