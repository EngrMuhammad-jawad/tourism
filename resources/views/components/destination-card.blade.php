@props(['name', 'tagline', 'image', 'url' => null, 'delay' => 0])

<a href="{{ $url ?? route('destinations.index') }}" class="group relative block rounded-3xl overflow-hidden shadow-2xl aspect-[3/4] cursor-pointer border border-white/10 transform hover:-translate-y-1.5 transition-all duration-500" data-aos="fade-up" data-aos-delay="{{ $delay }}">
    <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
    <div class="absolute inset-0 bg-gradient-to-t from-deepblack/90 via-black/30 to-transparent"></div>
    <div class="absolute top-4 left-4">
        <span class="text-[10px] font-extrabold uppercase tracking-widest text-deepblack bg-gold px-3 py-1 rounded-full shadow-md">Emirate</span>
    </div>
    <div class="absolute bottom-0 left-0 right-0 p-6 rtl:right-0 rtl:left-auto">
        <h3 class="text-2xl font-extrabold text-white mb-1 group-hover:text-gold transition-colors">{{ $name }}</h3>
        <p class="text-gray-300 text-xs leading-relaxed line-clamp-2 font-medium">{{ $tagline }}</p>
        <span class="inline-flex items-center gap-1 text-gold text-xs font-bold mt-3 group-hover:underline">Explore Destination →</span>
    </div>
</a>
