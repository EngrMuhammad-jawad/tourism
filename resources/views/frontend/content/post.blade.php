@extends('layouts.app')
@section('title', $post->meta_title ?: $post->title)
@section('meta_description', $post->meta_description ?: $post->excerpt)

@section('content')
<main class="min-h-screen bg-slate-50 pt-28 pb-20 text-slate-800">
    {{-- Breadcrumb Navigation --}}
    <nav class="border-b border-slate-200 bg-white py-3 shadow-xs" aria-label="Breadcrumb">
        <div class="container mx-auto max-w-6xl px-4 sm:px-6">
            <ol class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-slate-500">
                <li>
                    <a href="{{ route('home') }}" class="transition hover:text-gold flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>{{ __('Home') }}</span>
                    </a>
                </li>
                <li class="text-slate-300">/</li>
                <li>
                    <a href="{{ route('posts.index') }}" class="transition hover:text-gold">{{ __('Travel Guides & Journal') }}</a>
                </li>
                @if($post->category)
                    <li class="text-slate-300">/</li>
                    <li>
                        <span class="text-slate-600 font-medium">{{ $post->category->name }}</span>
                    </li>
                @endif
                <li class="text-slate-300">/</li>
                <li class="truncate max-w-[200px] sm:max-w-xs text-slate-900 font-medium" aria-current="page">
                    {{ $post->title }}
                </li>
            </ol>
        </div>
    </nav>

    {{-- Article Container --}}
    <div class="container mx-auto max-w-6xl px-4 sm:px-6 mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- Main Article Content Column (8 cols) --}}
            <article class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-slate-100">
                {{-- Category & Meta Header --}}
                <div class="flex flex-wrap items-center gap-3 text-xs sm:text-sm text-slate-500 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-gold border border-amber-200">
                        {{ $post->category?->name ?? 'Dubai Travel Guide' }}
                    </span>
                    <span>•</span>
                    <time datetime="{{ $post->published_at?->toIso8601String() ?? now()->toIso8601String() }}">
                        {{ $post->published_at?->format('F d, Y') ?? now()->format('F d, Y') }}
                    </time>
                    <span>•</span>
                    @php
                        $wordCount = str_word_count(strip_tags((string) $post->content));
                        $readingTime = max(1, (int) ceil($wordCount / 200));
                    @endphp
                    <span class="flex items-center gap-1">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $readingTime }} min read
                    </span>
                </div>

                {{-- Primary H1 Heading --}}
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $post->title }}
                </h1>

                {{-- Author Byline --}}
                <div class="flex items-center gap-3 mt-5 pb-6 border-b border-slate-100">
                    <div class="h-10 w-10 rounded-full bg-slate-900 text-gold font-bold flex items-center justify-center text-sm shadow-inner">
                        DTB
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">{{ $post->author?->name ?? 'DubaiTourBook Editorial Team' }}</p>
                        <p class="text-xs text-slate-500">Verified UAE Tourism & Destination Specialists</p>
                    </div>
                </div>

                {{-- Featured Hero Image --}}
                <div class="mt-6 overflow-hidden rounded-2xl shadow-md bg-slate-100">
                    <img 
                        src="{{ $post->getFirstMediaUrl('featured') ?: asset('assets/images/tour_burj.jpg') }}" 
                        alt="{{ $post->title }}"
                        width="1200" 
                        height="630"
                        fetchpriority="high"
                        class="w-full h-72 sm:h-96 object-cover transition duration-300 hover:scale-105"
                    >
                </div>

                {{-- Lead Excerpt --}}
                @if($post->excerpt)
                    <div class="mt-8 p-5 bg-amber-50/60 rounded-2xl border-l-4 border-gold text-slate-700 font-medium text-base sm:text-lg leading-relaxed">
                        {{ $post->excerpt }}
                    </div>
                @endif

                {{-- Article Body Content --}}
                <div class="mt-8 prose prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-p:leading-8 prose-p:text-slate-700 prose-a:text-gold prose-a:font-semibold prose-a:no-underline hover:prose-a:underline prose-img:rounded-xl">
                    {!! nl2br(e($post->content)) !!}
                </div>

                {{-- Tags --}}
                @if($post->tags->isNotEmpty())
                    <div class="mt-10 pt-6 border-t border-slate-100 flex flex-wrap items-center gap-2">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mr-2">{{ __('Tags') }}:</span>
                        @foreach($post->tags as $tag)
                            <span class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-medium transition">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Social Share Section --}}
                <div class="mt-8 p-5 bg-slate-50 rounded-2xl flex flex-wrap items-center justify-between gap-4 border border-slate-200/60">
                    <span class="text-sm font-bold text-slate-800">{{ __('Share this Dubai Travel Guide') }}:</span>
                    <div class="flex items-center gap-2">
                        @php
                            $shareUrl = urlencode(url()->current());
                            $shareTitle = urlencode($post->title);
                        @endphp
                        {{-- WhatsApp Share --}}
                        <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#25D366] text-white rounded-lg text-xs font-semibold hover:bg-opacity-90 transition shadow-xs">
                            WhatsApp
                        </a>
                        {{-- Twitter/X Share --}}
                        <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-black text-white rounded-lg text-xs font-semibold hover:bg-opacity-90 transition shadow-xs">
                            X / Twitter
                        </a>
                        {{-- Facebook Share --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#1877F2] text-white rounded-lg text-xs font-semibold hover:bg-opacity-90 transition shadow-xs">
                            Facebook
                        </a>
                        {{-- Copy Link Button --}}
                        <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('URL copied to clipboard!');" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-xs font-semibold hover:bg-slate-100 transition shadow-xs">
                            {{ __('Copy Link') }}
                        </button>
                    </div>
                </div>

                {{-- Author Bio Card --}}
                <div class="mt-8 p-6 bg-slate-900 text-white rounded-2xl shadow-md flex flex-col sm:flex-row items-center gap-5">
                    <div class="h-16 w-16 rounded-full bg-gradient-to-tr from-gold to-amber-200 text-slate-900 font-extrabold flex items-center justify-center text-xl shrink-0 shadow-lg">
                        DTB
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-white">About the DubaiTourBook Editorial Team</h4>
                        <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                            DubaiTourBook is a premier UAE travel concierge and tour operator licensed in Dubai. Our team of certified tourism experts, desert safari guides, and luxury planners curates first-hand guides, real ticket advice, and VIP itineraries for international travelers.
                        </p>
                    </div>
                </div>

                {{-- Comments Section --}}
                <section class="mt-12 pt-8 border-t border-slate-100">
                    <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                        <span>{{ __('Comments') }}</span>
                        <span class="text-sm font-semibold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full">
                            {{ $post->comments->whereNull('parent_id')->count() }}
                        </span>
                    </h2>

                    @forelse($post->comments->whereNull('parent_id') as $comment)
                        <div class="mt-5 rounded-2xl bg-slate-50 p-5 border border-slate-100">
                            <div class="flex items-center justify-between">
                                <p class="font-bold text-sm text-slate-900">{{ $comment->displayName() }}</p>
                                <span class="text-xs text-slate-400">{{ $comment->created_at?->diffForHumans() }}</span>
                            </div>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ $comment->body }}</p>
                        </div>
                    @empty
                        <p class="mt-4 text-sm text-slate-400 italic">{{ __('No comments yet. Be the first to share your thoughts!') }}</p>
                    @endforelse

                    @auth
                        <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="mt-8">
                            @csrf
                            <label for="comment-body" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">{{ __('Add a thoughtful comment') }}</label>
                            <textarea id="comment-body" required name="body" rows="4" class="w-full rounded-xl border border-slate-300 p-4 text-sm focus:border-gold focus:ring-1 focus:ring-gold" placeholder="Share your experience or ask a question about this Dubai destination..."></textarea>
                            <button type="submit" class="mt-3 rounded-xl bg-slate-900 px-6 py-3 text-sm font-bold text-white hover:bg-gold hover:text-slate-900 transition shadow-sm">
                                {{ __('Post Comment') }}
                            </button>
                        </form>
                    @else
                        <div class="mt-8 p-4 bg-slate-100 rounded-xl text-center text-xs sm:text-sm text-slate-600">
                            <span>{{ __('Please') }}</span>
                            <a href="{{ route('login') }}" class="font-bold text-gold hover:underline">{{ __('sign in') }}</a>
                            <span>{{ __('to join the conversation and ask travel questions.') }}</span>
                        </div>
                    @endauth
                </section>
            </article>

            {{-- Sidebar Column (4 cols) --}}
            <aside class="lg:col-span-4 space-y-6">
                
                {{-- Commercial Booking CTA Widget --}}
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-6 shadow-xl border border-slate-700/50 sticky top-28">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gold/20 text-gold text-xs font-semibold mb-3">
                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span>{{ __('VIP Dubai Booking') }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-white">{{ __('Planning Your Dubai Trip?') }}</h3>
                    <p class="text-xs text-slate-300 mt-2 leading-relaxed">
                        {{ __('Book authentic desert safaris, Burj Khalifa VIP access, private yachts, and airport chauffeur transfers with instant confirmation.') }}
                    </p>

                    <div class="mt-4 space-y-2 text-xs">
                        <a href="{{ route('landings.desert-safari') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700 transition border border-slate-700">
                            <span class="font-medium text-slate-200">🏜️ {{ __('Dubai Desert Safari') }}</span>
                            <span class="text-gold font-bold">From 45 AED →</span>
                        </a>
                        <a href="{{ route('landings.burj-khalifa') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700 transition border border-slate-700">
                            <span class="font-medium text-slate-200">🏙️ {{ __('Burj Khalifa Fast Track') }}</span>
                            <span class="text-gold font-bold">From 52 AED →</span>
                        </a>
                        <a href="{{ route('landings.city-tour') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700 transition border border-slate-700">
                            <span class="font-medium text-slate-200">🏛️ {{ __('Dubai City Sightseeing') }}</span>
                            <span class="text-gold font-bold">From 35 AED →</span>
                        </a>
                        <a href="{{ route('landings.yacht-tour') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700 transition border border-slate-700">
                            <span class="font-medium text-slate-200">🛥️ {{ __('Dubai Marina Yacht Tour') }}</span>
                            <span class="text-gold font-bold">From 60 AED →</span>
                        </a>
                    </div>

                    {{-- WhatsApp Direct Booking CTA --}}
                    <div class="mt-5 pt-4 border-t border-slate-700/60">
                        <a href="https://api.whatsapp.com/send?phone=971500000000&text={{ urlencode('Hello DubaiTourBook, I read your guide on ' . $post->title . ' and would like to book a tour in Dubai.') }}" target="_blank" rel="noopener noreferrer" class="w-full py-3 px-4 rounded-xl bg-[#25D366] text-white font-bold text-xs flex items-center justify-center gap-2 hover:bg-opacity-90 transition shadow-lg">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.353.101.173.448.74 1.033 1.261.754.671 1.39.88 1.587.978.197.098.312.083.428-.05.116-.133.491-.572.621-.767.13-.195.26-.163.433-.099.173.064 1.097.517 1.285.611.188.094.312.14.358.219.046.079.046.46-.098.865z"/></svg>
                            <span>{{ __('WhatsApp Concierge 24/7') }}</span>
                        </a>
                    </div>
                </div>

                {{-- Featured Tour Packages Showcase --}}
                @if(isset($relatedPackages) && $relatedPackages->isNotEmpty())
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center justify-between">
                            <span>{{ __('Top Recommended Tours') }}</span>
                            <a href="{{ route('packages.index') }}" class="text-xs text-gold hover:underline">{{ __('View All') }}</a>
                        </h3>
                        <div class="space-y-4">
                            @foreach($relatedPackages as $pkg)
                                <a href="{{ route('packages.show', $pkg->slug) }}" class="group block p-3 rounded-2xl bg-slate-50 hover:bg-slate-100 transition border border-slate-100">
                                    <div class="flex gap-3">
                                        <img 
                                            src="{{ $pkg->getFirstMediaUrl('featured') ?: asset('assets/images/tour_burj.jpg') }}" 
                                            alt="{{ $pkg->name }}" 
                                            class="h-16 w-16 rounded-xl object-cover shrink-0 group-hover:scale-105 transition"
                                            width="64"
                                            height="64"
                                            loading="lazy"
                                        >
                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-xs font-bold text-slate-900 truncate group-hover:text-gold transition">
                                                {{ $pkg->name }}
                                            </h4>
                                            <p class="text-[11px] text-slate-500 mt-0.5 truncate">{{ $pkg->destination?->name ?? 'Dubai' }}</p>
                                            <div class="flex items-center justify-between mt-1">
                                                <span class="text-xs font-extrabold text-gold">{{ number_format($pkg->effectivePrice(), 0) }} AED</span>
                                                <span class="text-[10px] text-slate-400">{{ $pkg->duration_days ? $pkg->duration_days . ' Days' : 'Daily' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Recent Posts List --}}
                @if(isset($recentPosts) && $recentPosts->isNotEmpty())
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-base font-bold text-slate-900 mb-4">{{ __('Latest Dubai Guides') }}</h3>
                        <div class="space-y-3">
                            @foreach($recentPosts as $rPost)
                                <a href="{{ route('posts.show', $rPost->slug) }}" class="block group">
                                    <p class="text-xs font-semibold text-slate-800 group-hover:text-gold transition line-clamp-2 leading-snug">
                                        {{ $rPost->title }}
                                    </p>
                                    <span class="text-[11px] text-slate-400 mt-1 block">
                                        {{ $rPost->published_at?->format('M d, Y') ?? 'Recent' }}
                                    </span>
                                </a>
                                @if(!$loop->last)
                                    <div class="border-b border-slate-100"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

            </aside>
        </div>
    </div>
</main>
@endsection
