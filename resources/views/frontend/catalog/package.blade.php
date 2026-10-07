@extends('layouts.app')

@php
    $isAr = app()->getLocale() === 'ar';

    $isRu = app()->getLocale() === 'ru';
    $destName = $tourPackage->destination?->name ?? ($isAr ? 'دبي' : 'Dubai');

    $pkgMetaTitle = $isAr
        ? 'حجز ' . e($tourPackage->name) . ' | رحلات ' . $destName . ' الفاخرة وسفاري VIP'
        : ($isRu
            ? 'Экскурсия ' . e($tourPackage->name) . ' в Дубае | Бронирование и Цены 2026'
            : e($tourPackage->name) . ' | ' . ($tourPackage->destination?->name ?? 'Dubai') . ' Luxury Tours & Safaris');

    $pkgMetaDesc = $isAr
        ? 'احجز ' . e($tourPackage->name) . ' في ' . $destName . '. جولة مميزة تشمل التوصيل الفاخر من الفندق، مرشد سياحي معتمد، وضيافة عربية متميزة للعوائل الخليجية.'
        : ($isRu
            ? 'Забронируйте ' . e($tourPackage->name) . ' в ' . ($tourPackage->destination?->name ?? 'Дубае') . ': трансфер из отеля, русский гид, входные билеты и VIP сервис.'
            : 'Book ' . e($tourPackage->name) . ' in ' . ($tourPackage->destination?->name ?? 'Dubai') . ' - Enjoy VIP hotel pickup, certified guide, entry passes, and Arabian hospitality.');

    $pkgMetaKeywords = $isAr
        ? e($tourPackage->name) . ', رحلات ' . $destName . ', سفاري دبي VIP للعوائل, حجز رحلات دبي من السعودية, سياحة دبي, بكجات سياحية'
        : ($isRu
            ? e($tourPackage->name) . ', экскурсии в дубае, сафари дубай, туры в оаэ 2026'
            : e($tourPackage->name) . ', ' . ($tourPackage->destination?->name ?? 'Dubai') . ' tours, Dubai desert safari, Dubai luxury travel, UAE tour packages');
@endphp

@section('title', $pkgMetaTitle)
@section('meta_description', $pkgMetaDesc)
@section('meta_keywords', $pkgMetaKeywords)
@section('og_image', $tourPackage->getFirstMediaUrl('featured') ?: asset('assets/images/tour_burj.jpg'))

@section('content')
<!-- Breadcrumb Navigation -->
<nav class="pt-24 pb-4 bg-offwhite border-b border-gray-200/60" aria-label="Breadcrumb">
    <div class="container mx-auto px-6">
        <ol class="flex items-center space-x-2 text-xs text-gray-500 rtl:space-x-reverse">
            <li>
                <a href="{{ route('home') }}" class="hover:text-gold transition-colors">{{ __('nav_home') }}</a>
            </li>
            <li><span class="text-gray-400">/</span></li>
            <li>
                <a href="{{ route('packages.index') }}" class="hover:text-gold transition-colors">{{ __('packages') }}</a>
            </li>
            <li><span class="text-gray-400">/</span></li>
            <li class="text-deepblack font-semibold truncate max-w-xs md:max-w-md" aria-current="page">{{ $tourPackage->name }}</li>
        </ol>
    </div>
</nav>

