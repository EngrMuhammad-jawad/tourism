@extends('layouts.app')

@php
    $isAr = app()->getLocale() === 'ar';
    $isRu = app()->getLocale() === 'ru';

    $landingTitle = $isAr
        ? 'جولات دبي الخاصة VIP 2026 | سيارات فارهة، مرشد خاص وبرامج سياحية مخصصة'
        : ($isRu
            ? 'Индивидуальные Туры в Дубае 2026: VIP Гид, Личный Автомобиль и Маршруты'
            : 'Dubai Private Tours 2026 | Bespoke VIP Itineraries & Private Chauffeur');

    $landingDesc = $isAr
        ? 'صمم رحلتك الخاصة في دبي لعام 2026 مع نخبة من الخبراء السياحيين. سيارات مرسيدس فارهة، مرشد سياحي خاص يتحدث لغتك، مرونة تامة في المواعيد وخصوصية كاملة للعائلات الخليجية وكبار الشخصيات.'
        : ($isRu
            ? 'Эксклюзивные индивидуальные экскурсии в Дубае и ОАЭ. Личный русскоязычный лицензированный гид, представительский автомобиль Mercedes, гибкое расписание и персонализированные маршруты без посторонних.'
            : 'Design your bespoke private Dubai tour in 2026. Travel in absolute comfort with dedicated private chauffeurs, certified private guides, flexible timings, and fully customized itineraries tailored to couples, families, and VIP groups.');

    $landingKeywords = $isAr
        ? 'جولات خاصة دبي, مرشد سياحي خاص دبي, رحلات دبي VIP للعوائل, سيارة مع سائق ومرشد دبي, برامج سياحية خاصة دبي'
        : ($isRu
            ? 'индивидуальный гид дубай, приватные туры дубай, индивидуальная экскурсия в дубае цена 2026, личный гид в оаэ'
            : 'Dubai private tours, private tour guide Dubai, bespoke Dubai itineraries, private VIP tours UAE, custom Dubai travel 2026');
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
            <li class="text-deepblack font-semibold" aria-current="page">{{ $isAr ? 'جولات دبي الخاصة' : ($isRu ? 'Индивидуальные туры' : 'Dubai Private Tours') }}</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center text-white overflow-hidden py-20 bg-deepblack">
    <div class="absolute inset-0 w-full h-full">
        <img src="{{ asset('assets/images/hero.jpg') }}" alt="Dubai Private Tours VIP Chauffeur" class="w-full h-full object-cover object-center transform scale-105" loading="eager" width="1920" height="1080">
        <div class="absolute inset-0 bg-gradient-to-t from-deepblack via-black/60 to-black/40"></div>
    </div>

    <div class="container relative z-10 mx-auto px-6 text-center max-w-4xl" data-aos="fade-up">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/60 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-6 shadow-xl">
            <span>{{ $isAr ? 'خصوصية تامة ومرونة كاملة للعائلات وكبار الشخصيات' : ($isRu ? '100% приватность и персональный маршрут' : '100% Privacy & Flexible Pacing') }}</span>
        </div>

        <h1 class="text-4xl sm:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
            {{ $isAr ? 'جولات دبي السياحية الخاصة VIP' : ($isRu ? 'Индивидуальные VIP Туры по Дубаю' : 'Dubai Private Tours & Bespoke Luxury') }} <br />
            <span class="text-gradient-gold">{{ $isAr ? 'مرشدك الخاص وأفخم السيارات لخدمتك' : ($isRu ? 'Личный Гид и Автомобиль Премиум-Класса' : 'Personal Guide & Dedicated Luxury Vehicle') }}</span>
        </h1>

        <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto font-light leading-relaxed">
            {{ $landingDesc }}
        </p>

        @php
            $cleanPhone = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact.phone', '+971 4 321 8899'));
            $waText = rawurlencode('Hello Dubai Tour Book, I would like to plan a bespoke private tour in Dubai.');
        @endphp
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="bg-gold text-deepblack font-extrabold px-8 py-4 rounded-full hover:bg-white transition-all text-base shadow-2xl transform hover:-translate-y-1">
                {{ $isAr ? 'تحدث مع مستشار الرحلات الخاصة' : ($isRu ? 'Связаться с консьержем' : 'Chat with Private Concierge') }}
            </a>
            <button type="button" data-service-modal="city_tours" class="bg-black/60 backdrop-blur-md text-white font-bold px-8 py-4 rounded-full hover:bg-white hover:text-deepblack transition-all text-base shadow-xl border border-white/30">
                {{ $isAr ? 'طلب خطة رحلة مخصصة' : ($isRu ? 'Запросить расчет' : 'Request Custom Itinerary') }}
            </button>
        </div>
    </div>
