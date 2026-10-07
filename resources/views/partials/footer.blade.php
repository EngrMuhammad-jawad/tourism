<!-- Footer -->
@php
    $footerSiteName = \App\Models\Setting::get('general.site_name', 'Dubai Tour Book');
    $footerLogo = \App\Models\Setting::get('general.logo', '/assets/images/logo.svg');
    $footerPhone = \App\Models\Setting::get('contact.phone', '+971 4 321 8899');
    $footerEmail = \App\Models\Setting::get('contact.email', 'info@dubaitourbook.com');
    $footerAddress = \App\Models\Setting::get('contact.address', 'Sheikh Mohammed bin Rashid Blvd, Downtown Dubai, United Arab Emirates');
    $footerFb = \App\Models\Setting::get('social.facebook', 'https://facebook.com/dubaitourbook');
    $footerIg = \App\Models\Setting::get('social.instagram', 'https://instagram.com/dubaitourbook');
    $footerTw = \App\Models\Setting::get('social.twitter', 'https://x.com/dubaitourbook');
    $footerYt = \App\Models\Setting::get('social.youtube', 'https://youtube.com/@dubaitourbook');
    $footerWa = \App\Models\Setting::get('social.whatsapp', 'https://wa.me/971508887766');
    $footerCopyright = \App\Models\Setting::get('footer.copyright', '© 2026 Dubai Tour Book (dubaitourbook.com). All Rights Reserved.');

    $aboutAll = \App\Models\Setting::get('footer.about_text');
    $currentLocale = app()->getLocale();
    if (is_array($aboutAll)) {
        $footerAbout = $aboutAll[$currentLocale] ?? $aboutAll['en'] ?? 'Dubai Tour Book is your premier luxury portal to experience Dubai’s iconic skyline, golden desert safaris, VIP yacht cruises, and 7-star Arabian hospitality.';
    } else {
        $footerAbout = $aboutAll ?: 'Dubai Tour Book is your premier luxury portal to experience Dubai’s iconic skyline, golden desert safaris, VIP yacht cruises, and 7-star Arabian hospitality.';
    }
@endphp

