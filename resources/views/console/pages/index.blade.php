@extends('console.layouts.app')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Manajemen Halaman</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('console.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Halaman</li>
            </ul>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <span class="badge badge-light-{{ $currentCount >= $limit ? 'danger' : 'primary' }} fw-bold fs-6 px-4 py-3 me-2">
                {{ $currentCount }} / {{ $limit }} Halaman
            </span>
            @if($currentCount >= $limit)
                <button class="btn btn-sm fw-bold btn-secondary" disabled data-bs-toggle="tooltip" title="Batas maksimal halaman tercapai">
                    <i class="ki-duotone ki-plus fs-2"></i> Tambah Halaman
                </button>
            @else
                <a href="{{ route('console.pages.create') }}" class="btn btn-sm fw-bold btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i> Tambah Halaman
                </a>
            @endif
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                <i class="ki-duotone ki-check-circle fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-success">Berhasil</h4>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                <i class="ki-duotone ki-cross-circle fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-danger">Gagal</h4>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="card card-flush">
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4"><span class="path1"></span><span class="path2"></span></i>
                        <input type="text" data-kt-page-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari Halaman..." />
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_pages_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_pages_table .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="min-w-200px">Judul Halaman</th>
                            <th class="min-w-100px text-center">Status</th>
                            <th class="text-end min-w-70px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($pages as $page)
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="{{ $page->id }}" />
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <a href="{{ route('console.pages.edit', $page->id) }}" class="text-gray-800 text-hover-primary mb-1 fw-bold fs-5">{{ $page->title }}</a>
                                    <span class="text-muted fs-7">/pages/{{ $page->slug }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($page->is_active)
                                    <span class="badge badge-light-success fs-7 fw-bold">Aktif</span>
                                @else
                                    <span class="badge badge-light-danger fs-7 fw-bold">Non-aktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Aksi <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a href="{{ route('console.pages.edit', $page->id) }}" class="menu-link px-3">Edit</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="menu-link px-3">Lihat</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <form action="{{ route('console.pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="menu-link px-3 text-danger bg-transparent border-0 w-100 text-start" style="cursor: pointer;">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Init datatable
        const table = document.getElementById('kt_pages_table');
        if (table) {
            const datatable = $(table).DataTable({
                "info": false,
                'order': [],
                'pageLength': 10,
                'columnDefs': [
                    { orderable: false, targets: 0 },
                    { orderable: false, targets: 3 },
                ]
            });

            // Search
            document.querySelector('[data-kt-page-table-filter="search"]').addEventListener('keyup', function (e) {
                datatable.search(e.target.value).draw();
            });
        }
    });
</script>
@endpush