<section class="bg-offwhite py-8">
    <div class="container mx-auto grid gap-10 px-6 lg:grid-cols-2 items-center">
        <div class="overflow-hidden rounded-3xl shadow-2xl relative">
            <img class="h-[420px] w-full object-cover transform hover:scale-105 transition-transform duration-700" src="{{ $tourPackage->getFirstMediaUrl('featured') ?: asset('assets/images/hero.jpg') }}" alt="{{ $tourPackage->name }}" loading="eager" width="800" height="420">
            <span class="absolute top-4 left-4 bg-deepblack/80 backdrop-blur-md text-gold px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border border-gold/30 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-gold" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span>VIP Verified Experience</span>
            </span>
        </div>
        <div>
            <p class="font-bold text-gold uppercase tracking-widest text-sm">{{ $tourPackage->destination?->name ?? 'UAE' }} · {{ $tourPackage->duration_days }} days / {{ $tourPackage->duration_nights }} nights</p>
            <h1 class="mt-3 text-3xl md:text-4xl lg:text-5xl font-bold text-deepblack leading-tight">{{ $tourPackage->name }}</h1>
            <p class="mt-4 text-gray-600 text-lg leading-relaxed">{{ $tourPackage->summary }}</p>
            <div class="mt-6 flex items-baseline gap-3">
                <p class="text-4xl font-extrabold text-gold">{{ number_format($tourPackage->effectivePrice(), 0) }} <span class="text-2xl font-bold">AED</span></p>
                <span class="text-sm text-gray-500 font-medium">per person · All taxes & permits included</span>
            </div>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('bookings.create', ['type' => 'package', 'id' => $tourPackage->id]) }}" onclick="if(typeof window.trackEvent==='function'){window.trackEvent('begin_checkout', {content_type: 'package', content_name: '{{ addslashes($tourPackage->name) }}', content_ids: ['{{ $tourPackage->id }}'], value: {{ (float) $tourPackage->effectivePrice() }}, currency: 'AED'});}" class="rounded-full bg-gold px-8 py-4 font-bold text-deepblack shadow-lg hover:bg-deepblack hover:text-white transition-all duration-300 transform hover:-translate-y-1">
                    Book this package
                </a>
                @php
                    $rawPhone = \App\Models\Setting::get('contact.phone', '+971 4 321 8899');
                    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                    $waMsg = rawurlencode("Hello Dubai Tour Book, I am interested in booking: {$tourPackage->name}");
                @endphp
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMsg }}" target="_blank" rel="noopener noreferrer" class="rounded-full bg-emerald-600 px-6 py-4 font-bold text-white shadow-lg hover:bg-emerald-700 transition-all duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>WhatsApp Concierge</span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-16">
    <div class="container mx-auto grid gap-12 px-6 lg:grid-cols-3">
        <article class="lg:col-span-2">
            <h2 class="text-3xl font-bold text-deepblack">Experience Details & Highlights</h2>
            <div class="prose max-w-none mt-5 whitespace-pre-line text-gray-600 leading-relaxed text-base">{{ $tourPackage->description }}</div>
            
            @if($tourPackage->itineraries->isNotEmpty())
                <h2 class="mt-12 text-2xl font-bold text-deepblack">Tour Itinerary</h2>
                <ol class="mt-6 space-y-4">
                    @foreach($tourPackage->itineraries as $itinerary)
                        <li class="rounded-2xl border border-gray-100 bg-offwhite p-6 shadow-sm">
                            <strong class="text-lg text-deepblack">Day {{ $itinerary->day_number }}: {{ $itinerary->title }}</strong>
                            <p class="mt-2 text-gray-600 leading-relaxed">{{ $itinerary->description }}</p>
                        </li>
                    @endforeach
                </ol>
            @endif

            <!-- Common Tour FAQs (Triggers Google Rich FAQ Snippets) -->
            <div class="mt-14">
                <h2 class="text-2xl font-bold text-deepblack">Frequently Asked Questions</h2>
                <div class="mt-6 space-y-4">
                    <div class="border border-gray-100 rounded-2xl p-5 bg-offwhite">
                        <h3 class="font-bold text-deepblack text-base">Is hotel pickup and drop-off included in this package?</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">Yes, all our luxury tour packages include private or semi-private air-conditioned transfers from any hotel or residence across Dubai, Sharjah, and major UAE meeting points.</p>
                    </div>
                    <div class="border border-gray-100 rounded-2xl p-5 bg-offwhite">
                        <h3 class="font-bold text-deepblack text-base">What is the cancellation and refund policy?</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">You can cancel or reschedule free of charge up to 24 hours prior to your scheduled departure time for a 100% full refund.</p>
                    </div>
                    <div class="border border-gray-100 rounded-2xl p-5 bg-offwhite">
                        <h3 class="font-bold text-deepblack text-base">Are multi-lingual guides (Arabic, Russian, English) available?</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">Yes, certified native-speaking tour guides for Arabic, Russian, and English can be assigned upon booking confirmation at no additional charge.</p>
                    </div>
                </div>
            </div>
        </article>

        <aside class="space-y-6">
            <div class="rounded-2xl bg-deepblack p-8 text-white shadow-xl">
                <h3 class="text-xl font-bold text-gold mb-4">What's Included</h3>
                <ul class="space-y-3 text-sm text-gray-300">
                    @foreach((array) $tourPackage->getTranslation('included_services', app()->getLocale(), false) as $item)
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Regional Trust Badge -->
            <div class="rounded-2xl border border-gray-200 bg-amber-50/50 p-6 shadow-sm text-sm">
                <h4 class="font-bold text-deepblack text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Best Price & Luxury Guarantee
                </h4>
                <p class="mt-2 text-gray-600 text-xs leading-relaxed">
                    Official UAE Licensed Tour Operator. We accept Apple Pay, Visa, MasterCard, UnionPay, and Cash on Arrival. Instant 24/7 confirmation.
                </p>
            </div>
        </aside>
    </div>
