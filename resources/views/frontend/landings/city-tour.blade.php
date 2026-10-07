@extends('layouts.app')

@php
    $isAr = app()->getLocale() === 'ar';
    $isRu = app()->getLocale() === 'ru';

    $landingTitle = $isAr
        ? 'جولة دبي السياحية الشاملة 2026 | استكشف برج خليفة، مارينا والأسواق القديمة'
        : ($isRu
            ? 'Обзорная Экскурсия по Дубаю 2026: Бурдж Халифа, Дубай Марина, Старый Город'
            : 'Dubai City Tour 2026 | Full Day Luxury Sightseeing & Iconic Landmarks');

    $landingDesc = $isAr
        ? 'استمتع بأروع جولة سياحية في دبي لعام 2026. اكتشف معالم دبي الأيقونية: برج خليفة، فندق أتلانتس، نخلة جميرا، ممشى دبي مارينا، وبرواز دبي مع مرشد سياحي معتمد وتوصيل VIP.'
        : ($isRu
            ? 'Грандиозная обзорная экскурсия по Дубаю с русскоязычным гидом: Бурдж Халифа, Пальма Джумейра, отель Атлантис, Дубайская Рамка, Дубай Молл и традиционные рынки золота и специй.'
            : 'Experience the ultimate Dubai City Tour in 2026. Discover modern and historic Dubai landmarks: Burj Khalifa, Palm Jumeirah, Atlantis, Dubai Marina, Dubai Frame, and the vibrant Gold & Spice Souks with certified multilingual guides and luxury transfers.');

    $landingKeywords = $isAr
        ? 'جولة دبي, رحلات دبي السياحية, جولة دبي ليوم كامل, معالم دبي السياحية, مرشد سياحي دبي, جولات دبي للعوائل'
        : ($isRu
            ? 'экскурсия по дубаю, обзорная экскурсия дубай 2026, русский гид дубай, достопримечательности дубая, тур по дубаю цена'
            : 'Dubai city tour, Dubai sightseeing tour, full day Dubai tour, Dubai landmarks tour, private Dubai city tour, Dubai tour guide');
@endphp

@section('title', $landingTitle . ' | ' . \App\Models\Setting::get('general.site_name', 'Dubai Tour Book'))
@section('meta_description', $landingDesc)
@section('meta_keywords', $landingKeywords)
@section('og_image', asset('assets/images/tour_frame.jpg'))

@section('content')
<!-- Breadcrumbs -->
<nav class="pt-24 pb-4 bg-offwhite border-b border-gray-200/60" aria-label="Breadcrumb">
    <div class="container mx-auto px-6">
        <ol class="flex items-center space-x-2 text-xs text-gray-500 rtl:space-x-reverse">
            <li><a href="{{ route('home') }}" class="hover:text-gold transition-colors">{{ __('nav_home') }}</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li><a href="{{ route('packages.index') }}" class="hover:text-gold transition-colors">{{ __('packages') }}</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li class="text-deepblack font-semibold" aria-current="page">{{ $isAr ? 'جولة دبي السياحية' : ($isRu ? 'Обзорная экскурсия' : 'Dubai City Tour') }}</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center text-white overflow-hidden py-20 bg-deepblack">
    <div class="absolute inset-0 w-full h-full">
        <img src="{{ asset('assets/images/tour_frame.jpg') }}" alt="Dubai Skyline & Dubai Frame Sightseeing" class="w-full h-full object-cover object-center transform scale-105" loading="eager" width="1920" height="1080">
        <div class="absolute inset-0 bg-gradient-to-t from-deepblack via-black/60 to-black/40"></div>
    </div>

    <div class="container relative z-10 mx-auto px-6 text-center max-w-4xl" data-aos="fade-up">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/60 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-6 shadow-xl">
            <span>{{ $isAr ? 'اكتشف دبي القديمة والحديثة في يوم واحد' : ($isRu ? 'Все главные символы Дубая за 1 день' : 'Discover Old & Modern Dubai in One Day') }}</span>
        </div>

        <h1 class="text-4xl sm:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
            {{ $isAr ? 'جولة دبي السياحية الفاخرة' : ($isRu ? 'Гранд-Тур по Дубаю 2026' : 'Dubai Full Day City Sightseeing') }} <br />
            <span class="text-gradient-gold">{{ $isAr ? 'من الأسواق التراثية إلى قمة برج خليفة' : ($isRu ? 'От Золотого Рынка до Бурдж Халифа' : 'From Heritage Souks to Burj Khalifa') }}</span>
        </h1>

        <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto font-light leading-relaxed">
            {{ $landingDesc }}
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="#city-packages" class="bg-gold text-deepblack font-extrabold px-8 py-4 rounded-full hover:bg-white transition-all text-base shadow-2xl transform hover:-translate-y-1">
                {{ $isAr ? 'استعراض الباقات' : ($isRu ? 'Выбрать тур' : 'View City Tours') }}
            </a>
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact.phone', '+971 4 321 8899'));
                $waText = rawurlencode('Hello Dubai Tour Book, I would like to book the Dubai City Tour.');
            @endphp
            <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-4 rounded-full transition-all text-base shadow-xl flex items-center gap-2">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                <span>{{ $isAr ? 'استفسار عبر الواتساب' : ($isRu ? 'WhatsApp Консьерж' : 'WhatsApp Concierge') }}</span>
            </a>
        </div>
    </div>
