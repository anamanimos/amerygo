<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <title>Sign In - Console</title>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    @php $favicon = \App\Models\Setting::where('key', 'site_favicon')->first()?->value; @endphp
    @if($favicon)
    <link rel="shortcut icon" href="{{ asset($favicon) }}" />
    @else
    <link rel="shortcut icon" href="{{ asset('metronic/assets/media/logos/favicon.ico') }}" />
    @endif
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Montserrat:ital,wght@0,700;0,800;0,900;1,900&display=swap" rel="stylesheet"/>
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
                        "outline": "#aa8a7d",
                        /* Light mode specific overrides */
                        "light-background": "#ffffff",
                        "light-surface": "#f8f9fa",
                        "light-on-surface": "#1e1e2d",
                        "light-on-surface-muted": "#a1a5b7",
                        "light-border": "#eff2f5",
                    },
                    "fontFamily": {
                        "body-md": ["Inter"],
                        "headline-lg": ["Montserrat"],
                        "headline-md": ["Montserrat"]
                    },
                    "animation": {
                        "fade-in-up": "fadeInUp 0.6s ease-out forwards",
                        "slide-in-right": "slideInRight 0.8s ease-out forwards",
                    },
                    "keyframes": {
                        "fadeInUp": {
                            "0%": { opacity: 0, transform: "translateY(20px)" },
                            "100%": { opacity: 1, transform: "translateY(0)" }
                        },
                        "slideInRight": {
                            "0%": { opacity: 0, transform: "translateX(40px)" },
                            "100%": { opacity: 1, transform: "translateX(0)" }
                        }
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
            box-shadow: 0 0 32px 4px rgba(255, 102, 0, 0.4);
        }
        .bg-pattern {
            background-image: radial-gradient(circle at 2px 2px, rgba(255, 255, 255, 0.05) 1px, transparent 0);
            background-size: 24px 24px;
        }
        html:not(.dark) .bg-pattern {
            background-image: radial-gradient(circle at 2px 2px, rgba(0, 0, 0, 0.05) 1px, transparent 0);
        }
        
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
    </style>
</head>

