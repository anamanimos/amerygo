@extends('console.layouts.app')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Artikel</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <span class="badge badge-light-{{ $currentCount >= $limit ? 'danger' : 'primary' }} fw-bold fs-6 px-4 py-3 me-2">
                {{ $currentCount }} / {{ $limit }} Artikel
            </span>
            @if($currentCount >= $limit)
                <button class="btn btn-sm fw-bold btn-secondary" disabled data-bs-toggle="tooltip" title="Batas maksimal artikel tercapai">Tambah Artikel</button>
            @else
                <a href="{{ route('console.articles.create') }}" class="btn btn-sm fw-bold btn-primary">Tambah Artikel</a>
            @endif
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body py-4">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_articles">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-200px">Judul</th>
                            <th class="min-w-125px">Kategori</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-125px">Tanggal</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @foreach($articles as $article)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-3">
                                        <img src="{{ $article->image ? asset($article->image) : 'https://ui-avatars.com/api/?name=Article&background=random' }}" class="" alt="" />
                                    </div>
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $article->title }}</a>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $article->category->name ?? '-' }}</td>
                            <td>
                                @if($article->is_published)
                                    <span class="badge badge-light-success">Published</span>
                                @else
                                    <span class="badge badge-light-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}
                            </td>
                            <td class="text-end">
                                <a href="{{ route('console.articles.edit', $article->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <i class="ki-duotone ki-pencil fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </a>
                                <form action="{{ route('console.articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
                                        <i class="ki-duotone ki-trash fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </button>
                                </form>
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
