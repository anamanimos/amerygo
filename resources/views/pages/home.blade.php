@extends('layouts.app')

@section('content')
<main class="flex-grow pt-20 md:pt-20">
<!-- Hero Section -->
<section class="relative min-h-[calc(100vh-80px)] lg:min-h-[795px] flex items-center overflow-hidden">
<!-- Background effects -->
<div class="absolute inset-0 bg-gradient-to-br from-background via-surface-container-lowest to-[#2a1300] -z-10"></div>
<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] md:w-[800px] md:h-[800px] bg-primary-container/5 rounded-full blur-[80px] md:blur-[100px] pointer-events-none -z-10"></div>
<div class="max-w-container-max mx-auto px-6 md:px-12 w-full grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center py-12 lg:py-24">
<div class="flex flex-col gap-6 lg:gap-8 items-center text-center lg:items-start lg:text-left z-10 mt-6 lg:mt-0 order-2 lg:order-1">
<h1 class="font-display-xl text-5xl md:text-6xl lg:text-[80px] leading-[1.1] uppercase italic text-on-surface tracking-tighter">
                        {!! $heroSettings['hero_title'] ?? "Custom Jersey &amp;<br/>\n<span class=\"text-primary-container text-glow\">Sportwear</span><br/>\n                        Premium" !!}
                    </h1>
<p class="font-body-md text-base md:text-lg text-on-secondary-container max-w-lg">
                        {{ $heroSettings['hero_description'] ?? 'Desain gratis tanpa batas. Produksi cepat dengan hasil presisi. Jadikan tim Anda tampil layaknya profesional di lapangan.' }}
                    </p>
<div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto mt-4 lg:mt-6">
<a href="{{ !empty($heroSettings['hero_btn1_url']) ? $heroSettings['hero_btn1_url'] : '#' }}" class="inline-flex justify-center items-center text-center w-full sm:w-auto bg-primary-container text-white px-8 py-4 rounded-full font-bold uppercase tracking-wider hover:bg-[#e65c00] transition-all glow-primary hover:scale-105 active:scale-95">
                            {{ $heroSettings['hero_btn1_text'] ?? 'Konsultasi' }}
                        </a>
<a href="{{ !empty($heroSettings['hero_btn2_url']) ? $heroSettings['hero_btn2_url'] : route('products') }}" class="inline-flex justify-center items-center text-center w-full sm:w-auto bg-transparent border-2 border-primary-container text-primary-container px-8 py-4 rounded-full font-bold uppercase tracking-wider hover:bg-primary-container/10 transition-all active:scale-95">
                            {{ $heroSettings['hero_btn2_text'] ?? 'Lihat Produk' }}
                        </a>
</div>
</div>
<div class="relative z-10 flex justify-center lg:justify-end mt-4 lg:mt-0 order-1 lg:order-2">
<div class="relative w-full max-w-[280px] sm:max-w-[400px] lg:max-w-[500px] aspect-square">
<!-- Simulated mockup container -->
<div class="absolute inset-0 bg-surface-container rounded-full border border-surface-container-highest flex items-center justify-center overflow-hidden shadow-[0_0_40px_rgba(255,102,0,0.15)]">
<img alt="Hero Image" class="w-[120%] h-[120%] object-cover object-center scale-110" src="{{ !empty($heroSettings['hero_image']) ? asset($heroSettings['hero_image']) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuA60XIoVKXCdU4ymRxeQ3a3mbYM2PNRQp5BMF5IdMgbKWcCeQXowbmxZUeWv1yzKe2IlnXadCT3-jpOEqjJcZO7JfNrDh1Cr_DSg-6n5dw9qlu8m6JmmxabcPNp4P3XTYMlZr3yelOXBuikoWe3IbbyL05_tpiKDlALSeIo6RpQCEgpMv_oftrq-UmZeukCv4emNeY-boxww50Cq1D5L687_OlMpyclPAkR8QNBZiwVKt9yMq7M6HPeG2V1ZhYOyNJqsRNTcXwXa77_' }}"/>
</div>
<!-- Badges -->
<div class="absolute top-4 lg:top-10 -left-2 lg:-left-6 bg-primary-container text-background font-bold text-[10px] lg:text-sm px-4 py-2 rounded-full shadow-xl transform -rotate-6 backdrop-blur-md">
                            {{ $heroSettings['hero_badge1'] ?? 'Free Design' }}
                        </div>
<div class="absolute bottom-4 lg:bottom-10 -right-2 lg:-right-6 bg-surface-container-high/90 backdrop-blur-md border border-surface-container-highest text-primary-container font-bold text-[10px] lg:text-sm px-4 py-2 rounded-full shadow-xl transform rotate-3 flex items-center gap-1">
<span class="material-symbols-rounded text-[14px] lg:text-[16px]">bolt</span>
                            {{ $heroSettings['hero_badge2'] ?? 'Fast Production' }}
                        </div>
</div>
</div>
</div>
</section>
<!-- Trust Section -->
<section class="border-y border-surface-container-highest bg-surface-container-low py-12">
<div class="max-w-container-max mx-auto px-4 md:px-md">
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 lg:gap-6 text-center">
@if(isset($iconList) && $iconList->count() > 0)
    @foreach($iconList as $item)
    <div class="flex flex-col items-center gap-4 hover:scale-105 transition-transform">
        <i class="ki-duotone ki-{{ $item->icon }} text-primary-container drop-shadow-[0_0_15px_rgba(255,102,0,0.3)]" style="font-size: 64px; line-height: 1;">
            <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span>
        </i>
        <span class="font-bold text-sm">{{ $item->label }}</span>
    </div>
    @endforeach
@else
<div class="flex flex-col items-center gap-4 hover:scale-105 transition-transform">
<span class="material-symbols-rounded text-primary-container text-[56px] lg:text-[64px] drop-shadow-[0_0_15px_rgba(255,102,0,0.3)]">groups</span>
<span class="font-bold text-sm">Ribuan pelanggan puas</span>
</div>
<div class="flex flex-col items-center gap-4 hover:scale-105 transition-transform">
<span class="material-symbols-rounded text-primary-container text-[56px] lg:text-[64px] drop-shadow-[0_0_15px_rgba(255,102,0,0.3)]">factory</span>
<span class="font-bold text-sm">Produksi profesional</span>
</div>
<div class="flex flex-col items-center gap-4 hover:scale-105 transition-transform">
<span class="material-symbols-rounded text-primary-container text-[56px] lg:text-[64px] drop-shadow-[0_0_15px_rgba(255,102,0,0.3)]">diamond</span>
<span class="font-bold text-sm">Bahan premium</span>
</div>
<div class="flex flex-col items-center gap-4 hover:scale-105 transition-transform">
<span class="material-symbols-rounded text-primary-container text-[56px] lg:text-[64px] drop-shadow-[0_0_15px_rgba(255,102,0,0.3)]">verified</span>
<span class="font-bold text-sm">Garansi kualitas</span>
</div>
<div class="flex flex-col items-center gap-4 hover:scale-105 transition-transform">
<span class="material-symbols-rounded text-primary-container text-[56px] lg:text-[64px] drop-shadow-[0_0_15px_rgba(255,102,0,0.3)]">local_shipping</span>
<span class="font-bold text-sm">Pengiriman seluruh Indonesia</span>
</div>
<div class="flex flex-col items-center gap-4 hover:scale-105 transition-transform">
<span class="material-symbols-rounded text-primary-container text-[56px] lg:text-[64px] drop-shadow-[0_0_15px_rgba(255,102,0,0.3)]">support_agent</span>
<span class="font-bold text-sm">Fast response support</span>
</div>
@endif
</div>
</div>
</section>
<!-- About & Stats Section -->
<section class="py-xl">
<div class="max-w-container-max mx-auto px-4 md:px-md grid grid-cols-1 lg:grid-cols-2 gap-lg items-center">
<div class="flex flex-col gap-6">
<h2 class="font-headline-lg text-headline-lg font-black uppercase italic">{!! $aboutSettings['about_title'] ?? 'Kualitas Manufaktur <span class="text-primary-container">Terbaik</span>' !!}</h2>
<p class="text-on-secondary-container text-lg leading-relaxed">
                {{ $aboutSettings['about_description'] ?? 'AMERYGO berdedikasi untuk memberikan hasil produksi pakaian olahraga dengan standar tertinggi. Kami menggunakan teknologi printing sublimasi terbaru untuk warna yang tajam dan tidak pudar. Material kain yang kami pilih menjamin kenyamanan maksimal saat beraktivitas berat, didukung dengan jahitan profesional yang kuat dan rapi.' }}
            </p>
