<!-- Footer -->
<footer class="bg-deepblack text-white pt-16 pb-8 border-t border-gray-800">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <div>
                <h4 class="text-2xl font-bold mb-4 text-gold">{{ __('footer_about') }}</h4>
                <p class="text-gray-400">{{ __('footer_about_text') }}</p>
            </div>
            <div>
                <h4 class="text-xl font-bold mb-4">{{ __('footer_links') }}</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}#home" class="text-gray-400 hover:text-gold transition">{{ __('nav_home') }}</a></li>
                    <li><a href="{{ route('home') }}#explore" class="text-gray-400 hover:text-gold transition">{{ __('nav_explore') }}</a></li>
                    <li><a href="{{ route('home') }}#tours" class="text-gray-400 hover:text-gold transition">{{ __('nav_tours') }}</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xl font-bold mb-4">{{ __('footer_contact') }}</h4>
                <p class="text-gray-400">info@uaetourism.example.com</p>
                <p class="text-gray-400">+971 4 123 4567</p>
            </div>
        </div>
        <div class="text-center pt-8 border-t border-gray-800 text-gray-500 text-sm">
            <p>{{ __('footer_rights') }}</p>
        </div>
    </div>
</footer>
