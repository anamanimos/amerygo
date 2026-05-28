@extends('console.layouts.app')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                {{ isset($article) ? 'Edit Artikel' : 'Tambah Artikel' }}
            </h1>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <form id="article_form" action="{{ isset($article) ? route('console.articles.update', $article->id) : route('console.articles.store') }}" method="POST" enctype="multipart/form-data" class="form row">
            @csrf
            @if(isset($article))
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
                            <label class="required form-label">Judul Artikel</label>
                            <input type="text" name="title" class="form-control mb-2" placeholder="Judul" value="{{ old('title', $article->title ?? '') }}" required />
                            <div class="text-muted fs-7">Judul artikel yang menarik dan SEO friendly.</div>
                        </div>

                        @if(isset($article))
                        <div class="mb-10 fv-row">
                            <label class="form-label">Slug URL</label>
                            <input type="text" class="form-control mb-2 form-control-solid" value="{{ $article->slug }}" disabled />
                            <div class="text-muted fs-7">Slug otomatis dihasilkan dari judul.</div>
                        </div>
                        @endif

                        <div>
                            <label class="required form-label">Konten Artikel</label>
                            <input type="hidden" name="content" id="content_input" value="{{ old('content', $article->content ?? '') }}">
                            <div id="kt_docs_quill_basic" class="min-h-400px mb-2">
                                {!! old('content', $article->content ?? '') !!}
                            </div>
                            <div class="text-muted fs-7">Tulis isi lengkap artikel di sini. Gunakan format yang sesuai agar mudah dibaca.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (4) -->
            <div class="col-lg-4">
                <!-- Thumbnail -->
                <div class="card card-flush py-4 mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Thumbnail</h2>
                        </div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <!-- Drag and Drop Area -->
                        <div id="thumbnail_upload_area" class="border border-dashed border-primary rounded p-7 text-center position-relative mb-3 {{ isset($article) && $article->image ? 'd-none' : '' }}" style="background-color: var(--bs-primary-light); min-height: 150px; display: flex; flex-direction: column; justify-content: center;">
                            <i class="ki-duotone ki-file-up text-primary fs-3x mb-3"><span class="path1"></span><span class="path2"></span></i>
                            <h5 class="mb-1 text-gray-900 fw-bold">Drag & Drop Thumbnail</h5>
                            <span class="text-muted fs-7">atau klik untuk memilih file</span>
                            <!-- Hidden input overlay -->
                            <input type="file" name="image" id="thumbnail_input" accept=".png, .jpg, .jpeg, .webp" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; z-index: 10;" />
                        </div>

                        <!-- Preview Area -->
                        <div id="thumbnail_preview_area" class="position-relative {{ isset($article) && $article->image ? '' : 'd-none' }} mb-3">
                            <img id="thumbnail_preview_img" src="{{ isset($article) && $article->image ? asset($article->image) : '' }}" class="img-fluid rounded border w-100" style="max-height: 200px; object-fit: cover;" />
                            
                            <button type="button" id="btn_remove_thumbnail" class="btn btn-icon btn-circle btn-danger position-absolute top-0 end-0 mt-n3 me-n3 shadow-sm" data-bs-toggle="tooltip" title="Hapus Thumbnail">
                                <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                        </div>

                        <input type="hidden" name="avatar_remove" id="avatar_remove_input" value="0" />
                        
                        <div class="text-muted fs-7 text-center">Format yang didukung: *.png, *.jpg, *.jpeg, *.webp (Max 2MB).</div>
                    </div>
                </div>

                <!-- Kategori & Status -->
                <div class="card card-flush py-4 mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Pengaturan</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-7">
                            <label class="required form-label">Kategori</label>
                            <select name="article_category_id" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori" required>
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('article_category_id', $article->article_category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Status Artikel</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published" {{ old('is_published', $article->is_published ?? true) ? 'checked' : '' }} />
                                <label class="form-check-label" for="is_published">
                                    Publish
                                </label>
                            </div>
                            <div class="text-muted fs-7 mt-2">Setel ke publish agar artikel muncul di website.</div>
                        </div>
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
                            <input type="text" class="form-control mb-2" name="meta_title" placeholder="Meta title" value="{{ old('meta_title', $article->meta_title ?? '') }}" />
                            <div class="text-muted fs-7">Judul khusus untuk mesin pencari. Biarkan kosong untuk menggunakan judul artikel.</div>
                        </div>

                        <div>
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="3" placeholder="Meta description">{{ old('meta_description', $article->meta_description ?? '') }}</textarea>
                            <div class="text-muted fs-7 mt-2">Ringkasan singkat tentang isi artikel untuk meningkatkan klik (CTR).</div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('console.articles.index') }}" class="btn btn-light w-100">Batal / Discard</a>
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
                    [{
                        header: [1, 2, 3, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image']
                ]
            },
            placeholder: 'Tulis konten artikel di sini...',
            theme: 'snow'
        });

        const form = document.getElementById('article_form');
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
                text: "Menyimpan data artikel...",
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
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('console.articles.index') }}";
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
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
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
                    customClass: {
                        confirmButton: "btn btn-danger"
                    }
                });
            });
        });
    });
</script>
<script>
    // Thumbnail Drag and Drop Logic
    document.addEventListener('DOMContentLoaded', function () {
        const thumbInput = document.getElementById('thumbnail_input');
        const uploadArea = document.getElementById('thumbnail_upload_area');
        const previewArea = document.getElementById('thumbnail_preview_area');
        const previewImg = document.getElementById('thumbnail_preview_img');
        const btnRemove = document.getElementById('btn_remove_thumbnail');
        const removeInput = document.getElementById('avatar_remove_input');

        // Drag events for styling
        thumbInput.addEventListener('dragenter', function() {
            uploadArea.classList.add('border-primary');
            uploadArea.style.backgroundColor = 'var(--bs-primary-light)';
        });
        thumbInput.addEventListener('dragleave', function() {
            uploadArea.classList.remove('border-primary');
            // reset bg if needed
        });
        thumbInput.addEventListener('drop', function() {
            uploadArea.classList.remove('border-primary');
        });

        thumbInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    uploadArea.classList.add('d-none');
                    previewArea.classList.remove('d-none');
                    removeInput.value = "0";
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        btnRemove.addEventListener('click', function() {
            thumbInput.value = ""; // clear file input
            previewImg.src = ""; // clear preview
            previewArea.classList.add('d-none'); // hide preview
            uploadArea.classList.remove('d-none'); // show upload area
            removeInput.value = "1"; // mark for deletion in backend
        });
    });
</script>
<style>
    .image-input-placeholder {
        background-image: url('{{ asset('metronic/assets/media/svg/files/blank-image.svg') }}');
    }

    [data-bs-theme="dark"] .image-input-placeholder {
        background-image: url('{{ asset('metronic/assets/media/svg/files/blank-image-dark.svg') }}');
    }
    
    .min-h-400px {
        min-height: 400px;
    }
</style>
@endsection
