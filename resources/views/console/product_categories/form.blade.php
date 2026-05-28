@extends('console.layouts.app')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                {{ isset($productCategory) ? 'Edit Kategori Produk' : 'Tambah Kategori Produk' }}
            </h1>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <form id="category_form" action="{{ isset($productCategory) ? route('console.product_categories.update', $productCategory->id) : route('console.product_categories.store') }}" method="POST" enctype="multipart/form-data" class="form row">
            @csrf
            @if(isset($productCategory))
                @method('PUT')
            @endif

            <div class="col-lg-8 mb-7">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Informasi Kategori</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-10 fv-row">
                            <label class="required form-label">Nama Kategori</label>
                            <input type="text" name="name" class="form-control mb-2" placeholder="Nama kategori" value="{{ old('name', $productCategory->name ?? '') }}" required />
                        </div>

                        <div class="mb-10 fv-row">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $productCategory->description ?? '') }}</textarea>
                            <div class="text-muted fs-7 mt-2">Opsional: Deskripsi singkat tentang kategori ini.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-flush py-4 mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Thumbnail Kategori</h2>
                        </div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <div id="thumbnail_upload_area" class="border border-dashed border-primary rounded p-7 text-center position-relative mb-3 {{ isset($productCategory) && $productCategory->image ? 'd-none' : '' }}" style="background-color: var(--bs-primary-light); min-height: 150px; display: flex; flex-direction: column; justify-content: center;">
                            <i class="ki-duotone ki-file-up text-primary fs-3x mb-3"><span class="path1"></span><span class="path2"></span></i>
                            <h5 class="mb-1 text-gray-900 fw-bold">Drag & Drop Thumbnail</h5>
                            <span class="text-muted fs-7">atau klik untuk memilih file</span>
                            <input type="file" name="image" id="thumbnail_input" accept=".png, .jpg, .jpeg, .webp" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; z-index: 10;" />
                        </div>

                        <div id="thumbnail_preview_area" class="position-relative {{ isset($productCategory) && $productCategory->image ? '' : 'd-none' }} mb-3">
                            <img id="thumbnail_preview_img" src="{{ isset($productCategory) && $productCategory->image ? asset($productCategory->image) : '' }}" class="img-fluid rounded border w-100" style="max-height: 200px; object-fit: cover;" />
                            
                            <button type="button" id="btn_remove_thumbnail" class="btn btn-icon btn-circle btn-danger position-absolute top-0 end-0 mt-n3 me-n3 shadow-sm" data-bs-toggle="tooltip" title="Hapus Thumbnail">
                                <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                        </div>

                        <input type="hidden" name="avatar_remove" id="avatar_remove_input" value="0" />
                        <div class="text-muted fs-7 text-center">Format yang didukung: *.png, *.jpg, *.jpeg, *.webp (Max 2MB).</div>
                    </div>
                </div>

                <div class="card card-flush py-4 mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Status</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $productCategory->is_active ?? true) ? 'checked' : '' }} />
                            <label class="form-check-label fw-bold text-gray-800" for="is_active">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('console.product_categories.index') }}" class="btn btn-light w-100">Batal</a>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('category_form');
        const submitBtn = form.querySelector('button[type="submit"]');

        // Drag and Drop Logic
        const thumbInput = document.getElementById('thumbnail_input');
        const uploadArea = document.getElementById('thumbnail_upload_area');
        const previewArea = document.getElementById('thumbnail_preview_area');
        const previewImg = document.getElementById('thumbnail_preview_img');
        const btnRemove = document.getElementById('btn_remove_thumbnail');
        const removeInput = document.getElementById('avatar_remove_input');

        thumbInput.addEventListener('dragenter', function() {
            uploadArea.classList.add('border-primary');
        });
        thumbInput.addEventListener('dragleave', function() {
            uploadArea.classList.remove('border-primary');
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
            thumbInput.value = "";
            previewImg.src = "";
            previewArea.classList.add('d-none');
            uploadArea.classList.remove('d-none');
            removeInput.value = "1";
        });

        // Submit form
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;

            const formData = new FormData(form);
            
            Swal.fire({
                text: "Menyimpan kategori...",
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
                            window.location.href = "{{ route('console.product_categories.index') }}";
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
@endsection
