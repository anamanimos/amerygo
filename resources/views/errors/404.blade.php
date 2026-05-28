@extends('layouts.app')

@section('content')
<main class="flex-grow flex items-center justify-center pt-20 px-4">
    <div class="max-w-xl mx-auto text-center">
        <!-- Huge 404 Text -->
        <h1 class="font-headline-lg font-black italic text-[140px] md:text-[200px] leading-none text-surface-container-highest drop-shadow-2xl select-none relative inline-block">
            404
            <!-- Subtle gradient overlay on text to make it blend into background -->
            <span class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent pointer-events-none"></span>
        </h1>
        
        <div class="relative -mt-16 md:-mt-24 z-10 space-y-6">
            <h2 class="font-headline-md font-bold text-3xl md:text-5xl text-on-surface drop-shadow-md">Oops! Halaman Tidak Ditemukan</h2>
            <p class="text-on-secondary-container text-lg md:text-xl max-w-md mx-auto leading-relaxed">
                Maaf, halaman yang Anda cari sepertinya telah dipindahkan, dihapus, atau mungkin Anda salah mengetikkan alamat URL.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-8">
                <a href="{{ route('home') }}" class="w-full sm:w-auto px-8 py-4 bg-primary-container text-background font-bold rounded-full hover:bg-[#e65c00] active:scale-[0.98] transition-all duration-300 glow-primary flex items-center justify-center gap-2">
                    <span class="material-symbols-rounded text-xl">home</span> Kembali ke Beranda
                </a>
                <a href="{{ route('products') }}" class="w-full sm:w-auto px-8 py-4 bg-surface-container border border-surface-container-highest text-on-surface font-bold rounded-full hover:border-primary-container/50 hover:text-primary-container transition-all duration-300 flex items-center justify-center gap-2">
                    <span class="material-symbols-rounded text-xl">shopping_cart</span> Belanja Sekarang
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
