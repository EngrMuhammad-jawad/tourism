@props(['quote', 'author', 'delay' => 0])

<div class="bg-white p-8 rounded-2xl shadow-xl" data-aos="zoom-in" data-aos-delay="{{ $delay }}">
    <p class="text-xl text-gray-700 italic mb-4">{{ $quote }}</p>
    <p class="font-bold text-deepblack">{{ $author }}</p>
</div>