<ul class="flex flex-col gap-4 mt-4">
@if(isset($aboutChecklist) && $aboutChecklist->count() > 0)
    @foreach($aboutChecklist as $item)
    <li class="flex items-center gap-3">
    <span class="material-symbols-rounded text-primary-container">check_circle</span>
    <span class="font-bold">{{ $item->label }}</span>
    </li>
    @endforeach
@else
<li class="flex items-center gap-3">
<span class="material-symbols-rounded text-primary-container">check_circle</span>
<span class="font-bold">Printing Tajam &amp; Awet</span>
</li>
<li class="flex items-center gap-3">
<span class="material-symbols-rounded text-primary-container">check_circle</span>
<span class="font-bold">Material Nyaman &amp; Breatable</span>
</li>
<li class="flex items-center gap-3">
<span class="material-symbols-rounded text-primary-container">check_circle</span>
<span class="font-bold">Jahitan Presisi &amp; Kuat</span>
</li>
@endif
</ul>
</div>
<div class="grid grid-cols-2 gap-6">
<div class="bg-surface-container border border-surface-container-highest p-8 rounded-lg text-center flex flex-col items-center gap-2 glow-primary-hover transition-all">
<span class="font-display-xl text-primary-container font-black leading-none">{{ $aboutSettings['about_stat1_value'] ?? '5000+' }}</span>
<span class="font-bold text-on-secondary-container uppercase tracking-wider text-sm">{{ $aboutSettings['about_stat1_label'] ?? 'Jersey Diproduksi' }}</span>
</div>
<div class="bg-surface-container border border-surface-container-highest p-8 rounded-lg text-center flex flex-col items-center gap-2 glow-primary-hover transition-all">
<span class="font-display-xl text-primary-container font-black leading-none">{{ $aboutSettings['about_stat2_value'] ?? '1200+' }}</span>
<span class="font-bold text-on-secondary-container uppercase tracking-wider text-sm">{{ $aboutSettings['about_stat2_label'] ?? 'Klien' }}</span>
</div>
<div class="bg-surface-container border border-surface-container-highest p-8 rounded-lg text-center flex flex-col items-center gap-2 glow-primary-hover transition-all">
<span class="font-display-xl text-primary-container font-black leading-none">{{ $aboutSettings['about_stat3_value'] ?? '150+' }}</span>
<span class="font-bold text-on-secondary-container uppercase tracking-wider text-sm">{{ $aboutSettings['about_stat3_label'] ?? 'Komunitas' }}</span>
</div>
<div class="bg-surface-container border border-surface-container-highest p-8 rounded-lg text-center flex flex-col items-center gap-2 glow-primary-hover transition-all">
<span class="font-display-xl text-primary-container font-black leading-none">{{ $aboutSettings['about_stat4_value'] ?? '5' }}</span>
<span class="font-bold text-on-secondary-container uppercase tracking-wider text-sm">{{ $aboutSettings['about_stat4_label'] ?? 'Tahun Pengalaman' }}</span>
</div>
</div>
</div>
</section>
<!-- Product Showcase -->
<section class="py-xl bg-surface-container-lowest border-y border-surface-container-highest">
<div class="max-w-container-max mx-auto px-4 md:px-md">
<div class="text-center mb-12">
<h2 class="font-headline-lg text-headline-lg font-black uppercase italic mb-4">Pilihan <span class="text-primary-container">Produk</span></h2>
<p class="text-on-secondary-container max-w-2xl mx-auto">Berbagai macam kebutuhan seragam olahraga kustom untuk tim Anda.</p>
</div>
<div class="flex md:grid md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8 overflow-x-auto snap-x snap-mandatory pb-8 pt-4 -mx-4 px-4 md:mx-0 md:px-0 md:overflow-visible [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
@if(isset($featuredProducts) && $featuredProducts->count() > 0)
    @foreach($featuredProducts as $product)
    <!-- Product Card -->
    <div class="group flex flex-col gap-4 cursor-pointer snap-center shrink-0 w-[260px] md:w-auto" onclick="window.location.href='{{ route('products.show', $product->slug) }}'">
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
    <h3 class="font-headline-md font-bold text-lg text-on-surface group-hover:text-primary-container transition-colors leading-tight">{{ $product->name }}</h3>
    <div class="flex items-center gap-2 mt-2 whitespace-nowrap">
        @if($product->discount_price > 0 && $product->discount_price < $product->price)
            <span class="font-bold text-primary-container text-lg">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
            <span class="text-on-secondary-container text-sm line-through decoration-on-secondary-container/50">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
        @else
            <span class="font-bold text-primary-container text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
        @endif
    </div>
    </div>
    </div>
    @endforeach
