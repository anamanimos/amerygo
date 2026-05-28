@extends('console.tampilan.layout')

@section('tampilan_content')
<div class="card shadow-sm mb-5">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900">Pengaturan Header</span>
            <span class="text-muted mt-1 fw-semibold fs-7">Ubah logo dan tombol CTA pada header website</span>
        </h3>
    </div>
    <div class="card-body py-5">
        <form id="headerSettingsForm" action="{{ route('console.tampilan.header.update') }}" method="POST" enctype="multipart/form-data" class="ajax-form">
            @csrf
            
            <h4 class="mb-4 text-gray-800">1. Logo</h4>
            <div class="mb-8">
                <div class="mb-3 d-flex align-items-center gap-4">
                    <div id="logoPreviewWrapper" class="border rounded p-2 d-inline-block" style="background-color: #f1f1f1; min-width:60px; min-height:40px;">
                        <img id="logoPreview" src="{{ $logo ? asset($logo) : '' }}" alt="Logo Preview" class="h-50px" style="{{ $logo ? '' : 'display:none;' }}">
                    </div>
                    <button type="button" class="btn btn-sm btn-light-primary" id="btnSelectLogo">
                        <i class="ki-duotone ki-picture fs-2 me-1"><span class="path1"></span><span class="path2"></span></i> Pilih & Crop Logo
                    </button>
                </div>
                <input type="file" class="d-none" id="logoFileInput" accept="image/png,image/jpeg,image/jpg,image/gif,image/svg+xml,image/webp" />
                <input type="hidden" name="logo_cropped" id="logoCroppedData" />
                <div class="text-muted fs-7 mt-2">Format yang diizinkan: png, jpg, jpeg, svg, webp. Klik tombol di atas untuk memilih dan memotong gambar.</div>
            </div>

            <!-- Modal Cropper -->
            <div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Crop Logo</h5>
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                        </div>
                        <div class="modal-body text-center">
                            <div style="max-height:400px; overflow:hidden;">
                                <img id="cropperImage" src="" alt="Crop" style="max-width:100%;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="btnCropApply">Terapkan</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="separator mb-8"></div>

            <h4 class="mb-4 text-gray-800">2. Tombol CTA (Call to Action)</h4>
            <div class="row mb-5">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Teks Tombol</label>
                    <input type="text" class="form-control form-control-solid" name="cta_text" value="{{ $ctaText ?? 'Order Now' }}" placeholder="Contoh: Pesan Sekarang" />
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Link Tujuan</label>
                    <input type="text" class="form-control form-control-solid" name="cta_url" value="{{ $ctaUrl ?? '#' }}" placeholder="Contoh: https://wa.me/..." />
                </div>
            </div>
            <div class="mb-8">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" value="1" name="cta_new_tab" id="cta_new_tab" {{ ($ctaNewTab ?? '0') === '1' ? 'checked' : '' }} />
                    <label class="form-check-label fw-semibold text-gray-700" for="cta_new_tab">
                        Buka tautan CTA di tab baru (New Tab)
                    </label>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" id="btnSaveHeader">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>

@include('console.partials.menu_manager', [
    'title' => 'Menu Navigasi Header',
    'subtitle' => 'Atur menu navigasi (drag untuk mengubah urutan)',
    'location' => 'header',
    'menus' => $menus,
    'hasIcon' => false
])
@endsection

@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';
    let cropper = null;

    // === CROPPER LOGO ===
    const btnSelectLogo = document.getElementById('btnSelectLogo');
    const logoFileInput = document.getElementById('logoFileInput');
    const cropperImage = document.getElementById('cropperImage');
    const cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));
    const btnCropApply = document.getElementById('btnCropApply');
    const logoPreview = document.getElementById('logoPreview');
    const logoCroppedData = document.getElementById('logoCroppedData');

    btnSelectLogo.addEventListener('click', function () {
        logoFileInput.value = '';
        logoFileInput.click();
    });

    logoFileInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validasi tipe file
        const allowed = ['image/png','image/jpeg','image/jpg','image/gif','image/svg+xml','image/webp'];
        if (!allowed.includes(file.type)) {
            Swal.fire({ text: 'Format file tidak didukung.', icon: 'error', buttonsStyling: false, confirmButtonText: 'Ok', customClass: { confirmButton: 'btn btn-danger' } });
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            cropperImage.src = event.target.result;
            cropperModal.show();

            // Destroy old cropper instance
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            // Wait for modal to fully show before initializing
            document.getElementById('cropperModal').addEventListener('shown.bs.modal', function handler() {
                cropper = new Cropper(cropperImage, {
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 1,
                    responsive: true,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });
                this.removeEventListener('shown.bs.modal', handler);
            });
        };
        reader.readAsDataURL(file);
    });

    btnCropApply.addEventListener('click', function () {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            maxWidth: 800,
            maxHeight: 800,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        const croppedDataUrl = canvas.toDataURL('image/png');

        // Set preview
        logoPreview.src = croppedDataUrl;
        logoPreview.style.display = '';

        // Set hidden input value
        logoCroppedData.value = croppedDataUrl;

        // Close modal
        cropperModal.hide();
        cropper.destroy();
        cropper = null;
    });

    // Destroy cropper when modal is hidden (e.g. clicking Batal)
    document.getElementById('cropperModal').addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });

    // === AJAX FORMS ===
    const ajaxForms = document.querySelectorAll('.ajax-form');
    ajaxForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            
            const btn = this.querySelector('button[type="submit"]');
            let originalText = '';
            
            if (btn) {
                originalText = btn.innerHTML;
                btn.setAttribute('data-kt-indicator', 'on');
                btn.disabled = true;
            }

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                const data = await response.json().catch(() => null);
                
                if (response.ok && data && data.success) {
                    Swal.fire({
                        text: data.message || "Berhasil disimpan!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, mengerti!",
                        customClass: { confirmButton: "btn btn-primary" }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    let errorMsg = "Terjadi kesalahan, silakan periksa input Anda.";
                    if (data && data.errors) {
                        errorMsg = Object.values(data.errors).flat().join('<br>');
                    } else if (data && data.message) {
                        errorMsg = data.message;
                    }
                    Swal.fire({
                        html: errorMsg,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: { confirmButton: "btn btn-danger" }
                    });
                }
            })
            .catch(error => {
                console.error(error);
                Swal.fire({
                    text: "Terjadi kesalahan server.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: { confirmButton: "btn btn-danger" }
                });
            })
            .finally(() => {
                if (btn) {
                    btn.removeAttribute('data-kt-indicator');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        });
    });

    // === DELETE MENU ===
    document.querySelectorAll('.btnDeleteMenu').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const menuId = this.getAttribute('data-id');
            const deleteUrl = this.getAttribute('data-url');

            Swal.fire({
                text: "Apakah Anda yakin ingin menghapus menu ini?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('_token', csrfToken);
                    formData.append('_method', 'DELETE');
                    
                    fetch(deleteUrl, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.success) {
                            Swal.fire({
                                text: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: { confirmButton: "btn btn-primary" }
                            }).then(() => {
                                const row = document.querySelector('tr[data-id="'+menuId+'"]');
                                if (row) row.remove();
                            });
                        }
                    });
                }
            });
        });
    });

    // Sortable JS moved to menu_manager.blade.php
});
</script>
@endpush
