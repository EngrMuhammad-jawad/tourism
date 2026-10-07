<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('localization.supported.'.app()->getLocale().'.dir', 'ltr') }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    @php
        $gtmContainerId = config('services.gtm.id') ?: \App\Models\Setting::get('analytics.gtm_id');
    @endphp

    @if(!empty($gtmContainerId))
    <!-- Google Tag Manager -->
    <script>
        window.dataLayer = window.dataLayer || [];
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $gtmContainerId }}');
    </script>
    <!-- End Google Tag Manager -->
    @endif

    <!-- Google AdSense Account Meta Tag & Auto Ads Script -->
    <meta name="google-adsense-account" content="ca-pub-8539530555121156">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8539530555121156"
     crossorigin="anonymous"></script>
        
    @php
        $siteName = \App\Models\Setting::get('general.site_name', 'Dubai Tour Book');
        $tagline = \App\Models\Setting::get('general.tagline', 'Luxury Tours, Desert Safaris & VIP Experiences');
        
        $isAr = app()->getLocale() === 'ar';
        $isRu = app()->getLocale() === 'ru';

        $defaultDesc = $isAr
            ? 'احجز أرقى رحلات دبي وبكجات السياحة العائلية لزوار السعودية والكويت وقطر والإمارات. استمتع بسفاري صحراوي VIP، جولات يخوت مارينا الخاصة، وتذاكر برج خليفة مع خدمة عملاء راقية على مدار الساعة.'
            : ($isRu
                ? 'Премиальные экскурсии и индивидуальные туры в Дубае с русскими гидами: VIP сафари, аренда яхт в Дубай Марина, билеты на Бурдж Халифа без очередей.'
                : \App\Models\Setting::get('seo.meta_description', 'Discover Dubai & the UAE - Experience luxury desert safaris, Burj Khalifa VIP tours, yacht rentals, and 7-star Arabian hospitality at dubaitourbook.com.'));

        $siteLogo = \App\Models\Setting::get('general.logo', '/assets/images/logo.svg');
        $contactPhone = \App\Models\Setting::get('contact.phone', '+971 4 321 8899');
        $contactEmail = \App\Models\Setting::get('contact.email', 'info@dubaitourbook.com');
        $contactAddress = \App\Models\Setting::get('contact.address', 'Sheikh Mohammed bin Rashid Blvd, Downtown Dubai, United Arab Emirates');

        // Synchronize view sections with SEOTools if view set them
        if (View::hasSection('title')) {
            $t = (string) $__env->yieldContent('title');
            \Artesaos\SEOTools\Facades\SEOTools::setTitle($t, false);
            \Artesaos\SEOTools\Facades\SEOTools::opengraph()->setTitle($t);
            \Artesaos\SEOTools\Facades\SEOTools::twitter()->setTitle($t);
        }
        if (View::hasSection('meta_description')) {
            $d = (string) $__env->yieldContent('meta_description');
            \Artesaos\SEOTools\Facades\SEOTools::setDescription($d);
            \Artesaos\SEOTools\Facades\SEOTools::opengraph()->setDescription($d);
            \Artesaos\SEOTools\Facades\SEOTools::twitter()->setDescription($d);
        }
        if (View::hasSection('meta_keywords')) {
            $kw = (string) $__env->yieldContent('meta_keywords');
            if (!empty($kw)) {
                \Artesaos\SEOTools\Facades\SEOMeta::setKeywords(array_map('trim', explode(',', $kw)));
            }
        }
        if (View::hasSection('og_image')) {
            $img = (string) $__env->yieldContent('og_image');
            if (!empty($img)) {
                \Artesaos\SEOTools\Facades\SEOTools::opengraph()->addImage($img);
                \Artesaos\SEOTools\Facades\SEOTools::twitter()->setImage($img);
            }
        }
    @endphp

    <!-- SEOTools Meta, OpenGraph, Twitter & Schema Tags -->
    {!! SEO::generate() !!}

    <!-- Geo & Local Search Signals (UAE & GCC Regional Targeting) -->
    <meta name="geo.region" content="AE-DU" />
    <meta name="geo.placename" content="Dubai, United Arab Emirates" />
    <meta name="geo.position" content="25.1972;55.2744" />
    <meta name="ICBM" content="25.1972, 55.2744" />
    <meta name="coverage" content="United Arab Emirates, Saudi Arabia, Kuwait, Qatar, Bahrain, Oman, Worldwide" />

    <!-- Multi-lingual & Regional Hreflang Tags -->
    @php
        $supportedLocales = array_keys(config('localization.supported', ['en' => [], 'ar' => [], 'ru' => []]));
        $segments = request()->segments();
        if (!empty($segments) && in_array($segments[0], $supportedLocales)) {
            array_shift($segments);
        }
        $pathWithoutLocale = implode('/', $segments);
        $cleanPage = request()->integer('page') > 1 ? '?page='.request()->integer('page') : '';
        $cleanSuffix = ($pathWithoutLocale ? '/'.$pathWithoutLocale : '').$cleanPage;

        $canonicalBase = rtrim(\App\Models\Setting::get('general.site_url', config('app.url', 'https://dubaitourbook.com')), '/');
        if (str_starts_with($canonicalBase, 'http://127.0.0.1') || str_starts_with($canonicalBase, 'http://localhost')) {
            $canonicalBase = 'https://dubaitourbook.com';
        }
        $cleanCanonicalUrl = $canonicalBase . '/' . app()->getLocale() . $cleanSuffix;

        if (View::hasSection('canonical')) {
            $c = (string) $__env->yieldContent('canonical');
            \Artesaos\SEOTools\Facades\SEOTools::setCanonical($c);
            \Artesaos\SEOTools\Facades\SEOTools::opengraph()->setUrl($c);
        } else {
            \Artesaos\SEOTools\Facades\SEOTools::setCanonical($cleanCanonicalUrl);
            \Artesaos\SEOTools\Facades\SEOTools::opengraph()->setUrl($cleanCanonicalUrl);
        }
    @endphp

    <!-- SEOTools Meta, OpenGraph, Twitter & Schema Tags -->
    {!! SEO::generate() !!}

    <!-- Geo & Local Search Signals (UAE & GCC Regional Targeting) -->
    <meta name="geo.region" content="AE-DU" />
    <meta name="geo.placename" content="Dubai, United Arab Emirates" />
    <meta name="geo.position" content="25.1972;55.2744" />
    <meta name="ICBM" content="25.1972, 55.2744" />
    <meta name="coverage" content="United Arab Emirates, Saudi Arabia, Kuwait, Qatar, Bahrain, Oman, Worldwide" />

    <!-- Multi-lingual & Canonical Hreflang Tags (Google Search Central Compliant) -->
    <link rel="alternate" hreflang="en" href="{{ $canonicalBase . '/en' . $cleanSuffix }}" />
    <link rel="alternate" hreflang="ar" href="{{ $canonicalBase . '/ar' . $cleanSuffix }}" />
    <link rel="alternate" hreflang="ru" href="{{ $canonicalBase . '/ru' . $cleanSuffix }}" />
    <link rel="alternate" hreflang="x-default" href="{{ $canonicalBase . '/en' . $cleanSuffix }}" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Preload LCP Hero Image for Core Web Vitals Optimization -->
    @if(request()->routeIs('home'))
        <link rel="preload" as="image" href="{{ asset('assets/images/hero.jpg') }}" fetchpriority="high">
    @endif

    <!-- Google Fonts with Preconnect & Display Swap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <!-- Global Organization & LocalBusiness Schema -->
    <script type="application/ld+json">
    {
      "{{ '@context' }}": "https://schema.org",
      "@type": ["TravelAgency", "LocalBusiness"],
      "name": "{{ $siteName }}",
      "url": "{{ $canonicalBase }}",
      "logo": "{{ str_starts_with($siteLogo, 'http') ? $siteLogo : $canonicalBase . '/' . ltrim($siteLogo, '/') }}",
      "image": "{{ $canonicalBase }}/assets/images/hero.jpg",
      "description": "{{ $defaultDesc }}",
      "telephone": "{{ $contactPhone }}",
      "email": "{{ $contactEmail }}",
      "priceRange": "$$$$",
      "currenciesAccepted": "AED, SAR, QAR, KWD, USD, EUR, RUB",
      "paymentAccepted": "Cash, Credit Card, Apple Pay, Debit Card, Wire Transfer",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ $contactAddress }}",
        "addressLocality": "Dubai",
        "addressRegion": "Dubai",
        "postalCode": "00000",
        "addressCountry": "AE"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 25.1972,
        "longitude": 55.2744
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
          "opens": "08:00",
          "closes": "23:00"
        }
      ],
      "areaServed": [
        { "@type": "Country", "name": "United Arab Emirates", "identifier": "AE" },
        { "@type": "Country", "name": "Saudi Arabia", "identifier": "SA" },
        { "@type": "Country", "name": "Kuwait", "identifier": "KW" },
        { "@type": "Country", "name": "Qatar", "identifier": "QA" },
        { "@type": "Country", "name": "Bahrain", "identifier": "BH" },
        { "@type": "Country", "name": "Oman", "identifier": "OM" },
        { "@type": "Country", "name": "Russia", "identifier": "RU" },
        { "@type": "Country", "name": "United Kingdom", "identifier": "GB" }
      ]
    }
    </script>

    <!-- WebSite & SearchAction Schema for Google Search Box -->
    <script type="application/ld+json">
    {
      "{{ '@context' }}": "https://schema.org",
      "@type": "WebSite",
      "name": "{{ $siteName }}",
      "url": "{{ $canonicalBase }}",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "{{ $canonicalBase }}/{{ app()->getLocale() }}/packages?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
    </script>
</head>
<body class="bg-offwhite text-deepblack font-sans antialiased overflow-x-hidden">
    @if(!empty($gtmContainerId))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmContainerId }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif

    @include('partials.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.service-request-modal')
    @include('partials.whatsapp-bot-widget')

    <!-- Scripts -->
    <script defer src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @include('partials.tracking')
    @stack('scripts')
</body>
</html>