@else
    <p class="text-on-secondary-container">Belum ada produk unggulan.</p>
@endif
</div>
</div>
</section>
<!-- How to Order -->
<section class="py-xl">
<div class="max-w-container-max mx-auto px-4 md:px-md">
<div class="text-center mb-16">
<h2 class="font-headline-lg text-headline-lg font-black uppercase italic mb-4">{!! $howToOrderSettings['how_to_order_title'] ?? 'Cara <span class="text-primary-container">Pemesanan</span>' !!}</h2>
<p class="text-on-secondary-container max-w-2xl mx-auto">{{ $howToOrderSettings['how_to_order_description'] ?? 'Proses pemesanan yang mudah, transparan, dan cepat.' }}</p>
</div>
<div class="flex md:grid md:grid-cols-4 gap-4 md:gap-6 overflow-x-auto snap-x snap-mandatory pb-8 pt-4 -mx-4 px-4 md:mx-0 md:px-0 md:overflow-visible [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
@if(isset($howToOrderSteps) && $howToOrderSteps->count() > 0)
    @foreach($howToOrderSteps as $index => $step)
    <div class="group bg-surface-container rounded-2xl p-8 flex flex-col items-center text-center gap-4 snap-center shrink-0 w-[260px] md:w-auto shadow-lg hover:shadow-primary-container/20 transition-all duration-300 relative overflow-hidden">
    <div class="absolute -right-4 -top-4 text-9xl font-black text-surface-container-highest/30 select-none group-hover:text-primary-container/10 transition-colors">{{ $index + 1 }}</div>
    <div class="w-16 h-16 rounded-full bg-background border-2 border-primary-container flex items-center justify-center text-primary-container text-2xl font-black z-10 group-hover:scale-110 transition-transform glow-primary">
    <i class="ki-duotone ki-{{ $step->icon }}" style="font-size: 24px; line-height: 1;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
    </div>
    <h3 class="font-headline-md font-bold text-xl z-10">{{ $step->label }}</h3>
    <p class="text-on-secondary-container text-sm z-10">{{ $step->url }}</p>
    </div>
    @endforeach