</section>

<!-- City Tour Highlights -->
<section id="city-packages" class="py-20 bg-offwhite">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Iconic Itineraries</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-deepblack">Featured Dubai Sightseeing Experiences</h2>
            <p class="text-gray-600 mt-3 text-sm">Choose from shared group tours or private VIP chauffeur tours with custom itineraries.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($packages as $pkg)
                <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 flex flex-col justify-between group hover:shadow-2xl hover:border-gold/40 transition-all duration-300">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="{{ $pkg->getFirstMediaUrl('featured') ?: asset('assets/images/tour_burj.jpg') }}" alt="{{ $pkg->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" width="400" height="300">
                        <span class="absolute top-4 right-4 bg-deepblack/85 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-gold/40 text-gold text-xs font-bold">
                            {{ number_format($pkg->effectivePrice(), 0) }} AED / person
                        </span>
                    </div>

                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-deepblack mb-2">{{ $pkg->name }}</h3>
                            <p class="text-xs text-gray-500 line-clamp-3 mb-4">{{ $pkg->summary }}</p>

                            <div class="space-y-1.5 text-xs text-gray-600 mb-6">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Hotel Pickup & Return Included</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Licensed Multilingual Tour Guide</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Entry Passes & Photo Stops</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('packages.show', $pkg) }}" class="flex-1 py-3 text-center bg-deepblack text-white hover:bg-gold hover:text-deepblack rounded-xl font-bold text-sm transition-colors">
                                View Tour Details
                            </a>
                            <a href="{{ route('bookings.create', ['type' => 'package', 'id' => $pkg->id]) }}" class="px-5 py-3 bg-gold text-deepblack hover:bg-deepblack hover:text-white rounded-xl font-bold text-sm transition-colors">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Visible FAQ Section -->
<section class="py-20 bg-white border-t border-gray-100">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="text-center mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Common Questions</span>
            <h2 class="text-3xl font-extrabold text-deepblack">Dubai City Tour FAQs</h2>
        </div>

        <div class="space-y-4">
            <div class="bg-offwhite rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">What major attractions are covered in the Dubai City Tour?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Our comprehensive tour covers Downtown Dubai (Burj Khalifa & Dubai Mall), Palm Jumeirah (Atlantis photo stop), Dubai Marina, Burj Al Arab viewpoint, Dubai Frame, and the historic Al Fahidi district with Gold and Spice Souks.</p>
            </div>
            <div class="bg-offwhite rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">Are tickets to Burj Khalifa and Dubai Frame included?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Entry passes can be added to your booking package. You can select tickets for Level 124/125 At The Top or Dubai Frame glass bridge during booking or inquiry.</p>
            </div>
            <div class="bg-offwhite rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-deepblack mb-2">Can we book a private vehicle and guide for our family?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Yes, we provide private VIP Mercedes V-Class or luxury coach tours customized entirely to your family's schedule and pacing.</p>
            </div>
        </div>
    </div>
</section>

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "TouristTrip",
  "name": "Dubai City Tour Luxury Sightseeing",
  "description": "{{ $landingDesc }}",
  "touristType": ["Sightseeing", "Cultural", "Family Travel"],
  "image": "{{ asset('assets/images/tour_frame.jpg') }}",
  "provider": {
    "@type": "TravelAgency",
    "name": "Dubai Tour Book",
    "url": "https://dubaitourbook.com"
  },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "AED",
    "price": "150.00",
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
    { "@type": "ListItem", "position": 3, "name": "Dubai City Tour", "item": "{{ url()->current() }}" }
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
      "name": "What major attractions are covered in the Dubai City Tour?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Our comprehensive tour covers Downtown Dubai (Burj Khalifa & Dubai Mall), Palm Jumeirah (Atlantis photo stop), Dubai Marina, Burj Al Arab viewpoint, Dubai Frame, and the historic Al Fahidi district with Gold and Spice Souks."
      }
    },
    {
      "@type": "Question",
      "name": "Are tickets to Burj Khalifa and Dubai Frame included?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Entry passes can be added to your booking package. You can select tickets for Level 124/125 At The Top or Dubai Frame glass bridge during booking or inquiry."
      }
    },
    {
      "@type": "Question",
      "name": "Can we book a private vehicle and guide for our family?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, we provide private VIP Mercedes V-Class or luxury coach tours customized entirely to your family's schedule and pacing."
      }
    }
  ]
}
</script>
@endsection
