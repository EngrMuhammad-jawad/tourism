@extends('layouts.app')

@php
    $isAr = app()->getLocale() === 'ar';
    $isRu = app()->getLocale() === 'ru';

    $landingTitle = $isAr
        ? 'رحلة أبوظبي من دبي 2026 | جامع الشيخ زايد الكبير، قصر الإمارات ومتحف اللوفر'
        : ($isRu
            ? 'Экскурсия в Абу-Даби из Дубая 2026: Мечеть Шейха Зайда, Лувр, Президентский Дворец'
            : 'Abu Dhabi City Tour from Dubai 2026 | Sheikh Zayed Mosque & Emirates Palace');

    $landingDesc = $isAr
        ? 'احجز أفضل رحلة ليوم كامل إلى أبوظبي انطلاقاً من فنادق دبي لعام 2026. زيارة جامع الشيخ زايد الكبير المعماري الأيقوني، قصر الوطن، قصر الإمارات، ومتحف اللوفر مع مرشد VIP وتوصيل مكيف.'
        : ($isRu
            ? 'Гранд-тур в столицу ОАЭ Абу-Даби из отелей Дубая: Белая Мечеть Шейха Зайда, Лувр Абу-Даби, дворец Эмирейтс Палас, набережная Корниш и Дворец Нации Каср Аль-Ватан с гидом.'
            : 'Book the ultimate full-day Abu Dhabi tour from Dubai for 2026. Explore the architectural wonder of Sheikh Zayed Grand Mosque, Emirates Palace, Louvre Abu Dhabi, and Qasr Al Watan with certified guides and luxury transfers.');

    $landingKeywords = $isAr
        ? 'رحلة ابوظبي من دبي, جولة جامع الشيخ زايد, سياحة ابوظبي 2026, حجز رحلة ابوظبي, اسعار جولات ابوظبي'
        : ($isRu
            ? 'экскурсия в абу-даби из дубая, белая мечеть абу-даби экскурсия, лувр абу-даби билеты, тур в абу-даби цена'
            : 'Abu Dhabi city tour from Dubai, Sheikh Zayed Grand Mosque tour, full day Abu Dhabi tour, Louvre Abu Dhabi tour from Dubai 2026');
@endphp

@section('title', $landingTitle . ' | ' . \App\Models\Setting::get('general.site_name', 'Dubai Tour Book'))
@section('meta_description', $landingDesc)
@section('meta_keywords', $landingKeywords)
@section('og_image', asset('assets/images/tour_mosque.jpg'))

@section('content')
<!-- Breadcrumbs -->
<nav class="pt-24 pb-4 bg-offwhite border-b border-gray-200/60" aria-label="Breadcrumb">
    <div class="container mx-auto px-6">
        <ol class="flex items-center space-x-2 text-xs text-gray-500 rtl:space-x-reverse">
            <li><a href="{{ route('home') }}" class="hover:text-gold transition-colors">{{ __('nav_home') }}</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li><a href="{{ route('packages.index') }}" class="hover:text-gold transition-colors">{{ __('packages') }}</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li class="text-deepblack font-semibold" aria-current="page">{{ $isAr ? 'رحلة أبوظبي' : ($isRu ? 'Экскурсия в Абу-Даби' : 'Abu Dhabi Tour') }}</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center text-white overflow-hidden py-20 bg-deepblack">
    <div class="absolute inset-0 w-full h-full">
        <img src="{{ asset('assets/images/tour_mosque.jpg') }}" alt="Sheikh Zayed Grand Mosque Abu Dhabi Tour" class="w-full h-full object-cover object-center transform scale-105" loading="eager" width="1920" height="1080">
        <div class="absolute inset-0 bg-gradient-to-t from-deepblack via-black/60 to-black/40"></div>
    </div>

    <div class="container relative z-10 mx-auto px-6 text-center max-w-4xl" data-aos="fade-up">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/60 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-6 shadow-xl">
            <span>{{ $isAr ? 'رحلة ثقافية متميزة من فنادق دبي' : ($isRu ? 'Главный культурный тур из Дубая' : 'Premier UAE Cultural Capital Tour') }}</span>
        </div>

        <h1 class="text-4xl sm:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
            {{ $isAr ? 'رحلة أبوظبي الشاملة من دبي' : ($isRu ? 'Экскурсия в Абу-Даби из Дубая' : 'Abu Dhabi Full Day Tour from Dubai') }} <br />
            <span class="text-gradient-gold">{{ $isAr ? 'جامع الشيخ زايد، قصر الإمارات ومتحف اللوفر' : ($isRu ? 'Мечеть Шейха Зайда и Лувр Абу-Даби' : 'Sheikh Zayed Mosque & Louvre Abu Dhabi') }}</span>
        </h1>

        <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto font-light leading-relaxed">
            {{ $landingDesc }}
        </p>

        @php
            $cleanPhone = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact.phone', '+971 4 321 8899'));
            $waText = rawurlencode('Hello Dubai Tour Book, I would like to book the Abu Dhabi City Tour from Dubai.');
        @endphp
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="#tours" class="bg-gold text-deepblack font-extrabold px-8 py-4 rounded-full hover:bg-white transition-all text-base shadow-2xl transform hover:-translate-y-1">
                {{ $isAr ? 'استعراض الباقات' : ($isRu ? 'Выбрать тур' : 'Explore Tours') }}
            </a>
            <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-4 rounded-full transition-all text-base shadow-xl flex items-center gap-2">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                <span>{{ $isAr ? 'حجز فوري عبر الواتساب' : ($isRu ? 'WhatsApp Бронь' : 'WhatsApp Concierge') }}</span>
            </a>
        </div>
    </div>
