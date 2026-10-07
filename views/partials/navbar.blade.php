<!-- Navigation Header -->
<header id="navbar-header" class="fixed w-full z-50 transition-all duration-300 top-0 left-0">
    <nav class="bg-deepblack/90 backdrop-blur-xl border-b border-gold/20 shadow-2xl py-3.5 px-4 sm:px-8">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="text-2xl font-extrabold text-white tracking-wider flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gold/20 border border-gold/40 flex items-center justify-center group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="font-extrabold text-white text-xl">UAE<span class="text-gradient-gold">Tourism</span></span>
            </a>

            <!-- Desktop Navigation Links (Visible on md screens and up) -->
            <div class="hidden md:flex items-center gap-5 lg:gap-7 rtl:space-x-reverse">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-gold font-bold border-b-2 border-gold pb-0.5' : 'text-gray-200 hover:text-gold font-medium' }} transition-colors text-sm">{{ __('nav_home') }}</a>
                <a href="{{ route('destinations.index') }}" class="{{ request()->routeIs('destinations.*') ? 'text-gold font-bold border-b-2 border-gold pb-0.5' : 'text-gray-200 hover:text-gold font-medium' }} transition-colors text-sm">Destinations</a>
                <a href="{{ route('packages.index') }}" class="{{ request()->routeIs('packages.*') ? 'text-gold font-bold border-b-2 border-gold pb-0.5' : 'text-gray-200 hover:text-gold font-medium' }} transition-colors text-sm">Packages</a>
                <a href="{{ route('hotels.index') }}" class="{{ request()->routeIs('hotels.*') ? 'text-gold font-bold border-b-2 border-gold pb-0.5' : 'text-gray-200 hover:text-gold font-medium' }} transition-colors text-sm">Hotels</a>
                <a href="{{ route('transports.index') }}" class="{{ request()->routeIs('transports.*') ? 'text-gold font-bold border-b-2 border-gold pb-0.5' : 'text-gray-200 hover:text-gold font-medium' }} transition-colors text-sm">Transport</a>
                <a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.*') ? 'text-gold font-bold border-b-2 border-gold pb-0.5' : 'text-gray-200 hover:text-gold font-medium' }} transition-colors text-sm">Gallery</a>
                <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'text-gold font-bold border-b-2 border-gold pb-0.5' : 'text-gray-200 hover:text-gold font-medium' }} transition-colors text-sm">Blog</a>
                <a href="{{ route('contact.create') }}" class="{{ request()->routeIs('contact.*') ? 'text-gold font-bold border-b-2 border-gold pb-0.5' : 'text-gray-200 hover:text-gold font-medium' }} transition-colors text-sm">Contact</a>
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

                <!-- Mobile Hamburger Toggle Button -->
                <button id="mobile-menu-btn" type="button" class="md:hidden text-white hover:text-gold focus:outline-none p-1.5 rounded-lg border border-white/20" aria-label="Toggle Mobile Menu">
                    <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobile-menu" class="hidden md:hidden bg-deepblack/95 backdrop-blur-2xl border-t border-gold/20 px-6 py-6 mt-3 rounded-2xl shadow-2xl transition-all duration-300">
            <div class="flex flex-col space-y-3.5">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-gold font-bold bg-white/5 px-4 py-2.5 rounded-xl' : 'text-white hover:text-gold px-4 py-2.5' }} transition-colors text-base font-medium">{{ __('nav_home') }}</a>
                <a href="{{ route('destinations.index') }}" class="{{ request()->routeIs('destinations.*') ? 'text-gold font-bold bg-white/5 px-4 py-2.5 rounded-xl' : 'text-white hover:text-gold px-4 py-2.5' }} transition-colors text-base font-medium">Destinations</a>
                <a href="{{ route('packages.index') }}" class="{{ request()->routeIs('packages.*') ? 'text-gold font-bold bg-white/5 px-4 py-2.5 rounded-xl' : 'text-white hover:text-gold px-4 py-2.5' }} transition-colors text-base font-medium">Tour Packages</a>
                <a href="{{ route('hotels.index') }}" class="{{ request()->routeIs('hotels.*') ? 'text-gold font-bold bg-white/5 px-4 py-2.5 rounded-xl' : 'text-white hover:text-gold px-4 py-2.5' }} transition-colors text-base font-medium">Luxury Hotels</a>
                <a href="{{ route('transports.index') }}" class="{{ request()->routeIs('transports.*') ? 'text-gold font-bold bg-white/5 px-4 py-2.5 rounded-xl' : 'text-white hover:text-gold px-4 py-2.5' }} transition-colors text-base font-medium">Transport</a>
                <a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.*') ? 'text-gold font-bold bg-white/5 px-4 py-2.5 rounded-xl' : 'text-white hover:text-gold px-4 py-2.5' }} transition-colors text-base font-medium">Gallery</a>
                <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'text-gold font-bold bg-white/5 px-4 py-2.5 rounded-xl' : 'text-white hover:text-gold px-4 py-2.5' }} transition-colors text-base font-medium">Travel Blog</a>
                <a href="{{ route('contact.create') }}" class="{{ request()->routeIs('contact.*') ? 'text-gold font-bold bg-white/5 px-4 py-2.5 rounded-xl' : 'text-white hover:text-gold px-4 py-2.5' }} transition-colors text-base font-medium">Contact Us</a>
                @guest
                    <div class="pt-4 border-t border-gray-800 flex flex-col gap-3">
                        <a href="{{ route('login') }}" class="w-full text-center py-3 rounded-xl border border-gold text-gold font-bold hover:bg-gold hover:text-deepblack transition-colors">{{ __('login') }}</a>
                        <a href="{{ route('register') }}" class="w-full text-center py-3 rounded-xl bg-gold text-deepblack font-extrabold hover:bg-white transition-colors shadow-lg">{{ __('register') }}</a>
                    </div>
                @endguest
            </div>
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
