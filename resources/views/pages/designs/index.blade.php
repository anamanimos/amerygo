@extends('layouts.app')

@section('content')
<main class="flex-grow pt-20 md:pt-32 pb-24">
    <div class="max-w-container-max mx-auto px-4 md:px-md">
        
        <!-- Page Header & Filters -->
        <div class="mb-12 border-b border-surface-container-highest pb-8">
            <h1 class="font-headline-lg text-4xl md:text-5xl font-black uppercase italic mb-2">Katalog <span class="text-primary-container">Desain Jersey</span></h1>
            <p class="text-on-secondary-container mb-8">Temukan inspirasi desain jersey terbaik untuk tim kesayangan Anda.</p>
            
            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
                <!-- Category Filter (Pills) -->
                <div class="flex overflow-x-auto snap-x gap-3 pb-2 -mx-4 px-4 md:mx-0 md:px-0 w-full xl:w-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
                    <a href="{{ route('designs', request()->except('category')) }}" class="snap-center shrink-0 px-6 py-2.5 rounded-full {{ request('category') ? 'bg-surface-container border-2 border-surface-container-highest text-on-surface hover:border-primary-container/50 hover:text-primary-container' : 'bg-primary-container text-background border-2 border-primary-container shadow-[0_0_16px_rgba(255,102,0,0.3)]' }} font-bold text-sm transition-colors">Semua</a>
                    @foreach($categories as $cat)
                    <a href="{{ route('designs', array_merge(request()->all(), ['category' => $cat->slug])) }}" class="snap-center shrink-0 px-6 py-2.5 rounded-full {{ request('category') == $cat->slug ? 'bg-primary-container text-background border-2 border-primary-container shadow-[0_0_16px_rgba(255,102,0,0.3)]' : 'bg-surface-container border-2 border-surface-container-highest text-on-surface hover:border-primary-container/50 hover:text-primary-container' }} transition-colors font-medium text-sm">{{ $cat->name }}</a>
                    @endforeach
                </div>

                <!-- Search Box -->
                <form action="{{ route('designs') }}" method="GET" class="relative w-full xl:w-80">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari desain jersey..." class="w-full bg-surface-container border border-surface-container-highest rounded-full px-5 py-2.5 text-sm text-on-surface placeholder-on-secondary-container focus:outline-none focus:border-primary-container transition-colors" />
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-on-secondary-container hover:text-primary-container transition-colors">
                        <span class="material-symbols-rounded text-xl">search</span>
                    </button>
                </form>
            </div>
        </div>

        @if($designs->count() > 0)
        <!-- Designs Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8 mb-16">
            @foreach($designs as $design)
            <div class="group flex flex-col gap-4 cursor-pointer design-card" 
                 data-name="{{ $design->name }}"
                 data-slug="{{ $design->slug }}"
                 data-image="{{ $design->image ? Storage::disk('public')->url(str_replace('storage/', '', $design->image)) : '' }}"
                 data-category="{{ $design->category ? $design->category->name : 'Uncategorized' }}"
                 onclick="openDesignModal(this)">
                 
                <!-- Description Container (Hidden) -->
                <div class="hidden-description hidden">{!! $design->description !!}</div>

                <div class="aspect-[4/5] relative overflow-hidden rounded-2xl bg-surface-container shadow-lg transition-shadow duration-300 group-hover:shadow-primary-container/20">
                    @if($design->image)
                        <img alt="{{ $design->name }}" class="object-cover w-full h-full transition-transform duration-700 ease-out group-hover:scale-105" src="{{ Storage::disk('public')->url(str_replace('storage/', '', $design->image)) }}"/>
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-surface-container-highest">
                            <span class="material-symbols-rounded text-6xl text-on-secondary-container">image</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <span class="bg-background/80 backdrop-blur-md text-primary-container px-6 py-2 rounded-full font-bold text-sm tracking-wide transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">Lihat Detail</span>
                    </div>
                </div>
                <div class="flex flex-col px-2">
                    <p class="text-on-secondary-container text-xs mb-1 uppercase tracking-wider font-bold">{{ $design->category ? $design->category->name : 'Uncategorized' }}</p>
                    <h3 class="font-headline-md font-bold text-base sm:text-lg text-on-surface group-hover:text-primary-container transition-colors leading-tight line-clamp-2">{{ $design->name }}</h3>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center border-t border-surface-container-highest pt-8 mt-12 custom-pagination">
            {{ $designs->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <span class="material-symbols-rounded text-6xl text-on-secondary-container mb-4 block">gallery_thumbnail</span>
            <h3 class="text-2xl font-bold text-on-surface mb-2">Belum ada desain</h3>
            <p class="text-on-secondary-container">Silakan kembali lagi nanti atau coba ubah filter pencarian Anda.</p>
        </div>
        @endif
    </div>
</main>

<!-- Lightbox Modal -->
<div id="designModal" class="fixed inset-0 z-50 hidden items-center justify-center p-2 sm:p-4">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/85 backdrop-blur-sm" onclick="closeDesignModal()"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-surface-container border border-surface-container-highest rounded-3xl p-3 sm:p-6 md:p-8 max-w-md w-full max-h-[95vh] overflow-y-auto flex flex-col items-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out" id="modalContent">
        <!-- Close Button -->
        <button onclick="closeDesignModal()" class="absolute top-3 right-3 text-on-secondary-container hover:text-primary-container transition-colors focus:outline-none z-10 bg-surface-container-high p-1.5 rounded-full border border-surface-container-highest shadow-sm">
            <span class="material-symbols-rounded text-lg block">close</span>
        </button>

        <!-- Category -->
        <span id="modalCategory" class="px-3.5 py-1 rounded-full bg-surface-container-high border border-surface-container-highest text-primary-container text-[11px] font-bold mb-3"></span>
        
        <!-- Title -->
        <h3 id="modalTitle" class="text-lg sm:text-2xl font-black font-headline-lg uppercase text-on-surface mb-4 text-center leading-tight"></h3>
        
        <!-- Image Container -->
        <div class="w-full rounded-2xl overflow-hidden bg-surface-container-lowest mb-4 border border-surface-container-highest flex items-center justify-center">
            <img id="modalImage" src="" alt="" class="w-full h-auto object-contain" />
        </div>

        <!-- Description -->
        <div id="modalDescription" class="prose prose-xs sm:prose-sm dark:prose-invert max-w-none mb-5 text-on-surface-variant text-center text-xs sm:text-sm"></div>
        
        <!-- WA Button -->
        <a id="modalWaBtn" href="" target="_blank" class="w-full bg-primary-container hover:bg-primary text-background text-sm sm:text-base font-bold py-3 px-6 rounded-full shadow-[0_0_15px_rgba(255,102,0,0.25)] hover:shadow-[0_0_25px_rgba(255,102,0,0.45)] transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
            Pilih Produk Ini
        </a>
    </div>
</div>

<script>
    function openDesignModal(element) {
        const name = element.getAttribute('data-name');
        const slug = element.getAttribute('data-slug');
        const image = element.getAttribute('data-image');
        const category = element.getAttribute('data-category');
        const description = element.querySelector('.hidden-description').innerHTML;
        
        // Construct WA link with design page URL
        const designUrl = window.location.origin + '/designs/' + slug;
        const waNumber = "{{ $whatsappNumber }}";
        const waText = `Halo Admin, saya tertarik dengan desain jersey ${name} ini (${designUrl}). Apakah bisa dibantu untuk pemesanannya?`;
        const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(waText)}`;
        
        document.getElementById('modalTitle').innerText = name;
        document.getElementById('modalCategory').innerText = category;
        
        const modalImg = document.getElementById('modalImage');
        if (image) {
            modalImg.src = image;
            modalImg.alt = name;
            modalImg.parentElement.classList.remove('d-none');
        } else {
            modalImg.src = '';
            modalImg.parentElement.classList.add('d-none');
        }
        
        document.getElementById('modalDescription').innerHTML = description;
        document.getElementById('modalWaBtn').href = waUrl;
        
        const modal = document.getElementById('designModal');
        const content = document.getElementById('modalContent');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Force reflow
        modal.offsetHeight;
        
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeDesignModal() {
        const modal = document.getElementById('designModal');
        const content = document.getElementById('modalContent');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }
</script>

<style>
    .custom-pagination nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .custom-pagination [aria-current="page"] span {
        background-color: rgb(var(--color-primary-container)) !important;
        color: rgb(var(--color-background)) !important;
        font-weight: 700;
        box-shadow: 0 0 16px rgba(255,102,0,0.3);
        border: none !important;
    }
</style>
@endsection
