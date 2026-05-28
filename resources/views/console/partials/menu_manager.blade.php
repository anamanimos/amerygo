@props(['title', 'subtitle', 'location', 'menus', 'hasIcon' => false])

<div class="card shadow-sm mb-5">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900">{{ $title }}</span>
            <span class="text-muted mt-1 fw-semibold fs-7">{{ $subtitle }}</span>
        </h3>
    </div>
    <div class="card-body py-5">
        <form action="{{ route('console.tampilan.menu.store') }}" method="POST" class="mb-8 bg-white rounded p-5 border border-dashed border-gray-400 ajax-form">
            @csrf
            <input type="hidden" name="location" value="{{ $location }}">
            <div class="row align-items-end">
                @php
                $keenicons = [
                    'geolocation', 'phone', 'telephone', 'call', 'sms', 'globe', 'devices', 'messages', 'shop', 'time', 'information', 
                    'facebook', 'instagram', 'twitter', 'whatsapp', 'youtube', 'address-book', 'bank', 
                    'briefcase', 'calculator', 'calendar', 'calendar-8', 'chart-line-star', 'chart-pie-3', 
                    'chart-pie-4', 'clipboard', 'clipboard-list', 'compass', 'credit-cart', 'document', 
                    'exit-right-corner', 'file', 'filter', 'finance-calculator', 'folder', 'folder-added', 
                    'graph-up', 'heart', 'home', 'home-2', 'key', 'map', 'send', 'send-2', 'setting-2', 
                    'setting-3', 'shield-tick', 'star', 'star-tick', 'tag', 'trash', 'user', 'user-tick', 'wallet'
                ];
                @endphp
                @if($hasIcon)
                <div class="col-md-3">
                    <label class="form-label">Ikon (Metronic)</label>
                    <div class="dropdown custom-icon-picker">
                        <button class="btn btn-outline btn-outline-dashed btn-outline-default d-flex flex-center p-2 w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" style="height: calc(1.5em + 1.1rem + 2px);">
                            <i class="ki-duotone ki-geolocation fs-2 icon-preview me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                            <span class="text-muted fs-7">Pilih Ikon</span>
                        </button>
                        <div class="dropdown-menu p-3 shadow-sm border-0" style="width: 320px; max-height: 300px; overflow-y: auto;">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($keenicons as $ic)
                                <button type="button" class="btn btn-icon btn-light btn-active-primary w-40px h-40px icon-select-btn" data-icon="{{ $ic }}" title="{{ $ic }}">
                                    <i class="ki-duotone ki-{{ $ic }} fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                </button>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="icon" class="icon-value" value="geolocation" required>
                    </div>
                </div>
                @endif
                <div class="{{ $hasIcon ? 'col-md-4' : 'col-md-4' }}">
                    <label class="form-label">Teks / Konten</label>
                    <input type="text" class="form-control form-control-solid form-control-sm" name="label" required>
                </div>
                <div class="{{ $hasIcon ? 'col-md-3' : 'col-md-4' }}">
                    <label class="form-label">{{ $linkLabel ?? 'Link (Opsional)' }}</label>
                    <input type="text" class="form-control form-control-solid form-control-sm" name="url" placeholder="{{ $linkPlaceholder ?? '' }}">
                </div>
                @if(!$hasIcon)
                <div class="col-md-2 pb-2">
                    <div class="form-check form-check-custom form-check-solid form-check-sm">
                        <input class="form-check-input" type="checkbox" name="is_new_tab" value="1">
                        <label class="form-check-label">New Tab</label>
                    </div>
                </div>
                @endif
                <div class="{{ $hasIcon ? 'col-md-2' : 'col-md-2' }}">
                    <button type="submit" class="btn btn-primary btn-sm w-100 text-nowrap"><i class="ki-duotone ki-plus fs-2"></i> Tambah</button>
                </div>
            </div>
        </form>

        <form action="{{ route('console.tampilan.menu.updateAll') }}" method="POST" class="ajax-form">
            @csrf
            <div class="table-responsive" style="overflow: visible;">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bold text-muted">
                            <th class="w-50px text-center">Urut</th>
                            @if($hasIcon)
                            <th class="w-150px">Ikon</th>
                            @endif
                            <th class="min-w-150px">Teks / Konten</th>
                            <th class="min-w-150px">{{ $linkLabel ?? 'Link/URL' }}</th>
                            @if(!$hasIcon)
                            <th class="w-50px text-center">New Tab</th>
                            @endif
                            <th class="w-100px text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="menu-sortable-{{ $location }}">
                        @forelse($menus as $menu)
                            <tr data-id="{{ $menu->id }}">
                                <td class="text-center cursor-move handle-{{ $location }}"><i class="ki-duotone ki-burger-menu fs-2 text-muted"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i></td>
                                @if($hasIcon)
                                <td>
                                    <div class="dropdown custom-icon-picker">
                                        <button class="btn btn-outline btn-outline-dashed btn-outline-default d-flex flex-center p-2 w-40px h-40px" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                            <i class="ki-duotone ki-{{ $menu->icon ?? 'geolocation' }} fs-2 icon-preview"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                        </button>
                                        <div class="dropdown-menu p-3 shadow-sm border-0" style="width: 320px; max-height: 300px; overflow-y: auto;">
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($keenicons as $ic)
                                                <button type="button" class="btn btn-icon btn-light btn-active-primary w-40px h-40px icon-select-btn {{ ($menu->icon ?? '') == $ic ? 'active' : '' }}" data-icon="{{ $ic }}" title="{{ $ic }}">
                                                    <i class="ki-duotone ki-{{ $ic }} fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                </button>
                                                @endforeach
                                            </div>
                                        </div>
                                        <input type="hidden" name="menus[{{ $menu->id }}][icon]" class="icon-value" value="{{ $menu->icon ?? 'geolocation' }}" required>
                                    </div>
                                </td>
                                @endif
                                <td><input type="text" class="form-control form-control-solid form-control-sm" name="menus[{{ $menu->id }}][label]" value="{{ $menu->label }}" required></td>
                                <td><input type="text" class="form-control form-control-solid form-control-sm" name="menus[{{ $menu->id }}][url]" value="{{ $menu->url }}"></td>
                                @if(!$hasIcon)
                                <td class="text-center"><div class="form-check form-check-custom form-check-solid form-check-sm justify-content-center"><input class="form-check-input" type="checkbox" name="menus[{{ $menu->id }}][is_new_tab]" value="1" {{ $menu->is_new_tab ? 'checked' : '' }}></div></td>
                                @endif
                                <td class="text-center"><button type="button" data-id="{{ $menu->id }}" data-url="{{ route('console.tampilan.menu.destroy', $menu->id) }}" class="btn btn-icon btn-light-danger btn-sm btnDeleteMenu"><i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></button></td>
                            </tr>
                        @empty
                            <tr><td colspan="{{ $hasIcon ? 5 : 5 }}" class="text-center text-muted py-5">Belum ada item.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(count($menus) > 0)
            <div class="d-flex justify-content-end mt-5"><button type="submit" class="btn btn-primary">Simpan {{ $title }}</button></div>
            @endif
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // === SORTABLE ({{ $location }}) ===
    try {
        const el = document.getElementById('menu-sortable-{{ $location }}');
        if (el && el.children.length > 0 && typeof Sortable !== 'undefined') {
            new Sortable(el, {
                handle: '.handle-{{ $location }}',
                animation: 150,
                onEnd: function () {
                    const order = [];
                    el.querySelectorAll('tr[data-id]').forEach(row => {
                        order.push(row.dataset.id);
                    });
                    if(order.length === 0) return;

                    fetch('{{ route('console.tampilan.menu.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.success) {
                            Swal.fire({
                                text: "Urutan berhasil diperbarui!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: { confirmButton: "btn btn-primary" }
                            });
                        }
                    });
                }
            });
        }
    } catch (e) {}
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const iconPickers = document.querySelectorAll('.custom-icon-picker');
    iconPickers.forEach(picker => {
        const btnSelects = picker.querySelectorAll('.icon-select-btn');
        const inputHidden = picker.querySelector('.icon-value');
        const previewIcon = picker.querySelector('.icon-preview');
        
        btnSelects.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const iconName = this.getAttribute('data-icon');
                
                // Update hidden input
                inputHidden.value = iconName;
                
                // Update preview classes (keep base classes, swap ki-[icon])
                previewIcon.className = 'ki-duotone ki-' + iconName + ' fs-2 icon-preview' + (previewIcon.classList.contains('me-2') ? ' me-2' : '');
                
                // Manage active state in grid
                btnSelects.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Close dropdown
                const dropdownToggle = picker.querySelector('[data-bs-toggle="dropdown"]');
                const bsDropdown = bootstrap.Dropdown.getInstance(dropdownToggle) || new bootstrap.Dropdown(dropdownToggle);
                bsDropdown.hide();
            });
        });
    });
});
</script>
@endpush
