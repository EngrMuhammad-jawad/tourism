@props(['name', 'tagline', 'image', 'url' => null, 'delay' => 0])

<a href="{{ $url ?? '#' }}" class="group relative block rounded-2xl overflow-hidden shadow-xl aspect-[3/4] cursor-pointer" data-aos="fade-up" data-aos-delay="{{ $delay }}">
    <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
    <div class="absolute bottom-0 left-0 p-6 rtl:right-0 rtl:left-auto">
        <h3 class="text-2xl font-bold text-white mb-2">{{ $name }}</h3>
        <p class="text-gray-300 text-sm">{{ $tagline }}</p>
    </div>
</a>