<footer class="bg-deepblack text-white pt-20 pb-10 border-t border-amber-500/20 relative overflow-hidden">
    <!-- Subtle Background Ambient Light Glow -->
    <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-amber-500/10 blur-3xl pointer-events-none animate-pulse-glow"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-amber-600/10 blur-3xl pointer-events-none animate-pulse-glow"></div>

    <div class="container mx-auto px-6 relative z-10">
        <!-- Newsletter Subscription Box -->
        <div class="mb-16 rounded-3xl bg-gradient-to-r from-gray-900 via-black to-gray-900 border border-gold/30 p-8 sm:p-10 shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="max-w-xl">
                <span class="text-xs font-bold uppercase tracking-widest text-gold">Exclusive Offers</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Subscribe to {{ $footerSiteName }} Journal</h3>
                <p class="text-gray-400 text-sm mt-2">Get curated Dubai itineraries, VIP Burj Khalifa deals, and seasonal desert experience guides straight to your inbox.</p>
            </div>
            <form method="POST" action="{{ route('newsletter.store') }}" class="w-full lg:w-auto flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="email" name="email" required placeholder="Enter your email address" class="px-5 py-3.5 rounded-full bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-gold min-w-[280px] text-sm">
                <button type="submit" class="bg-gold text-deepblack font-extrabold px-8 py-3.5 rounded-full hover:bg-white transition-all duration-300 text-sm shadow-lg transform hover:scale-105 flex-shrink-0">Subscribe</button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <!-- Brand & Mission -->
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 mb-5 group" title="{{ $footerSiteName }}">
                    <img src="{{ asset($footerLogo) }}" alt="{{ $footerSiteName }}" class="h-10 w-auto max-w-[220px] object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="items-center gap-2 hidden">
                        <div class="w-9 h-9 rounded-xl bg-gold/20 border border-gold/40 flex items-center justify-center">
                            <span class="text-gold font-black text-base">D</span>
                        </div>
                        <span class="font-extrabold text-white text-xl">Dubai<span class="text-gradient-gold">TourBook</span></span>
                    </div>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">{{ $footerAbout }}</p>
                <div class="flex items-center gap-3">
                    @if($footerFb)
                        <a href="{{ $footerFb }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-300 hover:text-gold hover:border-gold transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                    @endif
                    @if($footerIg)
                        <a href="{{ $footerIg }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-300 hover:text-gold hover:border-gold transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    @endif
                    @if($footerTw)
                        <a href="{{ $footerTw }}" target="_blank" rel="noopener noreferrer" aria-label="Twitter" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-300 hover:text-gold hover:border-gold transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    @endif
                    @if($footerYt)
                        <a href="{{ $footerYt }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-300 hover:text-gold hover:border-gold transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    @endif
                    @if($footerWa)
                        <a href="{{ $footerWa }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-emerald-400 hover:text-white hover:bg-emerald-600 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Explore Links -->
            <div>
                <h4 class="text-sm font-bold mb-5 text-gold uppercase tracking-widest">{{ __('footer_links') }}</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-gold transition-colors flex items-center gap-1.5"><span>›</span> {{ __('nav_home') }}</a></li>
                    <li><a href="{{ route('destinations.index') }}" class="text-gray-400 hover:text-gold transition-colors flex items-center gap-1.5"><span>›</span> Destinations</a></li>
                    <li><a href="{{ route('packages.index') }}" class="text-gray-400 hover:text-gold transition-colors flex items-center gap-1.5"><span>›</span> Tour Packages</a></li>
                    <li><a href="{{ route('hotels.index') }}" class="text-gray-400 hover:text-gold transition-colors flex items-center gap-1.5"><span>›</span> Luxury Stays</a></li>
                    <li><a href="{{ route('transports.index') }}" class="text-gray-400 hover:text-gold transition-colors flex items-center gap-1.5"><span>›</span> Private Transport</a></li>
                </ul>
            </div>

            <!-- Resources Links -->
            <div>
                <h4 class="text-sm font-bold mb-5 text-gold uppercase tracking-widest">Resources</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('posts.index') }}" class="text-gray-400 hover:text-gold transition-colors flex items-center gap-1.5"><span>›</span> Travel Journal</a></li>
                    <li><a href="{{ route('gallery.index') }}" class="text-gray-400 hover:text-gold transition-colors flex items-center gap-1.5"><span>›</span> Photo Gallery</a></li>
                    <li><a href="{{ route('testimonials.index') }}" class="text-gray-400 hover:text-gold transition-colors flex items-center gap-1.5"><span>›</span> Traveler Reviews</a></li>
                    <li><a href="{{ route('faqs.index') }}" class="text-gray-400 hover:text-gold transition-colors flex items-center gap-1.5"><span>›</span> FAQs</a></li>
                    <li><a href="{{ url('sitemap.xml') }}" class="text-gray-400 hover:text-gold transition-colors flex items-center gap-1.5" target="_blank"><span>›</span> Sitemap (XML)</a></li>
                </ul>
            </div>

            <!-- Contact & Office -->
            <div>
                <h4 class="text-sm font-bold mb-5 text-gold uppercase tracking-widest">{{ __('footer_contact') }}</h4>
                <p class="text-gray-400 text-sm mb-3 flex items-start gap-2">
                    <svg class="w-5 h-5 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    <span>{{ $footerAddress }}</span>
                </p>
                <p class="text-gray-400 text-sm mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <a href="mailto:{{ $footerEmail }}" class="hover:text-gold transition-colors">{{ $footerEmail }}</a>
                </p>
                <p class="text-gray-400 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 text-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $footerPhone) }}" class="hover:text-gold transition-colors">{{ $footerPhone }}</a>
                </p>
            </div>
        </div>

        <div class="text-center pt-8 border-t border-gray-800/80 text-gray-500 text-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <p>{{ $footerCopyright }}</p>
            <p class="text-xs text-gray-500">Dubai Tour Book &bull; dubaitourbook.com &bull; Luxury Travel, Desert Safaris &amp; VIP Experiences.</p>
        </div>
    </div>
</footer>
