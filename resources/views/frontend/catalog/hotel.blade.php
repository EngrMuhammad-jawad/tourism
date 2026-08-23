@extends('layouts.app')

@section('title', $hotel->name.' | UAE Tourism')
@section('meta_description', Str::limit(strip_tags((string)$hotel->description), 155))
@section('og_image', $hotel->getFirstMediaUrl('featured') ?: asset('assets/images/hero.jpg'))

@section('content')
<section class="pt-28 bg-offwhite">
    <div class="container mx-auto grid gap-10 px-6 py-12 lg:grid-cols-2 items-center">
        <div class="overflow-hidden rounded-3xl shadow-2xl">
            <img class="h-[420px] w-full object-cover transform hover:scale-105 transition-transform duration-700" src="{{ $hotel->getFirstMediaUrl('featured') ?: asset('assets/images/hero.jpg') }}" alt="{{ $hotel->name }}" loading="eager">
        </div>
        <div>
            <p class="font-bold text-gold text-lg mb-1">{{ str_repeat('★', $hotel->star_rating) }} · <span class="text-gray-600 font-medium">{{ $hotel->destination?->name ?? 'UAE' }}</span></p>
            <h1 class="text-4xl font-bold text-deepblack md:text-5xl leading-tight">{{ $hotel->name }}</h1>
            <p class="mt-4 text-gray-600 text-lg leading-relaxed">{{ $hotel->description }}</p>
            <p class="mt-3 text-sm text-gray-500 flex items-center gap-1">
                <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                <span>{{ $hotel->address }}</span>
            </p>

            @if($hotel->amenities->isNotEmpty())
                <h3 class="mt-6 font-bold text-deepblack uppercase text-xs tracking-wider">Property Amenities</h3>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach($hotel->amenities as $amenity)
                        <span class="rounded-full bg-amber-100/60 border border-amber-200/80 px-3.5 py-1 text-xs font-semibold text-amber-900">{{ $amenity->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

<section class="bg-white py-16">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-deepblack mb-8">Available Rooms & Suites</h2>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($hotel->rooms as $room)
                <article class="rounded-2xl border border-gray-100 bg-offwhite p-7 shadow-lg flex flex-col justify-between hover:shadow-xl transition-shadow">
                    <div>
                        <h3 class="text-2xl font-bold text-deepblack">{{ $room->name }}</h3>
                        <p class="mt-2 text-sm text-gray-500 font-medium">Capacity: Up to {{ $room->capacity }} guests</p>
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-200/60 flex items-center justify-between">
                        <div>
                            <p class="text-2xl font-bold text-gold">${{ number_format((float) $room->price_per_night, 2) }}</p>
                            <span class="text-xs text-gray-400">per night</span>
                        </div>
                        <a href="{{ route('bookings.create', ['type' => 'room', 'id' => $room->id]) }}" class="rounded-full bg-deepblack px-6 py-2.5 font-bold text-white text-sm hover:bg-gold hover:text-deepblack transition-colors">Book room</a>
                    </div>
                </article>
            @empty
                <p class="text-gray-500 col-span-full py-8 text-center">No rooms are currently available for this hotel.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "Hotel",
  "name": "{{ e($hotel->name) }}",
  "description": "{{ e(strip_tags((string)$hotel->description)) }}",
  "image": "{{ $hotel->getFirstMediaUrl('featured') ?: asset('assets/images/hero.jpg') }}",
  "starRating": {
    "@type": "Rating",
    "ratingValue": "{{ $hotel->star_rating }}"
  },
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "{{ e($hotel->address) }}",
    "addressCountry": "AE"
  }
}
</script>
@endsection
