@extends('layouts.app')

@php
    $isAr = app()->getLocale() === 'ar';
    $isRu = app()->getLocale() === 'ru';

    $landingTitle = $isAr
        ? 'تذاكر برج خليفة 2026 | حجز الطابق 124 و125 و148 سكاي لاونج بدون انتظار'
        : ($isRu
            ? 'Билеты на Бурдж Халифа 2026: Смотровая Площадка 124, 125 и 148 Этаж (SKY)'
            : 'Burj Khalifa Tickets 2026 | Level 124, 125 & 148 SKY Lounge Fast Track');

    $landingDesc = $isAr
        ? 'احجز تذاكر برج خليفة الرسمية لعام 2026 بأفضل الأسعار. استمتع بإطلالات بانورامية بزاوية 360 درجة من الطابقين 124 و125 قمة البرج أو تجربة VIP في الطابق 148 سكاي لاونج مع خدمة المسار السريع.'
        : ($isRu
            ? 'Официальные электронные билеты на Бурдж Халифа в Дубае: смотровая площадка At The Top (124 и 125 этажи) и роскошный SKY Lounge на 148 этаже. Мгновенное подтверждение и проход без очередей.'
            : 'Book official Burj Khalifa tickets for 2026. Experience breathtaking 360-degree views from Level 124 & 125 At The Top or indulge in the ultra-luxury Level 148 At The Top SKY Lounge with skip-the-line privileges.');

    $landingKeywords = $isAr
        ? 'تذاكر برج خليفة, حجز برج خليفة 2026, اسعار تذاكر برج خليفة, قمة البرج دبي, برج خليفة الطابق 148, برج خليفة تذاكر سريعة'
        : ($isRu
            ? 'билеты бурдж халифа, бурдж халифа цена 2026, смотровая площадка дубай, бурдж халифа 124 этаж, бурдж халифа 148 этаж билеты'
            : 'Burj Khalifa tickets, Burj Khalifa At The Top tickets, Burj Khalifa 148 floor tickets, Burj Khalifa fast track, Burj Khalifa ticket price 2026');
@endphp

@section('title', $landingTitle . ' | ' . \App\Models\Setting::get('general.site_name', 'Dubai Tour Book'))
@section('meta_description', $landingDesc)
@section('meta_keywords', $landingKeywords)
@section('og_image', asset('assets/images/tour_burj.jpg'))

@section('content')
<!-- Breadcrumbs -->
<nav class="pt-24 pb-4 bg-offwhite border-b border-gray-200/60" aria-label="Breadcrumb">
    <div class="container mx-auto px-6">
        <ol class="flex items-center space-x-2 text-xs text-gray-500 rtl:space-x-reverse">
            <li><a href="{{ route('home') }}" class="hover:text-gold transition-colors">{{ __('nav_home') }}</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li><a href="{{ route('packages.index') }}" class="hover:text-gold transition-colors">{{ __('packages') }}</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li class="text-deepblack font-semibold" aria-current="page">{{ $isAr ? 'تذاكر برج خليفة' : ($isRu ? 'Билеты на Бурдж Халифа' : 'Burj Khalifa Tickets') }}</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center text-white overflow-hidden py-20 bg-deepblack">
    <div class="absolute inset-0 w-full h-full">
        <img src="{{ asset('assets/images/tour_burj.jpg') }}" alt="Burj Khalifa Observation Deck View" class="w-full h-full object-cover object-center transform scale-105" loading="eager" width="1920" height="1080">
        <div class="absolute inset-0 bg-gradient-to-t from-deepblack via-black/60 to-black/40"></div>
    </div>

    <div class="container relative z-10 mx-auto px-6 text-center max-w-4xl" data-aos="fade-up">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/60 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-6 shadow-xl">
            <span>{{ $isAr ? 'أعلى منصة مراقبة في العالم' : ($isRu ? 'Самое высокое здание в мире' : 'World\'s Tallest Tower & Observation Decks') }}</span>
        </div>

        <h1 class="text-4xl sm:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
            {{ $isAr ? 'تذاكر برج خليفة الرسمية 2026' : ($isRu ? 'Билеты на Бурдж Халифа 2026' : 'Burj Khalifa Observation Tickets') }} <br />
            <span class="text-gradient-gold">{{ $isAr ? 'الطوابق 124 و125 و148 سكاي لاونج' : ($isRu ? '124, 125 и 148 Этаж (SKY Lounge)' : 'Level 124, 125 & 148 SKY Lounge') }}</span>
        </h1>

        <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto font-light leading-relaxed">
            {{ $landingDesc }}
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            @if($package)
                <a href="{{ route('bookings.create', ['type' => 'package', 'id' => $package->id]) }}" class="bg-gold text-deepblack font-extrabold px-8 py-4 rounded-full hover:bg-white transition-all text-base shadow-2xl transform hover:-translate-y-1">
                    {{ $isAr ? 'احجز تذكرتك الآن' : ($isRu ? 'Купить билет онлайн' : 'Book Tickets Now') }}
                </a>
            @endif
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact.phone', '+971 4 321 8899'));
                $waText = rawurlencode('Hello Dubai Tour Book, I want to book Burj Khalifa observation deck tickets.');
            @endphp
            <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-4 rounded-full transition-all text-base shadow-xl flex items-center gap-2">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                <span>{{ $isAr ? 'حجز فوري عبر الواتساب' : ($isRu ? 'WhatsApp Бронирование' : 'Instant WhatsApp Pass') }}</span>
            </a>
        </div>
    </div>