@else
<!-- Step 1 -->
<div class="group bg-surface-container rounded-2xl p-8 flex flex-col items-center text-center gap-4 snap-center shrink-0 w-[260px] md:w-auto shadow-lg hover:shadow-primary-container/20 transition-all duration-300 relative overflow-hidden">
<div class="absolute -right-4 -top-4 text-9xl font-black text-surface-container-highest/30 select-none group-hover:text-primary-container/10 transition-colors">1</div>
<div class="w-16 h-16 rounded-full bg-background border-2 border-primary-container flex items-center justify-center text-primary-container text-2xl font-black z-10 group-hover:scale-110 transition-transform glow-primary">
<span class="material-symbols-rounded">forum</span>
</div>
<h3 class="font-headline-md font-bold text-xl z-10">Konsultasi</h3>
<p class="text-on-secondary-container text-sm z-10">Hubungi tim kami untuk mendiskusikan kebutuhan, desain, dan budget Anda.</p>
</div>
<!-- Step 2 -->
<div class="group bg-surface-container rounded-2xl p-8 flex flex-col items-center text-center gap-4 snap-center shrink-0 w-[260px] md:w-auto shadow-lg hover:shadow-primary-container/20 transition-all duration-300 relative overflow-hidden">
<div class="absolute -right-4 -top-4 text-9xl font-black text-surface-container-highest/30 select-none group-hover:text-primary-container/10 transition-colors">2</div>
<div class="w-16 h-16 rounded-full bg-background border-2 border-primary-container flex items-center justify-center text-primary-container text-2xl font-black z-10 group-hover:scale-110 transition-transform glow-primary">
<span class="material-symbols-rounded">design_services</span>
</div>
<h3 class="font-headline-md font-bold text-xl z-10">Desain</h3>
<p class="text-on-secondary-container text-sm z-10">Tim desainer kami akan membuatkan preview 3D sesuai dengan keinginan Anda.</p>
</div>
<!-- Step 3 -->
<div class="group bg-surface-container rounded-2xl p-8 flex flex-col items-center text-center gap-4 snap-center shrink-0 w-[260px] md:w-auto shadow-lg hover:shadow-primary-container/20 transition-all duration-300 relative overflow-hidden">
<div class="absolute -right-4 -top-4 text-9xl font-black text-surface-container-highest/30 select-none group-hover:text-primary-container/10 transition-colors">3</div>
<div class="w-16 h-16 rounded-full bg-background border-2 border-primary-container flex items-center justify-center text-primary-container text-2xl font-black z-10 group-hover:scale-110 transition-transform glow-primary">
<span class="material-symbols-rounded">precision_manufacturing</span>
</div>
<h3 class="font-headline-md font-bold text-xl z-10">Produksi</h3>
<p class="text-on-secondary-container text-sm z-10">Setelah ACC desain dan DP, proses produksi akan segera dimulai.</p>
</div>
<!-- Step 4 -->
<div class="group bg-surface-container rounded-2xl p-8 flex flex-col items-center text-center gap-4 snap-center shrink-0 w-[260px] md:w-auto shadow-lg hover:shadow-primary-container/20 transition-all duration-300 relative overflow-hidden">
<div class="absolute -right-4 -top-4 text-9xl font-black text-surface-container-highest/30 select-none group-hover:text-primary-container/10 transition-colors">4</div>
<div class="w-16 h-16 rounded-full bg-background border-2 border-primary-container flex items-center justify-center text-primary-container text-2xl font-black z-10 group-hover:scale-110 transition-transform glow-primary">
<span class="material-symbols-rounded">local_shipping</span>
</div>
<h3 class="font-headline-md font-bold text-xl z-10">Pengiriman</h3>
<p class="text-on-secondary-container text-sm z-10">Pesanan selesai diproduksi, di-quality control, dan siap dikirim.</p>
</div>
@endif
</div>
</div>
</section>

<!-- Pricing Section -->
<section class="py-xl bg-surface-container-lowest border-y border-surface-container-highest">
<div class="max-w-container-max mx-auto px-4 md:px-md">
<div class="text-center mb-16">
<h2 class="font-headline-lg text-headline-lg font-black uppercase italic mb-4">Paket <span class="text-primary-container">Harga</span></h2>
<p class="text-on-secondary-container max-w-2xl mx-auto">Pilih paket yang sesuai dengan kebutuhan tim Anda.</p>
</div>
<div class="flex md:grid md:grid-cols-3 gap-4 md:gap-8 overflow-x-auto snap-x snap-mandatory pb-8 pt-4 -mx-4 px-4 md:mx-0 md:px-0 md:overflow-visible [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">

