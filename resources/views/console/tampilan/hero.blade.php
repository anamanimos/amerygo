@extends('console.tampilan.layout')

@section('tampilan_content')
<div class="card shadow-sm mb-5">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900">Pengaturan Hero</span>
            <span class="text-muted mt-1 fw-semibold fs-7">Atur konten untuk bagian Hero (Banner Utama).</span>
        </h3>
    </div>
    <div class="card-body py-5">
        <form action="{{ route('console.tampilan.hero.update') }}" method="POST" enctype="multipart/form-data" class="ajax-form">
            @csrf
            
            <div class="row mb-8">
                <div class="col-md-8">
                    <div class="mb-8">
                        <label class="form-label fw-bold">Judul Utama (Title)</label>
                        <textarea class="form-control form-control-solid" name="hero_title" rows="4" placeholder="Gunakan tag <br> untuk baris baru">{{ $settings['hero_title'] ?? '' }}</textarea>
                        <div class="text-muted fs-7 mt-2">Anda dapat menggunakan tag HTML dasar seperti &lt;br&gt; atau menambahkan inline CSS seperti &lt;span style="color: #ff6600; text-shadow: 0 0 15px rgba(255,102,0,0.5);"&gt;Teks&lt;/span&gt; untuk memberikan gaya/warna kustom.</div>
                    </div>

                    <div class="mb-8">
                        <label class="form-label fw-bold">Deskripsi Pendek</label>
                        <textarea class="form-control form-control-solid" name="hero_description" rows="3">{{ $settings['hero_description'] ?? '' }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-8">
                            <label class="form-label fw-bold">Teks Tombol Utama</label>
                            <input type="text" class="form-control form-control-solid" name="hero_btn1_text" value="{{ $settings['hero_btn1_text'] ?? '' }}" />
                        </div>
                        <div class="col-md-6 mb-8">
                            <label class="form-label fw-bold">URL Tombol Utama</label>
                            <input type="text" class="form-control form-control-solid" name="hero_btn1_url" value="{{ $settings['hero_btn1_url'] ?? '' }}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-8">
                            <label class="form-label fw-bold">Teks Tombol Kedua</label>
                            <input type="text" class="form-control form-control-solid" name="hero_btn2_text" value="{{ $settings['hero_btn2_text'] ?? '' }}" />
                        </div>
                        <div class="col-md-6 mb-8">
                            <label class="form-label fw-bold">URL Tombol Kedua</label>
                            <input type="text" class="form-control form-control-solid" name="hero_btn2_url" value="{{ $settings['hero_btn2_url'] ?? '' }}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-8">
                            <label class="form-label fw-bold">Teks Lencana 1 (Kiri Atas)</label>
                            <input type="text" class="form-control form-control-solid" name="hero_badge1" value="{{ $settings['hero_badge1'] ?? '' }}" />
                        </div>
                        <div class="col-md-6 mb-8">
                            <label class="form-label fw-bold">Teks Lencana 2 (Kanan Bawah)</label>
                            <input type="text" class="form-control form-control-solid" name="hero_badge2" value="{{ $settings['hero_badge2'] ?? '' }}" />
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-8 text-center">
                        <label class="form-label fw-bold d-block text-start">Gambar Utama (Hero Image)</label>
                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{ asset('metronic/assets/media/svg/avatars/blank.svg') }}')">
                            <!--begin::Preview existing avatar-->
                            <div class="image-input-wrapper w-200px h-200px shadow-sm" style="background-image: url('{{ !empty($settings['hero_image']) ? asset($settings['hero_image']) : asset('metronic/assets/media/svg/avatars/blank.svg') }}'); background-position: center; background-size: cover;"></div>
                            <!--end::Preview existing avatar-->
                            
                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-35px h-35px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah gambar">
                                <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                                <!--begin::Inputs-->
                                <input type="file" name="hero_image" accept=".png, .jpg, .jpeg, .webp"/>
                                <input type="hidden" name="avatar_remove"/>
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->
                        </div>
                        <div class="form-text mt-3 text-start">Format file yang diizinkan: png, jpg, jpeg, webp. Ukuran rasio 1:1 disarankan.</div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Pengaturan Hero</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
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
});
</script>
@endpush
