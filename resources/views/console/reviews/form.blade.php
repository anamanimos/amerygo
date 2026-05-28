@extends('console.layouts.app')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                {{ isset($review) ? 'Edit Review' : 'Tambah Review' }}
            </h1>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card">
            <div class="card-body py-4">
                <form id="review_form" action="{{ isset($review) ? route('console.reviews.update', $review->id) : route('console.reviews.store') }}" method="POST">
                    @csrf
                    @if(isset($review))
                        @method('PUT')
                    @endif

                    <div class="row mb-10">
                        <div class="col-md-6">
                            <label class="required form-label">Nama Pelanggan</label>
                            <input type="text" name="name" class="form-control form-control-solid" placeholder="Nama Pelanggan" value="{{ old('name', $review->name ?? '') }}" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Peran / Jabatan</label>
                            <input type="text" name="role" class="form-control form-control-solid" placeholder="Contoh: Kapten Garuda Futsal" value="{{ old('role', $review->role ?? '') }}" />
                        </div>
                    </div>

                    <div class="mb-10">
                        <label class="required form-label">Isi Ulasan</label>
                        <textarea name="content" class="form-control form-control-solid" rows="4" placeholder="Ulasan pelanggan..." required>{{ old('content', $review->content ?? '') }}</textarea>
                    </div>

                    <div class="row mb-10">
                        <div class="col-md-6">
                            <label class="required form-label">Rating (1.0 - 5.0)</label>
                            <input type="number" step="0.1" min="1" max="5" name="rating" class="form-control form-control-solid" value="{{ old('rating', $review->rating ?? '5.0') }}" required />
                        </div>
                        <div class="col-md-6 d-flex align-items-center mt-6">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $review->is_active ?? true) ? 'checked' : '' }} />
                                <label class="form-check-label" for="is_active">
                                    Tampilkan di Homepage
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('console.reviews.index') }}" class="btn btn-light me-3">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('review_form');
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
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
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
                            window.location.href = "{{ route('console.reviews.index') }}";
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
