{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach($urls as $url)
    <url>
        <loc>{{ $url['loc'] }}</loc>
@foreach($url['images'] as $img)
        <image:image>
            <image:loc>{{ $img['loc'] }}</image:loc>
            <image:title>{{ $img['title'] }}</image:title>
@if(!empty($img['caption']))
            <image:caption>{{ $img['caption'] }}</image:caption>
@endif
@if(!empty($img['geo_location']))
            <image:geo_location>{{ $img['geo_location'] }}</image:geo_location>
@endif
        </image:image>
@endforeach
    </url>
@endforeach
</urlset>
