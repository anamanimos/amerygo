@extends('layouts.app')

@section('content')
<main class="flex-grow pt-20 md:pt-28 pb-16">
    <!-- Header Section -->
    <section class="py-12 bg-surface-container-lowest border-b border-surface-container-highest">
        <div class="max-w-container-max mx-auto px-4 md:px-md text-center">
            <h1 class="font-display-xl text-4xl md:text-5xl font-black uppercase italic mb-4 text-on-surface">Kabar & <span class="text-primary-container">Artikel</span></h1>
            <p class="text-on-secondary-container max-w-2xl mx-auto text-lg">Berita terbaru, tips & trik, serta panduan lengkap seputar dunia olahraga dan desain jersey.</p>
        </div>
    </section>

    <!-- Categories Filter -->
    <section class="py-8">
        <div class="max-w-container-max mx-auto px-4 md:px-md">
            <div class="flex flex-wrap gap-2 justify-center mb-12">
                <a href="{{ route('articles') }}" class="px-6 py-2 rounded-full font-bold text-sm transition-all {{ request('category') ? 'bg-surface-container text-on-surface hover:bg-surface-container-highest' : 'bg-primary-container text-background shadow-lg' }}">
                    Semua
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('articles', ['category' => $category->slug]) }}" class="px-6 py-2 rounded-full font-bold text-sm transition-all {{ request('category') == $category->slug ? 'bg-primary-container text-background shadow-lg' : 'bg-surface-container text-on-surface hover:bg-surface-container-highest' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($articles as $article)
                    <article class="bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden group shadow-lg hover:shadow-primary-container/20 transition-all duration-300 cursor-pointer flex flex-col" onclick="window.location.href='{{ route('articles.show', $article->slug) }}'">
                        <div class="aspect-video bg-surface-container-high overflow-hidden relative shrink-0">
                            <img alt="{{ $article->title }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" src="{{ asset($article->image) }}"/>
                            @if($article->category)
                            <div class="absolute top-4 left-4 bg-primary-container text-background font-bold text-xs px-3 py-1 rounded shadow-md">{{ $article->category->name }}</div>
                            @endif
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <span class="text-on-secondary-container text-xs mb-2 block font-medium flex items-center gap-1">
                                <span class="material-symbols-rounded text-[14px]">calendar_month</span>
                                {{ $article->published_at ? $article->published_at->format('d M Y') : '' }}
                            </span>
                            <h3 class="font-headline-md font-bold text-xl mb-4 line-clamp-2 group-hover:text-primary-container transition-colors leading-tight">{{ $article->title }}</h3>
                            
                            <div class="mt-auto pt-4 border-t border-surface-container-highest flex justify-between items-center">
                                <a class="inline-flex items-center gap-2 text-primary-container font-bold text-sm hover:underline" href="{{ route('articles.show', $article->slug) }}">
                                    Baca Selengkapnya <span class="material-symbols-rounded text-xs">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-20">
                        <span class="material-symbols-rounded text-6xl text-surface-container-highest mb-4 block">article</span>
                        <h3 class="font-bold text-xl text-on-surface mb-2">Belum Ada Artikel</h3>
                        <p class="text-on-secondary-container">Belum ada artikel yang dipublikasikan saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $articles->links() }}
            </div>
        </div>
    </section>
</main>
@endsection
