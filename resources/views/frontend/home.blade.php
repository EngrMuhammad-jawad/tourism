@extends('layouts.app')

@section('title', 'UAE Tourism | Luxury Travel')
@section('meta_description', __('hero_subtitle'))

@section('content')

    <!-- Hero Section -->
    <section id="home" class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 w-full h-full">
            <div class="absolute inset-0 bg-black bg-opacity-50 z-10"></div>
            <img src="{{ asset('assets/images/hero.jpg') }}" alt="Dubai Skyline" class="w-full h-full object-cover object-center" />
        </div>

        <div class="relative z-20 text-center px-4" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 text-shadow">{{ __('hero_title') }}</h1>
            <p class="text-lg md:text-2xl text-gray-200 mb-10 max-w-3xl mx-auto font-light text-shadow">{{ __('hero_subtitle') }}</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#explore" class="bg-gold text-deepblack font-semibold px-8 py-4 rounded-full hover:bg-white transition-colors duration-300 text-lg shadow-lg">{{ __('explore_btn') }}</a>
                <a href="#tours" class="glass text-white font-semibold px-8 py-4 rounded-full hover:bg-white hover:text-deepblack transition-colors duration-300 text-lg shadow-lg">{{ __('book_now_btn') }}</a>
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
                        :delay="($loop->iteration) * 100"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Experiences Section -->
    <section class="py-24 bg-deepblack text-white">
        <div class="container mx-auto px-6">
            <x-section-heading light>{{ __('experiences_title') }}</x-section-heading>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 mx-auto bg-gold rounded-full flex items-center justify-center mb-6 text-deepblack">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">{{ __('exp_desert') }}</h3>
                    <p class="text-gray-400">{{ __('exp_desert_desc') }}</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 mx-auto bg-gold rounded-full flex items-center justify-center mb-6 text-deepblack">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">{{ __('exp_luxury') }}</h3>
                    <p class="text-gray-400">{{ __('exp_luxury_desc') }}</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-20 h-20 mx-auto bg-gold rounded-full flex items-center justify-center mb-6 text-deepblack">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">{{ __('exp_culture') }}</h3>
                    <p class="text-gray-400">{{ __('exp_culture_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trending Tours Carousel -->
    <section id="tours" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <x-section-heading>{{ __('trending_tours') }}</x-section-heading>

            <!-- Swiper -->
            <div class="swiper tourSwiper pb-12" data-aos="fade-up" data-aos-delay="200">
                <div class="swiper-wrapper">
                    @foreach ($tours as $tour)
                        <div class="swiper-slide">
                            <x-tour-card
                                :name="$tour['name']"
                                :price-label="$tour['price_label']"
                                :image="$tour['image']"
                            />
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-8"></div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-24 bg-gold">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-white mb-16" data-aos="fade-up">{{ __('testimonials') }}</h2>
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
