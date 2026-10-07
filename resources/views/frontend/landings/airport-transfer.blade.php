@extends('layouts.app')

@php
    $isAr = app()->getLocale() === 'ar';
    $isRu = app()->getLocale() === 'ru';

    $landingTitle = $isAr
        ? 'توصيل مطار دبي الدولي VIP 2026 | سيارات مرسيدس وفانات عائلية مع سائق خاص'
        : ($isRu
            ? 'VIP Трансфер из Аэропорта Дубая (DXB) 2026: Mercedes S-Class и Минивэны'
            : 'Dubai Airport Transfers & VIP Chauffeur 2026 | DXB / DWC Luxury Vehicles');

    $landingDesc = $isAr
        ? 'احجز خدمة استقبال وتوصيل مطار دبي الدولي (DXB / DWC) الفاخرة لعام 2026. أسطول حديث من سيارات مرسيدس الفئة S وفانات V-Class العائلية وسائقون محترفون مع تتبع رحلات الطيران وخدمة كبار الشخصيات.'
        : ($isRu
            ? 'Индивидуальный VIP трансфер из аэропорта Дубая (DXB и DWC) в отель. Встреча с именной табличкой, отслеживание рейсов, детские кресла, автомобили Mercedes-Benz S-Class и V-Class 24/7.'
            : 'Book executive Dubai airport transfers (DXB / DWC) in 2026. Enjoy flight tracking, VIP meet & greet inside the terminal, complimentary wait time, and luxury Mercedes S-Class or V-Class family minivans with private chauffeurs.');

    $landingKeywords = $isAr
        ? 'توصيل مطار دبي, سائق خاص مطار دبي, ليموزين مطار دبي, توصيل من مطار دبي الى الفندق, سيارات فخمة مطار دبي'
        : ($isRu
            ? 'трансфер аэропорт дубай, такси аэропорт дубай отель, аренда авто с водителем дубай, встреча в аэропорту дубая'
            : 'Dubai airport transfer, DXB airport transfer, Dubai chauffeur service, luxury airport pickup Dubai, private airport shuttle Dubai 2026');
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
            <li><a href="{{ route('transports.index') }}" class="hover:text-gold transition-colors">{{ __('transport') }}</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li class="text-deepblack font-semibold" aria-current="page">{{ $isAr ? 'توصيل مطار دبي' : ($isRu ? 'Трансфер из аэропорта' : 'Dubai Airport Transfers') }}</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center text-white overflow-hidden py-20 bg-deepblack">
    <div class="absolute inset-0 w-full h-full">
        <img src="{{ asset('assets/images/hero.jpg') }}" alt="Dubai VIP Chauffeur Airport Transfer" class="w-full h-full object-cover object-center transform scale-105" loading="eager" width="1920" height="1080">
        <div class="absolute inset-0 bg-gradient-to-t from-deepblack via-black/60 to-black/40"></div>
    </div>

    <div class="container relative z-10 mx-auto px-6 text-center max-w-4xl" data-aos="fade-up">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/60 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-6 shadow-xl">
            <span>{{ $isAr ? 'خدمة استقبال وتوصيل 24/7 في مطارات دبي' : ($isRu ? 'Круглосуточный VIP сервис 24/7' : '24/7 VIP Terminal Meet & Greet') }}</span>
        </div>

        <h1 class="text-4xl sm:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
            {{ $isAr ? 'توصيل مطار دبي الدولي VIP' : ($isRu ? 'VIP Трансфер в Аэропорту Дубая' : 'Dubai Airport VIP Chauffeur Transfers') }} <br />
            <span class="text-gradient-gold">{{ $isAr ? 'سيارات مرسيدس وفانات عائلية وسائقون محترفون' : ($isRu ? 'Mercedes S-Class и Семейные Минивэны' : 'Mercedes S-Class & Executive Minivans') }}</span>
        </h1>

        <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto font-light leading-relaxed">
            {{ $landingDesc }}
        </p>

        @php
            $cleanPhone = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact.phone', '+971 4 321 8899'));
            $waText = rawurlencode('Hello Dubai Tour Book, I would like to book a VIP Airport Transfer in Dubai.');
        @endphp
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="bg-gold text-deepblack font-extrabold px-8 py-4 rounded-full hover:bg-white transition-all text-base shadow-2xl transform hover:-translate-y-1">
                {{ $isAr ? 'احجز توصيل المطار عبر الواتساب' : ($isRu ? 'Забронировать через WhatsApp' : 'Book Chauffeur on WhatsApp') }}
            </a>
            <a href="{{ route('transports.index') }}" class="bg-black/60 backdrop-blur-md text-white font-bold px-8 py-4 rounded-full hover:bg-white hover:text-deepblack transition-all text-base shadow-xl border border-white/30">
                {{ $isAr ? 'استعراض أسطول السيارات' : ($isRu ? 'Посмотреть автопарк' : 'Explore Fleet') }}
            </a>
        </div>
    </div>
</section>

