@extends('layouts.app')

@php
    $isAr = app()->getLocale() === 'ar';
    $isRu = app()->getLocale() === 'ru';

    $typeName = match($transport->type?->value ?? 'car') {
        'car' => ($isAr ? 'سيارة خاصة وسفاري' : ($isRu ? 'Премиальный Автомобиль' : 'Luxury 4x4 & Private Car')),
        'van' => ($isAr ? 'حافلة عائلية فاخرة' : ($isRu ? 'Минивэн Бизнес-Класса' : 'VIP Family Minivan')),
        'bus' => ($isAr ? 'باص سياحي فاخر' : ($isRu ? 'Туристический Автобус' : 'Executive Tour Coach')),
        'flight' => ($isAr ? 'طيران خاص وجولات مروحية' : ($isRu ? 'Авиа / Вертолетный Тур' : 'Scenic Aerial & Flight')),
        default => ($isAr ? 'نقل فاخر' : ($isRu ? 'VIP Трансфер' : 'Luxury Chauffeur Transfer'))
    };

    $pageMetaTitle = $isAr
        ? 'حجز ' . e($transport->name) . ' في دبي | سيارات وسفاري وسائق خاص'
        : ($isRu
            ? 'Аренда ' . e($transport->name) . ' в Дубае | Цена и Бронирование 2026'
            : e($transport->name) . ' | Dubai Luxury Chauffeur & Private Transport');

    $pageMetaDesc = $isAr
        ? 'احجز ' . e($transport->name) . ' مع سائق خاص محترف في دبي. تشمل الوقود، بوابات سالك، مكيف فائق الجودة، وتوصيل من وإلى الفندق بأعلى معايير الراحة والأمان.'
        : ($isRu
            ? 'Забронируйте ' . e($transport->name) . ' с персональным водителем в Дубае. Включены топливо, дорожные сборы Salik, кондиционер и трансфер из отеля.'
            : 'Book ' . e($transport->name) . ' private chauffeur transfer in Dubai. Maximum comfort, desert safari marshals, punctuality, and all-inclusive pricing.');

    // Fallback Image Map for all transport fleet
    $defaultImageMap = [
        'desert-safari-4x4-land-cruiser' => asset('assets/images/transport_cruiser.jpg'),
        'polaris-dune-buggy-yamaha-quad' => asset('assets/images/transport_buggy.jpg'),
        'luxury-sedan' => asset('assets/images/transport_sedan.jpg'),
        'family-van' => asset('assets/images/transport_van.jpg'),
        'tour-coach' => asset('assets/images/transport_coach.jpg'),
        'airport-pickup' => asset('assets/images/transport_sedan.jpg'),
        'domestic-flight' => asset('assets/images/hero.jpg'),
    ];

    $mainImgUrl = $transport->getFirstMediaUrl('featured');
    if (empty($mainImgUrl) || (str_contains($mainImgUrl, '127.0.0.1:8003') && !str_contains(request()->getHost(), '8003'))) {
        $mainImgUrl = $defaultImageMap[$transport->slug] ?? asset('assets/images/transport_cruiser.jpg');
    }

    // Curated gallery images with local multi-angle photos
    $galleryImages = [];
    if ($transport->getMedia('gallery')->count() > 0) {
        foreach ($transport->getMedia('gallery') as $gm) {
            $u = $gm->getUrl();
            if (!empty($u) && (!str_contains($u, '127.0.0.1:8003') || str_contains(request()->getHost(), '8003'))) {
                $galleryImages[] = $u;
            }
        }
    }

    if (empty($galleryImages)) {
        if ($transport->slug === 'desert-safari-4x4-land-cruiser') {
            $galleryImages = [
                asset('assets/images/transport_cruiser.jpg'),
                asset('assets/images/transport_cruiser_1.jpg'),
                asset('assets/images/transport_cruiser_2.jpg'),
                asset('assets/images/transport_cruiser_3.jpg'),
                asset('assets/images/transport_cruiser_4.jpg'),
            ];
        } elseif ($transport->slug === 'family-van') {
            $galleryImages = [
                asset('assets/images/transport_van.jpg'),
                asset('assets/images/van_minivan.jpg'),
                asset('assets/images/van_sprinter1.jpg'),
                asset('assets/images/van_1.jpg'),
            ];
        } elseif ($transport->slug === 'tour-coach') {
            $galleryImages = [
                asset('assets/images/transport_coach.jpg'),
                asset('assets/images/bus_dubai_1.jpg'),
                asset('assets/images/bus_dubai_2.jpg'),
                asset('assets/images/bus_2.jpg'),
            ];
        } else {
            $galleryImages = [$mainImgUrl];
        }
    }

    $rawPhone = \App\Models\Setting::get('contact.phone', '+971 4 321 8899');
    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
    $waMsg = rawurlencode("Hello Dubai Tour Book, I would like to book the: {$transport->name} ({$transport->capacity} guests)");
