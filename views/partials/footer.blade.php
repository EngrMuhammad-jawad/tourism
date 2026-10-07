<!-- Footer -->
<footer class="bg-deepblack text-white pt-20 pb-10 border-t border-amber-500/20 relative overflow-hidden">
    <!-- Subtle Background Ambient Light Glow -->
    <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-amber-500/10 blur-3xl pointer-events-none animate-pulse-glow"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-amber-600/10 blur-3xl pointer-events-none animate-pulse-glow"></div>

    <div class="container mx-auto px-6 relative z-10">
        <!-- Newsletter Subscription Box -->
        <div class="mb-16 rounded-3xl bg-gradient-to-r from-gray-900 via-black to-gray-900 border border-gold/30 p-8 sm:p-10 shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="max-w-xl">
                <span class="text-xs font-bold uppercase tracking-widest text-gold">Exclusive Offers</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Subscribe to UAE Luxury Travel Journal</h3>
                <p class="text-gray-400 text-sm mt-2">Get curated travel itineraries, VIP hotel deals, and seasonal Emirates experience guides straight to your inbox.</p>
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
                <a href="{{ route('home') }}" class="text-2xl font-bold text-white tracking-wider flex items-center gap-2.5 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-gold/20 border border-gold/40 flex items-center justify-center">
                        <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="font-extrabold text-white">UAE<span class="text-gradient-gold">Tourism</span></span>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">{{ __('footer_about_text') }}</p>
                <div class="flex items-center gap-3">
                    <a href="#" aria-label="Facebook" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-300 hover:text-gold hover:border-gold transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-300 hover:text-gold hover:border-gold transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
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
                    <span>Downtown Dubai & Corniche Abu Dhabi, UAE</span>
                </p>
                <p class="text-gray-400 text-sm mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <a href="mailto:info@uaetourism.example.com" class="hover:text-gold transition-colors">info@uaetourism.example.com</a>
                </p>
                <p class="text-gray-400 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 text-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <a href="tel:+97141234567" class="hover:text-gold transition-colors">+971 4 123 4567</a>
                </p>
            </div>
        </div>

        <div class="text-center pt-8 border-t border-gray-800/80 text-gray-500 text-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <p>{{ __('footer_rights') }}</p>
            <p class="text-xs text-gray-500">Built for luxury travel, cultural heritage & desert adventures across the UAE.</p>
        </div>
    </div>
</footer>
