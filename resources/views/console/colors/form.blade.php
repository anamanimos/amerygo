@extends('console.layouts.app')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                {{ isset($color) ? 'Edit Warna' : 'Tambah Warna' }}
            </h1>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card">
            <div class="card-body py-4">
                <form id="color_form" action="{{ isset($color) ? route('console.colors.update', $color->id) : route('console.colors.store') }}" method="POST">
                    @csrf
                    @if(isset($color))
                        @method('PUT')
                    @endif

                    <div class="mb-10">
                        <label class="required form-label">Nama Warna</label>
                        <input type="text" name="name" class="form-control form-control-solid" placeholder="Nama Warna (misal: Merah)" value="{{ old('name', $color->name ?? '') }}" required />
                    </div>

                    <div class="mb-10">
                        <label class="form-label">Kode Hex (Opsional)</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="color" class="form-control form-control-color w-50px h-50px p-1" id="hex_picker" value="{{ old('hex_code', $color->hex_code ?? '#000000') }}" title="Pilih Warna">
                            <input type="text" name="hex_code" id="hex_input" class="form-control form-control-solid flex-grow-1" placeholder="Kode Hex (misal: #FF0000)" value="{{ old('hex_code', $color->hex_code ?? '') }}" />
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('console.colors.index') }}" class="btn btn-light me-3">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hexPicker = document.getElementById('hex_picker');
        const hexInput = document.getElementById('hex_input');

        hexPicker.addEventListener('input', function() {
            hexInput.value = this.value;
        });

        hexInput.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                hexPicker.value = this.value;
            }
        });

        const form = document.getElementById('color_form');
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
                            window.location.href = "{{ route('console.colors.index') }}";
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
