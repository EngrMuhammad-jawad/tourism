@extends('layouts.app')

@php
    $currentLocale = app()->getLocale();

    $isArabic = $currentLocale === 'ar';
    $isRussian = $currentLocale === 'ru';

    $pageTitle = $isArabic
        ? 'دبي تور بوك | رحلات دبي الفاخرة، سفاري VIP وبكجات سياحية للعوائل من دول الخليج'
        : ($isRussian
            ? 'Туры и Экскурсии в Дубае 2026: VIP Сафари, Яхты, Отели | Dubai Tour Book'
            : \App\Models\Setting::get('seo.meta_title', 'Dubai Tour Book | Luxury Tours, Desert Safaris & VIP Experiences'));

    $pageDesc = $isArabic
        ? 'احجز أرقى رحلات دبي وبكجات السياحة العائلية للمسافرين من السعودية والكويت وقطر ودول الخليج. استمتع بسفاري صحراوي VIP، جولات يخوت مارينا الخاصة، وتذاكر برج خليفة مع خدمة عملاء راقية على مدار الساعة.'
        : ($isRussian
            ? 'Премиальные экскурсии и индивидуальные туры в Дубае с русскоговорящими гидами: VIP джип-сафари, аренда яхт в Дубай Марина, билеты на Бурдж Халифа без очередей.'
            : \App\Models\Setting::get('seo.meta_description', __('hero_subtitle')));

    $pageKeywords = $isArabic
        ? 'رحلات دبي, سياحة دبي للعوائل, بكجات دبي من الرياض, رحلات دبي من الكويت, سفاري دبي VIP, حجز فنادق دبي, تأجير يخوت دبي مارينا, تذاكر برج خليفة, عروض سياحة دبي 2026, سياحة الامارات, رحلات دبي للعوائل السعودية'
        : ($isRussian
            ? 'экскурсии в дубае, туры в дубай 2026, сафари в дубае цена, русский гид в дубае, аренда яхты дубай марина, билеты бурдж халифа'
            : \App\Models\Setting::get('seo.meta_keywords', 'Dubai tours, Dubai luxury travel, desert safari Dubai, Burj Khalifa VIP tickets, Dubai yacht rental, GCC family holidays, Dubai packages from Saudi Arabia'));
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)
@section('meta_keywords', $pageKeywords)

