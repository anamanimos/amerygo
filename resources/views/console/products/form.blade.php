@extends('console.layouts.app')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                {{ isset($product) ? 'Edit Produk' : 'Tambah Produk' }}
            </h1>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <form id="product_form" action="{{ isset($product) ? route('console.products.update', $product->id) : route('console.products.store') }}" method="POST" enctype="multipart/form-data" class="form row">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            <!-- Left Column (8) -->
            <div class="col-lg-8 mb-7">
                <div class="card card-flush py-4 mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Informasi Umum</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-10 fv-row">
                            <label class="required form-label">Nama Produk</label>
                            <input type="text" name="name" class="form-control mb-2" placeholder="Nama Produk" value="{{ old('name', $product->name ?? '') }}" required />
                        </div>
                        
                        <div class="mb-10 fv-row">
                            <label class="required form-label">Kategori Produk</label>
                            <select name="product_category_id" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori" required>
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('product_category_id', $product->product_category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Deskripsi Produk</label>
                            <input type="hidden" name="description" id="description_input" value="{{ old('description', $product->description ?? '') }}">
                            <div id="kt_docs_quill_basic" class="min-h-300px mb-2">
                                {!! old('description', $product->description ?? '') !!}
                            </div>
                            <div class="text-muted fs-7">Jelaskan spesifikasi dan detail produk Anda secara lengkap.</div>
                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4 mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Galeri Gambar Produk</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                            <i class="ki-duotone ki-info-circle fs-2hx text-primary me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            <div class="d-flex flex-column">
                                <span>Gambar pertama di urutan akan otomatis menjadi <strong>Thumbnail (Gambar Utama)</strong> produk. Anda dapat menarik dan melepas (Drag & Drop) gambar untuk mengurutkannya.</span>
                            </div>
                        </div>

                        <div id="image_upload_area" class="border border-dashed border-primary rounded p-7 text-center position-relative mb-5" style="background-color: var(--bs-primary-light); min-height: 120px; display: flex; flex-direction: column; justify-content: center;">
                            <i class="ki-duotone ki-cloud-add text-primary fs-3x mb-3"><span class="path1"></span><span class="path2"></span></i>
                            <h5 class="mb-1 text-gray-900 fw-bold">Pilih atau Drag & Drop Gambar Baru</h5>
                            <span class="text-muted fs-7">Dapat memilih banyak file sekaligus (*.png, *.jpg, *.webp)</span>
                            <input type="file" id="images_input" name="images[]" multiple accept=".png, .jpg, .jpeg, .webp" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; z-index: 10;" />
                        </div>

                        <!-- Sortable Gallery Grid -->
                        <div id="gallery_grid" class="row g-3 sortable">
                            @if(isset($product) && $product->images->count() > 0)
                                @foreach($product->images as $img)
                                    <div class="col-6 col-md-4 col-lg-3 gallery-item" data-id="{{ $img->id }}">
                                        <div class="card shadow-sm border position-relative h-100">
                                            <div class="position-absolute top-0 start-0 m-2 badge bg-primary badge-sm thumbnail-badge {{ $loop->first ? '' : 'd-none' }}">Thumbnail</div>
                                            <button type="button" class="btn btn-icon btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-existing-image-btn" data-id="{{ $img->id }}" style="z-index: 5;">
                                                <i class="ki-duotone ki-cross fs-3"><span class="path1"></span><span class="path2"></span></i>
                                            </button>
                                            <img src="{{ asset($img->image_path) }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Product Image">
                                            <div class="card-body p-2 text-center" style="cursor: grab;">
                                                <i class="ki-duotone ki-dots-square fs-2 text-muted"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <!-- Preview New Uploads Here -->
                        </div>

                        <input type="hidden" name="image_order" id="image_order_input" value="">
                        <input type="hidden" name="deleted_images" id="deleted_images_input" value="">
                    </div>
                </div>
            </div>

            <!-- Right Column (4) -->
            <div class="col-lg-4">
                <!-- Pricing -->
                <div class="card card-flush py-4 mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Harga</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Harga Asli (Rp)</label>
                            <input type="number" name="price" class="form-control mb-2" placeholder="0" value="{{ old('price', $product->price ?? '') }}" required min="0" />
                            <div class="text-muted fs-7">Harga dasar produk.</div>
                        </div>

                        <div class="fv-row">
                            <label class="form-label">Harga Diskon (Rp)</label>
                            <input type="number" name="discount_price" class="form-control mb-2" placeholder="0" value="{{ old('discount_price', $product->discount_price ?? '') }}" min="0" />
                            <div class="text-muted fs-7">Biarkan kosong jika tidak ada diskon. Harga asli akan dicoret jika ini diisi.</div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="card card-flush py-4 mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Status & Pengaturan</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-5">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} />
                                <label class="form-check-label fw-bold text-gray-800" for="is_active">
                                    Aktif / Publish
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }} />
                                <label class="form-check-label fw-bold text-gray-800" for="is_featured">
                                    Produk Unggulan (Featured)
                                </label>
                            </div>
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
                            <input type="text" class="form-control mb-2" name="meta_title" placeholder="Meta title" value="{{ old('meta_title', $product->meta_title ?? '') }}" />
                        </div>

                        <div>
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="3" placeholder="Meta description">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('console.products.index') }}" class="btn btn-light w-100">Batal</a>
                    <button type="submit" class="btn btn-primary w-100">Simpan Produk</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Quill Editor
        var quill = new Quill('#kt_docs_quill_basic', {
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link']
                ]
            },
            placeholder: 'Tulis deskripsi lengkap produk di sini...',
            theme: 'snow'
        });

        // Gallery Sorting Logic
        var el = document.getElementById('gallery_grid');
        var sortable = Sortable.create(el, {
            animation: 150,
            ghostClass: 'bg-light-primary',
            onEnd: function (evt) {
                updateImageOrder();
            },
        });

        const imageOrderInput = document.getElementById('image_order_input');
        const deletedImagesInput = document.getElementById('deleted_images_input');
        let deletedImageIds = [];

        function updateImageOrder() {
            // Update order input
            let order = [];
            const items = el.querySelectorAll('.gallery-item');
            items.forEach((item, index) => {
                if (item.dataset.id) {
                    order.push(item.dataset.id);
                }
                
                // Update thumbnail badge visually
                const badge = item.querySelector('.thumbnail-badge');
                if (badge) {
                    if (index === 0) {
                        badge.classList.remove('d-none');
                    } else {
                        badge.classList.add('d-none');
                    }
                }
            });
            imageOrderInput.value = order.join(',');
        }

        // Initialize order
        updateImageOrder();

        // Handle existing image removal
        el.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-existing-image-btn');
            if (removeBtn) {
                const id = removeBtn.dataset.id;
                if (id) {
                    deletedImageIds.push(id);
                    deletedImagesInput.value = deletedImageIds.join(',');
                }
                const item = removeBtn.closest('.gallery-item');
                if (item) {
                    item.remove();
                    updateImageOrder();
                }
            }
        });

        // Handle new file selection previews
        const imagesInput = document.getElementById('images_input');
        let dt = new DataTransfer(); // Holds new files

        imagesInput.addEventListener('change', function(e) {
            const files = e.target.files;
            
            for (let i = 0; i < files.length; i++) {
                dt.items.add(files[i]);
                
                const file = files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const html = `
                        <div class="col-6 col-md-4 col-lg-3 gallery-item new-image-item">
                            <div class="card shadow-sm border position-relative h-100">
                                <div class="position-absolute top-0 start-0 m-2 badge bg-primary badge-sm thumbnail-badge d-none">Thumbnail</div>
                                <button type="button" class="btn btn-icon btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-new-image-btn" data-name="${file.name}" style="z-index: 5;">
                                    <i class="ki-duotone ki-cross fs-3"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                                <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Preview">
                                <div class="card-body p-2 text-center" style="cursor: grab;">
                                    <span class="badge badge-light-success fs-8">Baru</span>
                                </div>
                            </div>
                        </div>
                    `;
                    el.insertAdjacentHTML('beforeend', html);
                    updateImageOrder();
                }
                reader.readAsDataURL(file);
            }
            
            imagesInput.files = dt.files;
        });

        // Handle remove new image
        el.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-new-image-btn');
            if (removeBtn) {
                const name = removeBtn.dataset.name;
                
                // Remove from datatransfer
                for(let i = 0; i < dt.items.length; i++){
                    if(dt.items[i].getAsFile().name === name){
                        dt.items.remove(i);
                        break;
                    }
                }
                imagesInput.files = dt.files;

                const item = removeBtn.closest('.gallery-item');
                if (item) {
                    item.remove();
                    updateImageOrder();
                }
            }
        });

        // Form Submit
        const form = document.getElementById('product_form');
        const submitBtn = form.querySelector('button[type="submit"]');
        const descInput = document.getElementById('description_input');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Sync quill content
            descInput.value = quill.root.innerHTML;

            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;

            updateImageOrder();
            const formData = new FormData(form);
            
            Swal.fire({
                text: "Menyimpan data produk...",
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
                            window.location.href = "{{ route('console.products.index') }}";
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
    .min-h-300px {
        min-height: 300px;
    }
    .gallery-item.sortable-ghost {
        opacity: 0.4;
    }
</style>
@endsection