@endphp

@section('title', $pageMetaTitle)
@section('meta_description', $pageMetaDesc)
@section('og_image', $mainImgUrl)

@section('content')

<!-- Breadcrumb Navigation -->
<nav class="pt-28 pb-4 bg-offwhite border-b border-gray-200/60" aria-label="Breadcrumb">
    <div class="container mx-auto px-6">
        <ol class="flex items-center space-x-2 text-xs text-gray-500 rtl:space-x-reverse">
            <li>
                <a href="{{ route('home') }}" class="hover:text-gold transition-colors">{{ __('nav_home') }}</a>
            </li>
            <li><span class="text-gray-400">/</span></li>
            <li>
                <a href="{{ route('transports.index') }}" class="hover:text-gold transition-colors">
                    {{ $isAr ? 'خدمات النقل والسيارات' : ($isRu ? 'Транспорт и Авто' : 'Transport') }}
                </a>
            </li>
            <li><span class="text-gray-400">/</span></li>
            <li class="text-deepblack font-semibold truncate max-w-xs md:max-w-md" aria-current="page">{{ $transport->name }}</li>
        </ol>
    </div>
</nav>

<!-- Vehicle Hero Showcase Section -->
<section class="bg-offwhite py-10">
    <div class="container mx-auto px-6">
        <div class="grid gap-12 lg:grid-cols-12 items-start">
            
            <!-- Left Column: Gallery & Images (7 cols) -->
            <div class="lg:col-span-7">
                <!-- Main Featured Photo -->
                <div class="overflow-hidden rounded-3xl shadow-2xl relative aspect-[16/10] bg-gray-900 border border-gray-100 group">
                    <img id="mainTransportImg" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-105" src="{{ $mainImgUrl }}" alt="{{ $transport->name }}" loading="eager" width="800" height="500">
                    
                    <!-- VIP Badge -->
                    <span class="absolute top-5 left-5 bg-deepblack/85 backdrop-blur-md text-gold px-4 py-2 rounded-full text-xs font-extrabold uppercase tracking-wider border border-gold/40 flex items-center gap-2 shadow-lg">
                        <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>{{ $isAr ? 'أسطول معتمد ومضمون' : ($isRu ? 'Проверенный VIP Автопарк' : 'VIP Verified Fleet') }}</span>
                    </span>

                    <span class="absolute bottom-5 right-5 bg-deepblack/70 backdrop-blur-md text-white px-3 py-1.5 rounded-xl text-xs font-semibold">
                        {{ count($galleryImages) }} {{ $isAr ? 'صور' : ($isRu ? 'фото' : 'Photos') }}
                    </span>
                </div>

                <!-- Interactive Thumbnails -->
                @if(count($galleryImages) > 1)
                <div class="grid grid-cols-5 gap-3 mt-4">
                    @foreach($galleryImages as $index => $img)
                        <button type="button" 
                                onclick="document.getElementById('mainTransportImg').src = '{{ $img }}'; document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('ring-2', 'ring-gold')); this.classList.add('ring-2', 'ring-gold');"
                                class="thumb-btn relative rounded-2xl overflow-hidden aspect-[4/3] border border-gray-200 shadow-sm hover:opacity-90 transition-all focus:outline-none {{ $index === 0 ? 'ring-2 ring-gold' : '' }}">
                            <img src="{{ $img }}" alt="{{ $transport->name }} thumbnail {{ $index+1 }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Right Column: Vehicle Title, Rates & Quick Actions (5 cols) -->
            <div class="lg:col-span-5 bg-white p-8 rounded-3xl border border-gray-100 shadow-xl">
                <!-- Vehicle Sub-Category Pill -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-gold/15 text-deepblack font-extrabold text-xs uppercase tracking-wider mb-4 border border-gold/30">
                    <span class="w-2 h-2 rounded-full bg-gold"></span>
                    <span>{{ $typeName }}</span>
                </div>

                <!-- Main Name -->
                <h1 class="text-3xl sm:text-4xl font-black text-deepblack leading-tight mb-4">
                    {{ $transport->name }}
                </h1>

                <!-- Short Summary -->
                <p class="text-gray-600 text-sm leading-relaxed mb-6">
                    {{ $transport->description }}
                </p>

                <!-- Pricing Display Card -->
                <div class="bg-offwhite rounded-2xl p-6 border border-gray-200/70 mb-6">
                    <div class="flex items-baseline justify-between">
                        <div>
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider block mb-1">
                                {{ $isAr ? 'سعر الخدمة الخاص' : ($isRu ? 'Стоимость трансфера' : 'All-Inclusive Rate') }}
                            </span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-black text-gold">{{ number_format((float) $transport->price, 0) }}</span>
                                <span class="text-xl font-bold text-deepblack">AED</span>
                                <span class="text-xs text-gray-500 font-medium">/ {{ str_replace('_', ' ', $transport->price_unit) }}</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="inline-block bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold px-2.5 py-1 rounded-full">
                                {{ $isAr ? 'شامل الوقود وسالك' : ($isRu ? 'Топливо включено' : 'Fuel & Tolls Included') }}
                            </span>
                        </div>
                    </div>
                    <p class="text-[11px] text-gray-500 mt-2">
                        {{ $isAr ? 'شامل السائق الخاص، بوابات سالك، الوقود، والتوصيل من وإلى الفندق.' : ($isRu ? 'Включает персонального водителя, дорожные сборы Salik, топливо и трансфер.' : 'Includes licensed chauffeur, Salik road tolls, fuel, and door-to-door hotel transfers.') }}
                    </p>
                </div>

                <!-- Dual Action CTAs -->
                <div class="space-y-3 mb-6">
                    <a href="{{ route('bookings.create', ['type' => 'transport', 'id' => $transport->id]) }}" 
                       class="w-full bg-gold hover:bg-gold-light text-deepblack font-extrabold py-4 px-6 rounded-2xl transition-all duration-300 text-center text-base shadow-xl flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 text-deepblack" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ $isAr ? 'احجز وسيلة النقل الآن' : ($isRu ? 'Забронировать поездку' : 'Reserve Transport Now') }}</span>
                    </a>

                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMsg }}" 
                       target="_blank" rel="noopener noreferrer" 
                       class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-6 rounded-2xl transition-all duration-300 text-center text-sm shadow-md flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>{{ $isAr ? 'محادثة واتساب مباشرة' : ($isRu ? 'Быстрый заказ через WhatsApp' : 'Instant WhatsApp Concierge') }}</span>
                    </a>
                </div>

                <!-- Quick Highlights Row -->
                <div class="border-t border-gray-100 pt-4 grid grid-cols-2 gap-3 text-xs text-gray-600">
                    <div class="flex items-center gap-2">
                        <span class="text-gold font-bold">✓</span>
                        <span>{{ $isAr ? 'إلغاء مجاني حتى 24 ساعة' : ($isRu ? 'Бесплатная отмена за 24ч' : 'Free Cancellation (24h)') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gold font-bold">✓</span>
                        <span>{{ $isAr ? 'تأمين شامل للركاب' : ($isRu ? 'Полная страховка пассажиров' : 'Passenger Insurance Included') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gold font-bold">✓</span>
                        <span>{{ $isAr ? 'سائق محترف ومرخص' : ($isRu ? 'Лицензированный гид-водитель' : 'Licensed Chauffeur') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gold font-bold">✓</span>
                        <span>{{ $isAr ? 'توصيل مباشر من الفندق' : ($isRu ? 'Подача прямо к отелю' : 'Door-to-door Pickup') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Specifications & Capabilities Grid -->
<section class="py-16 bg-white border-t border-gray-100">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">
                {{ $isAr ? 'المواصفات والتجهيزات' : ($isRu ? 'Характеристики Авто' : 'Technical Specifications') }}
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-deepblack">
                {{ $isAr ? 'أعلى معايير الراحة والأمان' : ($isRu ? 'Комфорт и безопасность высшего класса' : 'Engineered for Comfort, Safety & Performance') }}
            </h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <!-- Capacity -->
            <div class="bg-offwhite rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                <div class="w-10 h-10 mx-auto mb-3 rounded-full bg-gold/20 flex items-center justify-center text-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-xs text-gray-500 uppercase font-bold block mb-1">{{ $isAr ? 'السعة' : ($isRu ? 'Вместимость' : 'Capacity') }}</span>
                <span class="text-lg font-black text-deepblack">{{ $transport->capacity }} {{ $isAr ? 'ركاب' : ($isRu ? 'мест' : 'Guests') }}</span>
            </div>

            <!-- Climate -->
            <div class="bg-offwhite rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                <div class="w-10 h-10 mx-auto mb-3 rounded-full bg-gold/20 flex items-center justify-center text-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <span class="text-xs text-gray-500 uppercase font-bold block mb-1">{{ $isAr ? 'التكييف' : ($isRu ? 'Кондиционер' : 'Climate Control') }}</span>
                <span class="text-lg font-black text-deepblack">{{ $isAr ? 'مزدوج فائق' : ($isRu ? 'Dual Multi-Zone' : 'Dual-Zone AC') }}</span>
            </div>

            <!-- Drive -->
            <div class="bg-offwhite rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                <div class="w-10 h-10 mx-auto mb-3 rounded-full bg-gold/20 flex items-center justify-center text-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-xs text-gray-500 uppercase font-bold block mb-1">{{ $isAr ? 'الدفع' : ($isRu ? 'Привод' : 'Drivetrain') }}</span>
                <span class="text-lg font-black text-deepblack">{{ $transport->slug === 'desert-safari-4x4-land-cruiser' ? 'Full 4x4' : 'Automatic' }}</span>
            </div>

            <!-- Safety / Roll Cage -->
            <div class="bg-offwhite rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                <div class="w-10 h-10 mx-auto mb-3 rounded-full bg-gold/20 flex items-center justify-center text-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <span class="text-xs text-gray-500 uppercase font-bold block mb-1">{{ $isAr ? 'الأمان' : ($isRu ? 'Безопасность' : 'Safety') }}</span>
                <span class="text-lg font-black text-deepblack">{{ $transport->slug === 'desert-safari-4x4-land-cruiser' ? ($isAr ? 'قفص حماية' : 'Roll Cage') : ($isAr ? 'تأمين شامل' : 'Insured') }}</span>
            </div>

            <!-- Driver -->
            <div class="bg-offwhite rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                <div class="w-10 h-10 mx-auto mb-3 rounded-full bg-gold/20 flex items-center justify-center text-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <span class="text-xs text-gray-500 uppercase font-bold block mb-1">{{ $isAr ? 'السائق' : ($isRu ? 'Водитель' : 'Chauffeur') }}</span>
                <span class="text-lg font-black text-deepblack">{{ $isAr ? 'سائق مرخص' : ($isRu ? 'Лицензирован' : 'Licensed') }}</span>
            </div>

            <!-- Refreshments -->
            <div class="bg-offwhite rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                <div class="w-10 h-10 mx-auto mb-3 rounded-full bg-gold/20 flex items-center justify-center text-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                </div>
                <span class="text-xs text-gray-500 uppercase font-bold block mb-1">{{ $isAr ? 'الضيافة' : ($isRu ? 'Напитки' : 'Refreshments') }}</span>
                <span class="text-lg font-black text-deepblack">{{ $isAr ? 'مياه مجانية' : ($isRu ? 'Вода и салфетки' : 'Chilled Water') }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Detailed Inclusions & Why Choose Section -->
<section class="py-16 bg-offwhite">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="grid gap-10 md:grid-cols-2 items-start">
            
            <!-- What's Included -->
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <h3 class="text-2xl font-bold text-deepblack mb-6 flex items-center gap-2">
                    <span class="text-gold">✓</span>
                    <span>{{ $isAr ? 'ما الذي تشمله هذه الخدمة؟' : ($isRu ? 'Что включено в бронирование' : 'What is Included in This Ride') }}</span>
                </h3>

                <ul class="space-y-4 text-sm text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">✓</span>
                        <span><strong>{{ $isAr ? 'مركبة خاصة بالكامل:' : ($isRu ? 'Индивидуальный автомобиль:' : '100% Private Vehicle:') }}</strong> {{ $isAr ? 'المركبة مخصصة لمجموعتك حصراً دون مشاركة مع مسافرين آخرين.' : ($isRu ? 'Транспорт предоставляется исключительно вашей семье или компании.' : 'Exclusive for your family or party only; no sharing with strangers.') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">✓</span>
                        <span><strong>{{ $isAr ? 'سائق محترف معتمد:' : ($isRu ? 'Опытный водитель:' : 'Expert Licensed Chauffeur:') }}</strong> {{ $isAr ? 'سائق مرخص من هيئة الطرق والمواصلات بدبي مع تدريب متقدم لسفاري الصحراء.' : ($isRu ? 'Сертифицированный специалист с отличным знанием Дубая и пустынных барханов.' : 'RTA-licensed professional driver certified for desert terrain and luxury transfers.') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">✓</span>
                        <span><strong>{{ $isAr ? 'الوقود وبوابات سالك مجاناً:' : ($isRu ? 'Топливо и Salik без доплат:' : 'All Fuel & Salik Tolls Included:') }}</strong> {{ $isAr ? 'لا توجد أي رسوم خفية أو تكاليف إضافية على المسارات أو الوقود.' : ($isRu ? 'Никаких скрытых платежей, все дорожные сборы и бензин полностью оплачены.' : 'Zero hidden charges. All highway tolls, fuel, and municipal permits are covered.') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">✓</span>
                        <span><strong>{{ $isAr ? 'توصيل مريح من الباب للباب:' : ($isRu ? 'Трансфер от двери до двери:' : 'Door-to-Door Hotel Pickup:') }}</strong> {{ $isAr ? 'استقبال وتوديع من فندقك، إقامتك، أو صالة الوصول بالمطار في دبي.' : ($isRu ? 'Подача авто прямо к вашему отелю, резиденции или терминалу аэропорта.' : 'Direct pickup from your hotel lobby, private residence, or airport terminal.') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">✓</span>
                        <span><strong>{{ $isAr ? 'ضيافة مياه باردة ومناديل مبللة:' : ($isRu ? 'Бутилированная вода:' : 'Chilled Mineral Water:') }}</strong> {{ $isAr ? 'مياه معدنية مثلجة مجاناً وشواحن هواتف داخل المقصورة.' : ($isRu ? 'Холодная вода и порты для зарядки мобильных устройств на борту.' : 'Complimentary cold bottled water, refreshing wipes, and in-cabin phone chargers.') }}</span>
                    </li>
                </ul>
            </div>

            <!-- Why Choose Our Luxury Fleet -->
            <div class="bg-gradient-to-br from-gray-900 to-deepblack text-white p-8 rounded-3xl border border-gold/30 shadow-xl">
                <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">
                    {{ $isAr ? 'لماذا تختار دبي تور بوك؟' : ($isRu ? 'Преимущества сервиса' : 'Why Travel With Us') }}
                </span>
                <h3 class="text-2xl font-bold mb-6 text-white">
                    {{ $isAr ? 'خدمة VIP وضيافة إماراتية أصيلة' : ($isRu ? 'Безупречный сервис 24/7' : 'The Dubai Tour Book VIP Standard') }}
                </h3>

                <div class="space-y-5 text-sm text-gray-300">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gold/20 text-gold flex items-center justify-center shrink-0 font-bold">1</div>
                        <div>
                            <strong class="text-white block">{{ $isAr ? 'دقة المواعيد بنسبة 100%' : ($isRu ? 'Пунктуальность 100%' : 'Guaranteed Punctuality') }}</strong>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $isAr ? 'سائقك يصل قبل موعدك بـ 15 دقيقة مع تواصل مسبق عبر واتساب.' : ($isRu ? 'Водитель приезжает за 15 минут до назначенного времени.' : 'Your chauffeur arrives 15 minutes before scheduled departure with WhatsApp coordination.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gold/20 text-gold flex items-center justify-center shrink-0 font-bold">2</div>
                        <div>
                            <strong class="text-white block">{{ $isAr ? 'نظافة وتعقيم مستمر' : ($isRu ? 'Идеальная чистота салона' : 'Pristine & Smoke-Free Cabins') }}</strong>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $isAr ? 'تنظيف وتعقيم دوري للمركبة قبل كل رحلة لضمان تجربة فندقية راقية.' : ($isRu ? 'Автомобили проходят регулярную дезинфекцию и мойку перед каждой поездкой.' : 'Every vehicle undergoes thorough detailing and inspection before greeting guests.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gold/20 text-gold flex items-center justify-center shrink-0 font-bold">3</div>
                        <div>
                            <strong class="text-white block">{{ $isAr ? 'دعم فوري على مدار 24 ساعة' : ($isRu ? 'Консьерж-сервис 24/7' : '24/7 Dedicated Concierge') }}</strong>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $isAr ? 'فريق خدمة العملاء جاهز لمساعدتك وتعديل حجوزاتك في أي وقت.' : ($isRu ? 'Русскоязычная и арабская поддержка в любое время суток.' : 'Our bilingual dispatch team is always available to handle route updates or flight delays.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-between">
                    <span class="text-xs text-gray-400">{{ $isAr ? 'هل تحتاج مساعدة في الحجز؟' : ($isRu ? 'Нужна консультация?' : 'Need personalized routing?') }}</span>
                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMsg }}" target="_blank" class="text-gold hover:text-white font-bold text-xs flex items-center gap-1 transition-colors">
                        <span>{{ $isAr ? 'تواصل مع الكونسييرج' : ($isRu ? 'Написать консьержу' : 'Chat with Concierge') }}</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Related Fleet / Other Vehicles Section -->
@if(isset($relatedTransports) && $relatedTransports->isNotEmpty())
<section class="py-16 bg-white border-t border-gray-100">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">
                    {{ $isAr ? 'أسطولنا الفاخر' : ($isRu ? 'Другие Автомобили' : 'Luxury Fleet Options') }}
                </span>
                <h2 class="text-3xl font-extrabold text-deepblack">
                    {{ $isAr ? 'مركبات وخيارات نقل أخرى' : ($isRu ? 'Похожие автомобили и трансферы' : 'Explore More From Our Fleet') }}
                </h2>
            </div>
            <a href="{{ route('transports.index') }}" class="mt-4 md:mt-0 text-sm font-bold text-gold hover:text-deepblack transition-colors flex items-center gap-1">
                <span>{{ $isAr ? 'عرض كامل الأسطول' : ($isRu ? 'Весь автопарк' : 'View Full Fleet') }}</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedTransports as $other)
                @php
                    $otherImg = $other->getFirstMediaUrl('featured');
                    if (empty($otherImg) || (str_contains($otherImg, '127.0.0.1:8003') && !str_contains(request()->getHost(), '8003'))) {
                        $otherImg = $defaultImageMap[$other->slug] ?? asset('assets/images/transport_cruiser.jpg');
                    }
                @endphp
                <div class="bg-offwhite rounded-3xl overflow-hidden border border-gray-100 shadow-lg hover:shadow-2xl hover:border-gold/40 transition-all duration-300 flex flex-col h-full justify-between group">
                    <div>
                        <div class="relative overflow-hidden h-52 w-full bg-gray-900/10">
                            <img src="{{ $otherImg }}" alt="{{ $other->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                            <span class="absolute top-4 left-4 bg-deepblack/80 backdrop-blur-md text-gold text-[11px] font-bold px-3 py-1 rounded-full border border-gold/30">
                                {{ $other->capacity }} {{ $isAr ? 'ركاب' : 'Seats' }}
                            </span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-deepblack group-hover:text-amber-700 transition-colors line-clamp-1 mb-2">
                                <a href="{{ route('transports.show', $other) }}">{{ $other->name }}</a>
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                                {{ $other->description }}
                            </p>
                        </div>
                    </div>
                    <div class="px-6 pb-6 pt-2 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="text-lg font-extrabold text-gold">{{ number_format((float) $other->price, 0) }} AED</span>
                            <span class="text-[11px] text-gray-400 block">/ {{ str_replace('_', ' ', $other->price_unit) }}</span>
                        </div>
                        <a href="{{ route('transports.show', $other) }}" class="rounded-full bg-deepblack text-white hover:bg-gold hover:text-deepblack px-4 py-2 text-xs font-bold transition-colors">
                            {{ $isAr ? 'تفاصيل المركبة' : ($isRu ? 'Подробнее' : 'View Vehicle') }} &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof window.trackEvent === 'function') {
            window.trackEvent('view_item', {
                content_type: 'transport',
                content_name: '{{ addslashes($transport->name) }}',
                content_category: 'Luxury Transport',
                content_ids: ['{{ $transport->id }}'],
                currency: 'AED',
                value: {{ (float) ($transport->price ?? 0) }}
            });
        }
    });
</script>
@endpush