</section>

<!-- Tours Grid -->
<section id="tours" class="py-20 bg-offwhite">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center mb-14">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Capital Excursions</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-deepblack">Abu Dhabi Packages from Dubai</h2>
            <p class="text-gray-600 mt-2 text-sm">Includes roundtrip hotel pickup from Dubai in comfortable air-conditioned coaches or private VIP sedans.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($packages as $pkg)
                <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 flex flex-col justify-between group hover:shadow-2xl hover:border-gold/40 transition-all duration-300">
                    <div class="relative overflow-hidden aspect-[16/9]">
                        <img src="{{ $pkg->getFirstMediaUrl('featured') ?: asset('assets/images/tour_mosque.jpg') }}" alt="{{ $pkg->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" width="600" height="340">
                        <span class="absolute top-4 right-4 bg-deepblack/85 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-gold/40 text-gold text-xs font-bold">
                            {{ number_format($pkg->effectivePrice(), 0) }} AED / person
                        </span>
                    </div>

                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-deepblack mb-2">{{ $pkg->name }}</h3>
                            <p class="text-xs text-gray-500 line-clamp-3 mb-4">{{ $pkg->summary }}</p>

                            <div class="space-y-1.5 text-xs text-gray-600 mb-6">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Sheikh Zayed Grand Mosque Visit</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Emirates Palace & Corniche Drive</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Certified Guide & Abaya Support</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('packages.show', $pkg) }}" class="flex-1 py-3 text-center bg-deepblack text-white hover:bg-gold hover:text-deepblack rounded-xl font-bold text-sm transition-colors">
                                View Details
                            </a>
                            <a href="{{ route('bookings.create', ['type' => 'package', 'id' => $pkg->id]) }}" class="px-5 py-3 bg-gold text-deepblack hover:bg-deepblack hover:text-white rounded-xl font-bold text-sm transition-colors">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Visible FAQ Section -->
<section class="py-20 bg-white border-t border-gray-100">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="text-center mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Tour Guide</span>
            <h2 class="text-3xl font-extrabold text-deepblack">Abu Dhabi Tour FAQs</h2>
        </div>

        <div class="space-y-4">
            <div class="bg-offwhite rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">What is the dress code for visiting Sheikh Zayed Grand Mosque?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Modest clothing is mandatory. Women must cover their heads with a scarf, wear loose ankle-length dresses or trousers, and long-sleeve shirts. Men must wear long trousers and shirts covering their shoulders. Transparent or tight clothing is strictly prohibited.</p>
            </div>
            <div class="bg-offwhite rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">How long does the drive take from Dubai to Abu Dhabi?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">The scenic highway drive between Dubai and Abu Dhabi takes approximately 75 to 90 minutes each way in comfortable air-conditioned luxury transport.</p>
            </div>
        </div>
    </div>
</section>

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "TouristTrip",
  "name": "Abu Dhabi City Tour from Dubai",
  "description": "{{ $landingDesc }}",
  "image": "{{ asset('assets/images/tour_mosque.jpg') }}",
  "provider": { "@type": "TravelAgency", "name": "Dubai Tour Book", "url": "https://dubaitourbook.com" },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "AED",
    "price": "65.00",
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
    { "@type": "ListItem", "position": 3, "name": "Abu Dhabi Tour", "item": "{{ url()->current() }}" }
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
      "name": "What is the dress code for visiting Sheikh Zayed Grand Mosque?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Modest clothing is mandatory. Women must cover their heads with a scarf, wear loose ankle-length dresses or trousers, and long-sleeve shirts. Men must wear long trousers and shirts covering their shoulders. Transparent or tight clothing is strictly prohibited."
      }
    },
    {
      "@type": "Question",
      "name": "How long does the drive take from Dubai to Abu Dhabi?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The scenic highway drive between Dubai and Abu Dhabi takes approximately 75 to 90 minutes each way in comfortable air-conditioned luxury transport."
      }
    }
  ]
}
</script>
@endsection
