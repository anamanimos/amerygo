@php
    $resolveAssetUrl = function ($path) {
        if (empty($path)) return '';
        if (str_starts_with($path, 'uploads/')) {
            return asset($path);
        }
        if (str_starts_with($path, 'storage/')) {
            return Storage::disk('public')->url(str_replace('storage/', '', $path));
        }
        return asset($path);
    };

    $headerLogoUrl = $resolveAssetUrl($headerLogo ?? '');
    $footerLogoUrl = $resolveAssetUrl($footerLogo ?? '');
    $faviconUrl = isset($globalSettings['site_favicon']) ? $resolveAssetUrl($globalSettings['site_favicon']) : '';
@endphp
<!DOCTYPE html>
<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>{{ $globalSettings['site_name'] ?? 'AMERYGO' }} - {{ $globalSettings['seo_title'] ?? 'Premium Custom Sportswear' }}</title>
@if(!empty($globalSettings['seo_description']))
<meta name="description" content="{{ $globalSettings['seo_description'] }}">
@endif
@if(!empty($globalSettings['seo_keywords']))
<meta name="keywords" content="{{ $globalSettings['seo_keywords'] }}">
@endif
@if(!empty($globalSettings['site_favicon']))
<link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
@else
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
@endif
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&amp;family=Montserrat:ital,wght@0,700;0,800;0,900;1,900&amp;display=swap" rel="stylesheet"/>
<link href="{{ asset('metronic/assets/plugins/global/keenicons.css') }}" rel="stylesheet" type="text/css" />
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-primary": "#581e00",
                        "tertiary-fixed": "#d0e4ff",
                        "background": "#131313",
                        "surface-container-highest": "#353534",
                        "on-secondary-container": "#b7b5b4",
                        "surface-container-lowest": "#0e0e0e",
                        "on-surface": "#e5e2e1",
                        "on-primary-container": "#561d00",
                        "secondary-fixed": "#e5e2e1",
                        "surface-tint": "#ffb596",
                        "secondary-fixed-dim": "#c8c6c5",
                        "on-secondary-fixed-variant": "#474746",
                        "on-primary-fixed-variant": "#7c2e00",
                        "surface-container-low": "#1c1b1b",
                        "primary-container": "#ff6600",
                        "on-secondary": "#313030",
                        "tertiary-fixed-dim": "#9ccaff",
                        "secondary": "#c8c6c5",
                        "surface": "#131313",
                        "on-tertiary-container": "#003155",
                        "inverse-surface": "#e5e2e1",
                        "primary-fixed": "#ffdbcd",
                        "inverse-primary": "#a33e00",
                        "surface-container": "#201f1f",
                        "surface-bright": "#3a3939",
                        "error-container": "#93000a",
                        "on-secondary-fixed": "#1b1b1b",
                        "on-error": "#690005",
                        "surface-dim": "#131313",
                        "primary-fixed-dim": "#ffb596",
                        "on-surface-variant": "#e3bfb1",
                        "on-background": "#e5e2e1",
                        "on-error-container": "#ffdad6",
                        "on-tertiary-fixed-variant": "#00497b",
                        "error": "#ffb4ab",
                        "surface-variant": "#353534",
                        "on-tertiary-fixed": "#001d35",
                        "tertiary-container": "#009cfc",
                        "secondary-container": "#474746",
                        "tertiary": "#9ccaff",
                        "on-tertiary": "#003256",
                        "on-primary-fixed": "#360f00",
                        "outline-variant": "#5a4136",
                        "surface-container-high": "#2a2a2a",
                        "primary": "#ffb596",
                        "inverse-on-surface": "#313030",
                        "outline": "#aa8a7d"
                    },
                    "fontFamily": {
                        "label-caps": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg": ["Montserrat"],
                        "body-md": ["Inter"],
                        "display-xl": ["Montserrat"],
                        "headline-lg-mobile": ["Montserrat"],
                        "headline-md": ["Montserrat"]
                    },
                    "maxWidth": {
                        "container-max": "1280px"
                    },
                    "spacing": {
                        "sm": "0.5rem",
                        "md": "1.5rem",
                        "lg": "2.5rem",
                        "xl": "5rem"
                    }
                }
            }
        }
    </script>
