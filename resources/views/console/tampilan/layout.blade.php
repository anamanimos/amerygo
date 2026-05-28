@extends('console.layouts.app')

@section('content')
<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                Pengaturan Tampilan
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    Sesuaikan tampilan halaman website Anda.
                </li>
            </ul>
        </div>
    </div>
</div>
<!--end::Toolbar-->

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="row">
            <!--begin::List Menu (3 Kolom)-->
            <div class="col-lg-3 col-md-4 mb-5">
                <div class="card shadow-sm" style="position: sticky; top: 100px; z-index: 99;">
                    <div class="card-body p-0">
                        <div class="menu menu-column menu-rounded menu-state-bg menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary p-3">
                            <div class="menu-item mb-1">
                                <a href="{{ route('console.tampilan.header') }}" class="menu-link {{ request()->routeIs('console.tampilan.header') ? 'active' : '' }} px-4 py-3">
                                    <span class="menu-title fw-bold">Header</span>
                                </a>
                            </div>
                            <div class="menu-item mb-1">
                                <a href="{{ route('console.tampilan.hero') }}" class="menu-link {{ request()->routeIs('console.tampilan.hero') ? 'active' : '' }} px-4 py-3">
                                    <span class="menu-title fw-bold">Hero</span>
                                </a>
                            </div>
                            <div class="menu-item mb-1">
                                <a href="{{ route('console.tampilan.icon-list') }}" class="menu-link {{ request()->routeIs('console.tampilan.icon-list') ? 'active' : '' }} px-4 py-3">
                                    <span class="menu-title fw-bold">Icon List</span>
                                </a>
                            </div>
                            <div class="menu-item mb-1">
                                <a href="{{ route('console.tampilan.short-about') }}" class="menu-link {{ request()->routeIs('console.tampilan.short-about') ? 'active' : '' }} px-4 py-3">
                                    <span class="menu-title fw-bold">Short About</span>
                                </a>
                            </div>
                            <div class="menu-item mb-1">
                                <a href="{{ route('console.tampilan.how-to-order') }}" class="menu-link {{ request()->routeIs('console.tampilan.how-to-order') ? 'active' : '' }} px-4 py-3">
                                    <span class="menu-title fw-bold">How to order</span>
                                </a>
                            </div>
                            <div class="menu-item mb-1">
                                <a href="{{ route('console.tampilan.footer') }}" class="menu-link {{ request()->routeIs('console.tampilan.footer') ? 'active' : '' }} px-4 py-3">
                                    <span class="menu-title fw-bold">Footer</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::List Menu-->

            <!--begin::Form Content (8 Kolom)-->
            <div class="col-lg-9 col-md-8">
                @yield('tampilan_content')
            </div>
            <!--end::Form Content-->
        </div>
    </div>
</div>
<!--end::Content-->
@endsection