@section('content')

    <!-- Hero Section with Animated Light Glow -->
    <section id="home" class="relative min-h-[90vh] flex items-center justify-center overflow-hidden pt-28 pb-16">
        <!-- Hero Background Image + Overlay -->
        <div class="absolute inset-0 w-full h-full">
            <div class="absolute inset-0 bg-gradient-to-t from-deepblack via-black/60 to-black/40 z-10"></div>
            <picture>
                <source srcset="{{ asset('assets/images/hero.webp') }}" type="image/webp">
                <img src="{{ asset('assets/images/hero.jpg') }}" alt="Dubai Skyline & Luxury Desert Safari Experiences" width="1920" height="1080" fetchpriority="high" class="w-full h-full object-cover object-center" loading="eager" />
            </picture>
        </div>

        <!-- Animated Background Light Orbs -->
        <div class="absolute top-1/4 left-10 w-96 h-96 rounded-full bg-amber-500/20 blur-3xl z-10 pointer-events-none animate-float-slow"></div>
        <div class="absolute bottom-10 right-10 w-[30rem] h-[30rem] rounded-full bg-amber-400/15 blur-3xl z-10 pointer-events-none animate-float-reverse"></div>

        <div class="relative z-20 text-center px-4 max-w-5xl mx-auto" data-aos="fade-up" data-aos-duration="1000">
            <!-- Animated Luxury Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/60 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-6 shadow-xl">
                <span class="w-2 h-2 rounded-full bg-gold animate-ping"></span>
                Exquisite Journeys in the United Arab Emirates
            </div>

            <!-- Main Heading with Gold Gradient -->
            <!-- Main Heading with Commercial Keyword Supremacy -->
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-black text-white mb-6 tracking-tight leading-tight text-shadow-lg">
                {{ $isArabic ? 'رحلات وسفاري دبي' : ($isRussian ? 'Экскурсии и Сафари в Дубае 2026' : 'Dubai Tours, Desert Safaris &') }} <br class="hidden sm:inline" />
                <span class="text-gradient-gold">{{ $isArabic ? 'تجارب سياحية وبكجات عائلية فاخرة' : ($isRussian ? 'VIP Экскурсии и Пакеты Отдыха' : 'Luxury UAE Experiences') }}</span>
            </h1>

            <p class="text-lg md:text-2xl text-gray-200 mb-10 max-w-3xl mx-auto font-light text-shadow">
                {{ __('hero_subtitle') }}
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-10">
                <a href="{{ route('packages.index') }}" class="bg-gold text-deepblack font-extrabold px-8 py-4 rounded-full hover:bg-white transition-all duration-300 text-lg shadow-2xl transform hover:-translate-y-1">
                    {{ __('explore_btn') }}
                </a>
                <button type="button" data-service-modal="flights" class="bg-black/60 backdrop-blur-md text-white font-bold px-8 py-4 rounded-full hover:bg-white hover:text-deepblack transition-all duration-300 text-lg shadow-xl border border-white/30 transform hover:-translate-y-1 flex items-center justify-center">
                    <span>{{ $isArabic ? 'خدمات الـ VIP الخاصة' : 'VIP Concierge Request' }}</span>
                </button>
            </div>



            <!-- Quick Booking Search Bar -->
            <div class="bg-deepblack/85 backdrop-blur-xl rounded-2xl p-5 sm:p-6 border border-gold/30 shadow-2xl max-w-4xl mx-auto text-start">
                <form method="GET" action="{{ route('packages.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-bold text-gold uppercase tracking-wider mb-2">
                            {{ $isArabic ? 'البحث عن جولة' : 'Search Experience' }}
                        </label>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isArabic ? 'مثال: جولة دبي، سفاري...' : 'e.g. Dubai Tour, Safari...' }}" class="w-full rounded-xl bg-white/10 border border-white/20 text-white placeholder-gray-400 text-base px-4 focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all" style="min-height: 60px; height: 60px;">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gold uppercase tracking-wider mb-2">
                            {{ $isArabic ? 'الوجهة' : 'Destination' }}
                        </label>
                        <select name="destination" class="w-full rounded-xl bg-white/10 border border-white/20 text-white text-base px-4 focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all cursor-pointer" style="min-height: 60px; height: 60px;">
                            <option value="" class="text-deepblack">{{ $isArabic ? 'جميع الإمارات والوجهات' : 'All Emirates' }}</option>
                            @foreach($destinations as $d)
                                <option value="{{ $d['slug'] ?? $d['id'] ?? $d['name'] }}" class="text-deepblack" @selected(request('destination') == ($d['slug'] ?? '') || request('destination') == ($d['id'] ?? ''))>{{ $d['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gold uppercase tracking-wider mb-2">
                            {{ $isArabic ? 'المدة' : 'Duration' }}
                        </label>
                        <select name="duration" class="w-full rounded-xl bg-white/10 border border-white/20 text-white text-base px-4 focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all cursor-pointer" style="min-height: 60px; height: 60px;">
                            <option value="" class="text-deepblack">{{ $isArabic ? 'أي مدة' : 'Any Duration' }}</option>
                            <option value="1" class="text-deepblack" @selected(request('duration') == '1')>{{ $isArabic ? 'يوم واحد' : '1 Day Experience' }}</option>
                            <option value="3" class="text-deepblack" @selected(request('duration') == '3')>{{ $isArabic ? '3 أيام' : '3 Days Trip' }}</option>
                            <option value="7" class="text-deepblack" @selected(request('duration') == '7')>{{ $isArabic ? '7 أيام' : '7 Days Package' }}</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-gold hover:bg-gold-light text-deepblack font-extrabold rounded-xl transition-all text-base shadow-lg flex items-center justify-center gap-2 cursor-pointer" style="min-height: 60px; height: 60px;">
                            <span>{{ $isArabic ? 'بحث في الجولات' : 'Search Tours' }}</span>
                        </button>
                    </div>
                </form>

                <!-- Quick Trending Badges Linked to High-Intent Landing Pages -->
                <div class="mt-4 pt-3 border-t border-white/10 flex flex-wrap items-center gap-2 text-xs text-gray-300">
                    <span class="text-gold font-bold">
                        {{ $isArabic ? 'الأكثر طلباً:' : 'Popular:' }}
                    </span>
                    <a href="{{ route('landings.desert-safari') }}" class="px-3 py-1 rounded-full bg-gold/20 text-gold border border-gold/40 hover:bg-gold hover:text-deepblack transition-colors font-semibold">
                        {{ $isArabic ? 'سفاري دبي VIP' : 'Dubai Desert Safari' }}
                    </a>
                    <a href="{{ route('landings.city-tour') }}" class="px-3 py-1 rounded-full bg-white/10 text-white hover:bg-gold hover:text-deepblack transition-colors">
                        {{ $isArabic ? 'جولة دبي السياحية' : 'Dubai City Tour' }}
                    </a>
                    <a href="{{ route('landings.burj-khalifa') }}" class="px-3 py-1 rounded-full bg-white/10 text-white hover:bg-gold hover:text-deepblack transition-colors">
                        {{ $isArabic ? 'تذاكر برج خليفة' : 'Burj Khalifa Tickets' }}
                    </a>
                    <a href="{{ route('landings.yacht-tour') }}" class="px-3 py-1 rounded-full bg-white/10 text-white hover:bg-gold hover:text-deepblack transition-colors">
                        {{ $isArabic ? 'يخوت مارينا' : 'Dubai Yacht Tours' }}
                    </a>
                    <a href="{{ route('landings.airport-transfer') }}" class="px-3 py-1 rounded-full bg-white/10 text-white hover:bg-gold hover:text-deepblack transition-colors">
                        {{ $isArabic ? 'توصيل المطار' : 'Airport Transfers' }}
                    </a>
                    <a href="{{ route('landings.abu-dhabi-tour') }}" class="px-3 py-1 rounded-full bg-white/10 text-white hover:bg-gold hover:text-deepblack transition-colors">
                        {{ $isArabic ? 'جامع الشيخ زايد' : 'Abu Dhabi Tour' }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Sleek Single-Row Horizontal Stats Counter Banner -->
    <section class="bg-deepblack border-y border-gold/20 py-8 relative">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="bg-gradient-to-r from-gray-900/90 via-deepblack to-gray-900/90 border border-gold/30 rounded-2xl py-6 px-6 shadow-2xl backdrop-blur-xl">
                <div style="display: flex; flex-direction: row; flex-wrap: wrap; items-center; justify-content: space-around; width: 100%; gap: 1rem;" class="stats-banner-container">
                    <div style="flex: 1; min-width: 140px; border-right: 1px solid rgba(255,255,255,0.15);" class="text-center px-4 py-2 stats-item-divider" data-aos="fade-up" data-aos-delay="100">
                        <p class="text-3xl lg:text-4xl font-extrabold text-gold tracking-tight">10,000+</p>
                        <p class="text-gray-200 text-xs font-bold uppercase tracking-wider mt-1">Happy Guests Hosted</p>
                    </div>
                    <div style="flex: 1; min-width: 140px; border-right: 1px solid rgba(255,255,255,0.15);" class="text-center px-4 py-2 stats-item-divider" data-aos="fade-up" data-aos-delay="200">
                        <p class="text-3xl lg:text-4xl font-extrabold text-gold tracking-tight">99.4%</p>
                        <p class="text-gray-200 text-xs font-bold uppercase tracking-wider mt-1">Satisfaction Rating</p>
                    </div>
                    <div style="flex: 1; min-width: 140px; border-right: 1px solid rgba(255,255,255,0.15);" class="text-center px-4 py-2 stats-item-divider" data-aos="fade-up" data-aos-delay="300">
                        <p class="text-3xl lg:text-4xl font-extrabold text-gold tracking-tight">50+</p>
                        <p class="text-gray-200 text-xs font-bold uppercase tracking-wider mt-1">Curated Experiences</p>
                    </div>
                    <div style="flex: 1; min-width: 140px;" class="text-center px-4 py-2" data-aos="fade-up" data-aos-delay="400">
                        <p class="text-3xl lg:text-4xl font-extrabold text-gold tracking-tight">24/7</p>
                        <p class="text-gray-200 text-xs font-bold uppercase tracking-wider mt-1">VIP Concierge</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- High-Intent Commercial Tourism Hubs -->
    <section class="py-16 bg-white border-b border-gray-100">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">
                    {{ $isArabic ? 'تجارب دبي الحصرية' : ($isRussian ? 'Главные Направления' : 'Signature Experiences') }}
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-deepblack">
                    {{ $isArabic ? 'أفضل وأشهر أنشطة السياحة في دبي' : ($isRussian ? 'Популярные Экскурсии и Услуги' : 'Trending Dubai Tourism Hubs') }}
                </h2>
                <p class="text-gray-500 text-sm mt-2">
                    {{ $isArabic ? 'تصفح أفضل خيارات السياحة والسفاري واليخوت والجولات المخصصة لعام 2026' : ($isRussian ? 'Выберите интересующее направление для бронирования с гарантией лучшей цены' : 'Explore curated hubs for desert safaris, private yachts, attraction passes, and VIP airport transfers.') }}
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="{{ route('landings.desert-safari') }}" class="group bg-offwhite hover:bg-gold/10 p-5 rounded-2xl border border-gray-200 hover:border-gold/50 transition-all duration-300 text-center flex flex-col items-center shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="font-bold text-deepblack text-sm group-hover:text-gold transition-colors">{{ $isArabic ? 'سفاري دبي' : 'Desert Safari' }}</h3>
                    <span class="text-[11px] text-gray-500 mt-1">Red Dunes & Quad</span>
                </a>

                <a href="{{ route('landings.city-tour') }}" class="group bg-offwhite hover:bg-gold/10 p-5 rounded-2xl border border-gray-200 hover:border-gold/50 transition-all duration-300 text-center flex flex-col items-center shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-2xl bg-blue-500/10 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="font-bold text-deepblack text-sm group-hover:text-gold transition-colors">{{ $isArabic ? 'جولة دبي' : 'Dubai City Tour' }}</h3>
                    <span class="text-[11px] text-gray-500 mt-1">Full Day Luxury</span>
                </a>

                <a href="{{ route('landings.burj-khalifa') }}" class="group bg-offwhite hover:bg-gold/10 p-5 rounded-2xl border border-gray-200 hover:border-gold/50 transition-all duration-300 text-center flex flex-col items-center shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    </div>
                    <h3 class="font-bold text-deepblack text-sm group-hover:text-gold transition-colors">{{ $isArabic ? 'برج خليفة' : 'Burj Khalifa' }}</h3>
                    <span class="text-[11px] text-gray-500 mt-1">124 & 148 Pass</span>
                </a>

                <a href="{{ route('landings.yacht-tour') }}" class="group bg-offwhite hover:bg-gold/10 p-5 rounded-2xl border border-gray-200 hover:border-gold/50 transition-all duration-300 text-center flex flex-col items-center shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 text-cyan-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="font-bold text-deepblack text-sm group-hover:text-gold transition-colors">{{ $isArabic ? 'تأجير يخوت' : 'Yacht Charters' }}</h3>
                    <span class="text-[11px] text-gray-500 mt-1">Dubai Marina VIP</span>
                </a>

                <a href="{{ route('landings.airport-transfer') }}" class="group bg-offwhite hover:bg-gold/10 p-5 rounded-2xl border border-gray-200 hover:border-gold/50 transition-all duration-300 text-center flex flex-col items-center shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-2xl bg-purple-500/10 text-purple-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </div>
                    <h3 class="font-bold text-deepblack text-sm group-hover:text-gold transition-colors">{{ $isArabic ? 'توصيل المطار' : 'Airport Transfer' }}</h3>
                    <span class="text-[11px] text-gray-500 mt-1">DXB & DWC Chauffeur</span>
                </a>

                <a href="{{ route('landings.abu-dhabi-tour') }}" class="group bg-offwhite hover:bg-gold/10 p-5 rounded-2xl border border-gray-200 hover:border-gold/50 transition-all duration-300 text-center flex flex-col items-center shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    </div>
                    <h3 class="font-bold text-deepblack text-sm group-hover:text-gold transition-colors">{{ $isArabic ? 'أبوظبي' : 'Abu Dhabi Tour' }}</h3>
                    <span class="text-[11px] text-gray-500 mt-1">Grand Mosque Day</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Destinations -->
    <section id="explore" class="py-24 bg-offwhite">
        <div class="container mx-auto px-6">
            <x-section-heading>{{ __('featured_destinations') }}</x-section-heading>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($destinations as $destination)
                    <x-destination-card
                        :name="$destination['name']"
                        :tagline="$destination['tagline']"
                        :image="$destination['image']"
                        :url="$destination['url']"
                        :delay="($loop->iteration) * 100"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Experiences Section -->
    <section class="py-24 bg-deepblack text-white relative overflow-hidden">
        <div class="absolute -top-20 right-0 w-80 h-80 rounded-full bg-amber-500/10 blur-3xl pointer-events-none animate-pulse-glow"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full bg-amber-600/10 blur-3xl pointer-events-none animate-pulse-glow"></div>

        <div class="container mx-auto px-6 relative z-10">
            <x-section-heading light>{{ __('experiences_title') }}</x-section-heading>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-gray-900/80 rounded-3xl p-8 border border-white/10 hover:border-gold/50 transition-all duration-500 transform hover:-translate-y-2 group shadow-xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-gold/20 border border-gold/40 rounded-2xl flex items-center justify-center mb-6 text-gold group-hover:bg-gold group-hover:text-deepblack transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-white">{{ __('exp_desert') }}</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">{{ __('exp_desert_desc') }}</p>
                </div>

                <div class="bg-gray-900/80 rounded-3xl p-8 border border-white/10 hover:border-gold/50 transition-all duration-500 transform hover:-translate-y-2 group shadow-xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-gold/20 border border-gold/40 rounded-2xl flex items-center justify-center mb-6 text-gold group-hover:bg-gold group-hover:text-deepblack transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-white">{{ __('exp_luxury') }}</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">{{ __('exp_luxury_desc') }}</p>
                </div>

                <div class="bg-gray-900/80 rounded-3xl p-8 border border-white/10 hover:border-gold/50 transition-all duration-500 transform hover:-translate-y-2 group shadow-xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-gold/20 border border-gold/40 rounded-2xl flex items-center justify-center mb-6 text-gold group-hover:bg-gold group-hover:text-deepblack transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-white">{{ __('exp_culture') }}</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">{{ __('exp_culture_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trending Tours Grid -->
    <section id="tours" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <x-section-heading>{{ __('trending_tours') }}</x-section-heading>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8" data-aos="fade-up">
                @foreach ($tours as $tour)
                    <x-tour-card
                        :name="$tour['name']"
                        :price-label="$tour['price_label']"
                        :image="$tour['image']"
                        :url="$tour['url']"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 bg-gradient-to-b from-gray-900 via-deepblack to-gray-900 border-t border-amber-500/20 text-white relative overflow-hidden">
        <div class="container mx-auto px-6 text-center relative z-10">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Real Traveler Experiences</span>
            <h2 class="text-4xl font-extrabold text-white mb-16" data-aos="fade-up">{{ __('testimonials') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @foreach ($testimonials as $testimonial)
                    <x-testimonial-card
                        :quote="$testimonial['quote']"
                        :author="$testimonial['author']"
                        :delay="($loop->iteration) * 100"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Latest Travel Guides & Dubai Journal Articles -->
    @if(isset($latestPosts) && $latestPosts->isNotEmpty())
    <section class="py-24 bg-white border-t border-gray-100">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">
                        {{ $isArabic ? 'مدونة السفر ودليل السياحة' : ($isRussian ? 'Блог и Советы Туристам' : 'Dubai Travel Journal') }}
                    </span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-deepblack">
                        {{ $isArabic ? 'أحدث نصائح وأدلة السياحة في دبي 2026' : ($isRussian ? 'Полезные Статьи и Гиды по Дубаю 2026' : 'Insider Dubai Travel Guides & Tips') }}
                    </h2>
                </div>
                <a href="{{ route('posts.index') }}" class="mt-4 md:mt-0 text-sm font-bold text-gold hover:text-deepblack transition-colors flex items-center gap-1">
                    <span>{{ $isArabic ? 'عرض جميع المقالات' : ($isRussian ? 'Все статьи блога' : 'View All Articles') }}</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestPosts as $post)
                    <article class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-md hover:shadow-2xl hover:border-gold/40 transition-all duration-300 flex flex-col h-full group">
                        <div class="relative overflow-hidden h-60 w-full bg-gray-900/10">
                            <img src="{{ $post->getFirstMediaUrl('featured') ?: asset('assets/images/tour_burj.jpg') }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" width="400" height="240">
                            <span class="absolute top-4 left-4 bg-deepblack/80 backdrop-blur-md text-gold text-[11px] font-bold px-3 py-1 rounded-full border border-gold/30 shadow-sm">
                                {{ $post->category?->name ?? 'Travel Guide' }}
                            </span>
                        </div>
                        <div class="p-6 flex flex-col flex-1 justify-between">
                            <div>
                                <span class="text-xs text-gray-500 font-medium block mb-2">{{ $post->published_at?->format('M d, Y') ?? now()->format('M d, Y') }} · 5 min read</span>
                                <h3 class="text-xl font-bold text-deepblack group-hover:text-amber-700 transition-colors line-clamp-2 mb-3 leading-snug">
                                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="text-xs text-gray-500 line-clamp-3 leading-relaxed">
                                    {{ $post->meta_description ?: ($post->excerpt ?: Str::limit(strip_tags((string)$post->content), 120)) }}
                                </p>
                            </div>
                            <div class="pt-4 mt-6 border-t border-gray-100">
                                <a href="{{ route('posts.show', $post) }}" class="text-xs font-bold text-deepblack group-hover:text-gold flex items-center gap-1.5 transition-colors">
                                    <span>Read Full Guide</span>
                                    <span class="inline-block transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Visible Frequently Asked Questions (FAQ) Section for Google Rich Results & Users -->
    <section class="py-24 bg-offwhite border-t border-gray-200/60" id="faqs">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="text-center mb-14">
                <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">
                    {{ $isArabic ? 'إجابات على أسئلتك' : ($isRussian ? 'Частые Вопросы' : 'Traveler Inquiries') }}
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-deepblack">
                    {{ $isArabic ? 'الأسئلة الشائعة حول سياحة ورحلات دبي' : ($isRussian ? 'Часто Задаваемые Вопросы о Турах в Дубае' : 'Frequently Asked Questions About Dubai Tours') }}
                </h2>
                <p class="text-gray-600 mt-2 text-sm">
                    {{ $isArabic ? 'إليك كل ما تحتاج لمعرفته قبل حجز رحلتك القادمة إلى دبي والإمارات' : ($isRussian ? 'Все, что нужно знать перед бронированием экскурсий и трансферов' : 'Everything you need to know about booking, transfers, guides, and policies.') }}
                </p>
            </div>

            <div class="space-y-4">
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-deepblack mb-2 flex items-center gap-2">
                        <span class="text-gold font-black">Q:</span>
                        <span>{{ $isArabic ? 'ما هي أفضل باقات ورحلات دبي السياحية لعام 2026؟' : ($isRussian ? 'Какие лучшие туры в Дубае в 2026 году?' : 'What are the best Dubai tour packages in 2026?') }}</span>
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed rtl:pr-6 ltr:pl-6">
                        {{ $isArabic ? 'تشمل أفضل الجولات تقييماً: جولة دبي السياحية الشاملة، رحلة سفاري الكثبان الحمراء VIP مع ركوب الدراجات وعشاء المشاوي، تذاكر برج خليفة قمة البرج بدون انتظار، وتأجير اليخوت الفاخرة في دبي مارينا.' : ($isRussian ? 'Лучшие туры: обзорная экскурсия по Дубаю на целый день, VIP джип-сафари по красным дюнам с квадроциклами, билеты на Бурдж Халифа без очередей и аренда яхт в Дубай Марина.' : 'The top-rated Dubai tours include the Full Day Dubai City Tour, VIP Red Dune Desert Safari with Quad Biking, Burj Khalifa At The Top skip-the-line experience, and private Dubai Marina luxury yacht charters.') }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-deepblack mb-2 flex items-center gap-2">
                        <span class="text-gold font-black">Q:</span>
                        <span>{{ $isArabic ? 'هل تتوفر جولات خاصة بمرشدين يتحدثون العربية أو الروسية؟' : ($isRussian ? 'Есть ли экскурсии с русскоговорящими гидами?' : 'Can I book private Dubai tours with Arabic or Russian speaking guides?') }}</span>
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed rtl:pr-6 ltr:pl-6">
                        {{ $isArabic ? 'نعم، نوفر مرشدين سياحيين محترفين ومعتمدين يتحدثون العربية بطلاقة لزوارنا من السعودية والكويت وقطر، بالإضافة إلى مرشدين روسيين وإنجليز مع توصيل خاص من الفندق.' : ($isRussian ? 'Да, все наши премиальные туры и сафари могут сопровождаться сертифицированными русскоговорящими гидами с индивидуальным трансфером из отеля.' : 'Yes, all our luxury Dubai tours and VIP desert safaris offer dedicated multilingual guides fluent in Arabic, Russian, and English with private 5-star hotel transfers.') }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-deepblack mb-2 flex items-center gap-2">
                        <span class="text-gold font-black">Q:</span>
                        <span>{{ $isArabic ? 'هل التوصيل من وإلى الفندق مشمول في الباقات؟' : ($isRussian ? 'Включен ли трансфер из отеля в стоимость туров?' : 'Is hotel pickup and drop-off included in all Dubai tour packages?') }}</span>
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed rtl:pr-6 ltr:pl-6">
                        {{ $isArabic ? 'نعم، تشمل جميع باقاتنا السياحية التوصيل المجاني ذهاباً وإياباً من أي فندق أو سكن في دبي والشارقة بسيارات مكيفة فاخرة وسائقين محترفين.' : ($isRussian ? 'Да, все пакетные экскурсии включают бесплатный трансфер туда и обратно из любого отеля или апартаментов в Дубае и Шардже.' : 'Yes, all our luxury tour packages include private or semi-private air-conditioned transfers from any hotel or residence across Dubai, Sharjah, and major UAE meeting points.') }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-deepblack mb-2 flex items-center gap-2">
                        <span class="text-gold font-black">Q:</span>
                        <span>{{ $isArabic ? 'ما هي سياسة الإلغاء واسترداد الأموال للجولات؟' : ($isRussian ? 'Каковы условия отмены и возврата средств?' : 'What is the cancellation and refund policy for Dubai tours?') }}</span>
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed rtl:pr-6 ltr:pl-6">
                        {{ $isArabic ? 'نقدم إمكانية الإلغاء أو إعادة الجدولة مجاناً بنسبة 100% حتى 24 ساعة قبل موعد انطلاق الجولة مع استرداد فوري لكامل المبلغ المدفوع.' : ($isRussian ? 'Вы можете бесплатно отменить или перенести бронирование за 24 часа до начала экскурсии со 100% возвратом средств.' : 'You can cancel or reschedule free of charge up to 24 hours prior to your scheduled departure time for a 100% full refund.') }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-deepblack mb-2 flex items-center gap-2">
                        <span class="text-gold font-black">Q:</span>
                        <span>{{ $isArabic ? 'كم يوماً قبل الموعد ينصح بحجز تذاكر برج خليفة وسفاري الصحراء؟' : ($isRussian ? 'За сколько дней нужно бронировать билеты на Бурдж Халифа и сафари?' : 'How far in advance should I book Burj Khalifa tickets and Desert Safaris?') }}</span>
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed rtl:pr-6 ltr:pl-6">
                        {{ $isArabic ? 'ننصح بحجز تذاكر برج خليفة لأوقات الغروب وسفاري الكثبان الحمراء قبل 3 إلى 5 أيام على الأقل، خاصة في موسم الذروة الشتوي (أكتوبر إلى أبريل).' : ($isRussian ? 'Рекомендуем бронировать билеты на закат на Бурдж Халифа и VIP сафари минимум за 3-5 дней, особенно в пиковый зимний сезон.' : 'We recommend booking Burj Khalifa sunset passes and VIP desert safaris at least 3 to 5 days in advance, especially during the peak winter season (October to April) to guarantee preferred time slots.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Schema.org Home FAQ & Tour Highlights for Google SERP (100% Synced with Visible Content) -->
    <script type="application/ld+json">
    {
      "{{ '@context' }}": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "{{ $isArabic ? 'ما هي أفضل باقات ورحلات دبي السياحية لعام 2026؟' : ($isRussian ? 'Какие лучшие туры в Дубае в 2026 году?' : 'What are the best Dubai tour packages in 2026?') }}",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "{{ $isArabic ? 'تشمل أفضل الجولات تقييماً: جولة دبي السياحية الشاملة، رحلة سفاري الكثبان الحمراء VIP مع ركوب الدراجات وعشاء المشاوي، تذاكر برج خليفة قمة البرج بدون انتظار، وتأجير اليخوت الفاخرة في دبي مارينا.' : ($isRussian ? 'Лучшие туры: обзорная экскурсия по Дубаю на целый день, VIP джип-сафари по красным дюнам с квадроциклами, билеты на Бурдж Халифа без очередей и аренда яхт в Дубай Марина.' : 'The top-rated Dubai tours include the Full Day Dubai City Tour, VIP Red Dune Desert Safari with Quad Biking, Burj Khalifa At The Top skip-the-line experience, and private Dubai Marina luxury yacht charters.') }}"
          }
        },
        {
          "@type": "Question",
          "name": "{{ $isArabic ? 'هل تتوفر جولات خاصة بمرشدين يتحدثون العربية أو الروسية؟' : ($isRussian ? 'Есть ли экскурсии с русскоговорящими гидами?' : 'Can I book private Dubai tours with Arabic or Russian speaking guides?') }}",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "{{ $isArabic ? 'نعم، نوفر مرشدين سياحيين محترفين ومعتمدين يتحدثون العربية بطلاقة لزوارنا من السعودية والكويت وقطر، بالإضافة إلى مرشدين روسيين وإنجليز مع توصيل خاص من الفندق.' : ($isRussian ? 'Да, все наши премиальные туры и сафари могут сопровождаться сертифицированными русскоговорящими гидами с индивидуальным трансфером из отеля.' : 'Yes, all our luxury Dubai tours and VIP desert safaris offer dedicated multilingual guides fluent in Arabic, Russian, and English with private 5-star hotel transfers.') }}"
          }
        },
        {
          "@type": "Question",
          "name": "{{ $isArabic ? 'هل التوصيل من وإلى الفندق مشمول في الباقات؟' : ($isRussian ? 'Включен ли трансфер из отеля в стоимость туров?' : 'Is hotel pickup and drop-off included in all Dubai tour packages?') }}",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "{{ $isArabic ? 'نعم، تشمل جميع باقاتنا السياحية التوصيل المجاني ذهاباً وإياباً من أي فندق أو سكن في دبي والشارقة بسيارات مكيفة فاخرة وسائقين محترفين.' : ($isRussian ? 'Да, все пакетные экскурсии включают бесплатный трансфер туда и обратно из любого отеля или апартаментов в Дубае и Шардже.' : 'Yes, all our luxury tour packages include private or semi-private air-conditioned transfers from any hotel or residence across Dubai, Sharjah, and major UAE meeting points.') }}"
          }
        },
        {
          "@type": "Question",
          "name": "{{ $isArabic ? 'ما هي سياسة الإلغاء واسترداد الأموال للجولات؟' : ($isRussian ? 'Каковы условия отмены и возврата средств?' : 'What is the cancellation and refund policy for Dubai tours?') }}",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "{{ $isArabic ? 'نقدم إمكانية الإلغاء أو إعادة الجدولة مجاناً بنسبة 100% حتى 24 ساعة قبل موعد انطلاق الجولة مع استرداد فوري لكامل المبلغ المدفوع.' : ($isRussian ? 'Вы можете бесплатно отменить или перенести бронирование за 24 часа до начала экскурсии со 100% возвратом средств.' : 'You can cancel or reschedule free of charge up to 24 hours prior to your scheduled departure time for a 100% full refund.') }}"
          }
        },
        {
          "@type": "Question",
          "name": "{{ $isArabic ? 'كم يوماً قبل الموعد ينصح بحجز تذاكر برج خليفة وسفاري الصحراء؟' : ($isRussian ? 'За сколько дней нужно бронировать билеты на Бурдж Халифа и сафари?' : 'How far in advance should I book Burj Khalifa tickets and Desert Safaris?') }}",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "{{ $isArabic ? 'ننصح بحجز تذاكر برج خليفة لأوقات الغروب وسفاري الكثبان الحمراء قبل 3 إلى 5 أيام على الأقل، خاصة في موسم الذروة الشتوي (أكتوبر إلى أبريل).' : ($isRussian ? 'Рекомендуем бронировать билеты на закат на Бурдж Халифа и VIP сафари минимум за 3-5 дней, особенно в пиковый зимний сезон.' : 'We recommend booking Burj Khalifa sunset passes and VIP desert safaris at least 3 to 5 days in advance, especially during the peak winter season (October to April) to guarantee preferred time slots.') }}"
          }
        }
      ]
    }
    </script>
@endsection
