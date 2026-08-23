@extends('layouts.app')

@section('title', 'Frequently Asked Questions | UAE Tourism')
@section('meta_description', 'Find answers to common questions about traveling, visas, booking tour packages, and luxury stays in the United Arab Emirates.')

@section('content')
<section class="bg-deepblack pb-16 pt-36 text-white">
    <div class="container mx-auto px-6 text-center">
        <p class="text-xs font-bold uppercase tracking-[.25em] text-gold mb-2">Helpful answers</p>
        <h1 class="text-4xl font-bold md:text-5xl">Frequently Asked Questions</h1>
        <p class="mt-3 text-gray-400 max-w-xl mx-auto">Everything you need to know about planning your luxury experience in the UAE.</p>
    </div>
</section>

<section class="py-16 bg-offwhite">
    <div class="container mx-auto max-w-3xl px-6 space-y-5">
        @forelse($faqs as $faq)
            <details class="group rounded-2xl bg-white p-6 shadow-md border border-gray-100 transition-all duration-300">
                <summary class="cursor-pointer font-bold text-lg text-deepblack flex justify-between items-center group-open:text-gold transition-colors">
                    <span>{{ $faq->question }}</span>
                    <span class="ml-4 transition-transform group-open:rotate-180 text-gold">▼</span>
                </summary>
                <p class="mt-4 leading-relaxed text-gray-600 border-t border-gray-100 pt-4">{{ $faq->answer }}</p>
            </details>
        @empty
            <p class="py-16 text-center text-gray-500">No FAQs have been published yet.</p>
        @endforelse
    </div>
</section>

@if($faqs->isNotEmpty())
<!-- Schema.org FAQPage JSON-LD -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    @foreach($faqs as $index => $faq)
    {
      "@type": "Question",
      "name": "{{ e($faq->question) }}",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "{{ e($faq->answer) }}"
      }
    }{{ $index < count($faqs) - 1 ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endif
@endsection
