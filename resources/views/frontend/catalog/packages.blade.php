@extends('layouts.app')

@php
    $isArabic = app()->getLocale() === 'ar';
    $isRussian = app()->getLocale() === 'ru';

    $packagesTitle = $isArabic
        ? 'بكجات دبي السياحية الفاخرة 2026 | عروض رحلات وسفاري العوائل الخليجية'
        : ($isRussian
            ? 'Туры и Экскурсионные Пакеты в Дубае 2026: Цены и Бронирование'
            : 'Dubai Luxury Tour Packages 2026 | Desert Safaris, Yachts & VIP Passes');

    $packagesDesc = $isArabic
        ? 'استكشف أفضل بكجات دبي السياحية المصممة للعوائل من السعودية والكويت وقطر والخليج. عروض سفاري صحراوي VIP، يخوت مارينا، وبرج خليفة بأسعار حصرية وحجز فوري.'
        : ($isRussian
            ? 'Лучшие экскурсионные пакеты и туры в Дубае 2026: сафари в пустыне, аренда яхт, билеты на Бурдж Халифа, индивидуальные русскоязычные гиды.'
            : 'Explore curated Dubai tour packages, VIP desert safaris, private yacht charters, and luxury UAE holiday experiences. Instant confirmation & 24/7 concierge.');

    $packagesKeywords = $isArabic
        ? 'بكجات دبي, عروض رحلات دبي للعوائل, بكجات دبي من الرياض, رحلات سفاري دبي VIP, اسعار جولات دبي 2026, حجز بكجات الامارات, رحلات دبي من الكويت'
        : ($isRussian
            ? 'туры в дубай 2026, экскурсии дубай цены, сафари в дубае, пакетные туры оаэ, русский гид'
            : 'Dubai tour packages, luxury Dubai tours, desert safari Dubai, Burj Khalifa VIP, Dubai yacht charter, GCC family holiday deals');
@endphp

@section('title', $packagesTitle . ' | ' . \App\Models\Setting::get('general.site_name', 'Dubai Tour Book'))
@section('meta_description', $packagesDesc)
@section('meta_keywords', $packagesKeywords)

@section('content')
<section class="bg-deepblack pb-14 pt-36 text-white">
    <div class="container mx-auto px-6">
        <p class="text-sm font-semibold uppercase tracking-[.2em] text-gold">
            {{ $isArabic ? 'تجارب سياحية مختارة بعناية' : 'Curated Luxury Experiences' }}
        </p>
        <h1 class="mt-3 text-4xl font-bold md:text-5xl">
            {{ $isArabic ? 'بكجات وجولات دبي الفاخرة' : 'Tour Packages & Experiences' }}
        </h1>
        <p class="mt-3 text-gray-300 max-w-2xl text-sm leading-relaxed">
            {{ $packagesDesc }}
        </p>
    </div>
</section>

