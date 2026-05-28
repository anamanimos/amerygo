@extends('layouts.app')

@section('content')
<main class="flex-grow pt-20 md:pt-28 pb-16">
    <article class="max-w-4xl mx-auto px-4 md:px-md">
        <!-- Breadcrumb -->
        <nav class="flex text-sm text-on-secondary-container mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-primary-container transition-colors">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-rounded text-sm mx-1">chevron_right</span>
                        <a href="{{ route('articles') }}" class="hover:text-primary-container transition-colors">Artikel</a>
                    </div>
                </li>
                @if($article->category)
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-rounded text-sm mx-1">chevron_right</span>
                        <span class="text-on-surface font-medium">{{ $article->category->name }}</span>
                    </div>
                </li>
                @endif
            </ol>
        </nav>

        <!-- Article Header -->
        <header class="mb-10 text-center md:text-left">
            @if($article->category)
            <span class="inline-block bg-primary-container/10 text-primary-container font-bold text-xs px-3 py-1 rounded-full mb-4">
                {{ $article->category->name }}
            </span>
            @endif
            <h1 class="font-display-xl text-3xl md:text-5xl font-black mb-6 text-on-surface leading-tight">{{ $article->title }}</h1>
            
            <div class="flex items-center justify-center md:justify-start gap-4 text-on-secondary-container text-sm font-medium border-y border-surface-container-highest py-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-rounded text-lg">calendar_month</span>
                    <span>{{ $article->published_at ? $article->published_at->format('d F Y') : '-' }}</span>
                </div>
                <div class="w-1 h-1 rounded-full bg-surface-container-highest"></div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-rounded text-lg">visibility</span>
                    <span>Admin</span>
                </div>
            </div>
        </header>

        <!-- Article Image -->
        @if($article->image)
        <div class="aspect-video w-full rounded-2xl overflow-hidden mb-12 shadow-xl bg-surface-container">
            <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover" />
        </div>
        @endif

        <!-- Article Content -->
        <div class="prose prose-lg md:prose-xl prose-stone mx-auto max-w-none 
            prose-headings:font-display prose-headings:font-black prose-headings:text-on-surface
            prose-p:text-on-secondary-container prose-p:leading-relaxed
            prose-a:text-primary-container prose-a:no-underline hover:prose-a:underline
            prose-strong:text-on-surface prose-strong:font-bold
            prose-img:rounded-xl prose-img:shadow-lg
            prose-blockquote:border-l-primary-container prose-blockquote:bg-surface-container-lowest prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:not-italic prose-blockquote:rounded-r-lg
            marker:text-primary-container">
            {!! $article->content !!}
        </div>

        <!-- Share & Tags -->
        <div class="mt-12 pt-8 border-t border-surface-container-highest flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-4">
                <span class="font-bold text-on-surface">Bagikan:</span>
                <div class="flex gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface hover:bg-[#1877F2] hover:text-white transition-colors">
                        <i class="ki-duotone ki-facebook fs-4"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface hover:bg-[#1DA1F2] hover:text-white transition-colors">
                        <i class="ki-duotone ki-twitter fs-4"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface hover:bg-[#25D366] hover:text-white transition-colors">
                        <i class="ki-duotone ki-whatsapp fs-4"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                </div>
            </div>
            <div>
                <a href="{{ route('articles') }}" class="btn btn-outline border-surface-container-highest hover:border-primary-container hover:text-primary-container px-6 py-3 rounded-full font-bold transition-colors inline-flex items-center gap-2">
                    <span class="material-symbols-rounded text-sm">arrow_back</span>
                    Kembali ke Artikel
                </a>
            </div>
        </div>
    </article>

    <!-- Related Articles -->
    @if($related_articles->count() > 0)
    <section class="mt-20 py-16 bg-surface-container-lowest border-t border-surface-container-highest">
        <div class="max-w-container-max mx-auto px-4 md:px-md">
            <h2 class="font-headline-lg text-3xl font-black mb-8 text-on-surface text-center md:text-left">Artikel <span class="text-primary-container">Terkait</span></h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($related_articles as $related)
                    <article class="bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden group shadow-lg hover:shadow-primary-container/20 transition-all duration-300 cursor-pointer flex flex-col" onclick="window.location.href='{{ route('articles.show', $related->slug) }}'">
                        <div class="aspect-video bg-surface-container-high overflow-hidden relative shrink-0">
                            <img alt="{{ $related->title }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" src="{{ asset($related->image) }}"/>
                            @if($related->category)
                            <div class="absolute top-4 left-4 bg-primary-container text-background font-bold text-xs px-3 py-1 rounded shadow-md">{{ $related->category->name }}</div>
                            @endif
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <span class="text-on-secondary-container text-xs mb-2 block font-medium flex items-center gap-1">
                                <span class="material-symbols-rounded text-[14px]">calendar_month</span>
                                {{ $related->published_at ? $related->published_at->format('d M Y') : '' }}
                            </span>
                            <h3 class="font-headline-md font-bold text-lg mb-4 line-clamp-2 group-hover:text-primary-container transition-colors leading-tight">{{ $related->title }}</h3>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</main>
@endsection
