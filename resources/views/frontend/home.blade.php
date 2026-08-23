@extends('layouts.app')

@section('title', 'UAE Tourism | Luxury Travel, Desert Safaris & VIP Experiences')
@section('meta_description', __('hero_subtitle'))

@section('content')

    <!-- Hero Section with Animated Light Glow -->
    <section id="home" class="relative min-h-[90vh] flex items-center justify-center overflow-hidden pt-28 pb-16">
        <!-- Hero Background Image + Overlay -->
        <div class="absolute inset-0 w-full h-full">
            <div class="absolute inset-0 bg-gradient-to-t from-deepblack via-black/60 to-black/40 z-10"></div>
            <img src="{{ asset('assets/images/hero.jpg') }}" alt="Dubai Skyline & Luxury Travel" class="w-full h-full object-cover object-center" loading="eager" />
        </div>

        <!-- Animated Background Light Orbs -->
        <div class="absolute top-1/4 left-10 w-96 h-96 rounded-full bg-amber-500/20 blur-3xl z-10 pointer-events-none animate-float-slow"></div>
        <div class="absolute bottom-10 right-10 w-[30rem] h-[30rem] rounded-full bg-amber-400/15 blur-3xl z-10 pointer-events-none animate-float-reverse"></div>

        <div class="relative z-20 text-center px-4 max-w-5xl mx-auto" data-aos="fade-up" data-aos-duration="1000">
            <!-- Animated Luxury Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/60 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-6 shadow-xl">
                <span class="w-2 h-2 rounded-full bg-gold animate-ping"></span>
                Exquisite Journeys in the United Arab Emirates
            </div>

            <!-- Main Heading with Gold Gradient -->
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-black text-white mb-6 tracking-tight leading-tight text-shadow-lg">
                Experience Unrivaled <br class="hidden sm:inline" />
                <span class="text-gradient-gold">Luxury & Heritage</span>
            </h1>

            <p class="text-lg md:text-2xl text-gray-200 mb-10 max-w-3xl mx-auto font-light text-shadow">
                {{ __('hero_subtitle') }}
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-14">
                <a href="{{ route('packages.index') }}" class="bg-gold text-deepblack font-extrabold px-8 py-4 rounded-full hover:bg-white transition-all duration-300 text-lg shadow-2xl transform hover:-translate-y-1">
                    {{ __('explore_btn') }}
                </a>
                <a href="{{ route('destinations.index') }}" class="bg-black/60 backdrop-blur-md text-white font-bold px-8 py-4 rounded-full hover:bg-white hover:text-deepblack transition-all duration-300 text-lg shadow-xl border border-white/30 transform hover:-translate-y-1">
                    {{ __('book_now_btn') }}
                </a>
            </div>

            <!-- Quick Booking Search Bar -->
            <div class="bg-deepblack/85 backdrop-blur-2xl rounded-3xl p-5 sm:p-7 border border-gold/30 shadow-2xl max-w-4xl mx-auto text-left">
                <form method="GET" action="{{ route('packages.index') }}" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-bold text-gold uppercase tracking-wider mb-1.5">Destination</label>
                        <select name="destination" class="w-full rounded-xl bg-white/10 border border-white/20 text-white text-sm p-3.5 focus:outline-none focus:border-gold">
                            <option value="" class="text-deepblack">All Emirates</option>
                            @foreach($destinations as $d)
                                <option value="{{ $d['name'] }}" class="text-deepblack">{{ $d['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gold uppercase tracking-wider mb-1.5">Max Price ($)</label>
                        <input type="number" name="max_price" placeholder="e.g. 500" class="w-full rounded-xl bg-white/10 border border-white/20 text-white placeholder-gray-400 text-sm p-3.5 focus:outline-none focus:border-gold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gold uppercase tracking-wider mb-1.5">Duration</label>
                        <select name="duration" class="w-full rounded-xl bg-white/10 border border-white/20 text-white text-sm p-3.5 focus:outline-none focus:border-gold">
                            <option value="" class="text-deepblack">Any Duration</option>
                            <option value="1" class="text-deepblack">1 Day Experience</option>
                            <option value="3" class="text-deepblack">3 Days Trip</option>
                            <option value="7" class="text-deepblack">7 Days Package</option>
                        </select>
                    </div>
                    <div class="sm:col-span-3 lg:col-span-1">
                        <button type="submit" class="w-full bg-gold text-deepblack font-extrabold py-3.5 px-6 rounded-xl hover:bg-white transition-all text-sm shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Search Tours
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Sleek Single-Row Horizontal Stats Counter Banner -->
    <section class="bg-deepblack border-y border-gold/20 py-8 relative">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="bg-gradient-to-r from-gray-900/90 via-deepblack to-gray-900/90 border border-gold/30 rounded-2xl py-6 px-6 shadow-2xl backdrop-blur-xl">
                <div style="display: flex; flex-direction: row; flex-wrap: wrap; items-center; justify-content: space-around; width: 100%; gap: 1rem;" class="stats-banner-container">
                    <div style="flex: 1; min-width: 140px; border-right: 1px solid rgba(255,255,255,0.15);" class="text-center px-4 py-2 stats-item-divider" data-aos="fade-up" data-aos-delay="100">
                        <p class="text-3xl lg:text-4xl font-extrabold text-gold tracking-tight">10,000+</p>
                        <p class="text-gray-200 text-xs font-bold uppercase tracking-wider mt-1">Happy Guests Hosted</p>
                    </div>
                    <div style="flex: 1; min-width: 140px; border-right: 1px solid rgba(255,255,255,0.15);" class="text-center px-4 py-2 stats-item-divider" data-aos="fade-up" data-aos-delay="200">
                        <p class="text-3xl lg:text-4xl font-extrabold text-gold tracking-tight">99.4%</p>
                        <p class="text-gray-200 text-xs font-bold uppercase tracking-wider mt-1">Satisfaction Rating</p>
                    </div>
                    <div style="flex: 1; min-width: 140px; border-right: 1px solid rgba(255,255,255,0.15);" class="text-center px-4 py-2 stats-item-divider" data-aos="fade-up" data-aos-delay="300">
                        <p class="text-3xl lg:text-4xl font-extrabold text-gold tracking-tight">50+</p>
                        <p class="text-gray-200 text-xs font-bold uppercase tracking-wider mt-1">Curated Experiences</p>
                    </div>
                    <div style="flex: 1; min-width: 140px;" class="text-center px-4 py-2" data-aos="fade-up" data-aos-delay="400">
                        <p class="text-3xl lg:text-4xl font-extrabold text-gold tracking-tight">24/7</p>
                        <p class="text-gray-200 text-xs font-bold uppercase tracking-wider mt-1">VIP Concierge</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Destinations -->
    <section id="explore" class="py-24 bg-offwhite">
        <div class="container mx-auto px-6">
            <x-section-heading>{{ __('featured_destinations') }}</x-section-heading>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($destinations as $destination)
                    <x-destination-card
                        :name="$destination['name']"
                        :tagline="$destination['tagline']"
                        :image="$destination['image']"
                        :url="$destination['url']"
                        :delay="($loop->iteration) * 100"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Experiences Section -->
    <section class="py-24 bg-deepblack text-white relative overflow-hidden">
        <div class="absolute -top-20 right-0 w-80 h-80 rounded-full bg-amber-500/10 blur-3xl pointer-events-none animate-pulse-glow"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full bg-amber-600/10 blur-3xl pointer-events-none animate-pulse-glow"></div>

        <div class="container mx-auto px-6 relative z-10">
            <x-section-heading light>{{ __('experiences_title') }}</x-section-heading>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-gray-900/80 rounded-3xl p-8 border border-white/10 hover:border-gold/50 transition-all duration-500 transform hover:-translate-y-2 group shadow-xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-gold/20 border border-gold/40 rounded-2xl flex items-center justify-center mb-6 text-gold group-hover:bg-gold group-hover:text-deepblack transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-white">{{ __('exp_desert') }}</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">{{ __('exp_desert_desc') }}</p>
                </div>

                <div class="bg-gray-900/80 rounded-3xl p-8 border border-white/10 hover:border-gold/50 transition-all duration-500 transform hover:-translate-y-2 group shadow-xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-gold/20 border border-gold/40 rounded-2xl flex items-center justify-center mb-6 text-gold group-hover:bg-gold group-hover:text-deepblack transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-white">{{ __('exp_luxury') }}</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">{{ __('exp_luxury_desc') }}</p>
                </div>

                <div class="bg-gray-900/80 rounded-3xl p-8 border border-white/10 hover:border-gold/50 transition-all duration-500 transform hover:-translate-y-2 group shadow-xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-gold/20 border border-gold/40 rounded-2xl flex items-center justify-center mb-6 text-gold group-hover:bg-gold group-hover:text-deepblack transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-white">{{ __('exp_culture') }}</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">{{ __('exp_culture_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trending Tours Grid -->
    <section id="tours" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <x-section-heading>{{ __('trending_tours') }}</x-section-heading>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8" data-aos="fade-up">
                @foreach ($tours as $tour)
                    <x-tour-card
                        :name="$tour['name']"
                        :price-label="$tour['price_label']"
                        :image="$tour['image']"
                        :url="$tour['url']"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 bg-gradient-to-b from-gray-900 via-deepblack to-gray-900 border-t border-amber-500/20 text-white relative overflow-hidden">
        <div class="container mx-auto px-6 text-center relative z-10">
            <span class="text-xs font-extrabold uppercase tracking-widest text-gold mb-2 block">Real Traveler Experiences</span>
            <h2 class="text-4xl font-extrabold text-white mb-16" data-aos="fade-up">{{ __('testimonials') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @foreach ($testimonials as $testimonial)
                    <x-testimonial-card
                        :quote="$testimonial['quote']"
                        :author="$testimonial['author']"
                        :delay="($loop->iteration) * 100"
                    />
                @endforeach
            </div>
        </div>
    </section>

@endsection
