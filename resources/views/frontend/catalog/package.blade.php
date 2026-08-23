@extends('layouts.app')

@section('title', e($tourPackage->name) . ' | ' . ($tourPackage->destination?->name ?? 'Dubai') . ' Luxury Tours & Safaris')
@section('meta_description', 'Book ' . e($tourPackage->name) . ' in ' . ($tourPackage->destination?->name ?? 'Dubai') . ' - Enjoy VIP hotel pickup, certified guide, entry passes, and Arabian hospitality.')
@section('meta_keywords', e($tourPackage->name) . ', ' . ($tourPackage->destination?->name ?? 'Dubai') . ' tours, Dubai desert safari, Dubai luxury travel, UAE tour packages')
@section('og_image', $tourPackage->getFirstMediaUrl('featured') ?: asset('assets/images/tour_burj.jpg'))

@section('content')
<section class="pt-28 bg-offwhite">
    <div class="container mx-auto grid gap-10 px-6 py-12 lg:grid-cols-2 items-center">
        <div class="overflow-hidden rounded-3xl shadow-2xl">
            <img class="h-[420px] w-full object-cover transform hover:scale-105 transition-transform duration-700" src="{{ $tourPackage->getFirstMediaUrl('featured') ?: asset('assets/images/hero.jpg') }}" alt="{{ $tourPackage->name }}" loading="eager">
        </div>
        <div>
            <p class="font-bold text-gold uppercase tracking-widest text-sm">{{ $tourPackage->destination?->name ?? 'UAE' }} · {{ $tourPackage->duration_days }} days / {{ $tourPackage->duration_nights }} nights</p>
            <h1 class="mt-3 text-4xl font-bold text-deepblack md:text-5xl leading-tight">{{ $tourPackage->name }}</h1>
            <p class="mt-5 text-gray-600 text-lg leading-relaxed">{{ $tourPackage->summary }}</p>
            <div class="mt-6 flex items-baseline gap-3">
                <p class="text-4xl font-bold text-gold">${{ number_format($tourPackage->effectivePrice(), 2) }}</p>
                <span class="text-sm text-gray-500 font-medium">per person</span>
            </div>
            <a href="{{ route('bookings.create', ['type' => 'package', 'id' => $tourPackage->id]) }}" class="mt-8 inline-block rounded-full bg-gold px-8 py-4 font-bold text-deepblack shadow-lg hover:bg-deepblack hover:text-white transition-all duration-300 transform hover:-translate-y-1">Book this package</a>
        </div>
    </div>
</section>

<section class="bg-white py-16">
    <div class="container mx-auto grid gap-12 px-6 lg:grid-cols-3">
        <article class="lg:col-span-2">
            <h2 class="text-3xl font-bold text-deepblack">Experience details</h2>
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
        </article>

        <aside class="rounded-2xl bg-deepblack p-8 text-white h-fit shadow-xl">
            <h3 class="text-xl font-bold text-gold mb-4">What's Included</h3>
            <ul class="space-y-3 text-sm text-gray-300">
                @foreach((array) $tourPackage->getTranslation('included_services', app()->getLocale(), false) as $item)
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
        </aside>
    </div>
</section>

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org/",
  "@type": "Product",
  "name": "{{ e($tourPackage->name) }}",
  "image": "{{ $tourPackage->getFirstMediaUrl('featured') ?: asset('assets/images/hero.jpg') }}",
  "description": "{{ e(strip_tags((string)$tourPackage->summary)) }}",
  "brand": {
    "@type": "Brand",
    "name": "UAE Tourism"
  },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "USD",
    "price": "{{ $tourPackage->effectivePrice() }}",
    "availability": "https://schema.org/InStock",
    "url": "{{ url()->current() }}"
  }
}
</script>
@endsection
