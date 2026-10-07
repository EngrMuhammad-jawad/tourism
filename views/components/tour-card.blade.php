@props(['name', 'priceLabel', 'image', 'url' => null])

<div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100/80 flex flex-col justify-between h-full group hover:shadow-2xl hover:border-gold/30 transition-all duration-500 transform hover:-translate-y-1.5">
    <div class="relative overflow-hidden aspect-[4/3]">
        <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        <div class="absolute top-4 right-4 bg-deepblack/80 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-gold/40">
            <span class="text-xs font-bold text-gold">{{ $priceLabel }}</span>
        </div>
    </div>
    <div class="p-6 flex flex-col flex-grow justify-between">
        <div>
            <h3 class="text-xl font-bold mb-2 text-deepblack group-hover:text-amber-700 transition-colors">{{ $name }}</h3>
            <p class="text-xs text-gray-500 font-medium mb-5">Includes Hotel Pickup, Certified Guide & Entry Pass</p>
        </div>
        <a href="{{ $url ?? route('packages.index') }}" class="block text-center w-full py-3 bg-deepblack text-white rounded-xl hover:bg-gold hover:text-deepblack transition-all duration-300 font-bold text-sm shadow-md">
            {{ __('book_now_btn') }}
        </a>
    </div>
</div>
