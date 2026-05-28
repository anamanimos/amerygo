@extends('console.layouts.app')

@section('content')
<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                {{ isset($pricing) ? 'Edit Paket Harga' : 'Tambah Paket Harga' }}
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar container-->
</div>
<!--end::Toolbar-->

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body py-4">
                <form id="pricing_form" action="{{ isset($pricing) ? route('console.pricings.update', $pricing->id) : route('console.pricings.store') }}" method="POST">
                    @csrf
                    @if(isset($pricing))
                        @method('PUT')
                    @endif

                    <div class="mb-10">
                        <label class="required form-label">Nama Paket</label>
                        <input type="text" name="name" class="form-control form-control-solid" placeholder="Contoh: Basic" value="{{ old('name', $pricing->name ?? '') }}" required />
                        @error('name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-10">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control form-control-solid" rows="3" placeholder="Deskripsi singkat paket">{{ old('description', $pricing->description ?? '') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-10">
                        <div class="col-md-6">
                            <label class="required form-label">Harga Asli (Rp)</label>
                            <input type="number" name="original_price" class="form-control form-control-solid" placeholder="Contoh: 150000" value="{{ old('original_price', $pricing->original_price ?? '') }}" required />
                            @error('original_price')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="required form-label">Harga Diskon (Rp)</label>
                            <input type="number" name="discounted_price" class="form-control form-control-solid" placeholder="Contoh: 120000" value="{{ old('discounted_price', $pricing->discounted_price ?? '') }}" required />
                            @error('discounted_price')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-10">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="is_best_seller" value="1" id="is_best_seller" {{ old('is_best_seller', $pricing->is_best_seller ?? false) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_best_seller">
                                Tandai sebagai Best Seller
                            </label>
                        </div>
                    </div>

                    <div class="row mb-10">
                        <div class="col-md-6">
                            <label class="form-label">Teks Tombol CTA</label>
                            <input type="text" name="cta_text" class="form-control form-control-solid" placeholder="Contoh: Pilih Paket Basic" value="{{ old('cta_text', $pricing->cta_text ?? '') }}" />
                            @error('cta_text')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Link Tombol CTA</label>
                            <input type="text" name="cta_link" class="form-control form-control-solid" placeholder="Contoh: https://wa.me/62..." value="{{ old('cta_link', $pricing->cta_link ?? '') }}" />
                            @error('cta_link')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-10">
                        <label class="form-label">Fitur Paket</label>
                        <div id="features_container">
                            @php
                                $features = old('features', isset($pricing) ? $pricing->features : []);
                            @endphp

                            @if(is_array($features) && count($features) > 0)
                                @foreach($features as $index => $feature)
                                    <div class="row mb-3 feature-row">
                                        <div class="col-md-8">
                                            <input type="text" name="features[{{ $index }}][name]" class="form-control form-control-solid" placeholder="Nama Fitur" value="{{ is_array($feature) ? $feature['name'] : '' }}" required />
                                        </div>
                                        <div class="col-md-3 d-flex align-items-center">
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="features[{{ $index }}][included]" value="1" {{ (is_array($feature) && isset($feature['included']) && $feature['included']) ? 'checked' : '' }} />
                                                <label class="form-check-label">Termasuk</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-sm btn-icon btn-light-danger btn-remove-feature"><i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-light-primary mt-3" id="btn_add_feature">
                            <i class="ki-duotone ki-plus fs-2"></i> Tambah Fitur
                        </button>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('console.pricings.index') }}" class="btn btn-light me-3">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let featureIndex = {{ is_array($features) ? count($features) : 0 }};
        const container = document.getElementById('features_container');
        const btnAdd = document.getElementById('btn_add_feature');

        btnAdd.addEventListener('click', function () {
            const html = `
                <div class="row mb-3 feature-row">
                    <div class="col-md-8">
                        <input type="text" name="features[${featureIndex}][name]" class="form-control form-control-solid" placeholder="Nama Fitur" required />
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="features[${featureIndex}][included]" value="1" checked />
                            <label class="form-check-label">Termasuk</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-icon btn-light-danger btn-remove-feature"><i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            featureIndex++;
        });

        container.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-remove-feature');
            if (btn) {
                btn.closest('.feature-row').remove();
            }
        });

        // AJAX Form Submission
        const form = document.getElementById('pricing_form');
        const submitBtn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;

            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
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
                            window.location.href = "{{ route('console.pricings.index') }}";
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
@endsection
