@props([
    'slotId' => null,
    'format' => 'auto',
    'affiliateUrl' => null,
    'affiliateImage' => null,
    'affiliateAlt' => 'Sponsored Partner',
    'class' => '',
])

@php
    $adsenseId = config('services.adsense.id') ?: \App\Models\Setting::get('ads.adsense_publisher_id');
@endphp

@if(!empty($affiliateUrl) && !empty($affiliateImage))
    <!-- Direct Sponsored / Travel Affiliate Banner (Viator, Booking.com, Local Partner) -->
    <div class="my-8 mx-auto max-w-5xl overflow-hidden rounded-2xl border border-gold/30 bg-gradient-to-r from-deepblack via-black to-deepblack p-1 text-center shadow-xl {{ $class }}">
        <a href="{{ $affiliateUrl }}" target="_blank" rel="noopener sponsored" class="group block relative overflow-hidden rounded-xl">
            <span class="absolute top-2 right-2 bg-deepblack/80 text-gold text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded border border-gold/30 z-10">
                Sponsored
            </span>
            <img src="{{ $affiliateImage }}" alt="{{ $affiliateAlt }}" class="w-full h-auto object-cover transform group-hover:scale-102 transition duration-500">
        </a>
    </div>
@elseif(!empty($adsenseId) && !empty($slotId))
    <!-- Google AdSense Manual Unit -->
    <div class="my-6 mx-auto text-center overflow-hidden max-w-5xl {{ $class }}">
        <div class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Advertisement</div>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="{{ $adsenseId }}"
             data-ad-slot="{{ $slotId }}"
             data-ad-format="{{ $format }}"
             data-full-width-responsive="true"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
@endif
