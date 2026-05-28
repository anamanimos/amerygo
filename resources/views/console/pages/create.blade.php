@extends('console.layouts.app')

@section('content')
<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                Tambah Halaman Baru
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('console.pages.index') }}" class="text-muted text-hover-primary">Daftar Halaman</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Buat Halaman</li>
            </ul>
        </div>
    </div>
</div>
<!--end::Toolbar-->

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <form action="{{ route('console.pages.store') }}" method="POST" class="form d-flex flex-column flex-lg-row">
            @csrf
            
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Informasi Halaman</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <!-- Judul -->
                        <div class="mb-10 fv-row">
                            <label class="required form-label">Judul Halaman</label>
                            <input type="text" name="title" class="form-control mb-2" placeholder="Contoh: Kebijakan Privasi" value="{{ old('title') }}" required />
                        </div>
                        
                        <!-- Konten -->
                        <div class="mb-10">
                            <label class="form-label required">Konten / Isi Halaman</label>
                            <textarea id="kt_docs_ckeditor_classic" name="content" class="form-control" rows="15" placeholder="Ketik isi halaman di sini...">{{ old('content') }}</textarea>
                            <div class="text-muted fs-7 mt-2">Gunakan editor di atas untuk memformat teks halaman. HTML diperbolehkan.</div>
                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>SEO (Opsional)</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-10">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control mb-2" name="meta_title" placeholder="Meta title" value="{{ old('meta_title') }}" />
                        </div>
                        <div>
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4">
                    <div class="card-body pt-0">
                        <div class="form-check form-switch form-check-custom form-check-solid mt-4">
                            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked="checked" />
                            <label class="form-check-label fw-semibold text-gray-400 ms-3" for="is_active">
                                Terbitkan (Aktif)
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mb-10">
                    <a href="{{ route('console.pages.index') }}" class="btn btn-light me-5">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan Halaman</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('metronic/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#kt_docs_ckeditor_classic'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