</section>

<!-- Level 124 vs 148 Comparison Table -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center mb-14">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Ticket Options</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-deepblack">Level 124/125 vs Level 148 SKY Comparison</h2>
            <p class="text-gray-600 mt-2 text-sm">Choose the experience matching your preferences and schedule.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="rounded-3xl border border-gray-200 p-8 bg-offwhite shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-gray-500">Popular Choice</span>
                    <h3 class="text-2xl font-bold text-deepblack mt-1">At The Top (Levels 124 & 125)</h3>
                    <p class="text-xs text-gray-500 mt-2">Access to the famous outdoor observation terrace at 452 meters high with high-powered telescopes.</p>
                    <div class="mt-6 flex items-baseline gap-2">
                        <span class="text-4xl font-black text-deepblack">180 AED</span>
                        <span class="text-xs text-gray-500">/ person (Gate Price: 189 AED)</span>
                    </div>

                    <ul class="mt-6 space-y-3 text-xs text-gray-600">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Access to Levels 124 and 125</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>High-speed double-deck elevator (10m/s)</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>360-degree glass viewing terrace</span>
                        </li>
                    </ul>
                </div>

                @if($package)
                    <a href="{{ route('packages.show', $package) }}" class="mt-8 block text-center py-3 bg-deepblack text-white hover:bg-gold hover:text-deepblack rounded-xl font-bold text-sm transition-colors">
                        Select Level 124 & 125
                    </a>
                @endif
            </div>

            <div class="rounded-3xl border-2 border-gold p-8 bg-gradient-to-b from-amber-50/50 to-white shadow-xl flex flex-col justify-between relative overflow-hidden">
                <span class="absolute top-4 right-4 bg-gold text-deepblack font-extrabold text-[10px] uppercase px-3 py-1 rounded-full">VIP Experience</span>
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-gold">Ultra-Luxury Lounge</span>
                    <h3 class="text-2xl font-bold text-deepblack mt-1">At The Top SKY (Level 148)</h3>
                    <p class="text-xs text-gray-500 mt-2">The world's highest luxury lounge at 555 meters with personalized guest ambassadors and refreshments.</p>
                    <div class="mt-6 flex items-baseline gap-2">
                        <span class="text-4xl font-black text-gold">459 AED</span>
                        <span class="text-xs text-gray-500">/ person</span>
                    </div>

                    <ul class="mt-6 space-y-3 text-xs text-gray-600">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Fast-track skip-the-line elevator entry</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Access to Levels 148, 125, and 124</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Signature Arabian coffee, dates & luxury pastries</span>
                        </li>
                    </ul>
                </div>

                <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode('Hello Dubai Tour Book, I want to book Level 148 SKY Lounge fast-track tickets.') }}" target="_blank" rel="noopener noreferrer" class="mt-8 block text-center py-3 bg-gold text-deepblack hover:bg-deepblack hover:text-white rounded-xl font-bold text-sm transition-colors shadow">
                    Book Level 148 SKY Pass
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Visible FAQ Section -->
<section class="py-20 bg-offwhite border-t border-gray-100">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="text-center mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Visitor Guide</span>
            <h2 class="text-3xl font-extrabold text-deepblack">Burj Khalifa Ticket FAQs</h2>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">What is the best time to visit Burj Khalifa?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Sunset hours (between 4:30 PM and 6:30 PM) offer the most breathtaking views as the city transitions from golden afternoon sunlight to twinkling nighttime lights. Early morning (9:00 AM – 11:00 AM) provides minimal crowds.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">How do I reach the Burj Khalifa ticket counter?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">The entrance to At The Top is located on the Lower Ground (LG) floor of The Dubai Mall, right near the food court and Dubai Fountain entrance.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">Can I show electronic mobile vouchers on my smartphone?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Yes! You do not need to print physical tickets. Simply display the digital barcode voucher received on WhatsApp or email at the turnstiles for immediate scanning.</p>
            </div>
        </div>
    </div>
</section>

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "Product",
  "name": "Burj Khalifa At The Top Observation Deck Tickets",
  "description": "{{ $landingDesc }}",
  "image": "{{ asset('assets/images/tour_burj.jpg') }}",
  "brand": { "@type": "Brand", "name": "Dubai Tour Book" },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "AED",
    "price": "180.00",
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
    { "@type": "ListItem", "position": 3, "name": "Burj Khalifa Tickets", "item": "{{ url()->current() }}" }
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
      "name": "What is the best time to visit Burj Khalifa?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Sunset hours (between 4:30 PM and 6:30 PM) offer the most breathtaking views as the city transitions from golden afternoon sunlight to twinkling nighttime lights. Early morning (9:00 AM – 11:00 AM) provides minimal crowds."
      }
    },
    {
      "@type": "Question",
      "name": "How do I reach the Burj Khalifa ticket counter?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The entrance to At The Top is located on the Lower Ground (LG) floor of The Dubai Mall, right near the food court and Dubai Fountain entrance."
      }
    },
    {
      "@type": "Question",
      "name": "Can I show electronic mobile vouchers on my smartphone?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes! You do not need to print physical tickets. Simply display the digital barcode voucher received on WhatsApp or email at the turnstiles for immediate scanning."
      }
    }
  ]
}
</script>
@endsection
