@extends('console.layouts.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<style>
    .img-container {
        width: 100%;
        max-height: 60vh;
        text-align: center;
        overflow: hidden;
    }
    #cropperImage {
        display: block;
        max-width: 100%;
        max-height: 60vh;
        margin: 0 auto;
    }
</style>
@endpush

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                {{ isset($design) ? 'Edit Desain Jersey' : 'Tambah Desain Jersey' }}
            </h1>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <form id="design_form" action="{{ isset($design) ? route('console.designs.update', $design->id) : route('console.designs.store') }}" method="POST" enctype="multipart/form-data" class="form row">
            @csrf
            @if(isset($design))
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
                            <label class="required form-label">Nama Desain</label>
                            <input type="text" name="name" class="form-control mb-2" placeholder="Nama Desain" value="{{ old('name', $design->name ?? '') }}" required />
                            <div class="text-muted fs-7">Nama desain jersey yang menarik dan jelas.</div>
                        </div>

                        @if(isset($design))
                        <div class="mb-10 fv-row">
                            <label class="form-label">Slug URL</label>
                            <input type="text" class="form-control mb-2 form-control-solid" value="{{ $design->slug }}" disabled />
                            <div class="text-muted fs-7">Slug otomatis dihasilkan dari nama desain.</div>
                        </div>
                        @endif

                        <div>
                            <label class="form-label">Deskripsi Desain</label>
                            <input type="hidden" name="description" id="description_input" value="{{ old('description', $design->description ?? '') }}">
                            <div id="kt_docs_quill_basic" class="min-h-400px mb-2">
                                {!! old('description', $design->description ?? '') !!}
                            </div>
                            <div class="text-muted fs-7">Tulis penjelasan detail mengenai desain jersey di sini (material, pilihan kerah, warna, dll).</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (4) -->
            <div class="col-lg-4">
                <!-- Image/Thumbnail -->
                <div class="card card-flush py-4 mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Gambar Desain</h2>
                        </div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <!-- Drag and Drop Area -->
                        <div id="thumbnail_upload_area" class="border border-dashed border-primary rounded p-7 text-center position-relative mb-3 {{ isset($design) && $design->image ? 'd-none' : '' }}" style="background-color: var(--bs-primary-light); min-height: 150px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <i class="ki-duotone ki-file-up text-primary fs-3x mb-3"><span class="path1"></span><span class="path2"></span></i>
                            <h5 class="mb-1 text-gray-900 fw-bold">Drag & Drop Gambar</h5>
                            <span class="text-muted fs-7">atau klik untuk memilih file</span>
                            <!-- Hidden input overlay -->
                            <input type="file" name="image" id="thumbnail_input" accept=".png, .jpg, .jpeg, .webp" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; z-index: 10;" {{ isset($design) ? '' : 'required' }} />
                        </div>

                        <!-- Preview Area -->
                        <div id="thumbnail_preview_area" class="position-relative {{ isset($design) && $design->image ? '' : 'd-none' }} mb-3">
                            <img id="thumbnail_preview_img" src="{{ isset($design) && $design->image ? Storage::disk('public')->url(str_replace('storage/', '', $design->image)) : '' }}" class="img-fluid rounded border w-100" style="max-height: 250px; object-fit: contain;" />
                            
                            <button type="button" id="btn_remove_thumbnail" class="btn btn-icon btn-circle btn-danger position-absolute top-0 end-0 mt-n3 me-n3 shadow-sm" data-bs-toggle="tooltip" title="Hapus Gambar">
                                <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                        </div>

                        <input type="hidden" name="cropped_image" id="cropped_image_input" />
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
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="required form-label mb-0">Kategori</label>
                                <button type="button" class="btn btn-link btn-color-primary btn-active-color-primary p-0 fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    + Tambah Kategori
                                </button>
                            </div>
                            <select name="design_category_id" id="design_category_select" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori" required>
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('design_category_id', $design->design_category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Status Tampilan</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $design->is_active ?? true) ? 'checked' : '' }} />
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                            </div>
                            <div class="text-muted fs-7 mt-2">Aktifkan agar desain ini muncul di katalog website.</div>
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
                            <input type="text" class="form-control mb-2" name="meta_title" placeholder="Meta title" value="{{ old('meta_title', $design->meta_title ?? '') }}" />
                            <div class="text-muted fs-7">Judul khusus mesin pencari. Biarkan kosong untuk menggunakan nama desain.</div>
                        </div>

                        <div>
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="3" placeholder="Meta description">{{ old('meta_description', $design->meta_description ?? '') }}</textarea>
                            <div class="text-muted fs-7 mt-2">Ringkasan singkat tentang desain ini untuk mesin pencari.</div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('console.designs.index') }}" class="btn btn-light w-100">Batal / Discard</a>
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
            placeholder: 'Tulis penjelasan desain jersey di sini...',
            theme: 'snow'
        });

        const form = document.getElementById('design_form');
        const submitBtn = form.querySelector('button[type="submit"]');
        const descriptionInput = document.getElementById('description_input');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Sync quill content to hidden input
            descriptionInput.value = quill.root.innerHTML;

            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;

            const formData = new FormData(form);
            
            // Show loading alert
            Swal.fire({
                text: "Menyimpan data desain...",
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
            .then(response => {
                if (response.status === 403) {
                    return response.json().then(data => { throw new Error(data.message || "Akses ditolak (Batas kuota tercapai).") });
                }
                return response.json();
            })
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
                            window.location.href = "{{ route('console.designs.index') }}";
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
                    text: error.message || "Terjadi kesalahan pada sistem.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, mengerti!",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    }
                });
            });
        });

        // Image upload and preview handling with Cropper
        const thumbnailInput = document.getElementById('thumbnail_input');
        const uploadArea = document.getElementById('thumbnail_upload_area');
        const previewArea = document.getElementById('thumbnail_preview_area');
        const previewImg = document.getElementById('thumbnail_preview_img');
        const btnRemove = document.getElementById('btn_remove_thumbnail');
        const avatarRemoveInput = document.getElementById('avatar_remove_input');
        const croppedImageInput = document.getElementById('cropped_image_input');
        const cropperModalEl = document.getElementById('cropperModal');
        const cropperImage = document.getElementById('cropperImage');
        const btnCrop = document.getElementById('btnCrop');
        let cropperModal = new bootstrap.Modal(cropperModalEl);
        let cropper;

        thumbnailInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    cropperImage.src = e.target.result;
                    cropperModal.show();
                    
                    cropperModalEl.addEventListener('shown.bs.modal', function onModalShown() {
                        if (cropper) {
                            cropper.destroy();
                        }
                        cropper = new Cropper(cropperImage, {
                            aspectRatio: 3/4, // 3:4 portrait (4:3 potrait)
                            viewMode: 2,
                            background: false,
                            zoomable: true,
                        });
                        cropperModalEl.removeEventListener('shown.bs.modal', onModalShown);
                    });
                }
                reader.readAsDataURL(file);
            }
        });

        btnCrop.addEventListener('click', function () {
            if (!cropper) return;

            const canvas = cropper.getCroppedCanvas({
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            const base64Data = canvas.toDataURL('image/jpeg');

            // Set to hidden input
            croppedImageInput.value = base64Data;

            // Update preview
            previewImg.src = base64Data;
            uploadArea.classList.add('d-none');
            previewArea.classList.remove('d-none');
            avatarRemoveInput.value = "0";
            thumbnailInput.required = false; // We have cropped image now

            cropperModal.hide();
        });

        cropperModalEl.addEventListener('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            if (!croppedImageInput.value) {
                thumbnailInput.value = '';
            }
        });

        btnRemove.addEventListener('click', function () {
            thumbnailInput.value = '';
            croppedImageInput.value = '';
            previewImg.src = '';
            previewArea.classList.add('d-none');
            uploadArea.classList.remove('d-none');
            avatarRemoveInput.value = "1";
            thumbnailInput.required = true; // Required if removing existing image during create
        });

        // Quick Category modal form handler
        const quickCategoryForm = document.getElementById('quick_category_form');
        const btnSubmitQuickCategory = document.getElementById('btnSubmitQuickCategory');
        const designCategorySelect = document.getElementById('design_category_select');
        const addCategoryModalEl = document.getElementById('addCategoryModal');

        if (quickCategoryForm) {
            quickCategoryForm.addEventListener('submit', function (e) {
                e.preventDefault();

                btnSubmitQuickCategory.setAttribute('data-kt-indicator', 'on');
                btnSubmitQuickCategory.disabled = true;

                const formData = new FormData(quickCategoryForm);

                fetch(quickCategoryForm.action, {
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
                    btnSubmitQuickCategory.removeAttribute('data-kt-indicator');
                    btnSubmitQuickCategory.disabled = false;

                    if (data.success) {
                        // Close modal using Bootstrap API
                        const modalInstance = bootstrap.Modal.getInstance(addCategoryModalEl) || new bootstrap.Modal(addCategoryModalEl);
                        modalInstance.hide();

                        // Reset input
                        document.getElementById('quick_category_name').value = '';

                        // Add new option and select it in Select2 dropdown
                        const newOption = new Option(data.category.name, data.category.id, true, true);
                        $(designCategorySelect).append(newOption).trigger('change');

                        Swal.fire({
                            text: data.message,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    } else {
                        let errors = data.message || "Terjadi kesalahan.";
                        if (data.errors) {
                            errors = Object.values(data.errors).flat().join('<br>');
                        }
                        Swal.fire({
                            html: errors,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                    }
                })
                .catch(error => {
                    btnSubmitQuickCategory.removeAttribute('data-kt-indicator');
                    btnSubmitQuickCategory.disabled = false;

                    Swal.fire({
                        text: "Terjadi kesalahan pada sistem.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
                });
            });
        }
    });
</script>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="quick_category_form" action="{{ route('console.design_categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <label class="required form-label">Nama Kategori</label>
                        <input type="text" name="name" id="quick_category_name" class="form-control form-control-solid" placeholder="Nama Kategori" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitQuickCategory">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Cropper -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Sesuaikan Gambar (Crop 3:4)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="cropperImage" src="" alt="Picture">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnCrop">Terapkan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endpush
@endsection
