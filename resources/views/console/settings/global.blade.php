@extends('console.layouts.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<style>
    .image-preview-wrapper {
        width: 100%;
        max-width: 300px;
        height: 150px;
        border: 2px dashed #e4e6ef;
        border-radius: 0.475rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        overflow: hidden;
        background-color: #f9f9f9;
        position: relative;
    }
    .image-preview-wrapper.icon-preview {
        max-width: 150px;
        height: 150px;
    }
    .image-preview-wrapper img {
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .image-preview-wrapper:hover {
        border-color: #009ef7;
        background-color: #f1faff;
    }
    .image-preview-placeholder {
        text-align: center;
        color: #a1a5b7;
    }
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
        object-fit: contain;
    }
</style>
@endpush

@section('content')
<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                Pengaturan Global
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    Sesuaikan identitas website dan SEO.
                </li>
            </ul>
        </div>
    </div>
</div>
<!--end::Toolbar-->

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card shadow-sm mb-5">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Pengaturan Global (SEO & Identitas)</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Atur nama website, favicon, dan tag SEO.</span>
                </h3>
            </div>
    <div class="card-body py-5">
        <form action="{{ route('console.settings.global.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <h4 class="mb-4 text-gray-800 fw-bold">Identitas Website</h4>
            
            <div class="row mb-8">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Website</label>
                    <input type="text" class="form-control form-control-solid" name="site_name" value="{{ $settings['site_name'] ?? 'AMERYGO' }}" placeholder="Contoh: AMERYGO" />
                    <div class="text-muted fs-7 mt-2">Nama ini akan digunakan pada tag title secara otomatis.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nomor WhatsApp</label>
                    <input type="text" class="form-control form-control-solid" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '6281234567890' }}" placeholder="Contoh: 6281234567890" />
                    <div class="text-muted fs-7 mt-2">Gunakan format kode negara tanpa '+' (contoh: 628...).</div>
                </div>
            </div>

            <div class="row mb-8">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Batas Maksimal Desain Jersey</label>
                    <input type="number" min="1" class="form-control form-control-solid" name="limit_designs" value="{{ $settings['limit_designs'] ?? '20' }}" placeholder="Contoh: 20" required />
                    <div class="text-muted fs-7 mt-2">Batas jumlah desain jersey yang dapat diunggah ke katalog (Default: 20).</div>
                </div>
            </div>

            <!-- Logo Upload Section -->
            <h5 class="mb-4 text-gray-800 fw-bold mt-10">Logo & Ikon</h5>
            <div class="row mb-8">
                <!-- Logo Light -->
                <div class="col-md-3 mb-5">
                    <label class="form-label fw-bold">Logo (Light Mode)</label>
                    <div class="text-muted fs-7 mb-2">Digunakan untuk background terang. Rasio 3:1.</div>
                    
                    <input type="file" id="input_site_logo_light" class="d-none" accept="image/*" onchange="openCropper(this, 'site_logo_light', 3/1)">
                    <input type="hidden" name="site_logo_light" id="hidden_site_logo_light">
                    
                    <div class="image-preview-wrapper" onclick="document.getElementById('input_site_logo_light').click()">
                        @if(!empty($settings['site_logo_light']))
                            <img src="{{ asset($settings['site_logo_light']) }}" id="preview_site_logo_light" class="w-100 h-100" alt="Logo Light">
                        @else
                            <img src="" id="preview_site_logo_light" class="d-none w-100 h-100" alt="Logo Light">
                            <div class="image-preview-placeholder" id="placeholder_site_logo_light">
                                <i class="ki-duotone ki-picture fs-3x text-muted mb-2"><span class="path1"></span><span class="path2"></span></i>
                                <br>Klik untuk Upload Logo Light
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Logo Dark -->
                <div class="col-md-3 mb-5">
                    <label class="form-label fw-bold">Logo (Dark Mode)</label>
                    <div class="text-muted fs-7 mb-2">Digunakan untuk background gelap. Rasio 3:1.</div>
                    
                    <input type="file" id="input_site_logo_dark" class="d-none" accept="image/*" onchange="openCropper(this, 'site_logo_dark', 3/1)">
                    <input type="hidden" name="site_logo_dark" id="hidden_site_logo_dark">
                    
                    <div class="image-preview-wrapper bg-dark border-dark" onclick="document.getElementById('input_site_logo_dark').click()">
                        @if(!empty($settings['site_logo_dark']))
                            <img src="{{ asset($settings['site_logo_dark']) }}" id="preview_site_logo_dark" class="w-100 h-100" alt="Logo Dark">
                        @else
                            <img src="" id="preview_site_logo_dark" class="d-none w-100 h-100" alt="Logo Dark">
                            <div class="image-preview-placeholder" id="placeholder_site_logo_dark">
                                <i class="ki-duotone ki-picture fs-3x text-muted mb-2"><span class="path1"></span><span class="path2"></span></i>
                                <br>Klik untuk Upload Logo Dark
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Logo Icon Light -->
                <div class="col-md-3 mb-5">
                    <label class="form-label fw-bold">Ikon (Light)</label>
                    <div class="text-muted fs-7 mb-2">Saat sidebar diperkecil. Rasio 1:1.</div>
                    
                    <input type="file" id="input_site_logo_sm_light" class="d-none" accept="image/*" onchange="openCropper(this, 'site_logo_sm_light', 1/1)">
                    <input type="hidden" name="site_logo_sm_light" id="hidden_site_logo_sm_light">
                    
                    <div class="image-preview-wrapper icon-preview" onclick="document.getElementById('input_site_logo_sm_light').click()">
                        @if(!empty($settings['site_logo_sm_light']))
                            <img src="{{ asset($settings['site_logo_sm_light']) }}" id="preview_site_logo_sm_light" class="w-100 h-100" alt="Logo Icon Light">
                        @else
                            <img src="" id="preview_site_logo_sm_light" class="d-none w-100 h-100" alt="Logo Icon Light">
                            <div class="image-preview-placeholder" id="placeholder_site_logo_sm_light">
                                <i class="ki-duotone ki-picture fs-3x text-muted mb-2"><span class="path1"></span><span class="path2"></span></i>
                                <br>Ikon Light
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Logo Icon Dark -->
                <div class="col-md-3 mb-5">
                    <label class="form-label fw-bold">Ikon (Dark)</label>
                    <div class="text-muted fs-7 mb-2">Saat sidebar diperkecil. Rasio 1:1.</div>
                    
                    <input type="file" id="input_site_logo_sm_dark" class="d-none" accept="image/*" onchange="openCropper(this, 'site_logo_sm_dark', 1/1)">
                    <input type="hidden" name="site_logo_sm_dark" id="hidden_site_logo_sm_dark">
                    
                    <div class="image-preview-wrapper bg-dark border-dark icon-preview" onclick="document.getElementById('input_site_logo_sm_dark').click()">
                        @if(!empty($settings['site_logo_sm_dark']))
                            <img src="{{ asset($settings['site_logo_sm_dark']) }}" id="preview_site_logo_sm_dark" class="w-100 h-100" alt="Logo Icon Dark">
                        @else
                            <img src="" id="preview_site_logo_sm_dark" class="d-none w-100 h-100" alt="Logo Icon Dark">
                            <div class="image-preview-placeholder" id="placeholder_site_logo_sm_dark">
                                <i class="ki-duotone ki-picture fs-3x text-muted mb-2"><span class="path1"></span><span class="path2"></span></i>
                                <br>Ikon Dark
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <label class="form-label fw-bold">Favicon (Ikon Tab Browser)</label>
                <div class="mt-1 flex items-center gap-4 d-flex">
                    @if(!empty($settings['site_favicon']))
                        <img src="{{ asset($settings['site_favicon']) }}" alt="Favicon" class="w-40px h-40px object-contain bg-light rounded border p-1 me-4">
                    @endif
                    <input type="file" class="form-control form-control-solid" name="site_favicon" accept="image/*" />
                </div>
                <div class="text-muted fs-7 mt-2">Format disarankan: PNG, ICO, ukuran 32x32 atau 64x64. Biarkan kosong jika tidak ingin mengubah.</div>
            </div>

            <hr class="text-muted border-dashed my-8">

            <h4 class="mb-4 text-gray-800 fw-bold">Pengaturan SEO Global</h4>
            <div class="mb-8">
                <label class="form-label fw-bold">SEO Title (Slogan / Deskripsi Singkat)</label>
                <input type="text" class="form-control form-control-solid" name="seo_title" value="{{ $settings['seo_title'] ?? 'Premium Custom Sportswear' }}" placeholder="Contoh: Premium Custom Sportswear" />
                <div class="text-muted fs-7 mt-2">Akan ditampilkan di tab browser sebagai: Nama Website - SEO Title</div>
            </div>

            <div class="mb-8">
                <label class="form-label fw-bold">Meta Description</label>
                <textarea class="form-control form-control-solid" name="seo_description" rows="3" placeholder="Masukkan deskripsi SEO untuk mesin pencari...">{{ $settings['seo_description'] ?? '' }}</textarea>
            </div>

            <div class="mb-8">
                <label class="form-label fw-bold">Meta Keywords</label>
                <input type="text" class="form-control form-control-solid" name="seo_keywords" value="{{ $settings['seo_keywords'] ?? '' }}" placeholder="Contoh: jersey custom, pakaian olahraga, amerygo" />
                <div class="text-muted fs-7 mt-2">Pisahkan dengan koma.</div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Pengaturan Global</button>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>

