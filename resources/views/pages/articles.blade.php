@extends('layouts.app')

@section('content')
<main class="flex-grow pt-32 pb-24">
    <div class="max-w-container-max mx-auto px-4 md:px-md">
        
        <!-- Header -->
        <div class="mb-12 border-b border-surface-container-highest pb-8">
            <h1 class="font-headline-lg text-4xl md:text-5xl font-black uppercase italic mb-2">Semua <span class="text-primary-container">Artikel</span></h1>
            <p class="text-on-secondary-container mb-8">Tips, trik, tren desain, dan berita terbaru seputar custom apparel.</p>
            
            <div class="flex overflow-x-auto snap-x gap-3 pb-2 -mx-4 px-4 md:mx-0 md:px-0 [&::-webkit-scrollbar]:hidden">
                <button class="snap-center shrink-0 px-6 py-2.5 rounded-full bg-primary-container text-background font-bold text-sm border-2 border-primary-container">Semua</button>
                <button class="snap-center shrink-0 px-6 py-2.5 rounded-full bg-surface-container border-2 border-surface-container-highest text-on-surface hover:border-primary-container/50 font-medium text-sm">Tips & Trik</button>
                <button class="snap-center shrink-0 px-6 py-2.5 rounded-full bg-surface-container border-2 border-surface-container-highest text-on-surface hover:border-primary-container/50 font-medium text-sm">Panduan</button>
                <button class="snap-center shrink-0 px-6 py-2.5 rounded-full bg-surface-container border-2 border-surface-container-highest text-on-surface hover:border-primary-container/50 font-medium text-sm">Tren Desain</button>
                <button class="snap-center shrink-0 px-6 py-2.5 rounded-full bg-surface-container border-2 border-surface-container-highest text-on-surface hover:border-primary-container/50 font-medium text-sm">Event</button>
            </div>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- Article 1 -->
            <article class="bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden group shadow-lg hover:shadow-primary-container/20 transition-all duration-300 cursor-pointer" onclick="window.location.href='article-detail.html'">
                <div class="aspect-video bg-surface-container-high overflow-hidden relative">
                    <img alt="Tips Merawat Jersey" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDy_Hrgnduk01cZ3ltC5SfYSIhomKP-T04j7Egrzd0GY52dFgnn3w5DPF-46_LmC8LIH3BH4Knj53XySYqRXYU8bfbN7kVPUWBsIxrimBEzeXX4NpIkVvrLrajmFCUP8PEMVkL--jVtwen_2F_YMUrVXe3gQ6ogpfXLS0qafkEQF97kJqqbbl0lFmeRj2UwgHpyRep3JoT0rnPwZXoNworJXGM4KtxAzGa8KLJEj3gpIitbwMnrwxDCP9h7ZhAGxJjYHpzc57wsRxfd"/>
                    <div class="absolute top-4 left-4 bg-primary-container text-background font-bold text-xs px-3 py-1 rounded">TIPS & TRIK</div>
                </div>
                <div class="p-6 flex flex-col h-full">
                    <span class="text-on-secondary-container text-xs mb-2 block">12 Oktober 2024</span>
                    <h3 class="font-headline-md font-bold text-lg mb-4 line-clamp-2 group-hover:text-primary-container transition-colors">Cara Tepat Merawat Jersey Printing Agar Warna Tetap Tajam Bertahun-tahun</h3>
                    <a class="mt-auto inline-flex items-center gap-2 text-primary-container font-bold text-sm" href="article-detail.html">Baca Selengkapnya <span class="material-symbols-rounded text-xs">arrow_forward</span></a>
                </div>
            </article>

            <!-- Article 2 -->
            <article class="bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden group shadow-lg hover:shadow-primary-container/20 transition-all duration-300 cursor-pointer" onclick="window.location.href='article-detail.html'">
                <div class="aspect-video bg-surface-container-high overflow-hidden relative">
                    <img alt="Pilih Bahan Jersey" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC1X3gF5RHtBJEIi_2NQcZly2f5E9TeQ5o9mtOm19ghuV-NjyIl4jCvum85Dna_sycqkzFtd7PfGixm0YI1--1ErzT07d0QPmgQYtFEMjZ2PGX_YUSSdw5NBF-miTCzAyMdBOPTMJy6JUIEraq22NbFSGtXXNqsXOZXnto3BqSC_RkpM9cp8k_qHBZDXtaGm3cOqauIxBOyYctYPYKdZNwGWjIuC68NLdT9GC0eF1Tv7DxlrjCIRWcpb1qRLuvIMYhxZpsXegBVavL9"/>
                    <div class="absolute top-4 left-4 bg-primary-container text-background font-bold text-xs px-3 py-1 rounded">PANDUAN</div>
                </div>
                <div class="p-6 flex flex-col h-full">
                    <span class="text-on-secondary-container text-xs mb-2 block">05 Oktober 2024</span>
                    <h3 class="font-headline-md font-bold text-lg mb-4 line-clamp-2 group-hover:text-primary-container transition-colors">Mengenal Jenis Bahan Jersey Olahraga: Mana yang Paling Cocok Untuk Tim Anda?</h3>
                    <a class="mt-auto inline-flex items-center gap-2 text-primary-container font-bold text-sm" href="article-detail.html">Baca Selengkapnya <span class="material-symbols-rounded text-xs">arrow_forward</span></a>
                </div>
            </article>

            <!-- Article 3 -->
            <article class="bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden group shadow-lg hover:shadow-primary-container/20 transition-all duration-300 cursor-pointer" onclick="window.location.href='article-detail.html'">
                <div class="aspect-video bg-surface-container-high overflow-hidden relative">
                    <img alt="Trend Desain" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCVbKXuyKyMvkSx6IZiAJ3Yr5dg1oxgg_EVgOanImGLgBEG4m-XQ2GVSxGp-EFNmzZvu8hgWU9xCLCkLiZWDjiXMvX8nl_MBSrhLHL6su16fclp15Q5cqdwDk3x7iJ6ugwlKRDJ00m3hXmSaTSkXf0y0nXyLWUm5hXbly_k7g4rPufDlMT9DuErTcDgrj1jQHmF-cTz4dzEXcubwVFYvkiHZ5Qcpcp_RbbdikrRv1tURrXsSU9PLbl_3iWtbOB4NJn6cLVgny-rLNhJ"/>
                    <div class="absolute top-4 left-4 bg-primary-container text-background font-bold text-xs px-3 py-1 rounded">TREN DESAIN</div>
                </div>
                <div class="p-6 flex flex-col h-full">
                    <span class="text-on-secondary-container text-xs mb-2 block">28 September 2024</span>
                    <h3 class="font-headline-md font-bold text-lg mb-4 line-clamp-2 group-hover:text-primary-container transition-colors">5 Tren Desain Jersey Futsal & Sepakbola yang Paling Diminati di Tahun 2024</h3>
                    <a class="mt-auto inline-flex items-center gap-2 text-primary-container font-bold text-sm" href="article-detail.html">Baca Selengkapnya <span class="material-symbols-rounded text-xs">arrow_forward</span></a>
                </div>
            </article>

            <!-- Article 4 -->
            <article class="bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden group shadow-lg hover:shadow-primary-container/20 transition-all duration-300 cursor-pointer" onclick="window.location.href='article-detail.html'">
                <div class="aspect-video bg-surface-container-high overflow-hidden relative flex items-center justify-center">
                    <span class="material-symbols-rounded text-6xl text-surface-container-highest">image</span>
                    <div class="absolute top-4 left-4 bg-primary-container text-background font-bold text-xs px-3 py-1 rounded">EVENT</div>
                </div>
                <div class="p-6 flex flex-col h-full">
                    <span class="text-on-secondary-container text-xs mb-2 block">15 September 2024</span>
                    <h3 class="font-headline-md font-bold text-lg mb-4 line-clamp-2 group-hover:text-primary-container transition-colors">AMERYGO Menjadi Sponsor Utama Turnamen Futsal Nasional 2024</h3>
                    <a class="mt-auto inline-flex items-center gap-2 text-primary-container font-bold text-sm" href="article-detail.html">Baca Selengkapnya <span class="material-symbols-rounded text-xs">arrow_forward</span></a>
                </div>
            </article>

            <!-- Article 5 -->
            <article class="bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden group shadow-lg hover:shadow-primary-container/20 transition-all duration-300 cursor-pointer" onclick="window.location.href='article-detail.html'">
                <div class="aspect-video bg-surface-container-high overflow-hidden relative flex items-center justify-center">
                    <span class="material-symbols-rounded text-6xl text-surface-container-highest">image</span>
                    <div class="absolute top-4 left-4 bg-primary-container text-background font-bold text-xs px-3 py-1 rounded">PANDUAN</div>
                </div>
                <div class="p-6 flex flex-col h-full">
                    <span class="text-on-secondary-container text-xs mb-2 block">02 September 2024</span>
                    <h3 class="font-headline-md font-bold text-lg mb-4 line-clamp-2 group-hover:text-primary-container transition-colors">Cara Mengukur Badan Agar Mendapatkan Ukuran Jersey yang Pas</h3>
                    <a class="mt-auto inline-flex items-center gap-2 text-primary-container font-bold text-sm" href="article-detail.html">Baca Selengkapnya <span class="material-symbols-rounded text-xs">arrow_forward</span></a>
                </div>
            </article>

            <!-- Article 6 -->
            <article class="bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden group shadow-lg hover:shadow-primary-container/20 transition-all duration-300 cursor-pointer" onclick="window.location.href='article-detail.html'">
                <div class="aspect-video bg-surface-container-high overflow-hidden relative flex items-center justify-center">
                    <span class="material-symbols-rounded text-6xl text-surface-container-highest">image</span>
                    <div class="absolute top-4 left-4 bg-primary-container text-background font-bold text-xs px-3 py-1 rounded">TIPS & TRIK</div>
                </div>
                <div class="p-6 flex flex-col h-full">
                    <span class="text-on-secondary-container text-xs mb-2 block">20 Agustus 2024</span>
                    <h3 class="font-headline-md font-bold text-lg mb-4 line-clamp-2 group-hover:text-primary-container transition-colors">Pentingnya Memilih Font dan Warna yang Tepat untuk Nomor Punggung</h3>
                    <a class="mt-auto inline-flex items-center gap-2 text-primary-container font-bold text-sm" href="article-detail.html">Baca Selengkapnya <span class="material-symbols-rounded text-xs">arrow_forward</span></a>
                </div>
            </article>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center border-t border-surface-container-highest pt-8 mt-12">
            <nav class="flex items-center gap-2">
                <button class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-secondary-container hover:bg-surface-container-highest transition-colors disabled:opacity-50 cursor-not-allowed" disabled>
                    <span class="material-symbols-rounded text-xl">chevron_left</span>
                </button>
                <button class="w-10 h-10 rounded-lg bg-primary-container text-background flex items-center justify-center font-bold glow-primary">1</button>
                <button class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface hover:bg-surface-container-highest hover:text-primary-container transition-colors">2</button>
                <button class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface hover:bg-surface-container-highest hover:text-primary-container transition-colors">3</button>
                <span class="text-on-secondary-container px-2">...</span>
                <button class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface hover:bg-surface-container-highest hover:text-primary-container transition-colors">8</button>
                <button class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface hover:bg-surface-container-highest hover:text-primary-container transition-colors">
                    <span class="material-symbols-rounded text-xl">chevron_right</span>
                </button>
            </nav>
        </div>

    </div>
</main>
@endsection