<body class="bg-light-background dark:bg-background text-light-on-surface dark:text-on-surface font-body-md min-h-screen flex flex-col relative bg-pattern transition-colors duration-500">
    
    <!-- Theme Switcher -->
    <button id="theme-toggle" class="absolute top-6 right-6 z-50 p-3 rounded-full bg-light-surface dark:bg-surface-container border border-light-border dark:border-surface-container-highest shadow-lg hover:scale-110 transition-transform duration-300 focus:outline-none">
        <i id="theme-toggle-dark-icon" class="ki-duotone ki-moon text-2xl text-primary-container hidden">
            <span class="path1"></span><span class="path2"></span>
        </i>
        <i id="theme-toggle-light-icon" class="ki-duotone ki-sun text-2xl text-primary-container hidden">
            <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span>
        </i>
    </button>

    <div class="flex-grow flex items-center justify-center min-h-screen p-4 md:p-8 relative z-10">
        
        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-0 bg-light-surface dark:bg-surface-container border border-light-border dark:border-surface-container-highest rounded-[2rem] overflow-hidden shadow-2xl opacity-0 animate-fade-in-up">
            
            <!-- Left Side - Form -->
            <div class="p-8 md:p-12 lg:p-16 flex flex-col justify-center relative">
                <div class="mb-10 text-center lg:text-left opacity-0 animate-slide-in-right delay-100">
                    <!-- Mobile Logo (Shows on small, hides on lg) -->
                    <a href="/" class="inline-block lg:hidden mb-6">
                        @php 
                            $logoLight = \App\Models\Setting::where('key', 'site_logo_light')->first()?->value; 
                            $logoDark = \App\Models\Setting::where('key', 'site_logo_dark')->first()?->value; 
                        @endphp
                        @if($logoLight || $logoDark)
                            <img alt="Logo" src="{{ asset($logoLight ?? $logoDark) }}" class="h-16 mx-auto dark:hidden" />
                            <img alt="Logo" src="{{ asset($logoDark ?? $logoLight) }}" class="h-16 mx-auto hidden dark:block" />
                        @else
                            <span class="font-headline-lg font-black text-3xl text-primary-container italic">AMERYGO</span>
                        @endif
                    </a>
                    
                    <h1 class="font-headline-lg font-black text-3xl md:text-4xl text-primary-container tracking-tight mb-2">Welcome Back</h1>
                    <p class="text-sm text-light-on-surface-muted dark:text-on-secondary-container opacity-70">Sign in to your console to manage your website.</p>
                </div>
                
                <form class="flex flex-col gap-6" method="POST" action="{{ route('console.login.post') }}">
                    @csrf
                    
                    <!-- Email Field -->
                    <div class="flex flex-col gap-2 opacity-0 animate-slide-in-right delay-200">
                        <label class="text-sm font-semibold ml-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-light-on-surface-muted dark:text-on-secondary-container">
                                <i class="ki-duotone ki-sms text-xl">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </div>
                            <input type="email" placeholder="name@example.com" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="bg-light-background dark:bg-background border-light-border dark:border-surface-container-highest text-light-on-surface dark:text-on-surface border rounded-xl w-full py-3.5 pl-12 pr-4 focus:outline-none focus:ring-2 focus:ring-primary-container focus:border-transparent transition-all duration-300 shadow-sm @error('email') ring-2 ring-error border-transparent @enderror" />
                        </div>
                        @error('email')
                            <p class="text-error text-xs ml-1 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password Field -->
                    <div class="flex flex-col gap-2 opacity-0 animate-slide-in-right delay-300">
                        <label class="text-sm font-semibold ml-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-light-on-surface-muted dark:text-on-secondary-container">
                                <i class="ki-duotone ki-lock-2 text-xl">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
                                </i>
                            </div>
                            <input type="password" placeholder="••••••••" name="password" required autocomplete="current-password" class="bg-light-background dark:bg-background border-light-border dark:border-surface-container-highest text-light-on-surface dark:text-on-surface border rounded-xl w-full py-3.5 pl-12 pr-12 focus:outline-none focus:ring-2 focus:ring-primary-container focus:border-transparent transition-all duration-300 shadow-sm @error('password') ring-2 ring-error border-transparent @enderror" id="password" />
                            
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-4 flex items-center text-light-on-surface-muted dark:text-on-secondary-container hover:text-primary-container transition-colors focus:outline-none">
                                <i class="ki-duotone ki-eye text-xl" id="eye-icon">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                </i>
                                <i class="ki-duotone ki-eye-slash text-xl hidden" id="eye-slash-icon">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
                                </i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-error text-xs ml-1 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="mt-4 opacity-0 animate-slide-in-right delay-300" style="animation-delay: 400ms;">
                        <button type="submit" class="w-full bg-primary-container text-white font-bold rounded-xl py-3.5 flex justify-center items-center gap-2 hover:bg-[#e65c00] active:scale-95 transition-all duration-300 glow-primary glow-primary-hover group">
                            <span>Sign In</span>
                            <i class="ki-duotone ki-entrance-left text-xl group-hover:translate-x-1 transition-transform">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Right Side - Graphic/Branding -->
            <div class="hidden lg:flex flex-col justify-center items-center relative overflow-hidden bg-[#fafafa] dark:bg-surface-container-lowest p-12">
                <!-- Background decorative elements -->
                <div class="absolute inset-0 bg-primary-container/5 mix-blend-overlay"></div>
                <div class="absolute -top-[20%] -right-[20%] w-[70%] h-[70%] rounded-full bg-primary-container/20 blur-[100px] pointer-events-none"></div>
                <div class="absolute -bottom-[20%] -left-[20%] w-[70%] h-[70%] rounded-full bg-primary-container/10 blur-[80px] pointer-events-none"></div>
                
                <a href="/" class="relative z-10 mb-8 transform hover:scale-105 transition-transform duration-500">
                    @if($logoLight || $logoDark)
                        <img alt="Logo" src="{{ asset($logoLight ?? $logoDark) }}" class="h-24 filter drop-shadow-2xl dark:hidden" />
                        <img alt="Logo" src="{{ asset($logoDark ?? $logoLight) }}" class="h-24 filter drop-shadow-2xl hidden dark:block" />
                    @else
                        <span class="font-headline-lg font-black text-6xl text-primary-container italic filter drop-shadow-2xl">AMERYGO</span>
                    @endif
                </a>
                
                <div class="relative z-10 text-center mt-8">
                    <h2 class="font-headline-md font-bold text-2xl text-light-on-surface dark:text-on-surface mb-4">Premium Custom Sportswear</h2>
                    <p class="text-light-on-surface-muted dark:text-on-secondary-container max-w-sm mx-auto">Manage your catalog, orders, articles, and customize your storefront experience all from one place.</p>
                </div>
                
                <!-- Floating Icons -->
                <div class="absolute top-1/4 left-1/4 animate-bounce" style="animation-duration: 3s;">
                    <i class="ki-duotone ki-shop text-4xl text-primary-container/50"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                </div>
                <div class="absolute bottom-1/4 right-1/4 animate-bounce" style="animation-duration: 4s; animation-delay: 1s;">
                    <i class="ki-duotone ki-chart-pie-3 text-4xl text-primary-container/50"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </div>

                <!-- Footer Artspace -->
                <div class="absolute bottom-6 w-full text-center flex flex-col items-center justify-center gap-2 opacity-80 hover:opacity-100 transition-opacity z-10">
                    <div class="flex items-center justify-center gap-1.5 text-xs text-light-on-surface-muted dark:text-on-secondary-container">
                        <span>Crafted with</span>
                        <i class="ki-duotone ki-heart text-error text-base"><span class="path1"></span><span class="path2"></span></i>
                        <span>by</span>
                    </div>
                    <a href="https://artspaceproduction.my.id" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('assets/logos/logo_1.png') }}" class="h-8 filter drop-shadow-md dark:hidden" alt="Artspace Production">
                        <img src="{{ asset('assets/logos/logo_2.png') }}" class="h-8 filter drop-shadow-md hidden dark:block" alt="Artspace Production">
                    </a>
                </div>
            </div>
            
        </div>
        
    </div>

    <script>
        // Password Visibility Toggle
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeSlashIcon = document.getElementById('eye-slash-icon');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'text') {
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        });

        // Dark/Light Mode Toggle Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        const themeStorageKey = 'data-bs-theme';

        // Check current theme
        if (localStorage.getItem(themeStorageKey) === 'dark' || (!localStorage.getItem(themeStorageKey) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
            document.documentElement.classList.add('dark');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
            document.documentElement.classList.remove('dark');
        }

        themeToggleBtn.addEventListener('click', function() {
            // Toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // If is set in localStorage
            if (localStorage.getItem(themeStorageKey)) {
                if (localStorage.getItem(themeStorageKey) === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem(themeStorageKey, 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem(themeStorageKey, 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem(themeStorageKey, 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem(themeStorageKey, 'dark');
                }
            }
        });
    </script>
</body>
</html>