<!-- Navigation -->
<nav id="navbar" class="fixed w-full z-50 transition-all duration-300 py-4 glass-dark">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-white tracking-wider flex items-center gap-2">
            <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            UAE<span class="text-gold">Tourism</span>
        </a>

        <div class="hidden md:flex items-center space-x-8 rtl:space-x-reverse">
            <a href="{{ route('home') }}#home" class="text-white hover:text-gold transition-colors font-medium">{{ __('nav_home') }}</a>
            <a href="{{ route('home') }}#explore" class="text-white hover:text-gold transition-colors font-medium">{{ __('nav_explore') }}</a>
            <a href="{{ route('home') }}#tours" class="text-white hover:text-gold transition-colors font-medium">{{ __('nav_tours') }}</a>
            <a href="{{ route('home') }}#hotels" class="text-white hover:text-gold transition-colors font-medium">{{ __('nav_hotels') }}</a>
        </div>

        <div class="flex items-center gap-4">
            @include('partials.lang-switcher')

            @auth
                <div class="relative group">
                    <button class="flex items-center gap-1 text-white hover:text-gold transition-colors focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-sm font-semibold hidden sm:inline">{{ auth()->user()->name }}</span>
                    </button>
                    <div class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden rtl:left-0 rtl:right-auto">
                        @can('dashboard.view')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gold hover:text-white transition-colors rtl:text-right">Admin dashboard</a>
                        @endcan
                        <a href="{{ route('account.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gold hover:text-white transition-colors rtl:text-right">{{ __('my_account') }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gold hover:text-white transition-colors rtl:text-right">{{ __('logout') }}</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="hidden sm:inline text-white hover:text-gold transition-colors font-medium text-sm">{{ __('login') }}</a>
                <a href="{{ route('register') }}" class="bg-gold text-deepblack font-semibold px-4 py-2 rounded-full hover:bg-white transition-colors text-sm">{{ __('register') }}</a>
            @endauth
        </div>
    </div>
</nav>
