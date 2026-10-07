@extends('layouts.app')

@php
    $isArabic = app()->getLocale() === 'ar';
    $isRussian = app()->getLocale() === 'ru';

    $destTitle = $isArabic
        ? 'أشهر الوجهات السياحية في دبي والإمارات 2026 | دليل المسافر الخليجي'
        : ($isRussian
            ? 'Популярные Туристические Направления Дубая и ОАЭ 2026'
            : 'Top Destinations in Dubai & UAE 2026 | Emirates Travel Guide');

    $destDesc = $isArabic
        ? 'دليلك لأهم وجهات السياحة في دبي وأبوظبي والشارقة ورأس الخيمة. معالم أيقونية، شواطئ فاخرة، وتجارب استثنائية تناسب العائلات والمسافرين من السعودية ودول الخليج.'
        : ($isRussian
            ? 'Путеводитель по главным направлениям Дубая и ОАЭ: Абу-Даби, Дубай Марина, Пальма Джумейра, культурные и природные достопримечательности.'
            : 'Discover iconic cities, coastlines, luxury islands, and desert heritage across Dubai and the United Arab Emirates. Curated guides & experiences.');

    $destKeywords = $isArabic
        ? 'وجهات دبي, سياحة الامارات, اماكن سياحية في دبي للعوائل, برج خليفة, نخلة جميرا, دبي مارينا, ابوظبي, سياحة دبي 2026'
        : ($isRussian
            ? 'достопримечательности дубая, куда сходить в дубае, дубай марина, пальма джумейра, абу даби экскурсии'
            : 'Dubai destinations, UAE tourist attractions, Burj Khalifa, Palm Jumeirah, Dubai Marina, Abu Dhabi tours, GCC luxury travel');
@endphp

@section('title', $destTitle . ' | ' . \App\Models\Setting::get('general.site_name', 'Dubai Tour Book'))
@section('meta_description', $destDesc)
@section('meta_keywords', $destKeywords)

@section('content')
<section class="bg-deepblack pb-16 pt-36 text-white">
    <div class="container mx-auto px-6">
        <p class="text-sm font-semibold uppercase tracking-[.2em] text-gold">
            {{ $isArabic ? 'استكشف إمارات الدولة ومعالمها الخالدة' : 'Explore the Emirates' }}
        </p>
        <h1 class="mt-3 text-4xl font-bold md:text-5xl">
            {{ $isArabic ? 'الوجهات والمعالم السياحية' : 'Destinations' }}
        </h1>
        <p class="mt-4 max-w-2xl text-gray-300 leading-relaxed text-sm md:text-base">
            {{ $destDesc }}
        </p>
    </div>
</section>

<section class="py-16 bg-offwhite">
    <div class="container mx-auto px-6">
        <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($destinations as $destination)
                <a href="{{ route('destinations.show', $destination) }}" class="group overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col">
                    <picture class="relative block overflow-hidden">
                        @if($destination->hasMedia('featured'))
                            <source srcset="{{ $destination->getFirstMediaUrl('featured', 'card') }}" type="image/webp">
                        @endif
                        <img class="h-64 w-full object-cover transition duration-700 group-hover:scale-105" src="{{ $destination->getFirstMediaUrl('featured') ?: asset('assets/images/hero.jpg') }}" alt="{{ $destination->name }}" loading="lazy" decoding="async" width="800" height="520">
                    </picture>
                    <div class="p-6 flex flex-col flex-1">
                        <h2 class="text-2xl font-bold text-deepblack group-hover:text-gold transition-colors">{{ $destination->name }}</h2>
                        <p class="mt-1 text-xs font-bold uppercase tracking-wider text-gold">{{ $destination->city }}, {{ $destination->country }}</p>
                        <p class="mt-3 line-clamp-2 text-gray-600 text-sm flex-1 leading-relaxed">{{ $destination->description }}</p>
                        <div class="mt-5 pt-3 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-deepblack">
                            <span>{{ $isArabic ? 'استكشف المعالم والرحلات' : 'Explore Experiences' }}</span>
                            <span class="text-gold font-bold">→</span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="col-span-full py-16 text-center text-gray-500">
                    {{ $isArabic ? 'لا توجد وجهات متاحة حالياً.' : 'No destinations are available yet.' }}
                </p>
            @endforelse
        </div>
        <div class="mt-10">
            {{ $destinations->links() }}
        </div>
    </div>
</section>

<!-- ItemList Schema for Destinations -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "ItemList",
  "name": "{{ $destTitle }}",
  "description": "{{ $destDesc }}",
  "itemListElement": [
    @foreach($destinations as $index => $dest)
    {
      "@type": "ListItem",
      "position": {{ $index + 1 }},
      "url": "{{ route('destinations.show', $dest) }}",
      "name": "{{ e($dest->name) }}"
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endsection
