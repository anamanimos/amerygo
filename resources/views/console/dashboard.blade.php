@extends('console.layouts.app')

@section('content')
<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                Welcome to AMERYGO Dashboard
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    This is your admin control panel. Use the sidebar to navigate to different sections of the application.
                </li>
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar container-->
</div>
<!--end::Toolbar-->

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <!-- Stats Row -->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!-- Products Stat -->
            <div class="col-md-3">
                <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                    <div class="card-body py-9">
                        <div class="fs-2hx fw-bold text-gray-900 mb-2">{{ number_format($stats['products']) }}</div>
                        <div class="fs-4 fw-semibold text-gray-400 mb-7">Total Produk</div>
                        <a href="{{ route('console.products.index') }}" class="btn btn-sm btn-light-primary fw-bold">Kelola Produk</a>
                    </div>
                </div>
            </div>
            <!-- Articles Stat -->
            <div class="col-md-3">
                <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                    <div class="card-body py-9">
                        <div class="fs-2hx fw-bold text-gray-900 mb-2">{{ number_format($stats['articles']) }}</div>
                        <div class="fs-4 fw-semibold text-gray-400 mb-7">Total Artikel</div>
                        <a href="{{ route('console.articles.index') }}" class="btn btn-sm btn-light-info fw-bold">Kelola Artikel</a>
                    </div>
                </div>
            </div>
            <!-- Pages Stat -->
            <div class="col-md-3">
                <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                    <div class="card-body py-9">
                        <div class="fs-2hx fw-bold text-gray-900 mb-2">{{ number_format($stats['pages']) }}</div>
                        <div class="fs-4 fw-semibold text-gray-400 mb-7">Total Halaman</div>
                        <a href="{{ route('console.pages.index') }}" class="btn btn-sm btn-light-success fw-bold">Kelola Halaman</a>
                    </div>
                </div>
            </div>
            <!-- Reviews Stat -->
            <div class="col-md-3">
                <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                    <div class="card-body py-9">
                        <div class="fs-2hx fw-bold text-gray-900 mb-2">{{ number_format($stats['reviews']) }}</div>
                        <div class="fs-4 fw-semibold text-gray-400 mb-7">Total Ulasan</div>
                        <a href="{{ route('console.reviews.index') }}" class="btn btn-sm btn-light-warning fw-bold">Kelola Ulasan</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tables Row -->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!-- Recent Products -->
            <div class="col-xl-6">
                <div class="card card-flush h-xl-100">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Produk Terbaru</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">5 produk yang baru ditambahkan</span>
                        </h3>
                        <div class="card-toolbar">
                            <a href="{{ route('console.products.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle gs-0 gy-3">
                                <thead>
                                    <tr>
                                        <th class="p-0 w-50px"></th>
                                        <th class="p-0 min-w-150px"></th>
                                        <th class="p-0 min-w-100px text-end"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentProducts as $product)
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-50px me-2">
                                                @if($product->thumbnail)
                                                    <span class="symbol-label" style="background-image:url({{ asset($product->thumbnail) }});"></span>
                                                @else
                                                    <span class="symbol-label bg-light-primary"><i class="ki-duotone ki-picture fs-2x text-primary"></i></span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('console.products.edit', $product->id) }}" class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{ $product->name }}</a>
                                            <span class="text-muted fw-semibold d-block fs-7">{{ $product->category ? $product->category->name : 'Uncategorized' }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-dark fw-bold d-block fs-6">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada produk.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Articles -->
            <div class="col-xl-6">
                <div class="card card-flush h-xl-100">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Artikel Terbaru</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">5 artikel terakhir</span>
                        </h3>
                        <div class="card-toolbar">
                            <a href="{{ route('console.articles.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle gs-0 gy-3">
                                <thead>
                                    <tr>
                                        <th class="p-0 min-w-150px"></th>
                                        <th class="p-0 min-w-100px text-end"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentArticles as $article)
                                    <tr>
                                        <td>
                                            <a href="{{ route('console.articles.edit', $article->id) }}" class="text-dark fw-bold text-hover-primary mb-1 fs-6 line-clamp-1">{{ $article->title }}</a>
                                            <span class="text-muted fw-semibold d-block fs-7">{{ $article->category ? $article->category->name : 'Uncategorized' }}</span>
                                        </td>
                                        <td class="text-end">
                                            @if($article->is_published)
                                                <span class="badge badge-light-success fs-7 fw-bold">Dipublikasikan</span>
                                            @else
                                                <span class="badge badge-light-warning fs-7 fw-bold">Draft</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Belum ada artikel.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Content-->
@endsection
