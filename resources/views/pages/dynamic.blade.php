@extends('layouts.app')

@section('content')
<div class="w-full pt-28 pb-20">
    <div class="max-w-container-max mx-auto px-6 md:px-12">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-black font-headline-lg uppercase italic text-on-surface mb-10 text-center">
                {{ $page->title }}
            </h1>
            
            <div class="prose prose-invert prose-lg max-w-none text-on-secondary-container">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update global document title based on page if needed
    @if(!empty($page->meta_title))
        document.title = "{{ $page->meta_title }} - {{ $globalSettings['site_name'] ?? 'AMERYGO' }}";
    @else
        document.title = "{{ $page->title }} - {{ $globalSettings['site_name'] ?? 'AMERYGO' }}";
    @endif
</script>
@endpush
