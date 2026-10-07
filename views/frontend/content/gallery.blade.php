@extends('layouts.app')

@section('title', 'Emirates Photo & Video Gallery | UAE Tourism')
@section('meta_description', 'Explore high-resolution photography and 4K video tours of Dubai, Abu Dhabi, Sheikh Zayed Grand Mosque, Burj Khalifa, and VIP desert safaris.')

@section('content')

    <!-- Hero Header -->
    <section class="relative bg-deepblack pb-20 pt-36 text-white overflow-hidden">
        <div class="absolute top-1/4 left-10 w-80 h-80 rounded-full bg-amber-500/15 blur-3xl pointer-events-none animate-float-slow"></div>
        <div class="absolute bottom-0 right-10 w-96 h-96 rounded-full bg-amber-600/15 blur-3xl pointer-events-none animate-float-reverse"></div>

        <div class="container mx-auto px-6 text-center relative z-10 max-w-4xl">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-4 shadow-xl">
                <span class="w-2 h-2 rounded-full bg-gold animate-ping"></span>
                High-Definition Photos & Video Tours
            </div>
            <h1 class="text-4xl font-extrabold md:text-6xl tracking-tight text-white mb-4">
                Emirates <span class="text-gradient-gold">Experience Gallery</span>
            </h1>
            <p class="mt-3 text-gray-300 text-base md:text-lg max-w-2xl mx-auto font-light leading-relaxed">
                Immersion into the extraordinary — explore HD photo albums and 4K aerial video tours from across the UAE.
            </p>

            <!-- Quick Action Tabs -->
            <div class="mt-10 flex flex-wrap justify-center items-center gap-4">
                <a href="#photos" class="bg-gold text-deepblack font-extrabold px-6 py-3 rounded-full hover:bg-white transition-all shadow-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Photo Albums
                </a>
                <a href="#videos" class="bg-white/10 backdrop-blur-md text-white font-bold px-6 py-3 rounded-full border border-white/20 hover:bg-white hover:text-deepblack transition-all shadow-md text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Video Tours
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content Body -->
    <section class="py-20 bg-offwhite">
        <div class="container mx-auto px-6 max-w-7xl">

            <!-- 1. PHOTO ALBUMS SECTION -->
            <div id="photos" class="mb-24">
                <x-section-heading>Photo Albums</x-section-heading>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @forelse($albums as $album)
                        <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100/80 group hover:shadow-2xl transition-all duration-500 flex flex-col justify-between">
                            <a href="{{ route('gallery.show', $album) }}" class="relative overflow-hidden aspect-[4/3] block">
                                <img class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-700" src="{{ $album->getFirstMediaUrl('images') ?: asset('assets/images/hero.jpg') }}" alt="{{ $album->name }}" loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                <div class="absolute top-4 right-4 bg-deepblack/80 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-gold/40 text-xs font-bold text-gold flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $album->media->count() }} Photos
                                </div>
                            </a>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-deepblack mb-2 group-hover:text-amber-700 transition-colors">
                                    <a href="{{ route('gallery.show', $album) }}">{{ $album->name }}</a>
                                </h3>
                                <p class="text-gray-500 text-sm leading-relaxed mb-6">{{ $album->description }}</p>
                                
                                <a href="{{ route('gallery.show', $album) }}" class="block text-center w-full py-3 bg-deepblack text-white font-bold text-sm rounded-xl hover:bg-gold hover:text-deepblack transition-all">
                                    View Full Album (Pinterest Grid) →
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full py-16 text-center text-gray-500">Gallery albums will be added soon.</p>
                    @endforelse
                </div>

                <div class="mt-10">
                    {{ $albums->links() }}
                </div>
            </div>

            <!-- 2. VIDEO TOURS SECTION -->
            <div id="videos">
                <x-section-heading>Immersive 4K Video Tours</x-section-heading>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    @forelse($videos as $video)
                        <div class="bg-deepblack rounded-3xl overflow-hidden shadow-2xl border border-amber-500/20 flex flex-col justify-between">
                            <div class="relative aspect-video w-full bg-black">
                                <iframe src="{{ $video->video_url }}" title="{{ $video->title }}" class="w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="p-6 text-white">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gold/20 text-gold text-xs font-bold uppercase tracking-wider mb-2">
                                    ▶ Video Tour
                                </div>
                                <h3 class="text-xl font-bold text-white">{{ $video->title }}</h3>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full py-12 text-center text-gray-500">No videos uploaded yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

@endsection
