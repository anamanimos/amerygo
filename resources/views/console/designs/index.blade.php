@extends('console.layouts.app')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Katalog Desain Jersey</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <span class="badge badge-light-{{ $currentCount >= $limit ? 'danger' : 'primary' }} fw-bold fs-6 px-4 py-3 me-2">
                {{ $currentCount }} / {{ $limit }} Desain
            </span>
            @if($currentCount >= $limit)
                <button class="btn btn-sm fw-bold btn-secondary" disabled data-bs-toggle="tooltip" title="Batas maksimal desain tercapai">Tambah Desain</button>
            @else
                <a href="{{ route('console.designs.create') }}" class="btn btn-sm fw-bold btn-primary">Tambah Desain</a>
            @endif
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>
                        <input type="text" data-kt-design-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari Desain..." />
                    </div>
                </div>
                <div class="card-toolbar">
                    <!-- Default Actions -->
                    <div class="d-flex justify-content-end" data-kt-design-table-toolbar="base">
                    </div>

                    <!-- Selected Actions -->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-design-table-toolbar="selected">
                        <div class="fw-bold me-5">
                            <span class="me-2" data-kt-design-table-select="selected_count"></span> Terpilih
                        </div>
                        <button type="button" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#bulkAddCategoryModal">Tambah Kategori</button>
                        <button type="button" class="btn btn-sm btn-info me-2" data-bs-toggle="modal" data-bs-target="#bulkAddColorModal">Tambah Warna</button>
                        <button type="button" class="btn btn-sm btn-danger" data-kt-design-table-select="delete_selected">Hapus</button>
                    </div>
                </div>
            </div>
            
            <div class="card-body py-4">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_designs">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_designs .select-row" value="1" />
                                </div>
                            </th>
                            <th class="min-w-200px">Nama Desain</th>
                            <th class="min-w-125px">Kategori</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-125px">Tanggal Dibuat</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bulk Add Category -->
