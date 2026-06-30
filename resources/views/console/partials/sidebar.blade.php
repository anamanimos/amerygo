<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    @php
        $siteLogoDark = \App\Models\Setting::where('key', 'site_logo_dark')->value('value');
        $siteLogoLight = \App\Models\Setting::where('key', 'site_logo_light')->value('value');
        
        // Fallback jika salah satu kosong
        $activeLogoDark = $siteLogoDark ?: $siteLogoLight;
        $activeLogoLight = $siteLogoLight ?: $siteLogoDark;

        $siteLogoSmDark = \App\Models\Setting::where('key', 'site_logo_sm_dark')->value('value');
        $siteLogoSmLight = \App\Models\Setting::where('key', 'site_logo_sm_light')->value('value');
        
        $activeLogoSmDark = $siteLogoSmDark ?: $siteLogoSmLight;
        $activeLogoSmLight = $siteLogoSmLight ?: $siteLogoSmDark;
    @endphp
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('console.dashboard') }}">
            <!-- Tampilan Normal (Tidak Minimize) -->
            @if($activeLogoDark)
                <img alt="Logo" src="{{ asset($activeLogoDark) }}" class="h-30px app-sidebar-logo-default theme-dark-show" style="max-width: 150px; object-fit: contain;" />
            @else
                <img alt="Logo" src="{{ asset('metronic/assets/media/logos/default-dark.svg') }}" class="h-25px app-sidebar-logo-default theme-dark-show" />
            @endif
            
            @if($activeLogoLight)
                <img alt="Logo" src="{{ asset($activeLogoLight) }}" class="h-30px app-sidebar-logo-default theme-light-show" style="max-width: 150px; object-fit: contain;" />
            @else
                <img alt="Logo" src="{{ asset('metronic/assets/media/logos/default.svg') }}" class="h-25px app-sidebar-logo-default theme-light-show" />
            @endif

            <!-- Tampilan Minimize (Icon) -->
            @if($activeLogoSmDark)
                <img alt="Logo" src="{{ asset($activeLogoSmDark) }}" class="h-30px app-sidebar-logo-minimize theme-dark-show" />
            @else
                <img alt="Logo" src="{{ asset('metronic/assets/media/logos/default-small.svg') }}" class="h-20px app-sidebar-logo-minimize theme-dark-show" />
            @endif
            
            @if($activeLogoSmLight)
                <img alt="Logo" src="{{ asset($activeLogoSmLight) }}" class="h-30px app-sidebar-logo-minimize theme-light-show" />
            @else
                <img alt="Logo" src="{{ asset('metronic/assets/media/logos/default-small.svg') }}" class="h-20px app-sidebar-logo-minimize theme-light-show" />
            @endif
        </a>
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
    </div>
    <!--end::Logo-->
    
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <!--begin::Scroll wrapper-->
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                    
                    <!-- Dashboard item -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('console.dashboard') ? 'active' : '' }}" href="{{ route('console.dashboard') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-element-11 fs-2">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>
                    
                    <!-- Halaman -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('console.pages.*') ? 'active' : '' }}" href="{{ route('console.pages.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-book fs-2">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">Halaman</span>
                        </a>
                    </div>

                    <!-- Artikel -->
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('console.articles.*') || request()->routeIs('console.article_categories.*') ? 'here show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-document fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Artikel / Blog</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('console.articles.*') ? 'active' : '' }}" href="{{ route('console.articles.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Semua Artikel</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('console.article_categories.*') ? 'active' : '' }}" href="{{ route('console.article_categories.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Kategori</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Produk -->
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('console.products.*') || request()->routeIs('console.product_categories.*') ? 'here show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-basket fs-2">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">Produk</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('console.products.*') ? 'active' : '' }}" href="{{ route('console.products.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Semua Produk</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('console.product_categories.*') ? 'active' : '' }}" href="{{ route('console.product_categories.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Kategori</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Katalog Desain -->
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('console.designs.*') || request()->routeIs('console.design_categories.*') ? 'here show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-picture fs-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Katalog Desain</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('console.designs.index') ? 'active' : '' }}" href="{{ route('console.designs.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Semua Desain</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('console.design_categories.index') ? 'active' : '' }}" href="{{ route('console.design_categories.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Kategori</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tampilan -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('console.tampilan.*') ? 'active' : '' }}" href="{{ route('console.tampilan.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-color-swatch fs-2">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span>
                                </i>
                            </span>
                            <span class="menu-title">Tampilan</span>
                        </a>
                    </div>
                    
                    <!-- Pricing -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('console.pricings.*') ? 'active' : '' }}" href="{{ route('console.pricings.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-tag fs-2">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                </i>
                            </span>
                            <span class="menu-title">Pricing</span>
                        </a>
                    </div>
                    
                    <!-- Customer Reviews -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('console.reviews.*') ? 'active' : '' }}" href="{{ route('console.reviews.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-star fs-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Customer Reviews</span>
                        </a>
                    </div>
                    
                    <!-- Manajemen Pengguna -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('console.users.*') ? 'active' : '' }}" href="{{ route('console.users.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-user fs-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Pengguna</span>
                        </a>
                    </div>

                    <!-- Pengaturan Global -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('console.settings.global') ? 'active' : '' }}" href="{{ route('console.settings.global') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-setting-2 fs-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Pengaturan Global</span>
                        </a>
                    </div>
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</div>
<!--end::Sidebar-->