@if(isset($pricings) && $pricings->count() > 0)
    @foreach($pricings as $pricing)
        @if($pricing->is_best_seller)
            <!-- Semi Pro (Highlighted) / Best Seller -->
            <div class="bg-surface border-2 border-primary-container rounded-xl p-8 flex flex-col h-full relative md:transform md:-translate-y-4 shadow-2xl shadow-primary-container/20 snap-center shrink-0 w-[300px] md:w-auto">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-primary-container text-background font-bold px-4 py-1 rounded-full text-sm whitespace-nowrap">BEST SELLER</div>
            <h3 class="font-headline-md font-bold text-2xl mb-2 text-on-surface">{{ $pricing->name }}</h3>
            <p class="text-on-secondary-container text-sm mb-6">{{ $pricing->description }}</p>
            <div class="mb-8">
            <span class="text-on-secondary-container text-sm">Mulai dari</span>
            <div class="flex flex-col gap-1 mt-1">
            <div class="text-sm text-on-secondary-container line-through decoration-on-secondary-container/50 whitespace-nowrap">Rp {{ number_format($pricing->original_price, 0, ',', '.') }}</div>
            <div class="font-display-xl text-4xl font-black text-primary-container leading-none whitespace-nowrap">Rp {{ number_format($pricing->discounted_price, 0, ',', '.') }}<span class="text-lg font-normal text-on-secondary-container">/pcs</span></div>
            </div>
            </div>
            <ul class="flex flex-col gap-4 flex-grow mb-8">
            @if(is_array($pricing->features))
                @foreach($pricing->features as $feature)
                    @if(isset($feature['included']) && $feature['included'])
                        <li class="flex items-start gap-3"><span class="material-symbols-rounded text-primary-container text-xl shrink-0">check</span><span class="text-sm">{{ $feature['name'] }}</span></li>
                    @else
                        <li class="flex items-start gap-3"><span class="material-symbols-rounded text-surface-container-highest text-xl shrink-0">close</span><span class="text-sm text-on-secondary-container line-through">{{ $feature['name'] }}</span></li>
                    @endif
                @endforeach
            @endif
            </ul>
            <a href="{{ $pricing->cta_link ?? '#' }}" class="w-full py-4 bg-primary-container text-background font-bold rounded hover:bg-[#e65c00] transition-colors glow-primary text-center block">{{ $pricing->cta_text ?? 'Pilih Paket ' . $pricing->name }}</a>
            </div>
        @else
            <!-- Standard Package -->
            <div class="bg-surface-container border border-surface-container-highest rounded-xl p-8 flex flex-col h-full hover:border-primary-container/50 transition-colors snap-center shrink-0 w-[300px] md:w-auto">
            <h3 class="font-headline-md font-bold text-2xl mb-2 text-on-surface">{{ $pricing->name }}</h3>
            <p class="text-on-secondary-container text-sm mb-6">{{ $pricing->description }}</p>
            <div class="mb-8">
            <span class="text-on-secondary-container text-sm">Mulai dari</span>
            <div class="flex flex-col gap-1 mt-1">
            <div class="text-sm text-on-secondary-container line-through decoration-on-secondary-container/50 whitespace-nowrap">Rp {{ number_format($pricing->original_price, 0, ',', '.') }}</div>
            <div class="font-display-xl text-4xl font-black text-primary-container leading-none whitespace-nowrap">Rp {{ number_format($pricing->discounted_price, 0, ',', '.') }}<span class="text-lg font-normal text-on-secondary-container">/pcs</span></div>
            </div>
            </div>
            <ul class="flex flex-col gap-4 flex-grow mb-8">
            @if(is_array($pricing->features))
                @foreach($pricing->features as $feature)
                    @if(isset($feature['included']) && $feature['included'])
                        <li class="flex items-start gap-3"><span class="material-symbols-rounded text-primary-container text-xl shrink-0">check</span><span class="text-sm">{{ $feature['name'] }}</span></li>
                    @else
                        <li class="flex items-start gap-3"><span class="material-symbols-rounded text-surface-container-highest text-xl shrink-0">close</span><span class="text-sm text-on-secondary-container line-through">{{ $feature['name'] }}</span></li>
                    @endif
                @endforeach
            @endif
            </ul>
            <a href="{{ $pricing->cta_link ?? '#' }}" class="w-full py-4 border-2 border-primary-container text-primary-container font-bold rounded hover:bg-primary-container/10 transition-colors text-center block">{{ $pricing->cta_text ?? 'Pilih Paket ' . $pricing->name }}</a>
            </div>
        @endif
    @endforeach
@endif

