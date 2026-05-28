@extends('layouts.app')

@section('content')
<main class="flex-grow pt-20 md:pt-32 pb-24">
    <div class="max-w-container-max mx-auto px-4 md:px-md">
        
        <!-- Page Header & Filters -->
        <div class="mb-12 border-b border-surface-container-highest pb-8">
            <h1 class="font-headline-lg text-4xl md:text-5xl font-black uppercase italic mb-2">Semua <span class="text-primary-container">Produk</span></h1>
            <p class="text-on-secondary-container mb-8">Temukan koleksi apparel olahraga custom terbaik untuk tim Anda.</p>
            
            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
                <!-- Category Filter (Pills) -->
                <div class="flex overflow-x-auto snap-x gap-3 pb-2 -mx-4 px-4 md:mx-0 md:px-0 w-full xl:w-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
                    <a href="{{ route('products') }}" class="snap-center shrink-0 px-6 py-2.5 rounded-full {{ request('category') ? 'bg-surface-container border-2 border-surface-container-highest text-on-surface hover:border-primary-container/50 hover:text-primary-container' : 'bg-primary-container text-background border-2 border-primary-container shadow-[0_0_16px_rgba(255,102,0,0.3)]' }} font-bold text-sm transition-colors">Semua</a>
                    @foreach($categories as $cat)
                    <a href="{{ route('products', ['category' => $cat->slug]) }}" class="snap-center shrink-0 px-6 py-2.5 rounded-full {{ request('category') == $cat->slug ? 'bg-primary-container text-background border-2 border-primary-container shadow-[0_0_16px_rgba(255,102,0,0.3)]' : 'bg-surface-container border-2 border-surface-container-highest text-on-surface hover:border-primary-container/50 hover:text-primary-container' }} transition-colors font-medium text-sm">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        @if($products->count() > 0)
        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8 mb-16">
            @foreach($products as $product)
            <div class="group flex flex-col gap-4 cursor-pointer" onclick="window.location.href='{{ route('products.show', $product->slug) }}'">
                <div class="aspect-[4/5] relative overflow-hidden rounded-2xl bg-surface-container shadow-lg transition-shadow duration-300 group-hover:shadow-primary-container/20">
                    @if($product->thumbnail)
                        <img alt="{{ $product->name }}" class="object-cover w-full h-full transition-transform duration-700 ease-out group-hover:scale-105" src="{{ asset($product->thumbnail) }}"/>
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-surface-container-highest">
                            <span class="material-symbols-rounded text-6xl text-on-secondary-container">image</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <span class="bg-background/80 backdrop-blur-md text-primary-container px-6 py-2 rounded-full font-bold text-sm tracking-wide transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">Lihat Detail</span>
                    </div>
                    @if($product->discount_price > 0 && $product->discount_price < $product->price)
                        @php
                            $discountPerc = round((($product->price - $product->discount_price) / $product->price) * 100);
                        @endphp
                        <div class="absolute top-3 left-3 bg-red-600 text-white font-bold text-[10px] px-2 py-1 rounded">-{{ $discountPerc }}% OFF</div>
                    @endif
                </div>
                <div class="flex flex-col px-2">
                    <p class="text-on-secondary-container text-xs mb-1 uppercase tracking-wider font-bold">{{ $product->category ? $product->category->name : 'Uncategorized' }}</p>
                    <h3 class="font-headline-md font-bold text-base sm:text-lg text-on-surface group-hover:text-primary-container transition-colors leading-tight line-clamp-2">{{ $product->name }}</h3>
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mt-2">
                        @if($product->discount_price > 0 && $product->discount_price < $product->price)
                            <span class="font-bold text-primary-container text-sm sm:text-lg whitespace-nowrap">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            <span class="text-on-secondary-container text-xs sm:text-sm line-through decoration-on-secondary-container/50 whitespace-nowrap">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @else
                            <span class="font-bold text-primary-container text-sm sm:text-lg whitespace-nowrap">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center border-t border-surface-container-highest pt-8 mt-12 custom-pagination">
            {{ $products->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <span class="material-symbols-rounded text-6xl text-on-secondary-container mb-4 block">inventory_2</span>
            <h3 class="text-2xl font-bold text-on-surface mb-2">Belum ada produk</h3>
            <p class="text-on-secondary-container">Silakan kembali lagi nanti untuk melihat koleksi terbaru kami.</p>
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
