@extends('layouts.app')

@php
    $isAr = app()->getLocale() === 'ar';
    $isRu = app()->getLocale() === 'ru';

    $landingTitle = $isAr
        ? 'سفاري صحراء دبي 2026 | حجز رحلات الكثبان الحمراء، دراجات رباعية وعشاء VIP'
        : ($isRu
            ? 'Сафари в Пустыне Дубая 2026: Джип-сафари, Квадроциклы, VIP Ужин и Цены'
            : 'Dubai Desert Safari 2026 | Red Dune Bashing, Quad Biking & VIP BBQ Dinner');

    $landingDesc = $isAr
        ? 'احجز أفضل رحلات سفاري صحراء دبي لعام 2026. مغامرات الكثبان الرملية الحمراء بسيارات لاندكروزر 4x4، ركوب الجمال، قيادة الدراجات الرباعية وعشاء مشاوي فاخر مع عروض فلكلورية.'
        : ($isRu
            ? 'Забронируйте лучшее сафари в пустыне Дубая: джип-сафари по красным дюнам Лахбаб на Toyota Land Cruiser, квадроциклы, сэндбординг и королевский ужин барбекю с шоу.'
            : 'Book the ultimate Dubai Desert Safari experience for 2026. Enjoy thrilling red dune bashing in 4x4 Land Cruisers, ATV quad biking, camel trekking, sandboarding, and a 5-star royal BBQ dinner under the desert stars.');

    $landingKeywords = $isAr
        ? 'سفاري دبي, رحلات سفاري صحراء دبي, سفاري دبي VIP للعوائل, اسعار سفاري دبي 2026, دراجات صحراوية دبي, عشاء بدوي فاخر دبي'
        : ($isRu
            ? 'сафари в дубае, джип сафари дубай цена, красные дюны дубай, квадроциклы дубай сафари, vip сафари дубай 2026'
            : 'Dubai desert safari, red dune bashing Dubai, evening desert safari Dubai, VIP desert safari with quad biking, best desert safari Dubai 2026, desert safari price Dubai');
@endphp

@section('title', $landingTitle . ' | ' . \App\Models\Setting::get('general.site_name', 'Dubai Tour Book'))
@section('meta_description', $landingDesc)
@section('meta_keywords', $landingKeywords)
@section('og_image', asset('assets/images/tour_desert_safari.jpg'))

@section('content')
<!-- Breadcrumbs -->
<nav class="pt-24 pb-4 bg-offwhite border-b border-gray-200/60" aria-label="Breadcrumb">
    <div class="container mx-auto px-6">
        <ol class="flex items-center space-x-2 text-xs text-gray-500 rtl:space-x-reverse">
            <li><a href="{{ route('home') }}" class="hover:text-gold transition-colors">{{ __('nav_home') }}</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li><a href="{{ route('packages.index') }}" class="hover:text-gold transition-colors">{{ __('packages') }}</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li class="text-deepblack font-semibold" aria-current="page">{{ $isAr ? 'سفاري صحراء دبي' : ($isRu ? 'Сафари в Пустыне' : 'Dubai Desert Safari') }}</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative min-h-[65vh] flex items-center justify-center text-white overflow-hidden py-20 bg-deepblack">
    <div class="absolute inset-0 w-full h-full">
        <img src="{{ asset('assets/images/tour_desert_safari.jpg') }}" alt="Dubai Desert Safari Red Dunes Sunset" class="w-full h-full object-cover object-center transform scale-105" loading="eager" width="1920" height="1080">
        <div class="absolute inset-0 bg-gradient-to-t from-deepblack via-black/60 to-black/40"></div>
    </div>

    <div class="container relative z-10 mx-auto px-6 text-center max-w-4xl" data-aos="fade-up">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/60 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-6 shadow-xl">
            <span>{{ $isAr ? 'المغامرة الصحراوية رقم 1 في الإمارات' : ($isRu ? '№1 Экскурсия в Дубае' : '#1 Rated UAE Desert Adventure') }}</span>
        </div>

        <h1 class="text-4xl sm:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
            {{ $isAr ? 'سفاري صحراء دبي VIP' : ($isRu ? 'VIP Сафари в Пустыне Дубая' : 'Dubai Desert Safari Experiences') }} <br />
            <span class="text-gradient-gold">{{ $isAr ? 'الكثبان الحمراء، دراجات وعشاء ملكي' : ($isRu ? 'Красные Дюны, Квадроциклы и Барбекю' : 'Red Dunes, Quad Biking & Royal BBQ') }}</span>
        </h1>

        <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto font-light leading-relaxed">
            {{ $landingDesc }}
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="#safari-packages" class="bg-gold text-deepblack font-extrabold px-8 py-4 rounded-full hover:bg-white transition-all text-base shadow-2xl transform hover:-translate-y-1">
                {{ $isAr ? 'استكشف باقات السفاري' : ($isRu ? 'Выбрать тур сафари' : 'Explore Safari Packages') }}
            </a>
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact.phone', '+971 4 321 8899'));
                $waText = rawurlencode('Hello Dubai Tour Book, I would like to book a VIP Desert Safari experience.');
            @endphp
            <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-4 rounded-full transition-all text-base shadow-xl flex items-center gap-2">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                <span>{{ $isAr ? 'حجز فوري عبر الواتساب' : ($isRu ? 'Бронь через WhatsApp' : 'Instant WhatsApp Booking') }}</span>
            </a>
        </div>
    </div>
