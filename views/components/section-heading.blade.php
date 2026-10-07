@props(['light' => false])

<div {{ $attributes->merge(['class' => 'text-center mb-16']) }} data-aos="fade-up">
    <h2 class="text-4xl font-bold mb-4 {{ $light ? '' : 'text-deepblack' }}">{{ $slot }}</h2>
    <div class="w-24 h-1 bg-gold mx-auto rounded-full"></div>
</div>