<div class="modal fade" id="bulkAddCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Tambah Kategori Massal</h2>
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
            <div class="modal-body py-10 px-lg-17">
                <div class="mb-5">
                    <label class="required fs-5 fw-semibold mb-2">Pilih Kategori</label>
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih kategori" data-dropdown-parent="#bulkAddCategoryModal" id="bulkCategorySelect" multiple="multiple">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <div class="text-muted fs-7 mt-2">Kategori ini akan ditambahkan ke semua desain yang Anda pilih.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnConfirmBulkCategory">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bulk Add Color -->
<div class="modal fade" id="bulkAddColorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Tambah Warna Massal</h2>
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
            <div class="modal-body py-10 px-lg-17">
                <div class="mb-5">
                    <label class="required fs-5 fw-semibold mb-2">Pilih Warna</label>
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih warna" data-dropdown-parent="#bulkAddColorModal" id="bulkColorSelect" multiple="multiple">
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                    <div class="text-muted fs-7 mt-2">Warna ini akan ditambahkan ke semua desain yang Anda pilih.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnConfirmBulkColor">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- DataTables -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = $('#kt_table_designs').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('console.designs.index') }}",
                type: "GET"
            },
            columns: [
                { data: 'checkbox', orderable: false, searchable: false },
                { data: 'design', name: 'name' },
                { data: 'categories', name: 'categories', orderable: false },
                { data: 'status', name: 'is_active' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', orderable: false, searchable: false }
            ],
            order: [[4, 'desc']], // Urutkan berdasarkan tanggal dibuat terbaru
            language: {
                lengthMenu: "Tampilkan _MENU_",
                zeroRecords: "Tidak ada data yang ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                search: "Cari:",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });

        // Search
        document.querySelector('[data-kt-design-table-filter="search"]').addEventListener('keyup', function (e) {
            table.search(e.target.value).draw();
        });

        // Handle Toolbar
        const toolbarBase = document.querySelector('[data-kt-design-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-design-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-design-table-select="selected_count"]');
        const checkAll = document.querySelector('[data-kt-check-target="#kt_table_designs .select-row"]');

        const toggleToolbars = () => {
            const allCheckboxes = document.querySelectorAll('tbody .select-row');
            let count = 0;
            allCheckboxes.forEach(c => {
                if (c.checked) count++;
            });

            if (count > 0) {
                selectedCount.innerHTML = count;
                toolbarBase.classList.add('d-none');
                toolbarSelected.classList.remove('d-none');
            } else {
                toolbarBase.classList.remove('d-none');
                toolbarSelected.classList.add('d-none');
            }
        }

        table.on('draw', function () {
            toggleToolbars();
            
            // Reset checkAll
            checkAll.checked = false;
            
            // Checkbox change event
            const checkboxes = document.querySelectorAll('tbody .select-row');
            checkboxes.forEach(c => {
                c.addEventListener('change', function () {
                    toggleToolbars();
                });
            });

            // Single delete button handler
            const deleteButtons = document.querySelectorAll('.form-delete');
            deleteButtons.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        text: "Apakah Anda yakin ingin menghapus desain ini?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal",
                        customClass: {
                            confirmButton: "btn btn-danger",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            form.submit();
                        }
                    });
                });
            });
        });

        // Check All handler
        checkAll.addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('tbody .select-row');
            checkboxes.forEach(c => {
                c.checked = checkAll.checked;
            });
            toggleToolbars();
        });

        function doBulkAction(action, data) {
            const checkboxes = document.querySelectorAll('tbody .select-row:checked');
            const ids = [];
            checkboxes.forEach(c => ids.push(c.value));

            if (ids.length === 0) return;

            let postData = {
                action: action,
                design_ids: ids
            };
            if (data) {
                postData = { ...postData, ...data };
            }

            fetch("{{ route('console.designs.bulk-action') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(postData)
            })
            .then(res => res.json())
            .then(res => {
                if(res.success) {
                    Swal.fire({
                        text: res.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, mengerti!",
                        customClass: { confirmButton: "btn btn-primary" }
                    }).then(() => {
                        checkAll.checked = false;
                        table.draw();
                    });
                } else {
                    Swal.fire("Error", res.message, "error");
                }
            })
            .catch(err => {
                Swal.fire("Error", "Terjadi kesalahan server", "error");
            });
        }

        // Bulk Delete
        document.querySelector('[data-kt-design-table-select="delete_selected"]').addEventListener('click', function () {
            Swal.fire({
                text: "Apakah Anda yakin ingin menghapus desain yang dipilih?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Tidak, batal",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    doBulkAction('delete');
                }
            });
        });

        // Bulk Add Category
        document.getElementById('btnConfirmBulkCategory').addEventListener('click', function () {
            const categoryIds = $('#bulkCategorySelect').val();
            if(!categoryIds || categoryIds.length === 0) {
                Swal.fire("Peringatan", "Pilih minimal 1 kategori", "warning");
                return;
            }
            doBulkAction('add_category', { category_ids: categoryIds });
            $('#bulkAddCategoryModal').modal('hide');
        });

        // Bulk Add Color
        document.getElementById('btnConfirmBulkColor').addEventListener('click', function () {
            const colorIds = $('#bulkColorSelect').val();
            if(!colorIds || colorIds.length === 0) {
                Swal.fire("Peringatan", "Pilih minimal 1 warna", "warning");
                return;
            }
            doBulkAction('add_color', { color_ids: colorIds });
            $('#bulkAddColorModal').modal('hide');
        });

        // Reset selections when modals are closed
        $('#bulkAddCategoryModal').on('hidden.bs.modal', function () {
            $('#bulkCategorySelect').val(null).trigger('change');
        });
        $('#bulkAddColorModal').on('hidden.bs.modal', function () {
            $('#bulkColorSelect').val(null).trigger('change');
        });
    });
</script>
@endpush
@endsection
