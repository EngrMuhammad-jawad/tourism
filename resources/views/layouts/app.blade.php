<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('localization.supported.'.app()->getLocale().'.dir', 'ltr') }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'UAE Tourism | Luxury Travel & Cultural Experiences')</title>
    <meta name="description" content="@yield('meta_description', 'Discover the UAE - Experience the perfect blend of modern luxury and rich cultural heritage in Dubai, Abu Dhabi, Sharjah, and Ras Al Khaimah.')">
    <meta name="keywords" content="@yield('meta_keywords', 'UAE tourism, Dubai luxury tours, Abu Dhabi experiences, desert safari, Burj Khalifa tickets, luxury hotels UAE, Sharjah cultural tours, Ras Al Khaimah travel')">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Multi-lingual Hreflang Tags -->
    @php
        $supportedLocales = array_keys(config('localization.supported', ['en' => [], 'ar' => [], 'ru' => []]));
        $segments = request()->segments();
        if (!empty($segments) && in_array($segments[0], $supportedLocales)) {
            array_shift($segments);
        }
        $pathWithoutLocale = implode('/', $segments);
        $queryString = request()->getQueryString();
        $suffix = ($pathWithoutLocale ? '/'.$pathWithoutLocale : '').($queryString ? '?'.$queryString : '');
    @endphp
    @foreach($supportedLocales as $code)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ url($code . $suffix) }}" />
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ url('en' . $suffix) }}" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="UAE Tourism">
    <meta property="og:title" content="@yield('title', 'UAE Tourism | Luxury Travel')">
    <meta property="og:description" content="@yield('meta_description', 'Discover the UAE - Experience the perfect blend of modern luxury and rich cultural heritage.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/hero.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="{{ app()->getLocale() }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'UAE Tourism | Luxury Travel')">
    <meta name="twitter:description" content="@yield('meta_description', 'Discover the UAE - Experience the perfect blend of modern luxury and rich cultural heritage.')">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/images/hero.jpg'))">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <!-- Global Organization Schema -->
    <script type="application/ld+json">
    {
      "{{ '@context' }}": "https://schema.org",
      "@type": "TravelAgency",
      "name": "UAE Tourism",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('assets/images/hero.jpg') }}",
      "description": "Premium luxury travel agency and destination tour operator in the United Arab Emirates.",
      "telephone": "+971-4-123-4567",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Dubai",
        "addressCountry": "AE"
      }
    }
    </script>
</head>
<body class="bg-offwhite text-deepblack font-sans antialiased overflow-x-hidden">

    @include('partials.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