</section>

<!-- Mobile Sticky Booking Bar (Optimized for GCC & Russian Mobile Conversion) -->
<div class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-gold/30 p-3 z-50 flex items-center justify-between lg:hidden shadow-2xl rtl:flex-row-reverse">
    <div>
        <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block">Price Per Person</span>
        <span class="text-xl font-black text-gold">{{ number_format($tourPackage->effectivePrice(), 0) }} AED</span>
    </div>
    <div class="flex items-center gap-2">
        <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMsg }}" target="_blank" rel="noopener noreferrer" class="bg-emerald-600 hover:bg-emerald-700 text-white p-2.5 rounded-xl font-bold text-xs flex items-center gap-1 shadow-md" title="WhatsApp Concierge">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
            <span class="hidden sm:inline">WhatsApp</span>
        </a>
        <a href="{{ route('bookings.create', ['type' => 'package', 'id' => $tourPackage->id]) }}" onclick="if(typeof window.trackEvent==='function'){window.trackEvent('begin_checkout', {content_type: 'package', content_name: '{{ addslashes($tourPackage->name) }}', content_ids: ['{{ $tourPackage->id }}'], value: {{ (float) $tourPackage->effectivePrice() }}, currency: 'AED'});}" class="bg-gold hover:bg-deepblack hover:text-white text-deepblack px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider shadow-md transition-colors">
            Book Now
        </a>
    </div>
</div>

<!-- Schema.org JSON-LD (Product, TouristTrip, AggregateRating, BreadcrumbList, FAQPage) -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org/",
  "@type": ["Product", "TouristTrip"],
  "name": "{{ e($tourPackage->name) }}",
  "image": "{{ $tourPackage->getFirstMediaUrl('featured') ?: asset('assets/images/hero.jpg') }}",
  "description": "{{ e(strip_tags((string)$tourPackage->summary)) }}",
  "touristType": ["Luxury Travel", "Family Travel", "Adventure", "Couples"],
  "brand": {
    "@type": "Brand",
    "name": "{{ \App\Models\Setting::get('general.site_name', 'Dubai Tour Book') }}"
  },
  "provider": {
    "@type": "TravelAgency",
    "name": "{{ \App\Models\Setting::get('general.site_name', 'Dubai Tour Book') }}",
    "url": "https://dubaitourbook.com"
  },
  "offers": [
    {
      "@type": "Offer",
      "priceCurrency": "AED",
      "price": "{{ $tourPackage->effectivePrice() }}",
      "availability": "https://schema.org/InStock",
      "url": "{{ url()->current() }}",
      "validFrom": "{{ now()->toIso8601String() }}"
    }
  ]
}
</script>

<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ route('home') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Packages",
      "item": "{{ route('packages.index') }}"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "{{ e($tourPackage->name) }}",
      "item": "{{ url()->current() }}"
    }
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
      "name": "Is hotel pickup and drop-off included in this package?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, all our luxury tour packages include private or semi-private air-conditioned transfers from any hotel or residence across Dubai, Sharjah, and major UAE meeting points."
      }
    },
    {
      "@type": "Question",
      "name": "What is the cancellation and refund policy?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "You can cancel or reschedule free of charge up to 24 hours prior to your scheduled departure time for a 100% full refund."
      }
    },
    {
      "@type": "Question",
      "name": "Are multi-lingual guides (Arabic, Russian, English) available?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, certified native-speaking tour guides for Arabic, Russian, and English can be assigned upon booking confirmation at no additional charge."
      }
    }
  ]
}
</script>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof window.trackEvent === 'function') {
            window.trackEvent('view_item', {
                content_type: 'product',
                content_name: '{{ addslashes($tourPackage->name) }}',
                content_category: 'Tour Package',
                content_ids: ['{{ $tourPackage->id }}'],
                currency: 'AED',
                value: {{ (float) ($tourPackage->price ?? 0) }}
            });
        }
    });
</script>
@endpush

