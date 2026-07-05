@extends('console.tampilan.layout')

@section('tampilan_content')
<div class="card shadow-sm mb-5">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900">Pengaturan Footer</span>
            <span class="text-muted mt-1 fw-semibold fs-7">Ubah logo, deskripsi, dan menu pada footer website</span>
        </h3>
    </div>
    <div class="card-body py-5">
        <form id="footerSettingsForm" action="{{ route('console.tampilan.footer.update') }}" method="POST" enctype="multipart/form-data" class="ajax-form">
            @csrf
            
            <h4 class="mb-4 text-gray-800">1. Identitas Brand (Kolom 1)</h4>
            <div class="mb-8">
                <label class="form-label fw-bold">Logo Footer</label>
                <div class="mb-3 d-flex align-items-center gap-4">
                    <div id="logoPreviewWrapper" class="border rounded p-2 d-inline-block" style="background-color: #f1f1f1; min-width:60px; min-height:40px;">
                        @php $logoUrl = $logo ? (str_starts_with($logo, 'storage/') ? Storage::disk('public')->url(str_replace('storage/', '', $logo)) : asset($logo)) : ''; @endphp
                        <img id="logoPreview" src="{{ $logoUrl }}" alt="Logo Preview" class="h-50px" style="{{ $logo ? '' : 'display:none;' }}">
                    </div>
                    <button type="button" class="btn btn-sm btn-light-primary" id="btnSelectLogo">
                        <i class="ki-duotone ki-picture fs-2 me-1"><span class="path1"></span><span class="path2"></span></i> Pilih & Crop Logo
                    </button>
                </div>
                <input type="file" class="d-none" id="logoFileInput" accept="image/png,image/jpeg,image/jpg,image/gif,image/svg+xml,image/webp" />
                <input type="hidden" name="logo_cropped" id="logoCroppedData" />
                <div class="text-muted fs-7 mt-2">Format yang diizinkan: png, jpg, jpeg, svg, webp.</div>
            </div>

            <div class="mb-8">
                <label class="form-label fw-bold">Deskripsi Singkat</label>
                <textarea class="form-control form-control-solid" name="description" rows="3" placeholder="Contoh: Produsen pakaian olahraga custom...">{{ $description ?? '' }}</textarea>
            </div>

            <div class="separator mb-8"></div>

            <h4 class="mb-4 text-gray-800">2. Pengaturan Judul Kolom</h4>
            <div class="row mb-5">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Judul Menu 1 (Kolom 2)</label>
                    <input type="text" class="form-control form-control-solid" name="menu_1_title" value="{{ $menu1Title }}" />
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Judul Menu 2 (Kolom 3)</label>
                    <input type="text" class="form-control form-control-solid" name="menu_2_title" value="{{ $menu2Title }}" />
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Judul Kontak (Kolom 4)</label>
                    <input type="text" class="form-control form-control-solid" name="contact_title" value="{{ $contactTitle }}" />
                </div>
            </div>

            <div class="separator mb-8"></div>

            <h4 class="mb-4 text-gray-800">3. Hak Cipta (Copyright)</h4>
            <div class="mb-8">
                <label class="form-label fw-bold">Teks Copyright</label>
                <input type="text" class="form-control form-control-solid" name="copyright" value="{{ $copyright }}" placeholder="© 2024 AMERYGO SPORT. ALL RIGHTS RESERVED." />
                <div class="text-muted fs-7 mt-2">Teks ini akan muncul di bagian paling bawah website.</div>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" id="btnSaveFooter">Simpan Pengaturan Utama</button>
            </div>
        </form>
    </div>
</div>

<!-- MENU 1 -->
@include('console.partials.menu_manager', [
    'title' => 'Menu 1 (' . $menu1Title . ')',
    'subtitle' => 'Atur menu navigasi kolom kedua (drag untuk mengubah urutan)',
    'location' => 'footer_1',
    'menus' => $footerMenu1,
    'hasIcon' => false
])

<!-- MENU 2 -->
@include('console.partials.menu_manager', [
    'title' => 'Menu 2 (' . $menu2Title . ')',
    'subtitle' => 'Atur menu navigasi kolom ketiga (drag untuk mengubah urutan)',
    'location' => 'footer_2',
    'menus' => $footerMenu2,
    'hasIcon' => false
])

<!-- KONTAK -->
@include('console.partials.menu_manager', [
    'title' => 'Kontak (' . $contactTitle . ')',
    'subtitle' => 'Atur ikon dan teks kontak (drag untuk mengubah urutan)',
    'location' => 'footer_contact',
    'menus' => $footerContact,
    'hasIcon' => true
])

<!-- SOCIAL MEDIA ICONS -->
@include('console.partials.menu_manager', [
    'title' => 'Ikon Media Sosial',
    'subtitle' => 'Atur tautan ikon media sosial yang muncul di bawah deskripsi',
    'location' => 'footer_social',
    'menus' => $footerSocial,
    'hasIcon' => true
])

<!-- Modal Cropper -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Crop Logo Footer</h5>
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
@endsection

@push('scripts')
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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

        const allowed = ['image/png','image/jpeg','image/jpg','image/gif','image/svg+xml','image/webp'];
        if (!allowed.includes(file.type)) {
            Swal.fire({ text: 'Format file tidak didukung.', icon: 'error', buttonsStyling: false, confirmButtonText: 'Ok', customClass: { confirmButton: 'btn btn-danger' } });
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            cropperImage.src = event.target.result;
            cropperModal.show();

            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

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
        logoPreview.src = croppedDataUrl;
        logoPreview.style.display = '';
        logoCroppedData.value = croppedDataUrl;

        cropperModal.hide();
        cropper.destroy();
        cropper = null;
    });

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
                text: "Apakah Anda yakin ingin menghapus ini?",
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