<!-- Modal Cropper -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sesuaikan Gambar (Crop)</h5>
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
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    let currentTargetId;
    let cropperModal;

    document.addEventListener('DOMContentLoaded', function () {
        cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));
        
        // Bersihkan input file saat modal ditutup (agar bisa pilih file yang sama lagi)
        document.getElementById('cropperModal').addEventListener('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            if (currentTargetId) {
                document.getElementById('input_' + currentTargetId).value = '';
            }
        });

        // Event listener untuk tombol Crop
        document.getElementById('btnCrop').addEventListener('click', function () {
            if (!cropper) return;
            
            // Dapatkan hasil crop dalam format base64
            const canvas = cropper.getCroppedCanvas({
                fillColor: 'transparent', // untuk PNG transparan
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
            
            const base64Data = canvas.toDataURL('image/png');
            
            // Set ke hidden input
            document.getElementById('hidden_' + currentTargetId).value = base64Data;
            
            // Update preview
            const previewImg = document.getElementById('preview_' + currentTargetId);
            const placeholder = document.getElementById('placeholder_' + currentTargetId);
            
            previewImg.src = base64Data;
            previewImg.classList.remove('d-none');
            
            if (placeholder) {
                placeholder.classList.add('d-none');
            }
            
            cropperModal.hide();
        });
    });

    function openCropper(input, targetId, aspectRatio) {
        if (input.files && input.files[0]) {
            currentTargetId = targetId;
            const file = input.files[0];
            const isSvg = file.type === 'image/svg+xml' || file.name.toLowerCase().endsWith('.svg');
            
            // Bypass cropper untuk file SVG
            if (isSvg) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('hidden_' + targetId).value = e.target.result;
                    const previewImg = document.getElementById('preview_' + targetId);
                    const placeholder = document.getElementById('placeholder_' + targetId);
                    
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('d-none');
                    
                    if (placeholder) {
                        placeholder.classList.add('d-none');
                    }
                }
                reader.readAsDataURL(file);
                
                // Jangan tampilkan modal cropper
                return;
            }

            const reader = new FileReader();
            
            reader.onload = function (e) {
                const image = document.getElementById('cropperImage');
                image.src = e.target.result;
                
                cropperModal.show();
                
                // Initialize cropper setelah modal tampil
                document.getElementById('cropperModal').addEventListener('shown.bs.modal', function onModalShown() {
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(image, {
                        aspectRatio: aspectRatio,
                        viewMode: 2,
                        background: false,
                        zoomable: true,
                    });
                    // Hapus event listener agar tidak menumpuk
                    document.getElementById('cropperModal').removeEventListener('shown.bs.modal', onModalShown);
                });
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