</section>

<!-- Private Benefits -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center mb-14">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Why Go Private</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-deepblack">The Private Tour Privilege</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-8 rounded-3xl bg-offwhite border border-gray-100">
                <div class="w-12 h-12 rounded-2xl bg-gold/20 flex items-center justify-center text-gold font-bold mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-deepblack mb-2">Total Schedule Control</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Start when you want, stay as long as you like at each attraction, and adjust the itinerary spontaneously.</p>
            </div>

            <div class="p-8 rounded-3xl bg-offwhite border border-gray-100">
                <div class="w-12 h-12 rounded-2xl bg-gold/20 flex items-center justify-center text-gold font-bold mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-deepblack mb-2">Native Language Guides</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Dedicated expert licensed tour guides fluent in Arabic, Russian, or English assigned exclusively to your group.</p>
            </div>

            <div class="p-8 rounded-3xl bg-offwhite border border-gray-100">
                <div class="w-12 h-12 rounded-2xl bg-gold/20 flex items-center justify-center text-gold font-bold mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-deepblack mb-2">Family Comfort & Privacy</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Ideal for GCC families, elderly relatives, and young children with private Mercedes vehicles and child safety seats.</p>
            </div>
        </div>
    </div>
</section>

<!-- Visible FAQ Section -->
<section class="py-20 bg-offwhite border-t border-gray-100">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="text-center mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Bespoke Inquiries</span>
            <h2 class="text-3xl font-extrabold text-deepblack">Private Tour FAQs</h2>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">How many people can fit in a private tour vehicle?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">For couples we offer luxury Mercedes S-Class or BMW 7 (up to 3 guests). For families we provide Mercedes V-Class VIP minivans (up to 7 guests) or luxury Mercedes Sprinters (up to 14 guests).</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">Can we visit multiple Emirates in a single private day tour?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Yes! You can combine Dubai and Abu Dhabi, or explore Sharjah, Ajman, and Ras Al Khaimah in a customized full-day road tour.</p>
            </div>
        </div>
    </div>
</section>

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "TouristTrip",
  "name": "Dubai Private Tours & Bespoke Luxury Experiences",
  "description": "{{ $landingDesc }}",
  "image": "{{ asset('assets/images/hero.jpg') }}",
  "provider": { "@type": "TravelAgency", "name": "Dubai Tour Book", "url": "https://dubaitourbook.com" },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "AED",
    "price": "900.00",
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
    { "@type": "ListItem", "position": 3, "name": "Dubai Private Tours", "item": "{{ url()->current() }}" }
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
      "name": "How many people can fit in a private tour vehicle?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "For couples we offer luxury Mercedes S-Class or BMW 7 (up to 3 guests). For families we provide Mercedes V-Class VIP minivans (up to 7 guests) or luxury Mercedes Sprinters (up to 14 guests)."
      }
    },
    {
      "@type": "Question",
      "name": "Can we visit multiple Emirates in a single private day tour?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes! You can combine Dubai and Abu Dhabi, or explore Sharjah, Ajman, and Ras Al Khaimah in a customized full-day road tour."
      }
    }
  ]
}
</script>
@endsection
