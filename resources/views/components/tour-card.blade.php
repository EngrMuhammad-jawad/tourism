@props(['name', 'priceLabel', 'image', 'url' => null])

<div class="bg-offwhite rounded-2xl overflow-hidden shadow-lg border border-gray-100">
    <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-full h-64 object-cover">
    <div class="p-6">
        <h3 class="text-xl font-bold mb-2 text-deepblack">{{ $name }}</h3>
        <p class="text-gold font-semibold text-lg mb-4">{{ $priceLabel }}</p>
        <a href="{{ $url ?? '#' }}" class="block text-center w-full py-3 bg-deepblack text-white rounded-lg hover:bg-gold transition-colors font-medium">{{ __('book_now_btn') }}</a>
    </div>
</div>