</section>

<!-- Safari Highlights Key Metrics -->
<section class="py-12 bg-white border-b border-gray-100">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="p-4 rounded-2xl bg-offwhite border border-gray-100">
                <span class="text-3xl font-black text-gold">45 Min</span>
                <p class="text-xs uppercase font-bold text-gray-500 mt-1">Lahbab Red Dune Bashing</p>
            </div>
            <div class="p-4 rounded-2xl bg-offwhite border border-gray-100">
                <span class="text-3xl font-black text-gold">4x4</span>
                <p class="text-xs uppercase font-bold text-gray-500 mt-1">Toyota Land Cruiser Pickup</p>
            </div>
            <div class="p-4 rounded-2xl bg-offwhite border border-gray-100">
                <span class="text-3xl font-black text-gold">7-Star</span>
                <p class="text-xs uppercase font-bold text-gray-500 mt-1">VIP Desert Camp & BBQ</p>
            </div>
            <div class="p-4 rounded-2xl bg-offwhite border border-gray-100">
                <span class="text-3xl font-black text-gold">100%</span>
                <p class="text-xs uppercase font-bold text-gray-500 mt-1">Free Cancellation 24h</p>
            </div>
        </div>
    </div>
</section>

<!-- Packages Grid -->
<section id="safari-packages" class="py-20 bg-offwhite">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">{{ $isAr ? 'عروض حصرية 2026' : ($isRu ? 'Цены и Пакеты 2026' : 'Exclusive 2026 Offers') }}</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-deepblack">{{ $isAr ? 'اختر باقة سفاري صحراء دبي المناسبة لك' : ($isRu ? 'Выберите Ваше Сафари в Дубае' : 'Curated Dubai Desert Safari Packages') }}</h2>
            <p class="text-gray-600 mt-3 text-sm">{{ $isAr ? 'جميع الباقات تشمل التوصيل من وإلى الفندق بسيارات مكيفة فاخرة ومرشدين معتمدين' : ($isRu ? 'Все пакеты включают трансфер из любого отеля Дубая на внедорожнике' : 'All packages include door-to-door hotel pickup and drop-off in luxury air-conditioned 4x4 vehicles.') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($packages as $pkg)
                <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 flex flex-col justify-between group hover:shadow-2xl hover:border-gold/40 transition-all duration-300">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="{{ $pkg->getFirstMediaUrl('featured') ?: asset('assets/images/tour_desert_safari.jpg') }}" alt="{{ $pkg->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" width="400" height="300">
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
                                    <span>Hotel Pickup & Drop-off Included</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Red Dune Bashing & Sandboarding</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Live Shows & Royal BBQ Dinner</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('packages.show', $pkg) }}" class="flex-1 py-3 text-center bg-deepblack text-white hover:bg-gold hover:text-deepblack rounded-xl font-bold text-sm transition-colors">
                                View Details
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

<!-- What's Included & Itinerary Details -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Standard Inclusions</span>
                <h2 class="text-3xl font-extrabold text-deepblack mb-6">What Makes Our VIP Desert Safari Legendary</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-offwhite border border-gray-100">
                        <div class="w-8 h-8 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0 text-gold font-bold">1</div>
                        <div>
                            <h4 class="font-bold text-deepblack text-sm">VIP 4x4 Hotel Transfer</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Prompt private or shared pickup from your hotel lobby in Dubai or Sharjah in a licensed 4x4 Toyota Land Cruiser.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-offwhite border border-gray-100">
                        <div class="w-8 h-8 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0 text-gold font-bold">2</div>
                        <div>
                            <h4 class="font-bold text-deepblack text-sm">Thrilling Lahbab Red Dune Bashing</h4>
                            <p class="text-xs text-gray-500 mt-0.5">35–45 minutes of exhilarating roller-coaster dune driving across the high red dunes by a government-licensed safari master.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-offwhite border border-gray-100">
                        <div class="w-8 h-8 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0 text-gold font-bold">3</div>
                        <div>
                            <h4 class="font-bold text-deepblack text-sm">Sunset Photography & Sandboarding</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Stop at the highest dune crest for panoramic sunset photos and surf the golden sand with professional sandboards.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-offwhite border border-gray-100">
                        <div class="w-8 h-8 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0 text-gold font-bold">4</div>
                        <div>
                            <h4 class="font-bold text-deepblack text-sm">5-Star Arabian Camp, Live Shows & Dinner</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Traditional Arabic coffee (Gahwa), fresh dates, henna painting, fire dancers, Tanoura dance, belly dancing, and a lavish BBQ buffet.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-deepblack text-white p-8 sm:p-10 rounded-3xl border border-gold/30 shadow-2xl">
                <span class="text-xs font-extrabold uppercase tracking-widest text-gold block mb-2">Essential Traveler Information</span>
                <h3 class="text-2xl font-black mb-6">Safari Preparation & Tips</h3>
                <ul class="space-y-4 text-sm text-gray-300">
                    <li class="flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span><strong>Timings:</strong> Evening safari pickup is between 2:30 PM – 3:30 PM; return is around 9:30 PM.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>Dress Code:</strong> Comfortable casual clothing (light cottons) with sandals or sneakers. Bring a light jacket for winter evenings (Nov–Feb).</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span><strong>Safety:</strong> Dune bashing is not recommended for pregnant women, infants under 3 years, or travelers with severe back/neck conditions. Gentle desert drives are available on private tours.</span>
                    </li>
                </ul>

                <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-gray-400 block">Starting from</span>
                        <span class="text-3xl font-black text-gold">55 AED</span>
                        <span class="text-xs text-gray-400">/ person</span>
                    </div>
                    <a href="{{ route('bookings.create', ['type' => 'package', 'id' => $packages->first()?->id ?? 8]) }}" class="bg-gold text-deepblack font-extrabold px-6 py-3 rounded-full hover:bg-white transition-colors text-sm shadow-lg">
                        Reserve Your 4x4
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visible FAQ Accordion Section (Matches Schema.org FAQPage Exactly) -->
<section class="py-20 bg-offwhite border-t border-gray-200/60">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="text-center mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Common Questions</span>
            <h2 class="text-3xl font-extrabold text-deepblack">Dubai Desert Safari FAQs</h2>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-deepblack mb-2">What is the difference between a Standard and VIP Desert Safari?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">A Standard Desert Safari includes shared camp seating and self-service buffet. The VIP Desert Safari includes dedicated table service with personal servers, premium stage seating for live shows, high-end quad bike access, and private 4x4 Land Cruiser transfer options.</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-deepblack mb-2">Can I drive a quad bike or dune buggy without a driving license?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Yes! Quad biking and dune buggy riding in our designated desert circuits do not require an international driving license. Full safety gear, helmets, and a guided briefing are provided before departure.</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-deepblack mb-2">Are vegetarian, vegan, and Jain meal options available at the BBQ dinner?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Yes, our 5-star desert camp buffet features designated vegetarian, vegan, and Halal-certified gourmet sections including fresh salads, hummus, falafel, vegetable curries, and lentil dahl alongside grilled meats.</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-deepblack mb-2">What should I wear during the desert safari?</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Wear loose, comfortable clothing (cotton shirts, shorts, or trousers) and footwear that is easy to remove on the sand (sandals or flip-flops). Sunglasses, sunscreen, and a light jacket for winter evenings (December–February) are recommended.</p>
            </div>
        </div>
    </div>
</section>

<!-- Schema.org JSON-LD Structured Data for Desert Safari Landing -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "TouristTrip",
  "name": "Dubai Desert Safari VIP Experience",
  "description": "{{ $landingDesc }}",
  "touristType": ["Adventure", "Couples", "Family Travel", "Luxury"],
  "image": "{{ asset('assets/images/tour_desert_safari.jpg') }}",
  "provider": {
    "@type": "TravelAgency",
    "name": "Dubai Tour Book",
    "url": "https://dubaitourbook.com"
  },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "AED",
    "price": "55.00",
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
    { "@type": "ListItem", "position": 3, "name": "Dubai Desert Safari", "item": "{{ url()->current() }}" }
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
      "name": "What is the difference between a Standard and VIP Desert Safari?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "A Standard Desert Safari includes shared camp seating and self-service buffet. The VIP Desert Safari includes dedicated table service with personal servers, premium stage seating for live shows, high-end quad bike access, and private 4x4 Land Cruiser transfer options."
      }
    },
    {
      "@type": "Question",
      "name": "Can I drive a quad bike or dune buggy without a driving license?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes! Quad biking and dune buggy riding in our designated desert circuits do not require an international driving license. Full safety gear, helmets, and a guided briefing are provided before departure."
      }
    },
    {
      "@type": "Question",
      "name": "Are vegetarian, vegan, and Jain meal options available at the BBQ dinner?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, our 5-star desert camp buffet features designated vegetarian, vegan, and Halal-certified gourmet sections including fresh salads, hummus, falafel, vegetable curries, and lentil dahl alongside grilled meats."
      }
    },
    {
      "@type": "Question",
      "name": "What should I wear during the desert safari?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Wear loose, comfortable clothing (cotton shirts, shorts, or trousers) and footwear that is easy to remove on the sand (sandals or flip-flops). Sunglasses, sunscreen, and a light jacket for winter evenings (December–February) are recommended."
      }
    }
  ]
}
</script>
@endsection
