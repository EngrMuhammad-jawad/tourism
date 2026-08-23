@extends('layouts.app')

@section('title', e($destination->name) . ' Luxury Tours, Desert Safaris & VIP Experiences | UAE Tourism')
@section('meta_description', 'Discover ' . e($destination->name) . ' - Experience iconic landmarks, Burj Khalifa, Museum of the Future, 5-star luxury stays, private desert safaris, and VIP yacht cruises.')
@section('meta_keywords', 'Dubai luxury tours, Dubai desert safari, Burj Khalifa tickets, Museum of the Future Dubai, Palm Jumeirah hotels, Dubai Marina yacht rental, UAE luxury travel')
@section('og_image', $destination->getFirstMediaUrl('featured') ?: asset('assets/images/dubai.jpg'))

@push('styles')
<!-- Schema.org JSON-LD TouristDestination Markup -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "TouristDestination",
  "name": "{{ e($destination->name) }}",
  "description": "{{ e(strip_tags((string)$destination->description)) }}",
  "image": "{{ $destination->getFirstMediaUrl('featured') ?: asset('assets/images/dubai.jpg') }}",
  "url": "{{ url()->current() }}",
  "touristType": [
    "Luxury Travel",
    "Desert Safari",
    "Cultural Tourism",
    "VIP Yacht Experiences",
    "Family Vacations"
  ],
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 25.2048,
    "longitude": 55.2708
  },
  "containedInPlace": {
    "@type": "Country",
    "name": "United Arab Emirates",
    "identifier": "AE"
  },
  "includesAttraction": [
    {
      "@type": "TouristAttraction",
      "name": "Burj Khalifa",
      "description": "World's tallest skyscraper featuring 360-degree observation decks in Downtown Dubai."
    },
    {
      "@type": "TouristAttraction",
      "name": "Museum of the Future",
      "description": "Architectural marvel showcasing futuristic technology and immersive exhibits."
    },
    {
      "@type": "TouristAttraction",
      "name": "Palm Jumeirah",
      "description": "World-famous artificial island adorned with 5-star luxury resorts and beach clubs."
    },
    {
      "@type": "TouristAttraction",
      "name": "Arabian Desert Dunes",
      "description": "Pristine desert dunes offering VIP dune bashing, camel trekking, and starlit BBQ dinners."
    }
  ]
}
</script>
@endpush

