@extends('layouts.app')

@section('content')
<main class="flex-grow pt-20 md:pt-28 pb-16">
    <article class="max-w-4xl mx-auto px-4 md:px-6">
        <!-- Breadcrumb -->
        <nav class="flex text-sm text-on-surface-variant mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center hover:text-primary transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-outline" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 md:ml-2 text-on-surface-variant line-clamp-1 max-w-[150px] sm:max-w-[300px]">{{ $page->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <header class="mb-10 text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-on-surface mb-6 leading-tight font-heading">{{ $page->title }}</h1>
            <div class="w-20 h-1 bg-primary mx-auto rounded-full"></div>
        </header>

        <!-- Content -->
        <div class="prose prose-lg dark:prose-invert max-w-none prose-headings:font-heading prose-headings:font-bold prose-a:text-primary hover:prose-a:text-primary-container prose-img:rounded-xl prose-img:shadow-lg prose-p:text-on-surface-variant">
            {!! $page->content !!}
        </div>
    </article>
</main>
@endsection
