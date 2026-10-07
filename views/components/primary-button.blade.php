<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full py-3 px-6 bg-deepblack text-white rounded-lg hover:bg-gold hover:text-deepblack transition-colors font-semibold shadow']) }}>
    {{ $slot }}
</button>
