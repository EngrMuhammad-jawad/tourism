@extends('layouts.app')

@php
    $isAr = app()->getLocale() === 'ar';
    $isRu = app()->getLocale() === 'ru';

    $landingTitle = $isAr
        ? 'تأجير يخوت دبي مارينا الفاخرة 2026 | رحلات بحرية خاصة ويخوت VIP بالساعة'
        : ($isRu
            ? 'Аренда Яхты в Дубай Марина 2026: Частные и Групповые VIP Круизы'
            : 'Dubai Yacht Tours 2026 | Luxury Dubai Marina Private Charters & Sunset Cruises');

    $landingDesc = $isAr
        ? 'استأجر يختاً فاخراً في دبي مارينا لعام 2026. جولات بحرية خاصة وممتعة تمر ببرج العرب، جزيرة بلوواترز، ونخلة جميرا مع طاقم محترف ومشروبات وخدمات 7 نجوم.'
        : ($isRu
            ? 'Премиальная аренда яхт в Дубай Марина: роскошные приватные круизы мимо Бурдж Аль Араб, Palm Jumeirah и колеса обозрения Ain Dubai. Капитан, экипаж и сервис 5 звезд.'
            : 'Charter a private luxury yacht in Dubai Marina for 2026. Cruise past iconic landmarks including Burj Al Arab, Atlantis Palm, Ain Dubai, and Bluewaters Island with licensed captain, crew, and 5-star amenities.');

    $landingKeywords = $isAr
        ? 'تأجير يخوت دبي, يخت خاص دبي مارينا, اسعار تأجير اليخوت في دبي, رحلات بحرية دبي, حجز يخت دبي'
        : ($isRu
            ? 'аренда яхты дубай, прокат яхты дубай марина, прогулка на яхте в дубае цена, яхта дубай с капитаном'
            : 'Dubai yacht tour, Dubai marina yacht rental, private yacht charter Dubai, luxury boat rental Dubai, Dubai sunset cruise');
@endphp

@section('title', $landingTitle . ' | ' . \App\Models\Setting::get('general.site_name', 'Dubai Tour Book'))
@section('meta_description', $landingDesc)
@section('meta_keywords', $landingKeywords)
@section('og_image', asset('assets/images/hero.jpg'))

@section('content')
<!-- Breadcrumbs -->
<nav class="pt-24 pb-4 bg-offwhite border-b border-gray-200/60" aria-label="Breadcrumb">
    <div class="container mx-auto px-6">
        <ol class="flex items-center space-x-2 text-xs text-gray-500 rtl:space-x-reverse">
            <li><a href="{{ route('home') }}" class="hover:text-gold transition-colors">{{ __('nav_home') }}</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li><a href="{{ route('packages.index') }}" class="hover:text-gold transition-colors">{{ __('packages') }}</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li class="text-deepblack font-semibold" aria-current="page">{{ $isAr ? 'تأجير يخوت دبي' : ($isRu ? 'Аренда яхт' : 'Dubai Yacht Tours') }}</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center text-white overflow-hidden py-20 bg-deepblack">
    <div class="absolute inset-0 w-full h-full">
        <img src="{{ asset('assets/images/hero.jpg') }}" alt="Dubai Marina Luxury Yacht Cruise" class="w-full h-full object-cover object-center transform scale-105" loading="eager" width="1920" height="1080">
        <div class="absolute inset-0 bg-gradient-to-t from-deepblack via-black/60 to-black/40"></div>
    </div>

    <div class="container relative z-10 mx-auto px-6 text-center max-w-4xl" data-aos="fade-up">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/60 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-6 shadow-xl">
            <span>{{ $isAr ? 'أسطول يخوت فاخرة في دبي مارينا' : ($isRu ? 'Премиум флот яхт в Дубай Марина' : 'Private Luxury Yachts in Dubai Marina') }}</span>
        </div>

        <h1 class="text-4xl sm:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
            {{ $isAr ? 'تأجير يخوت دبي مارينا الفاخرة' : ($isRu ? 'Аренда Яхт в Дубай Марина' : 'Dubai Marina Luxury Yacht Charters') }} <br />
            <span class="text-gradient-gold">{{ $isAr ? 'رحلات خاصة وغروب الشمس في الخليج العربي' : ($isRu ? 'VIP Круизы на Закате' : 'Private Sunset Cruises & VIP Stays') }}</span>
        </h1>

        <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto font-light leading-relaxed">
            {{ $landingDesc }}
        </p>

        @php
            $cleanPhone = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact.phone', '+971 4 321 8899'));
            $waText = rawurlencode('Hello Dubai Tour Book, I would like to inquire about private yacht charter in Dubai Marina.');
        @endphp
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="bg-gold text-deepblack font-extrabold px-8 py-4 rounded-full hover:bg-white transition-all text-base shadow-2xl transform hover:-translate-y-1 flex items-center gap-2">
                <span>{{ $isAr ? 'احجز يختك الخاص عبر الواتساب' : ($isRu ? 'Забронировать яхту' : 'Book Private Yacht on WhatsApp') }}</span>
            </a>
            <button type="button" data-service-modal="city_tours" class="bg-black/60 backdrop-blur-md text-white font-bold px-8 py-4 rounded-full hover:bg-white hover:text-deepblack transition-all text-base shadow-xl border border-white/30">
                <span>{{ $isAr ? 'طلب عرض مخصص' : ($isRu ? 'Индивидуальный расчет' : 'Request Custom Quote') }}</span>
            </button>
        </div>
    </div>
</section>

