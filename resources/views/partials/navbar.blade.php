<!-- Navigation Header -->
<header id="navbar-header" class="fixed w-full z-50 transition-all duration-300 top-0 left-0">
    <nav class="bg-deepblack/90 backdrop-blur-xl border-b border-gold/20 shadow-2xl py-3.5 px-4 sm:px-8">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Brand Logo -->
            @php
                $navSiteName = \App\Models\Setting::get('general.site_name', 'Dubai Tour Book');
                $navLogo = \App\Models\Setting::get('general.logo', '/assets/images/logo.svg');
            @endphp
            <a href="{{ route('home') }}" class="flex items-center gap-3 group" title="{{ $navSiteName }}">
                <img src="{{ asset($navLogo) }}" alt="{{ $navSiteName }}" class="h-10 sm:h-11 w-auto max-w-[220px] object-contain group-hover:scale-105 transition-transform" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="items-center gap-2.5 hidden">
                    <div class="w-10 h-10 rounded-xl bg-gold/20 border border-gold/40 flex items-center justify-center">
                        <span class="text-gold font-black text-lg">D</span>
                    </div>
                    <span class="font-extrabold text-white text-xl">Dubai<span class="text-gradient-gold">TourBook</span></span>
                </div>
            </a>

            <!-- Desktop Navigation: Original Links + VIP Services Dropdown -->
            <div class="hidden lg:flex items-center gap-1 xl:gap-3 rtl:space-x-reverse py-1">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-gold font-bold' : 'text-gray-200 hover:text-gold' }} transition-colors text-xs xl:text-sm font-semibold px-2.5 py-1.5 rounded-lg hover:bg-white/5">{{ __('nav_home') }}</a>
                <a href="{{ route('destinations.index') }}" class="{{ request()->routeIs('destinations.*') ? 'text-gold font-bold' : 'text-gray-200 hover:text-gold' }} transition-colors text-xs xl:text-sm font-semibold px-2.5 py-1.5 rounded-lg hover:bg-white/5">Destinations</a>
                <a href="{{ route('packages.index') }}" class="{{ request()->routeIs('packages.*') ? 'text-gold font-bold' : 'text-gray-200 hover:text-gold' }} transition-colors text-xs xl:text-sm font-semibold px-2.5 py-1.5 rounded-lg hover:bg-white/5">Tour Packages</a>

                <!-- VIP Services Dropdown (New 9 Services) -->
                <div class="relative group" id="vip-services-dropdown">
                    <button type="button" class="flex items-center gap-1.5 text-gold hover:text-white bg-gold/10 hover:bg-gold/20 px-3 py-1.5 rounded-xl transition-all text-xs xl:text-sm font-bold border border-gold/30">
                        <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span>VIP Services</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="absolute left-0 mt-2 w-64 bg-deepblack/95 backdrop-blur-2xl rounded-2xl shadow-2xl border border-gold/30 p-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="px-2.5 py-1.5 mb-1 border-b border-white/10 text-[10px] font-bold text-gold uppercase tracking-wider flex items-center justify-between">
                            <span>VIP Inquiries & Bookings</span>
                            <span class="text-[9px] text-gray-400">9 Services</span>
                        </div>
                        <div class="flex flex-col space-y-1 max-h-[70vh] overflow-y-auto">
                            <button type="button" data-service-modal="flights" class="w-full text-left rtl:text-right flex items-center justify-between text-gray-200 hover:text-gold hover:bg-white/10 px-3 py-2 rounded-xl transition-all text-xs font-semibold">
                                <span>{{ __('nav_flights') }}</span>
                                <span class="text-[10px] text-gray-400">Inquiry</span>
                            </button>
                            <button type="button" data-service-modal="hotels" class="w-full text-left rtl:text-right flex items-center justify-between text-gray-200 hover:text-gold hover:bg-white/10 px-3 py-2 rounded-xl transition-all text-xs font-semibold">
                                <span>{{ __('nav_hotels') }}</span>
                                <span class="text-[10px] text-gray-400">Inquiry</span>
                            </button>
                            <button type="button" data-service-modal="transfer_taxi" class="w-full text-left rtl:text-right flex items-center justify-between text-gray-200 hover:text-gold hover:bg-white/10 px-3 py-2 rounded-xl transition-all text-xs font-semibold">
                                <span>{{ __('nav_transfer_taxi') }}</span>
                                <span class="text-[10px] text-emerald-400">WhatsApp</span>
                            </button>
                            <button type="button" data-service-modal="food" class="w-full text-left rtl:text-right flex items-center justify-between text-gray-200 hover:text-gold hover:bg-white/10 px-3 py-2 rounded-xl transition-all text-xs font-semibold">
                                <span>{{ __('nav_food') }}</span>
                                <span class="text-[10px] text-emerald-400">WhatsApp</span>
                            </button>
                            <button type="button" data-service-modal="city_tours" class="w-full text-left rtl:text-right flex items-center justify-between text-gray-200 hover:text-gold hover:bg-white/10 px-3 py-2 rounded-xl transition-all text-xs font-semibold">
                                <span>{{ __('nav_city_tours') }}</span>
                                <span class="text-[10px] text-gold">Sharing / Private</span>
                            </button>
                            <button type="button" data-service-modal="desert_safari" class="w-full text-left rtl:text-right flex items-center justify-between text-gray-200 hover:text-gold hover:bg-white/10 px-3 py-2 rounded-xl transition-all text-xs font-semibold">
                                <span>{{ __('nav_desert_safari') }}</span>
                                <span class="text-[10px] text-gold">VIP Red Dune</span>
                            </button>
                            <button type="button" data-service-modal="tickets" class="w-full text-left rtl:text-right flex items-center justify-between text-gray-200 hover:text-gold hover:bg-white/10 px-3 py-2 rounded-xl transition-all text-xs font-semibold">
                                <span>{{ __('nav_tickets') }}</span>
                                <span class="text-[10px] text-gray-400">Instant Pass</span>
                            </button>
                            <button type="button" data-service-modal="relocation" class="w-full text-left rtl:text-right flex items-center justify-between text-gray-200 hover:text-gold hover:bg-white/10 px-3 py-2 rounded-xl transition-all text-xs font-semibold">
                                <span>{{ __('nav_relocation') }}</span>
                                <span class="text-[10px] text-gray-400">Visa & Move</span>
                            </button>
                            <button type="button" data-service-modal="to_buy_property" class="w-full text-left rtl:text-right flex items-center justify-between bg-gold/15 hover:bg-gold hover:text-deepblack text-gold px-3 py-2 rounded-xl transition-all text-xs font-extrabold border border-gold/40 shadow-sm">
                                <span>{{ __('nav_to_buy_property') }}</span>
                                <span class="text-[9px] uppercase font-black px-1.5 py-0.5 rounded bg-gold/30 text-amber-200">Invest</span>
                            </button>
                        </div>
                    </div>
                </div>

                <a href="{{ route('hotels.index') }}" class="{{ request()->routeIs('hotels.*') ? 'text-gold font-bold' : 'text-gray-200 hover:text-gold' }} transition-colors text-xs xl:text-sm font-semibold px-2.5 py-1.5 rounded-lg hover:bg-white/5">Luxury Hotels</a>
                <a href="{{ route('transports.index') }}" class="{{ request()->routeIs('transports.*') ? 'text-gold font-bold' : 'text-gray-200 hover:text-gold' }} transition-colors text-xs xl:text-sm font-semibold px-2.5 py-1.5 rounded-lg hover:bg-white/5">Transport</a>
                <a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.*') ? 'text-gold font-bold' : 'text-gray-200 hover:text-gold' }} transition-colors text-xs xl:text-sm font-semibold px-2.5 py-1.5 rounded-lg hover:bg-white/5">Gallery</a>
                <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'text-gold font-bold' : 'text-gray-200 hover:text-gold' }} transition-colors text-xs xl:text-sm font-semibold px-2.5 py-1.5 rounded-lg hover:bg-white/5">Blog</a>
                <a href="{{ route('contact.create') }}" class="{{ request()->routeIs('contact.*') ? 'text-gold font-bold' : 'text-gray-200 hover:text-gold' }} transition-colors text-xs xl:text-sm font-semibold px-2.5 py-1.5 rounded-lg hover:bg-white/5">Contact</a>
            </div>

            <!-- Language & User Controls -->
            <div class="flex items-center gap-3 sm:gap-4">
                @include('partials.lang-switcher')

                @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-white hover:text-gold transition-colors focus:outline-none py-1 px-2 rounded-lg hover:bg-white/5" aria-label="User Account Menu">
                            <div class="w-8 h-8 rounded-full bg-gold text-deepblack flex items-center justify-center font-bold text-xs shadow-md">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold hidden sm:inline">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden rtl:left-0 rtl:right-auto z-50 border border-gray-100 p-1.5">
                            @can('dashboard.view')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 rounded-xl hover:bg-amber-50 hover:text-amber-900 transition-colors rtl:text-right">
                                    <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    Admin Dashboard
                                </a>
                            @endcan
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 rounded-xl hover:bg-amber-50 hover:text-amber-900 transition-colors rtl:text-right">
                                <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                My Bookings
                            </a>
                            <a href="{{ route('account.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 rounded-xl hover:bg-amber-50 hover:text-amber-900 transition-colors rtl:text-right">
                                <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ __('my_account') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 text-left px-4 py-2.5 text-sm font-semibold text-rose-600 rounded-xl hover:bg-rose-50 transition-colors rtl:text-right">
                                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    {{ __('logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="hidden sm:inline text-white hover:text-gold transition-colors font-semibold text-sm px-3 py-2">{{ __('login') }}</a>
                    <a href="{{ route('register') }}" class="bg-gold text-deepblack font-extrabold px-5 py-2 rounded-full hover:bg-white transition-all text-sm shadow-md transform hover:scale-105">{{ __('register') }}</a>
                @endguest

                <!-- Mobile/Tablet Hamburger Toggle Button (Visible on screens smaller than lg) -->
                <button id="mobile-menu-btn" type="button" class="lg:hidden text-white hover:text-gold focus:outline-none p-1.5 rounded-lg border border-white/20" aria-label="Toggle Mobile Menu">
                    <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile & Tablet Navigation Drawer -->
        <div id="mobile-menu" class="hidden lg:hidden bg-deepblack/95 backdrop-blur-2xl border-t border-gold/20 px-4 sm:px-6 py-5 mt-3 rounded-2xl shadow-2xl transition-all duration-300 max-h-[85vh] overflow-y-auto">
            <!-- Primary Navigation Links -->
            <div class="grid grid-cols-2 gap-1.5 mb-4 pb-4 border-b border-white/10">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-gold font-bold bg-white/10' : 'text-white hover:text-gold bg-white/5' }} px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span>{{ __('nav_home') }}</span>
                </a>
                <a href="{{ route('destinations.index') }}" class="{{ request()->routeIs('destinations.*') ? 'text-gold font-bold bg-white/10' : 'text-white hover:text-gold bg-white/5' }} px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span>Destinations</span>
                </a>
                <a href="{{ route('packages.index') }}" class="{{ request()->routeIs('packages.*') ? 'text-gold font-bold bg-white/10' : 'text-white hover:text-gold bg-white/5' }} px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span>Tour Packages</span>
                </a>
                <a href="{{ route('hotels.index') }}" class="{{ request()->routeIs('hotels.*') ? 'text-gold font-bold bg-white/10' : 'text-white hover:text-gold bg-white/5' }} px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span>Luxury Hotels</span>
                </a>
                <a href="{{ route('transports.index') }}" class="{{ request()->routeIs('transports.*') ? 'text-gold font-bold bg-white/10' : 'text-white hover:text-gold bg-white/5' }} px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span>Transport</span>
                </a>
                <a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.*') ? 'text-gold font-bold bg-white/10' : 'text-white hover:text-gold bg-white/5' }} px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span>Gallery</span>
                </a>
                <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'text-gold font-bold bg-white/10' : 'text-white hover:text-gold bg-white/5' }} px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span>Travel Blog</span>
                </a>
                <a href="{{ route('contact.create') }}" class="{{ request()->routeIs('contact.*') ? 'text-gold font-bold bg-white/10' : 'text-white hover:text-gold bg-white/5' }} px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span>Contact Us</span>
                </a>
            </div>

            <!-- VIP Services (New 9 Services) -->
            <div class="mb-3 px-1 flex items-center justify-between">
                <span class="text-[11px] font-extrabold uppercase tracking-widest text-gold flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    VIP Concierge & Services
                </span>
                <span class="text-[10px] text-gold/80 font-bold bg-gold/15 px-2 py-0.5 rounded-md">9 Services</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                <button type="button" data-service-modal="flights" class="flex items-center justify-center text-white hover:text-gold bg-white/5 hover:bg-white/10 p-2.5 rounded-xl transition-all text-xs font-semibold border border-white/5 text-center">
                    <span>{{ __('nav_flights') }}</span>
                </button>
                <button type="button" data-service-modal="hotels" class="flex items-center justify-center text-white hover:text-gold bg-white/5 hover:bg-white/10 p-2.5 rounded-xl transition-all text-xs font-semibold border border-white/5 text-center">
                    <span>{{ __('nav_hotels') }}</span>
                </button>
                <button type="button" data-service-modal="transfer_taxi" class="flex items-center justify-center text-white hover:text-gold bg-white/5 hover:bg-white/10 p-2.5 rounded-xl transition-all text-xs font-semibold border border-white/5 text-center">
                    <span>{{ __('nav_transfer_taxi') }}</span>
                </button>
                <button type="button" data-service-modal="food" class="flex items-center justify-center text-white hover:text-gold bg-white/5 hover:bg-white/10 p-2.5 rounded-xl transition-all text-xs font-semibold border border-white/5 text-center">
                    <span>{{ __('nav_food') }}</span>
                </button>
                <button type="button" data-service-modal="city_tours" class="flex items-center justify-center text-white hover:text-gold bg-white/5 hover:bg-white/10 p-2.5 rounded-xl transition-all text-xs font-semibold border border-white/5 text-center">
                    <span>{{ __('nav_city_tours') }}</span>
                </button>
                <button type="button" data-service-modal="desert_safari" class="flex items-center justify-center text-white hover:text-gold bg-white/5 hover:bg-white/10 p-2.5 rounded-xl transition-all text-xs font-semibold border border-white/5 text-center">
                    <span>{{ __('nav_desert_safari') }}</span>
                </button>
                <button type="button" data-service-modal="tickets" class="flex items-center justify-center text-white hover:text-gold bg-white/5 hover:bg-white/10 p-2.5 rounded-xl transition-all text-xs font-semibold border border-white/5 text-center">
                    <span>{{ __('nav_tickets') }}</span>
                </button>
                <button type="button" data-service-modal="relocation" class="flex items-center justify-center text-white hover:text-gold bg-white/5 hover:bg-white/10 p-2.5 rounded-xl transition-all text-xs font-semibold border border-white/5 text-center">
                    <span>{{ __('nav_relocation') }}</span>
                </button>
                <button type="button" data-service-modal="to_buy_property" class="flex items-center justify-center text-gold bg-gold/15 hover:bg-gold hover:text-deepblack p-2.5 rounded-xl transition-all text-xs font-extrabold border border-gold/40 text-center col-span-2 sm:col-span-1 shadow-sm">
                    <span>{{ __('nav_to_buy_property') }}</span>
                </button>
            </div>

            @guest
                <div class="mt-4 pt-4 border-t border-gray-800 flex flex-col sm:flex-row gap-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl border border-gold text-gold font-bold hover:bg-gold hover:text-deepblack transition-colors text-xs">{{ __('login') }}</a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl bg-gold text-deepblack font-extrabold hover:bg-white transition-colors shadow-lg text-xs">{{ __('register') }}</a>
                </div>
            @endguest
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const hamburger = document.getElementById('hamburger-icon');
        const close = document.getElementById('close-icon');

        if (btn && menu) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                hamburger.classList.toggle('hidden');
                close.classList.toggle('hidden');
            });
        }
    });
</script>
