@extends('layouts.app')

@section('content')
<main class="flex-grow pt-20 md:pt-32 pb-24">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <!-- Back button -->
        <div class="mb-8 text-left">
            <a href="{{ route('designs') }}" class="inline-flex items-center gap-2 text-on-secondary-container hover:text-primary-container transition-colors text-sm font-semibold">
                <span class="material-symbols-rounded text-base">arrow_back</span>
                Kembali ke Katalog
            </a>
        </div>

        <!-- Design Card -->
        <div class="bg-surface-container border border-surface-container-highest rounded-3xl p-6 md:p-8 shadow-xl flex flex-col items-center">
            @if($design->categories->count() > 0)
                <div class="flex flex-wrap gap-2 mb-4 justify-center md:justify-start">
                    @foreach($design->categories as $category)
                        <span class="px-4 py-1.5 rounded-full bg-surface-container-high border border-surface-container-highest text-primary-container text-xs font-bold">{{ $category->name }}</span>
                    @endforeach
                </div>
            @endif
            
            <h1 class="text-2xl md:text-4xl font-black font-headline-lg uppercase text-on-surface mb-6">{{ $design->name }}</h1>
            
            <div class="w-full max-w-lg aspect-[4/5] rounded-2xl overflow-hidden bg-surface-container-lowest mb-8 border border-surface-container-highest flex items-center justify-center">
                @if($design->image)
                    <img src="{{ Storage::disk('public')->url(str_replace('storage/', '', $design->image)) }}" alt="{{ $design->name }}" class="object-contain w-full h-full" />
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="material-symbols-rounded text-9xl text-on-secondary-container">image</span>
                    </div>
                @endif
            </div>

            @if($design->description)
                <div class="prose prose-lg dark:prose-invert max-w-none mb-8 text-on-surface-variant text-sm md:text-base">
                    {!! $design->description !!}
                </div>
            @endif

            @if($design->colors->count() > 0)
                <div class="mb-8 flex flex-col items-center md:items-start">
                    <h4 class="text-on-secondary-container text-sm font-bold uppercase tracking-wider mb-3">Tersedia dalam warna:</h4>
                    <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                        @foreach($design->colors as $color)
                            <div class="flex flex-col items-center gap-1 group" title="{{ $color->name }}">
                                <div class="w-8 h-8 rounded-full border-2 border-surface-container-highest shadow-sm group-hover:scale-110 group-hover:border-primary-container transition-all" style="background-color: {{ $color->hex_code ?? '#ccc' }};"></div>
                                <span class="text-[10px] text-on-surface-variant">{{ $color->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <a href="https://wa.me/{{ $whatsappNumber }}?text=Halo%20Admin,%20saya%20tertarik%20dengan%20desain%20jersey%20{{ urlencode($design->name) }}%20ini%20({{ urlencode(route('designs.show', $design->slug)) }}).%20Apakah%20bisa%20dibantu%20untuk%20pemesanannya?" target="_blank" class="w-full max-w-md bg-primary-container hover:bg-primary text-background text-lg font-bold py-4 px-8 rounded-full shadow-[0_0_20px_rgba(255,102,0,0.3)] hover:shadow-[0_0_30px_rgba(255,102,0,0.5)] transition-all flex items-center justify-center gap-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                Pilih Produk Ini
            </a>
        </div>
    </div>
</main>
@endsection
