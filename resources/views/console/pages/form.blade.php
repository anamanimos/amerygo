@extends('console.layouts.app')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                {{ isset($page) ? 'Edit Halaman' : 'Tambah Halaman' }}
            </h1>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <form id="page_form" action="{{ isset($page) ? route('console.pages.update', $page->id) : route('console.pages.store') }}" method="POST" class="form row">
            @csrf
            @if(isset($page))
                @method('PUT')
            @endif

            <!-- Left Column (8) -->
            <div class="col-lg-8 mb-7">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Informasi Umum</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-10 fv-row">
                            <label class="required form-label">Judul Halaman</label>
                            <input type="text" name="title" class="form-control mb-2" placeholder="Judul Halaman" value="{{ old('title', $page->title ?? '') }}" required />
                            <div class="text-muted fs-7">Judul halaman akan ditampilkan sebagai header utama.</div>
                        </div>

                        @if(isset($page))
                        <div class="mb-10 fv-row">
                            <label class="form-label">Slug URL</label>
                            <input type="text" class="form-control mb-2 form-control-solid" value="{{ $page->slug }}" disabled />
                            <div class="text-muted fs-7">Slug halaman tidak bisa diubah (opsional untuk versi ini).</div>
                        </div>
                        @endif

                        <div>
                            <label class="required form-label">Konten Halaman</label>
                            <input type="hidden" name="content" id="content_input" value="{{ old('content', $page->content ?? '') }}">
                            <div id="kt_docs_quill_basic" class="min-h-400px mb-2">
                                {!! old('content', $page->content ?? '') !!}
                            </div>
                            <div class="text-muted fs-7">Isi konten halaman Anda.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (4) -->
            <div class="col-lg-4">
                <!-- Status -->
                <div class="card card-flush py-4 mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Status Publikasi</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }} />
                            <label class="form-check-label fw-bold text-gray-800" for="is_active">
                                Aktif
                            </label>
                        </div>
                        <div class="text-muted fs-7 mt-2">Setel aktif agar halaman bisa diakses oleh pengunjung.</div>
                    </div>
                </div>

                <!-- SEO -->
                <div class="card card-flush py-4 mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Pengaturan SEO</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-5">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control mb-2" name="meta_title" placeholder="Meta title" value="{{ old('meta_title', $page->meta_title ?? '') }}" />
                            <div class="text-muted fs-7">Judul di mesin pencari. Biarkan kosong untuk menggunakan judul asli halaman.</div>
                        </div>

                        <div>
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="3" placeholder="Meta description">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                            <div class="text-muted fs-7 mt-2">Ringkasan singkat tentang isi halaman.</div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('console.pages.index') }}" class="btn btn-light w-100">Batal / Discard</a>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Quill Editor
        var quill = new Quill('#kt_docs_quill_basic', {
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video']
                ]
            },
            placeholder: 'Tulis konten halaman di sini...',
            theme: 'snow'
        });

        const form = document.getElementById('page_form');
        const submitBtn = form.querySelector('button[type="submit"]');
        const contentInput = document.getElementById('content_input');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Sync quill content to hidden input
            contentInput.value = quill.root.innerHTML;

            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;

            const formData = new FormData(form);
            
            // Show loading alert
            Swal.fire({
                text: "Menyimpan data halaman...",
                icon: "info",
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;

                if (data.success) {
                    Swal.fire({
                        text: data.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, mengerti!",
                        customClass: { confirmButton: "btn btn-primary" }
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('console.pages.index') }}";
                        }
                    });
                } else {
                    let errors = data.message || "Terjadi kesalahan.";
                    if(data.errors) {
                        errors = Object.values(data.errors).flat().join('<br>');
                    }
                    Swal.fire({
                        html: errors,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, mengerti!",
                        customClass: { confirmButton: "btn btn-danger" }
                    });
                }
            })
            .catch(error => {
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
                
                Swal.fire({
                    text: "Terjadi kesalahan pada sistem.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, mengerti!",
                    customClass: { confirmButton: "btn btn-danger" }
                });
            });
        });
    });
</script>
<style>
    .min-h-400px {
        min-height: 400px;
    }
</style>
@endsection
