@props(['quote', 'author', 'delay' => 0])

<div class="bg-white p-8 rounded-3xl shadow-2xl border border-amber-200/50 flex flex-col justify-between text-left transform hover:-translate-y-1 transition-all duration-300" data-aos="zoom-in" data-aos-delay="{{ $delay }}">
    <div>
        <div class="flex items-center gap-1 text-gold text-lg mb-4">
            ★ ★ ★ ★ ★
        </div>
        <p class="text-gray-700 italic text-base leading-relaxed mb-6">“{{ $quote }}”</p>
    </div>
    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
        <div class="w-10 h-10 rounded-full bg-deepblack text-gold font-bold flex items-center justify-center text-sm shadow-md">
            {{ strtoupper(substr($author, 0, 1)) }}
        </div>
        <div>
            <p class="font-extrabold text-deepblack text-sm">{{ $author }}</p>
            <p class="text-xs text-amber-700 font-semibold">Verified Traveler</p>
        </div>
    </div>
</div>
