{{-- Language switcher: swaps the locale prefix of the current URL --}}
@php
    $restOfPath = implode('/', array_slice(request()->segments(), 1));
    $query = request()->getQueryString();
@endphp
<div class="relative group">
    <button class="flex items-center gap-1 text-white hover:text-gold transition-colors focus:outline-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
        <span class="text-sm font-semibold uppercase">{{ app()->getLocale() }}</span>
    </button>
    <div class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden rtl:left-0 rtl:right-auto">
        @foreach (config('localization.supported') as $code => $meta)
            <a href="{{ url($code.($restOfPath ? '/'.$restOfPath : '')).($query ? '?'.$query : '') }}"
               class="block w-full text-left px-4 py-2 text-sm {{ $code === app()->getLocale() ? 'text-gold font-semibold' : 'text-gray-700' }} hover:bg-gold hover:text-white transition-colors rtl:text-right">
                {{ $meta['native'] }}
            </a>
        @endforeach
    </div>
</div>