<!-- Fleet Grid -->
<section class="py-20 bg-offwhite">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center mb-14">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Executive Fleet</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-deepblack">Select Your VIP Vehicle</h2>
            <p class="text-gray-600 mt-2 text-sm">Fixed transparent prices with zero hidden airport parking or toll fees.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-xl flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gold uppercase tracking-wider">Up to 3 Passengers · 3 Bags</span>
                    <h3 class="text-2xl font-bold text-deepblack mt-1">Mercedes S-Class VIP</h3>
                    <p class="text-xs text-gray-500 mt-2">Executive sedan with leather recliner seats, bottled water, Wi-Fi, and personalized chauffeur meet & greet.</p>
                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-3xl font-black text-deepblack">350 AED</span>
                        <span class="text-xs text-gray-500">one way to Downtown / Marina</span>
                    </div>
                </div>
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode('Hello, I want to book Mercedes S-Class airport transfer.') }}" target="_blank" class="mt-8 block text-center py-3 bg-deepblack text-white hover:bg-gold hover:text-deepblack rounded-xl font-bold text-sm transition-colors">
                    Reserve S-Class Sedan
                </a>
            </div>

            <div class="bg-gradient-to-b from-gray-900 to-deepblack text-white rounded-3xl p-6 border border-gold/40 shadow-2xl flex flex-col justify-between relative">
                <span class="absolute top-4 right-4 bg-gold text-deepblack font-black text-[10px] uppercase px-3 py-1 rounded-full">Top Family Choice</span>
                <div>
                    <span class="text-xs font-bold text-gold uppercase tracking-wider">Up to 7 Passengers · 7 Bags</span>
                    <h3 class="text-2xl font-bold text-white mt-1">Mercedes V-Class VIP Van</h3>
                    <p class="text-xs text-gray-300 mt-2">Spacious luxury minivan designed for families with luggage, baby car seats, and extra legroom.</p>
                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-3xl font-black text-gold">400 AED</span>
                        <span class="text-xs text-gray-400">one way all inclusive</span>
                    </div>
                </div>
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode('Hello, I want to book Mercedes V-Class VIP minivan airport transfer.') }}" target="_blank" class="mt-8 block text-center py-3 bg-gold text-deepblack hover:bg-white rounded-xl font-bold text-sm transition-colors shadow">
                    Reserve V-Class Minivan
                </a>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-xl flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gold uppercase tracking-wider">Up to 14 Passengers · 14 Bags</span>
                    <h3 class="text-2xl font-bold text-deepblack mt-1">Executive Luxury Sprinter</h3>
                    <p class="text-xs text-gray-500 mt-2">Ideal for delegations, wedding guests, and large tour groups arriving at DXB or DWC airports.</p>
                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-3xl font-black text-deepblack">700 AED</span>
                        <span class="text-xs text-gray-500">one way all inclusive</span>
                    </div>
                </div>
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode('Hello, I want to book Executive Sprinter transfer.') }}" target="_blank" class="mt-8 block text-center py-3 bg-deepblack text-white hover:bg-gold hover:text-deepblack rounded-xl font-bold text-sm transition-colors">
                    Reserve Luxury Sprinter
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Visible FAQ Section -->
<section class="py-20 bg-white border-t border-gray-100">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="text-center mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Transfer Guide</span>
            <h2 class="text-3xl font-extrabold text-deepblack">Dubai Airport Transfer FAQs</h2>
        </div>

        <div class="space-y-4">
            <div class="bg-offwhite rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">What happens if my flight to Dubai is delayed?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">We monitor all arrival flights in real time. Your driver automatically adjusts pickup time according to your actual flight touchdown with 60 minutes complimentary waiting time after landing.</p>
            </div>
            <div class="bg-offwhite rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">Where will the driver meet me at Dubai Airport?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Your professional chauffeur will wait directly outside the customs exit in the arrivals hall holding a personalized signboard with your name.</p>
            </div>
            <div class="bg-offwhite rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">Are baby car seats and child booster seats available?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Yes, certified child safety seats and booster cushions are provided free of charge upon request during booking.</p>
            </div>
        </div>
    </div>
</section>

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "Product",
  "name": "Dubai Airport VIP Chauffeur Transfer",
  "description": "{{ $landingDesc }}",
  "image": "{{ asset('assets/images/hero.jpg') }}",
  "brand": { "@type": "Brand", "name": "Dubai Tour Book" },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "AED",
    "price": "350.00",
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
    { "@type": "ListItem", "position": 2, "name": "Transport", "item": "{{ route('transports.index') }}" },
    { "@type": "ListItem", "position": 3, "name": "Dubai Airport Transfers", "item": "{{ url()->current() }}" }
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
      "name": "What happens if my flight to Dubai is delayed?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We monitor all arrival flights in real time. Your driver automatically adjusts pickup time according to your actual flight touchdown with 60 minutes complimentary waiting time after landing."
      }
    },
    {
      "@type": "Question",
      "name": "Where will the driver meet me at Dubai Airport?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Your professional chauffeur will wait directly outside the customs exit in the arrivals hall holding a personalized signboard with your name."
      }
    },
    {
      "@type": "Question",
      "name": "Are baby car seats and child booster seats available?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, certified child safety seats and booster cushions are provided free of charge upon request during booking."
      }
    }
  ]
}
</script>
@endsection
