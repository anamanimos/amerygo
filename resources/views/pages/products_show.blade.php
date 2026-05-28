@extends('layouts.app')

@section('content')
<main class="flex-grow pt-20 md:pt-32 pb-24">
    <div class="max-w-container-max mx-auto px-4 md:px-md">
        
        <!-- Breadcrumb -->
        <nav class="flex text-sm text-on-surface-variant mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center hover:text-primary transition-colors">
                        <span class="material-symbols-rounded text-lg mr-2">home</span>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-rounded text-on-surface-variant text-lg">chevron_right</span>
                        <a href="{{ route('products') }}" class="ml-1 md:ml-2 hover:text-primary transition-colors">Produk</a>
                    </div>
                </li>
                @if($product->category)
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-rounded text-on-surface-variant text-lg">chevron_right</span>
                        <a href="{{ route('products', ['category' => $product->category->slug]) }}" class="ml-1 md:ml-2 hover:text-primary transition-colors">{{ $product->category->name }}</a>
                    </div>
                </li>
                @endif
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-rounded text-on-surface-variant text-lg">chevron_right</span>
                        <span class="ml-1 md:ml-2 text-on-surface-variant line-clamp-1 max-w-[150px] sm:max-w-[200px]">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 mb-20">
            <!-- Product Gallery -->
            <div class="lg:col-span-6 flex flex-col gap-4">
                <!-- Main Image -->
                <div class="aspect-square relative overflow-hidden rounded-2xl bg-surface-container shadow-xl">
                    @if($product->thumbnail)
                        <img id="main-product-image" src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}" class="object-cover w-full h-full cursor-zoom-in transition-transform duration-300 hover:scale-105" />
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-surface-container-highest">
                            <span class="material-symbols-rounded text-6xl text-on-secondary-container">image</span>
                        </div>
                    @endif
                    
                    @if($product->discount_price > 0 && $product->discount_price < $product->price)
                        @php
                            $discountPerc = round((($product->price - $product->discount_price) / $product->price) * 100);
                        @endphp
                        <div class="absolute top-4 left-4 bg-red-600 text-white font-bold text-sm px-3 py-1.5 rounded shadow-lg">-{{ $discountPerc }}% OFF</div>
                    @endif
                </div>
                
                <!-- Thumbnails -->
                @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $img)
                    <div class="aspect-square rounded-xl overflow-hidden cursor-pointer border-2 transition-all duration-300 {{ $loop->first ? 'border-primary-container shadow-lg scale-105' : 'border-transparent hover:border-primary-container/50 opacity-70 hover:opacity-100' }} gallery-thumbnail" onclick="changeMainImage(this, '{{ asset($img->image_path) }}')">
                        <img src="{{ asset($img->image_path) }}" class="object-cover w-full h-full" alt="Gallery image" />
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            
            <!-- Product Info -->
            <div class="lg:col-span-6 flex flex-col">
                @if($product->category)
                <a href="{{ route('products', ['category' => $product->category->slug]) }}" class="inline-block px-4 py-1.5 rounded-full bg-surface-container border border-surface-container-highest text-on-surface text-sm font-bold w-max mb-4 hover:border-primary-container/50 hover:text-primary-container transition-colors">{{ $product->category->name }}</a>
                @endif
                
                <h1 class="text-3xl md:text-5xl font-black font-headline-lg uppercase text-on-surface mb-4 leading-tight">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-8 pb-8 border-b border-surface-container-highest">
                    @if($product->discount_price > 0 && $product->discount_price < $product->price)
                        <span class="text-3xl md:text-4xl font-bold text-primary-container">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                        <span class="text-xl md:text-2xl text-on-secondary-container line-through decoration-on-secondary-container/50">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @else
                        <span class="text-3xl md:text-4xl font-bold text-primary-container">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                </div>
                
                <div class="prose prose-lg dark:prose-invert max-w-none prose-headings:font-heading prose-headings:font-bold prose-a:text-primary hover:prose-a:text-primary-container prose-img:rounded-xl prose-img:shadow-lg prose-p:text-on-surface-variant mb-10">
                    {!! $product->description !!}
                </div>
                
                <div class="mt-auto pt-6 flex flex-col sm:flex-row gap-4">
                    <a href="https://wa.me/{{ $whatsappNumber }}?text=Halo%20Admin,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->name) }}%20ini.%20Apakah%20bisa%20dibantu%20untuk%20pemesanannya?" target="_blank" class="flex-1 bg-primary-container hover:bg-primary text-background text-lg font-bold py-4 px-8 rounded-full shadow-[0_0_20px_rgba(255,102,0,0.3)] hover:shadow-[0_0_30px_rgba(255,102,0,0.5)] transition-all flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        Pesan via WhatsApp
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="border-t border-surface-container-highest pt-16">
            <h2 class="text-2xl md:text-3xl font-black font-headline-lg uppercase italic text-on-surface mb-8">Produk <span class="text-primary-container">Terkait</span></h2>
            
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8">
                @foreach($relatedProducts as $related)
                <div class="group flex flex-col gap-4 cursor-pointer" onclick="window.location.href='{{ route('products.show', $related->slug) }}'">
                    <div class="aspect-[4/5] relative overflow-hidden rounded-2xl bg-surface-container shadow-lg transition-shadow duration-300 group-hover:shadow-primary-container/20">
                        @if($related->thumbnail)
                            <img alt="{{ $related->name }}" class="object-cover w-full h-full transition-transform duration-700 ease-out group-hover:scale-105" src="{{ asset($related->thumbnail) }}"/>
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
                        <h3 class="font-headline-md font-bold text-base sm:text-lg text-on-surface group-hover:text-primary-container transition-colors leading-tight line-clamp-2">{{ $related->name }}</h3>
                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mt-2">
                            @if($related->discount_price > 0 && $related->discount_price < $related->price)
                                <span class="font-bold text-primary-container text-sm sm:text-lg whitespace-nowrap">Rp {{ number_format($related->discount_price, 0, ',', '.') }}</span>
                            @else
                                <span class="font-bold text-primary-container text-sm sm:text-lg whitespace-nowrap">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
    </div>
</main>

<script>
    function changeMainImage(element, src) {
        document.getElementById('main-product-image').src = src;
        
        // Update styling of thumbnails
        document.querySelectorAll('.gallery-thumbnail').forEach(el => {
            el.classList.remove('border-primary-container', 'shadow-lg', 'scale-105');
            el.classList.add('border-transparent', 'opacity-70');
            el.classList.remove('opacity-100');
        });
        
        element.classList.remove('border-transparent', 'opacity-70');
        element.classList.add('border-primary-container', 'shadow-lg', 'scale-105', 'opacity-100');
    }
</script>
@endsection
