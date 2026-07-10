@extends('layouts.app')
@section('title', 'FAQs | UAE Tourism')
@section('content')
<section class="bg-deepblack pb-14 pt-36 text-white"><div class="container mx-auto px-6"><p class="text-sm font-semibold uppercase tracking-[.2em] text-gold">Helpful answers</p><h1 class="mt-3 text-4xl font-bold">Frequently asked questions</h1></div></section><section class="py-14"><div class="container mx-auto max-w-3xl px-6 space-y-4">@forelse($faqs as $faq)<details class="rounded-xl bg-white p-5 shadow"><summary class="cursor-pointer font-bold">{{ $faq->question }}</summary><p class="mt-4 leading-relaxed text-gray-600">{{ $faq->answer }}</p></details>@empty <p class="py-16 text-center text-gray-500">No FAQs have been published yet.</p>@endforelse</div></section>
@endsection
