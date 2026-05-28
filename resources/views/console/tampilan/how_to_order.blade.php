@extends('console.tampilan.layout')

@section('tampilan_content')
<div class="card shadow-sm mb-5">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900">Pengaturan Cara Pemesanan</span>
            <span class="text-muted mt-1 fw-semibold fs-7">Atur langkah-langkah pemesanan.</span>
        </h3>
    </div>
    <div class="card-body py-5">
        <form action="{{ route('console.tampilan.how-to-order.update') }}" method="POST" class="ajax-form">
            @csrf
            
            <div class="mb-8">
                <label class="form-label fw-bold">Judul (Title)</label>
                <input type="text" class="form-control form-control-solid" name="how_to_order_title" value="{{ $settings['how_to_order_title'] ?? '' }}" />
                <div class="text-muted fs-7 mt-2">Anda dapat menambahkan inline CSS seperti &lt;span style="color: #ff6600;"&gt;Teks&lt;/span&gt; untuk memberikan warna kustom.</div>
            </div>

            <div class="mb-8">
                <label class="form-label fw-bold">Deskripsi Singkat</label>
                <textarea class="form-control form-control-solid" name="how_to_order_description" rows="3">{{ $settings['how_to_order_description'] ?? '' }}</textarea>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>

@include('console.partials.menu_manager', [
    'title' => 'Langkah-Langkah Pemesanan',
    'subtitle' => 'Atur ikon, judul langkah, dan deskripsinya.',
    'location' => 'home_how_to_order',
    'menus' => $steps,
    'hasIcon' => true,
    'linkLabel' => 'Deskripsi Singkat',
    'linkPlaceholder' => 'Masukkan deskripsi langkah...'
])
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';

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
});
</script>
@endpush
