@extends('layouts.app')

@section('title', e($album->name) . ' | Photo & Video Album')
@section('meta_description', e($album->description) . ' View high-resolution photos and video tours in our luxury UAE gallery.')
@section('og_image', $album->getFirstMediaUrl('images') ?: asset('assets/images/hero.jpg'))

@section('content')

    <!-- Hero Header -->
    <section class="relative bg-deepblack pb-16 pt-36 text-white overflow-hidden">
        <div class="absolute top-1/4 left-10 w-80 h-80 rounded-full bg-amber-500/15 blur-3xl pointer-events-none animate-float-slow"></div>
        <div class="absolute bottom-0 right-10 w-96 h-96 rounded-full bg-amber-600/15 blur-3xl pointer-events-none animate-float-reverse"></div>

        <div class="container mx-auto px-6 relative z-10 max-w-5xl">
            <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 text-gold hover:text-white transition-colors text-sm font-bold mb-6">
                ← Back to All Albums
            </a>
            
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-3">
                        📷 {{ $album->media->count() }} High-Res Photos
                    </div>
                    <h1 class="text-3xl font-extrabold md:text-5xl tracking-tight text-white mb-2">
                        {{ $album->name }}
                    </h1>
                    <p class="text-gray-300 text-base md:text-lg font-light max-w-2xl">
                        {{ $album->description }}
                    </p>
                </div>

                <a href="#pinterest-grid" class="bg-gold text-deepblack font-extrabold px-6 py-3 rounded-full hover:bg-white transition-all shadow-lg text-sm flex-shrink-0">
                    View Pinterest Grid ↓
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content Section: Pinterest-Style Masonry Grid -->
    <section id="pinterest-grid" class="py-16 bg-offwhite min-h-[60vh]">
        <div class="container mx-auto px-6 max-w-7xl">

            @if($album->media->isEmpty())
                <div class="py-24 text-center">
                    <p class="text-gray-500 text-lg">No photos found in this album yet.</p>
                    <a href="{{ route('gallery.index') }}" class="mt-4 inline-block bg-deepblack text-white px-6 py-3 rounded-xl text-sm font-bold">Return to Gallery</a>
                </div>
            @else
                <!-- Pinterest-Style Masonry Columns Grid -->
                <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-6 space-y-6">
                    @foreach($album->media as $index => $photo)
                        <div class="break-inside-avoid bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100/80 group hover:shadow-2xl transition-all duration-500 relative transform hover:-translate-y-1">
                            <a href="{{ $photo->getUrl() }}" target="_blank" class="block relative overflow-hidden group">
                                <img src="{{ $photo->getUrl() }}" alt="{{ $album->name }} Photo {{ $index + 1 }}" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-700 loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-deepblack/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
                                    <div class="text-white">
                                        <span class="text-xs font-bold text-gold uppercase tracking-wider block mb-1">High Resolution</span>
                                        <p class="text-sm font-bold leading-tight">{{ $album->name }} — Photo #{{ $index + 1 }}</p>
                                        <span class="inline-flex items-center gap-1 text-xs text-amber-300 font-semibold mt-2">Click to Open Full View ↗</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Album Video Embeds (If Any) -->
            @if(isset($videos) && $videos->isNotEmpty())
                <div class="mt-20 pt-16 border-t border-gray-200">
                    <h2 class="text-3xl font-extrabold text-deepblack mb-8 flex items-center gap-3">
                        <span class="w-2 h-8 bg-gold rounded-full"></span>
                        Album Video Highlights
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($videos as $video)
                            <div class="bg-deepblack rounded-3xl overflow-hidden shadow-2xl border border-amber-500/20">
                                <div class="aspect-video w-full bg-black">
                                    <iframe src="{{ $video->video_url }}" title="{{ $video->title }}" class="w-full h-full border-0" allowfullscreen></iframe>
                                </div>
                                <div class="p-5 text-white">
                                    <h3 class="font-bold text-base text-white">{{ $video->title }}</h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection
