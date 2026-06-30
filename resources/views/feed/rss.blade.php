<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
    <title>{{ $siteName }}</title>
    <link>{{ url('/') }}</link>
    <description>{{ $siteDesc }}</description>
    <atom:link href="{{ url('feed') }}" rel="self" type="application/rss+xml" />
    <language>id</language>
    <lastBuildDate>{{ \Carbon\Carbon::now()->toRfc2822String() }}</lastBuildDate>
    
    @php $favicon = \App\Models\Setting::where('key', 'site_favicon')->first()?->value; @endphp
    @if($favicon)
    <image>
        <url>{{ asset($favicon) }}</url>
        <title>{{ $siteName }}</title>
        <link>{{ url('/') }}</link>
    </image>
    @endif
    
    @foreach($articles as $article)
    <item>
        <title><![CDATA[{{ $article->title }}]]></title>
        <link>{{ route('articles.show', $article->slug) }}</link>
        <description><![CDATA[{!! \Illuminate\Support\Str::limit(strip_tags($article->content), 250) !!}]]></description>
        <pubDate>{{ \Carbon\Carbon::parse($article->published_at ?? $article->created_at)->toRfc2822String() }}</pubDate>
        <guid isPermaLink="true">{{ route('articles.show', $article->slug) }}</guid>
        @if($article->image)
        <enclosure url="{{ asset($article->image) }}" type="image/jpeg" length="0" />
        @endif
    </item>
    @endforeach
</channel>
</rss>
