@props(['title'])

{{-- Full-screen auth section: hero image + dark overlay + centered card --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden py-24 px-4">
    <div class="absolute inset-0 w-full h-full">
        <div class="absolute inset-0 bg-black/60 z-10"></div>
        <img src="{{ asset('assets/images/hero.jpg') }}" alt="" class="w-full h-full object-cover object-center">
    </div>

    <div class="relative z-20 w-full max-w-md" data-aos="fade-up">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h1 class="text-2xl font-bold text-deepblack mb-1">{{ $title }}</h1>
            <div class="w-16 h-1 bg-gold rounded-full mb-6"></div>

            @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</section>