<section class="py-12 bg-offwhite">
    <div class="container mx-auto px-6">
        <!-- Clean 4-Column Search & Filter Form -->
        <form method="GET" action="{{ route('packages.index') }}" class="mb-10 rounded-2xl bg-white p-5 shadow border border-gray-100">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 items-end">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        {{ $isArabic ? 'البحث عن جولة' : 'Search Tours' }}
                    </label>
                    <input name="q" type="text" value="{{ request('q', request('search')) }}" placeholder="{{ $isArabic ? 'مثال: جولة دبي، سفاري...' : 'e.g. Dubai Tour, Safari...' }}" class="w-full rounded-xl border border-gray-300 px-4 text-base focus:border-gold focus:outline-none transition-all shadow-sm" style="min-height: 60px; height: 60px;">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        {{ $isArabic ? 'الوجهة' : 'Destination' }}
                    </label>
                    <select name="destination" class="w-full rounded-xl border border-gray-300 px-4 text-base focus:border-gold focus:outline-none cursor-pointer transition-all shadow-sm bg-white" style="min-height: 60px; height: 60px;">
                        <option value="">{{ $isArabic ? 'جميع الوجهات' : 'All destinations' }}</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" @selected(request('destination') == $destination->id || request('destination') == $destination->slug || strtolower(request('destination') ?? '') === strtolower($destination->name))>{{ $destination->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        {{ $isArabic ? 'أقصى سعر ($)' : 'Max Price ($)' }}
                    </label>
                    <input name="max_price" type="number" min="0" value="{{ request('max_price') }}" placeholder="{{ $isArabic ? 'مثال: 200' : 'e.g. 200' }}" class="w-full rounded-xl border border-gray-300 px-4 text-base focus:border-gold focus:outline-none transition-all shadow-sm" style="min-height: 60px; height: 60px;">
                </div>

                <div>
                    <button type="submit" class="w-full rounded-xl bg-deepblack hover:bg-gold hover:text-deepblack font-bold text-white px-5 text-base transition-colors shadow flex items-center justify-center cursor-pointer" style="min-height: 60px; height: 60px;">
                        <span>{{ $isArabic ? 'بحث وتصفية' : 'Filter Packages' }}</span>
                    </button>
                </div>
            </div>

            <!-- Quick Search Tags & Clear Action -->
            <div class="mt-4 pt-3 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2 text-xs">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-gray-400 font-semibold">{{ $isArabic ? 'الأكثر بحثاً:' : 'Popular:' }}</span>
                    <a href="{{ route('packages.index', ['q' => 'Dubai Tour']) }}" class="px-3 py-1 rounded-full {{ request('q') === 'Dubai Tour' ? 'bg-gold text-deepblack font-bold' : 'bg-gray-100 text-gray-700 hover:bg-gold hover:text-deepblack' }} transition-colors">Dubai Tour</a>
                    <a href="{{ route('packages.index', ['q' => 'Desert Safari']) }}" class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 hover:bg-gold hover:text-deepblack transition-colors">Desert Safari</a>
                    <a href="{{ route('packages.index', ['q' => 'Burj Khalifa']) }}" class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 hover:bg-gold hover:text-deepblack transition-colors">Burj Khalifa</a>
                    <a href="{{ route('packages.index', ['destination' => 2]) }}" class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 hover:bg-gold hover:text-deepblack transition-colors">Dubai Only</a>
                    <a href="{{ route('packages.index', ['q' => 'Grand Mosque']) }}" class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 hover:bg-gold hover:text-deepblack transition-colors">Abu Dhabi Mosque</a>
                </div>

                @if(request()->hasAny(['q', 'search', 'keyword', 'destination', 'duration', 'min_price', 'max_price']))
                    <a href="{{ route('packages.index') }}" class="text-rose-500 font-bold hover:underline">
                        ✕ {{ $isArabic ? 'إعادة ضبط' : 'Clear Filters' }}
                    </a>
                @endif
            </div>
        </form>

        <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($packages as $tourPackage)
                <article class="overflow-hidden rounded-2xl bg-white shadow-lg group hover:shadow-2xl transition-all duration-300 flex flex-col">
                    <picture class="relative block overflow-hidden">
                        @if($tourPackage->hasMedia('featured'))
                            <source srcset="{{ $tourPackage->getFirstMediaUrl('featured', 'card') }}" type="image/webp">
                        @endif
                        <img class="h-56 w-full object-cover transition duration-700 group-hover:scale-105" src="{{ $tourPackage->getFirstMediaUrl('featured') ?: asset('assets/images/hero.jpg') }}" alt="{{ $tourPackage->name }}" loading="lazy" decoding="async" width="800" height="520">
                        <span class="absolute top-3 left-3 bg-deepblack/80 backdrop-blur-md text-gold px-2.5 py-1 rounded-full text-xs font-bold border border-gold/30">
                            ★ 4.9
                        </span>
                    </picture>
                    <div class="p-6 flex flex-col flex-1">
                        <p class="text-xs font-bold uppercase tracking-wider text-gold">{{ $tourPackage->destination?->name ?? 'UAE' }} · {{ $tourPackage->duration_days }} day(s)</p>
                        <h2 class="mt-2 text-xl font-bold text-deepblack group-hover:text-gold transition-colors">{{ $tourPackage->name }}</h2>
                        <p class="mt-2 line-clamp-2 text-sm text-gray-600 flex-1">{{ $tourPackage->summary }}</p>
                        <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="font-extrabold text-gold text-lg">{{ number_format($tourPackage->effectivePrice(), 0) }} AED</span>
                            <a href="{{ route('packages.show', $tourPackage) }}" class="font-bold text-xs uppercase tracking-wider text-deepblack hover:text-gold transition-colors flex items-center gap-1">
                                {{ $isArabic ? 'التفاصيل والحجز ←' : 'View Details →' }}
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <p class="col-span-full py-16 text-center text-gray-500">
                    {{ $isArabic ? 'لم يتم العثور على بكجات مطابقة للبحث.' : 'No packages match these filters.' }}
                </p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $packages->links() }}
        </div>
    </div>
</section>

<!-- ItemList Schema Markup for Tour Packages -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "ItemList",
  "name": "{{ $packagesTitle }}",
  "description": "{{ $packagesDesc }}",
  "numberOfItems": {{ $packages->total() }},
  "itemListElement": [
    @foreach($packages as $index => $pkg)
    {
      "@type": "ListItem",
      "position": {{ $index + 1 }},
      "item": {
        "@type": ["Product", "TouristTrip"],
        "name": "{{ e($pkg->name) }}",
        "url": "{{ route('packages.show', $pkg) }}",
        "image": "{{ $pkg->getFirstMediaUrl('featured') ?: asset('assets/images/hero.jpg') }}",
        "description": "{{ e(strip_tags((string)$pkg->summary)) }}",
        "offers": {
          "@type": "Offer",
          "priceCurrency": "AED",
          "price": "{{ $pkg->effectivePrice() }}",
          "availability": "https://schema.org/InStock",
          "url": "{{ route('packages.show', $pkg) }}"
        }
      }
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endsection