@section('content')

    <!-- Hero Header -->
    <section class="relative min-h-[65vh] flex items-end pt-32 pb-16 text-white overflow-hidden">
        <div class="absolute inset-0 w-full h-full">
            <img class="h-full w-full object-cover object-center transform scale-105 transition-transform duration-10000" src="{{ $destination->getFirstMediaUrl('featured') ?: asset('assets/images/dubai.jpg') }}" alt="{{ $destination->name }} Luxury Travel & Experiences">
            <div class="absolute inset-0 bg-gradient-to-t from-deepblack via-black/60 to-black/30"></div>
        </div>

        <div class="container relative z-10 mx-auto px-6 max-w-7xl">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-4 shadow-xl">
                <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                <span>{{ $destination->city ?? 'Dubai' }}, {{ $destination->country ?? 'United Arab Emirates' }}</span>
            </div>

            <h1 class="text-4xl sm:text-6xl md:text-7xl font-black text-white tracking-tight leading-tight mb-4 text-shadow-lg">
                {{ $destination->name }} <span class="text-gradient-gold">Luxury Travel & Safaris</span>
            </h1>

            <p class="text-gray-200 text-lg md:text-xl max-w-3xl font-light leading-relaxed text-shadow">
                {{ $destination->tagline ?? 'Experience iconic skyscrapers, world-class shopping, private desert safaris, and Arabian hospitality.' }}
            </p>
        </div>
    </section>

    <!-- Main Content Grid -->
    <section class="py-20 bg-offwhite">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Left Column: Primary SEO Content & Packages (8 cols) -->
                <article class="lg:col-span-8 space-y-12">
                    
                    <!-- Overview Section -->
                    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100/80">
                        <h2 class="text-3xl font-extrabold text-deepblack mb-6 flex items-center gap-3">
                            <span class="w-2 h-8 bg-gold rounded-full"></span>
                            Discover {{ $destination->name }} — Luxury & Modern Wonders
                        </h2>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-4">
                            {!! nl2br(e($destination->description)) !!}
                        </div>
                    </div>

                    <!-- Top Attractions Highlights Grid -->
                    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100/80">
                        <h2 class="text-2xl font-extrabold text-deepblack mb-6">Iconic {{ $destination->name }} Landmarks & Experiences</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gold/20 text-gold font-bold flex items-center justify-center flex-shrink-0">
                                    🏰
                                </div>
                                <div>
                                    <h3 class="font-bold text-deepblack text-base">Burj Khalifa & Downtown</h3>
                                    <p class="text-xs text-gray-500 mt-1">Ascend to the 148th floor VIP observation lounge and witness the Dubai Fountain spectacle.</p>
                                </div>
                            </div>

                            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gold/20 text-gold font-bold flex items-center justify-center flex-shrink-0">
                                    🐪
                                </div>
                                <div>
                                    <h3 class="font-bold text-deepblack text-base">VIP Desert Safari</h3>
                                    <p class="text-xs text-gray-500 mt-1">Private 4x4 dune bashing, falconry demonstrations, and gourmet starlit desert dining.</p>
                                </div>
                            </div>

                            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gold/20 text-gold font-bold flex items-center justify-center flex-shrink-0">
                                    🏝️
                                </div>
                                <div>
                                    <h3 class="font-bold text-deepblack text-base">Palm Jumeirah & Marina</h3>
                                    <p class="text-xs text-gray-500 mt-1">Charter private luxury yachts, visit Atlantis The Royal, and enjoy beachside dining.</p>
                                </div>
                            </div>

                            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gold/20 text-gold font-bold flex items-center justify-center flex-shrink-0">
                                    🏛️
                                </div>
                                <div>
                                    <h3 class="font-bold text-deepblack text-base">Museum of the Future</h3>
                                    <p class="text-xs text-gray-500 mt-1">Explore groundbreaking futuristic exhibits and revolutionary architecture.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Tour Packages for Dubai -->
                    @if($destination->packages->isNotEmpty())
                        <div>
                            <div class="flex items-center justify-between mb-8">
                                <h2 class="text-3xl font-extrabold text-deepblack">Top {{ $destination->name }} Tour Packages</h2>
                                <a href="{{ route('packages.index', ['destination' => $destination->name]) }}" class="text-sm font-bold text-gold hover:underline">View All Packages →</a>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                @foreach($destination->packages as $tourPackage)
                                    <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 flex flex-col justify-between group hover:shadow-2xl transition-all">
                                        <div class="relative aspect-[4/3] overflow-hidden">
                                            <img src="{{ $tourPackage->getFirstMediaUrl('featured') ?: asset('assets/images/tour_burj.jpg') }}" alt="{{ $tourPackage->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                            <div class="absolute top-4 right-4 bg-deepblack/80 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-gold/40">
                                                <span class="text-xs font-bold text-gold">${{ number_format($tourPackage->effectivePrice(), 0) }}</span>
                                            </div>
                                        </div>
                                        <div class="p-6">
                                            <h3 class="text-xl font-bold text-deepblack mb-2 group-hover:text-amber-700 transition-colors">{{ $tourPackage->name }}</h3>
                                            <p class="text-xs text-gray-500 mb-5 line-clamp-2">{{ strip_tags((string)$tourPackage->description) }}</p>
                                            <a href="{{ route('packages.show', $tourPackage) }}" class="block text-center w-full py-3 bg-deepblack text-white font-bold text-sm rounded-xl hover:bg-gold hover:text-deepblack transition-all">
                                                View Package Details
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Travel Tips SEO FAQ Section -->
                    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100/80">
                        <h2 class="text-2xl font-extrabold text-deepblack mb-6">Frequently Asked Questions About Visiting {{ $destination->name }}</h2>
                        <div class="space-y-4">
                            <details class="group rounded-2xl bg-gray-50 p-5 border border-gray-100">
                                <summary class="font-bold text-base text-deepblack cursor-pointer flex justify-between items-center group-open:text-gold">
                                    <span>What is the best time of year to visit {{ $destination->name }}?</span>
                                    <span class="text-gold font-bold">+</span>
                                </summary>
                                <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                                    The best time to visit {{ $destination->name }} is from October to April when temperatures are pleasant (20°C to 30°C), making it ideal for sightseeing, outdoor desert safaris, and beach activities.
                                </p>
                            </details>

                            <details class="group rounded-2xl bg-gray-50 p-5 border border-gray-100">
                                <summary class="font-bold text-base text-deepblack cursor-pointer flex justify-between items-center group-open:text-gold">
                                    <span>What is included in a VIP {{ $destination->name }} Desert Safari?</span>
                                    <span class="text-gold font-bold">+</span>
                                </summary>
                                <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                                    Our VIP Desert Safaris include private 4x4 Land Cruiser hotel pickup, thrilling red dune bashing, quad biking, falconry photos, luxury desert camp seating, unlimited beverages, live cultural shows, and a gourmet barbecue dinner.
                                </p>
                            </details>

                            <details class="group rounded-2xl bg-gray-50 p-5 border border-gray-100">
                                <summary class="font-bold text-base text-deepblack cursor-pointer flex justify-between items-center group-open:text-gold">
                                    <span>Do you offer private luxury airport transfers in {{ $destination->name }}?</span>
                                    <span class="text-gold font-bold">+</span>
                                </summary>
                                <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                                    Yes, we provide 24/7 private VIP chauffeur transfers from Dubai International Airport (DXB) and Al Maktoum Airport (DWC) in Mercedes-Maybach, Rolls-Royce, and Cadillac Escalade vehicles directly to your resort.
                                </p>
                            </details>
                        </div>
                    </div>

                </article>

                <!-- Right Column: Sidebar Booking & Quick Information (4 cols) -->
                <aside class="lg:col-span-4 space-y-8">
                    <!-- Quick Booking Card -->
                    <div class="bg-deepblack text-white rounded-3xl p-8 shadow-2xl border border-amber-500/20 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>
                        <span class="text-xs font-bold text-gold uppercase tracking-widest mb-1 block">VIP Travel Desk</span>
                        <h3 class="text-2xl font-extrabold text-white mb-4">Book Your {{ $destination->name }} Experience</h3>
                        <p class="text-gray-300 text-sm mb-6 leading-relaxed">Browse curated luxury tour itineraries, 5-star resort packages, and private chauffeur options.</p>
                        
                        <a href="{{ route('packages.index', ['destination' => $destination->name]) }}" class="w-full block text-center bg-gold text-deepblack font-extrabold py-4 px-6 rounded-xl hover:bg-white transition-all text-base shadow-lg mb-4">
                            Explore {{ $destination->name }} Packages
                        </a>

                        <a href="{{ route('contact.create') }}" class="w-full block text-center bg-white/10 text-white font-bold py-3.5 px-6 rounded-xl border border-white/20 hover:bg-white hover:text-deepblack transition-all text-sm">
                            Contact Concierge Desk
                        </a>
                    </div>

                    <!-- Quick Facts Card -->
                    <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                        <h3 class="text-lg font-extrabold text-deepblack mb-4">Fast Travel Facts</h3>
                        <ul class="space-y-3.5 text-sm">
                            <li class="flex justify-between border-b border-gray-100 pb-2.5">
                                <span class="text-gray-500 font-medium">Best Season:</span>
                                <span class="font-bold text-deepblack">Oct – April</span>
                            </li>
                            <li class="flex justify-between border-b border-gray-100 pb-2.5">
                                <span class="text-gray-500 font-medium">Language:</span>
                                <span class="font-bold text-deepblack">Arabic & English</span>
                            </li>
                            <li class="flex justify-between border-b border-gray-100 pb-2.5">
                                <span class="text-gray-500 font-medium">Currency:</span>
                                <span class="font-bold text-deepblack">UAE Dirham (AED)</span>
                            </li>
                            <li class="flex justify-between pb-1">
                                <span class="text-gray-500 font-medium">Time Zone:</span>
                                <span class="font-bold text-deepblack">GST (UTC+4)</span>
                            </li>
                        </ul>
                    </div>

                    <!-- 24/7 VIP Concierge Card -->
                    <div class="bg-gradient-to-br from-amber-500 to-amber-600 text-deepblack rounded-3xl p-8 shadow-xl">
                        <h4 class="text-xl font-black mb-2">Need Custom Itineraries?</h4>
                        <p class="text-sm font-medium mb-5 text-deepblack/80">Our local travel architects can build personalized VIP Dubai schedules for individuals and corporate groups.</p>
                        <a href="tel:+97141234567" class="inline-flex items-center gap-2 bg-deepblack text-white font-bold py-3 px-5 rounded-xl text-sm hover:bg-white hover:text-deepblack transition-colors shadow-md">
                            📞 Call +971 4 123 4567
                        </a>
                    </div>
                </aside>

            </div>
        </div>
    </section>

@endsection