<!-- Fleet & Pricing Grid -->
<section class="py-20 bg-offwhite">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center mb-14">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Available Charters</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-deepblack">Dubai Marina Yacht Fleet Options</h2>
            <p class="text-gray-600 mt-2 text-sm">All charters include professional captain, crew, fuel, soft drinks, ice, and sound system.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-xl flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gold uppercase tracking-wider">Up to 8 Guests</span>
                    <h3 class="text-2xl font-bold text-deepblack mt-1">44ft Luxury Sport Yacht</h3>
                    <p class="text-xs text-gray-500 mt-2">Perfect for couples and small family gatherings seeking an intimate cruise around Ain Dubai and JBR.</p>
                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-3xl font-black text-deepblack">650 AED</span>
                        <span class="text-xs text-gray-500">/ hour</span>
                    </div>
                </div>
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode('Hello, I want to book the 44ft Luxury Yacht.') }}" target="_blank" class="mt-8 block text-center py-3 bg-deepblack text-white hover:bg-gold hover:text-deepblack rounded-xl font-bold text-sm transition-colors">
                    Reserve 44ft Yacht
                </a>
            </div>

            <div class="bg-gradient-to-b from-gray-900 to-deepblack text-white rounded-3xl p-6 border border-gold/40 shadow-2xl flex flex-col justify-between relative">
                <span class="absolute top-4 right-4 bg-gold text-deepblack font-black text-[10px] uppercase px-3 py-1 rounded-full">Most Popular</span>
                <div>
                    <span class="text-xs font-bold text-gold uppercase tracking-wider">Up to 15 Guests</span>
                    <h3 class="text-2xl font-bold text-white mt-1">56ft Majesty Flybridge Yacht</h3>
                    <p class="text-xs text-gray-300 mt-2">Spacious flybridge, sunbed lounge, full kitchen, and sound system. Cruises to Atlantis Palm and Burj Al Arab.</p>
                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-3xl font-black text-gold">950 AED</span>
                        <span class="text-xs text-gray-400">/ hour</span>
                    </div>
                </div>
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode('Hello, I want to book the 56ft Majesty Flybridge Yacht.') }}" target="_blank" class="mt-8 block text-center py-3 bg-gold text-deepblack hover:bg-white rounded-xl font-bold text-sm transition-colors shadow">
                    Reserve 56ft Majesty
                </a>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-xl flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gold uppercase tracking-wider">Up to 30 Guests</span>
                    <h3 class="text-2xl font-bold text-deepblack mt-1">85ft VIP Mega Yacht</h3>
                    <p class="text-xs text-gray-500 mt-2">Ultimate corporate events, birthday celebrations, and VIP luxury with 3 master bedrooms and Jacuzzi deck.</p>
                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-3xl font-black text-deepblack">2,000 AED</span>
                        <span class="text-xs text-gray-500">/ hour</span>
                    </div>
                </div>
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode('Hello, I want to book the 85ft VIP Mega Yacht.') }}" target="_blank" class="mt-8 block text-center py-3 bg-deepblack text-white hover:bg-gold hover:text-deepblack rounded-xl font-bold text-sm transition-colors">
                    Reserve 85ft Mega Yacht
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Visible FAQ Section -->
<section class="py-20 bg-white border-t border-gray-100">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="text-center mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Charter Guide</span>
            <h2 class="text-3xl font-extrabold text-deepblack">Dubai Yacht Rental FAQs</h2>
        </div>

        <div class="space-y-4">
            <div class="bg-offwhite rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">What is the minimum rental duration for private yachts in Dubai?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">The minimum rental duration is 2 hours. A 2-hour cruise allows you to sail through Dubai Marina, JBR, and Bluewaters Island (Ain Dubai). A 3 to 4-hour cruise reaches Atlantis The Palm and Burj Al Arab.</p>
            </div>
            <div class="bg-offwhite rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">Can we bring our own food and beverages on board?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Yes! You are welcome to bring your own food, snacks, and beverages. All yachts are equipped with refrigerators, microwave ovens, ice boxes, and electric grills. Catering services can also be arranged upon request.</p>
            </div>
            <div class="bg-offwhite rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">Where do the yachts depart from in Dubai?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">All our yachts depart directly from Dubai Marina Yacht Club and Dubai Harbour, with convenient drop-off and parking areas.</p>
            </div>
        </div>
    </div>
</section>

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "Product",
  "name": "Dubai Marina Luxury Yacht Charter",
  "description": "{{ $landingDesc }}",
  "image": "{{ asset('assets/images/hero.jpg') }}",
  "brand": { "@type": "Brand", "name": "Dubai Tour Book" },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "AED",
    "price": "650.00",
    "availability": "https://schema.org/InStock",
    "url": "{{ url()->current() }}"
  }
}
</script>

<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ route('home') }}" },
    { "@type": "ListItem", "position": 2, "name": "Packages", "item": "{{ route('packages.index') }}" },
    { "@type": "ListItem", "position": 3, "name": "Dubai Yacht Tours", "item": "{{ url()->current() }}" }
  ]
}
</script>

<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is the minimum rental duration for private yachts in Dubai?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The minimum rental duration is 2 hours. A 2-hour cruise allows you to sail through Dubai Marina, JBR, and Bluewaters Island (Ain Dubai). A 3 to 4-hour cruise reaches Atlantis The Palm and Burj Al Arab."
      }
    },
    {
      "@type": "Question",
      "name": "Can we bring our own food and beverages on board?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes! You are welcome to bring your own food, snacks, and beverages. All yachts are equipped with refrigerators, microwave ovens, ice boxes, and electric grills. Catering services can also be arranged upon request."
      }
    },
    {
      "@type": "Question",
      "name": "Where do the yachts depart from in Dubai?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "All our yachts depart directly from Dubai Marina Yacht Club and Dubai Harbour, with convenient drop-off and parking areas."
      }
    }
  ]
}
</script>
@endsection