<style>
        .glow-primary {
            box-shadow: 0 0 32px 4px rgba(255, 102, 0, 0.2);
        }
        .glow-primary-hover:hover {
            box-shadow: 0 0 32px 4px rgba(255, 102, 0, 0.3);
        }
        .text-glow {
            text-shadow: 0 0 16px rgba(255, 102, 0, 0.5);
        }
        .bg-pattern {
            background-image: radial-gradient(circle at 2px 2px, rgba(255, 255, 255, 0.05) 1px, transparent 0);
            background-size: 24px 24px;
        }
        body {
          min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background text-on-surface font-body-md min-h-screen flex flex-col relative bg-pattern">
<header class="fixed top-0 w-full z-50 bg-background/90 backdrop-blur-lg border-b border-surface-container-highest shadow-xl shadow-primary-container/10 transition-all duration-300">
    <div class="flex justify-between items-center px-6 md:px-12 h-20 w-full max-w-container-max mx-auto">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center hover:opacity-80 transition-opacity">
            @if(!empty($headerLogo))
                <img src="{{ $headerLogoUrl }}" alt="Logo" class="h-10 md:h-12">
            @else
                <span class="font-headline-lg font-black text-primary-container tracking-tighter italic">AMERYGO</span>
            @endif
        </a>
        
        <!-- Desktop Nav -->
        <nav class="hidden md:flex gap-8 items-center">
            @forelse($headerMenus as $hMenu)
                <a class="text-on-surface font-medium hover:text-primary-container transition-colors duration-300" href="{{ $hMenu->url ?? '#' }}" {{ $hMenu->is_new_tab ? 'target="_blank" rel="noopener noreferrer"' : '' }}>{{ $hMenu->label }}</a>
            @empty
                <a class="{{ request()->routeIs('home') ? 'text-primary-container font-bold relative after:content-[\'\'] after:absolute after:-bottom-2 after:left-0 after:w-full after:h-0.5 after:bg-primary-container' : 'text-on-surface font-medium hover:text-primary-container transition-colors duration-300' }}" href="{{ route('home') }}">Home</a>
                <a class="{{ request()->routeIs('products') ? 'text-primary-container font-bold relative after:content-[\'\'] after:absolute after:-bottom-2 after:left-0 after:w-full after:h-0.5 after:bg-primary-container' : 'text-on-surface font-medium hover:text-primary-container transition-colors duration-300' }}" href="{{ route('products') }}">Shop All</a>
                <a class="{{ request()->routeIs('designs') ? 'text-primary-container font-bold relative after:content-[\'\'] after:absolute after:-bottom-2 after:left-0 after:w-full after:h-0.5 after:bg-primary-container' : 'text-on-surface font-medium hover:text-primary-container transition-colors duration-300' }}" href="{{ route('designs') }}">Katalog</a>
                <a class="{{ request()->routeIs('articles') ? 'text-primary-container font-bold relative after:content-[\'\'] after:absolute after:-bottom-2 after:left-0 after:w-full after:h-0.5 after:bg-primary-container' : 'text-on-surface font-medium hover:text-primary-container transition-colors duration-300' }}" href="{{ route('articles') }}">Artikel</a>
                <a class="{{ request()->routeIs('contact') ? 'text-primary-container font-bold relative after:content-[\'\'] after:absolute after:-bottom-2 after:left-0 after:w-full after:h-0.5 after:bg-primary-container' : 'text-on-surface font-medium hover:text-primary-container transition-colors duration-300' }}" href="{{ route('contact') }}">Kontak</a>
            @endforelse
            @if(!empty($ctaText))
                <a class="ml-4 px-6 py-2.5 bg-primary-container text-background font-bold rounded-full hover:bg-[#e65c00] hover:scale-105 active:scale-95 transition-all duration-300 glow-primary" href="{{ $ctaUrl ?? '#' }}" {{ $ctaNewTab ? 'target="_blank" rel="noopener noreferrer"' : '' }}>{{ $ctaText }}</a>
            @endif
        </nav>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" aria-label="Toggle Menu" class="md:hidden text-on-surface hover:text-primary-container focus:outline-none transition-colors duration-300 p-2">
            <span class="material-symbols-rounded text-3xl" id="menu-icon">menu</span>
        </button>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/60 z-[55] hidden opacity-0 transition-opacity duration-300 md:hidden"></div>

    <!-- Mobile Nav Sidebar -->
    <div id="mobile-menu" class="fixed top-0 left-0 h-screen w-4/5 max-w-sm bg-background/95 backdrop-blur-xl border-r border-surface-container-highest shadow-2xl z-[60] transform -translate-x-full transition-transform duration-300 md:hidden flex flex-col">
        <div class="flex justify-between items-center px-6 h-20 border-b border-surface-container-highest shrink-0">
            @if(!empty($headerLogo))
                <img src="{{ $headerLogoUrl }}" alt="Logo" class="h-8">
            @else
                <span class="font-headline-lg font-black text-primary-container tracking-tighter italic">AMERYGO</span>
            @endif
            <button id="close-menu-btn" aria-label="Close Menu" class="text-on-surface hover:text-primary-container transition-colors duration-300 p-2 focus:outline-none">
                <span class="material-symbols-rounded text-3xl">close</span>
            </button>
        </div>
        <nav class="flex flex-col gap-6 py-8 px-6 overflow-y-auto">
            @forelse($headerMenus as $hMenu)
                <a class="text-on-surface font-medium text-xl hover:text-primary-container transition-colors border-b border-surface-container-highest pb-4" href="{{ $hMenu->url ?? '#' }}" {{ $hMenu->is_new_tab ? 'target="_blank" rel="noopener noreferrer"' : '' }}>{{ $hMenu->label }}</a>
            @empty
                <a class="{{ request()->routeIs('home') ? 'text-primary-container font-bold' : 'text-on-surface font-medium' }} text-xl hover:text-primary-container transition-colors border-b border-surface-container-highest pb-4" href="{{ route('home') }}">Home</a>
                <a class="{{ request()->routeIs('products') ? 'text-primary-container font-bold' : 'text-on-surface font-medium' }} text-xl hover:text-primary-container transition-colors border-b border-surface-container-highest pb-4" href="{{ route('products') }}">Shop All</a>
                <a class="{{ request()->routeIs('designs') ? 'text-primary-container font-bold' : 'text-on-surface font-medium' }} text-xl hover:text-primary-container transition-colors border-b border-surface-container-highest pb-4" href="{{ route('designs') }}">Katalog</a>
                <a class="{{ request()->routeIs('articles') ? 'text-primary-container font-bold' : 'text-on-surface font-medium' }} text-xl hover:text-primary-container transition-colors border-b border-surface-container-highest pb-4" href="{{ route('articles') }}">Artikel</a>
                <a class="{{ request()->routeIs('contact') ? 'text-primary-container font-bold' : 'text-on-surface font-medium' }} text-xl hover:text-primary-container transition-colors border-b border-surface-container-highest pb-4" href="{{ route('contact') }}">Kontak</a>
            @endforelse
            @if(!empty($ctaText))
                <a class="mt-4 px-8 py-3 w-full text-center bg-primary-container text-background font-bold rounded-full hover:bg-[#e65c00] active:scale-95 transition-all duration-300 glow-primary" href="{{ $ctaUrl ?? '#' }}" {{ $ctaNewTab ? 'target="_blank" rel="noopener noreferrer"' : '' }}>{{ $ctaText }}</a>
            @endif
        </nav>
    </div>
</header>

@yield('content')

<footer class="bg-surface-container-lowest border-t border-surface-container-highest w-full pt-xl pb-8 mt-xl">
<div class="max-w-container-max mx-auto px-4 md:px-md">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
<!-- Brand Col -->
<div class="flex flex-col gap-6">
    <a href="{{ route('home') }}" class="flex items-center hover:opacity-80 transition-opacity">
        @if(!empty($footerLogo))
            <img src="{{ $footerLogoUrl }}" alt="Footer Logo" class="h-10 md:h-12">
        @else
            <div class="font-headline-lg text-headline-md font-black text-primary-container italic tracking-tighter">AMERYGO</div>
        @endif
    </a>
    <p class="text-on-secondary-container text-sm leading-relaxed">
        {{ $footerDesc ?? 'Produsen pakaian olahraga custom premium terpercaya di Indonesia.' }}
    </p>
    <div class="flex gap-4 mt-2">
        @if(isset($footerSocial) && $footerSocial->count() > 0)
            @foreach($footerSocial as $social)
                <a class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface hover:bg-primary-container hover:text-background transition-colors" href="{{ $social->url ?? '#' }}" {{ $social->is_new_tab ? 'target="_blank" rel="noopener noreferrer"' : '' }} aria-label="{{ $social->label }}">
                    @if($social->icon)
                        <i class="ki-duotone ki-{{ $social->icon }} text-xl"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                    @else
                        <span class="font-bold">{{ substr($social->label, 0, 1) }}</span>
                    @endif
                </a>
            @endforeach
        @endif
    </div>
</div>
<!-- Links 1 -->
<div class="flex flex-col gap-4">
    <h4 class="font-bold text-lg text-on-surface mb-2">{{ $footerMenu1Title }}</h4>
    @foreach($footerMenu1 as $item)
        <a class="text-on-secondary-container hover:text-primary-container transition-colors text-sm" href="{{ $item->url ?? '#' }}" {{ $item->is_new_tab ? 'target="_blank" rel="noopener noreferrer"' : '' }}>{{ $item->label }}</a>
    @endforeach
</div>
<!-- Links 2 -->
<div class="flex flex-col gap-4">
    <h4 class="font-bold text-lg text-on-surface mb-2">{{ $footerMenu2Title }}</h4>
    @foreach($footerMenu2 as $item)
        <a class="text-on-secondary-container hover:text-primary-container transition-colors text-sm" href="{{ $item->url ?? '#' }}" {{ $item->is_new_tab ? 'target="_blank" rel="noopener noreferrer"' : '' }}>{{ $item->label }}</a>
    @endforeach
</div>
<!-- Contact -->
<div class="flex flex-col gap-4">
    <h4 class="font-bold text-lg text-on-surface mb-2">{{ $footerContactTitle }}</h4>
    @foreach($footerContact as $item)
        <div class="flex items-start gap-3 text-on-secondary-container text-sm mt-2">
            @if($item->icon)
                <i class="ki-duotone ki-{{ $item->icon }} text-primary-container text-2xl shrink-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
            @endif
            @if($item->url && $item->url !== '#')
                <a href="{{ $item->url }}" class="hover:text-primary-container transition-colors" {{ $item->is_new_tab ? 'target="_blank" rel="noopener noreferrer"' : '' }}>{{ $item->label }}</a>
            @else
                <p>{{ $item->label }}</p>
            @endif
        </div>
    @endforeach
</div>
</div>
<div class="pt-8 border-t border-surface-container-highest flex flex-col md:flex-row justify-between items-center gap-4">
<div class="font-body-md text-sm text-on-secondary-container">
            {{ \App\Models\Setting::where('key', 'footer_copyright')->first()?->value ?? '© ' . date('Y') . ' AMERYGO SPORT. ALL RIGHTS RESERVED.' }}
        </div>
<div class="flex items-center gap-2 text-sm text-on-secondary-container">
    <span>Crafted with</span>
    <i class="ki-duotone ki-heart text-error text-lg"><span class="path1"></span><span class="path2"></span></i>
    <span>by</span>
    <a href="https://artspaceproduction.my.id" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity flex items-center">
        <img src="{{ asset('assets/logos/logo_2.png') }}" class="h-12" alt="Artspace Production">
    </a>
</div>
</div>
</div>
</footer>

<script>
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const closeMenuBtn = document.getElementById('close-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

    function openMenu() {
        mobileMenuOverlay.classList.remove('hidden');
        // trigger reflow to enable transition
        void mobileMenuOverlay.offsetWidth;
        mobileMenuOverlay.classList.remove('opacity-0');
        mobileMenu.classList.remove('-translate-x-full');
    }

    function closeMenu() {
        mobileMenu.classList.add('-translate-x-full');
        mobileMenuOverlay.classList.add('opacity-0');
        setTimeout(() => {
            mobileMenuOverlay.classList.add('hidden');
        }, 300);
    }

    mobileMenuBtn.addEventListener('click', openMenu);
    closeMenuBtn.addEventListener('click', closeMenu);
    mobileMenuOverlay.addEventListener('click', closeMenu);
</script>
@stack('scripts')
</body>
</html>