</div>
</div>
</section>
<!-- Article List -->
<section class="py-xl">
<div class="max-w-container-max mx-auto px-4 md:px-md">
<div class="flex justify-between items-end mb-12">
<div>
<h2 class="font-headline-lg text-headline-lg font-black uppercase italic mb-2">Artikel &amp; <span class="text-primary-container">Berita</span></h2>
<p class="text-on-secondary-container">Update terbaru seputar dunia olahraga dan tips jersey.</p>
</div>
<a class="hidden md:flex items-center gap-2 text-primary-container font-bold hover:underline" href="{{ route('articles') }}">Lihat Semua <span class="material-symbols-rounded text-sm">arrow_forward</span></a>
</div>
<div class="flex md:grid md:grid-cols-3 gap-4 md:gap-8 overflow-x-auto snap-x snap-mandatory pb-8 pt-4 -mx-4 px-4 md:mx-0 md:px-0 md:overflow-visible [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
@if(isset($articles) && $articles->count() > 0)
    @foreach($articles as $article)
    <article class="bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden group snap-center shrink-0 w-[300px] md:w-auto shadow-lg hover:shadow-primary-container/20 transition-all duration-300 cursor-pointer" onclick="window.location.href='{{ route('articles.show', $article->slug) }}'">
    <div class="aspect-video bg-surface-container-high overflow-hidden relative">
    <img alt="{{ $article->title }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" src="{{ asset($article->image) }}"/>
    @if($article->category)
    <div class="absolute top-4 left-4 bg-primary-container text-background font-bold text-xs px-3 py-1 rounded">{{ $article->category->name }}</div>
    @endif
    </div>
    <div class="p-6">
    <span class="text-on-secondary-container text-xs mb-2 block">{{ $article->published_at ? $article->published_at->format('d F Y') : '' }}</span>
    <h3 class="font-headline-md font-bold text-lg mb-4 line-clamp-2 group-hover:text-primary-container transition-colors">{{ $article->title }}</h3>
    <a class="inline-flex items-center gap-2 text-primary-container font-bold text-sm" href="{{ route('articles.show', $article->slug) }}">Baca Selengkapnya <span class="material-symbols-rounded text-xs">arrow_forward</span></a>
    </div>
    </article>
    @endforeach
@else
    <p class="text-on-secondary-container text-center w-full">Belum ada artikel.</p>
@endif
<div class="mt-8 text-center md:hidden">
<a class="inline-block px-6 py-3 border border-primary-container text-primary-container font-bold rounded w-full" href="{{ route('articles') }}">Lihat Semua Artikel</a>
</div>
</div>
</section>

<!-- Review Section -->
<section class="py-xl bg-surface-container-lowest border-y border-surface-container-highest overflow-hidden relative">
    <div class="absolute inset-0 bg-pattern opacity-50"></div>
    <div class="max-w-container-max mx-auto px-4 md:px-md relative z-10">
        <div class="text-center mb-16">
            <h2 class="font-headline-lg text-headline-lg font-black uppercase italic mb-4">Apa Kata <span class="text-primary-container">Mereka?</span></h2>
            <p class="text-on-secondary-container max-w-2xl mx-auto">Lebih dari 10.000 tim olahraga di seluruh Indonesia telah mempercayakan pembuatan jersey mereka kepada AMERYGO.</p>
        </div>

        <div class="flex gap-6 overflow-x-auto snap-x snap-mandatory pb-8 pt-4 -mx-4 px-4 md:mx-0 md:px-0 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
            @if(isset($reviews) && $reviews->count() > 0)
                @foreach($reviews as $review)
                <!-- Review Card -->
                <div class="bg-surface-container border border-surface-container-highest rounded-2xl p-8 shadow-lg snap-center shrink-0 w-[320px] md:w-[400px] flex flex-col justify-between hover:border-primary-container/50 transition-colors">
                    <div>
                        <div class="flex text-primary-container mb-4">
                            @for($i=1; $i<=5; $i++)
                                @if($i <= floor($review->rating))
                                    <span class="material-symbols-rounded" style="font-variation-settings: 'FILL' 1;">star</span>
                                @elseif($i - 0.5 <= $review->rating)
                                    <span class="material-symbols-rounded" style="font-variation-settings: 'FILL' 1;">star_half</span>
                                @else
                                    <span class="material-symbols-rounded" style="font-variation-settings: 'FILL' 0;">star</span>
                                @endif
                            @endfor
                        </div>
                        <p class="text-on-surface mb-8 leading-relaxed italic">"{{ $review->content }}"</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-surface-container-highest flex items-center justify-center font-bold text-xl text-primary-container">
                            {{ $review->initials }}
                        </div>
                        <div>
                            <h4 class="font-bold text-on-surface">{{ $review->name }}</h4>
                            @if($review->role)
                                <span class="text-xs text-on-secondary-container">{{ $review->role }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <p class="text-on-secondary-container text-center w-full">Belum ada review pelanggan.</p>
            @endif
        </div>
    </div>
</section>
</main>
@endsection
