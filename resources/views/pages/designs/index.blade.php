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
            <div class="group flex flex-col gap-4 cursor-pointer" onclick="window.location.href='{{ route('designs.show', $design->slug) }}'">
                <div class="aspect-[4/5] relative overflow-hidden rounded-2xl bg-surface-container shadow-lg transition-shadow duration-300 group-hover:shadow-primary-container/20">
                    @if($design->image)
                        <img alt="{{ $design->name }}" class="object-cover w-full h-full transition-transform duration-700 ease-out group-hover:scale-105" src="{{ asset($design->image) }}"/>
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
