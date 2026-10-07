@extends('layouts.app')

@php
    $siteName = \App\Models\Setting::get('general.site_name', 'Dubai Tour Book');
    $contactPhone = \App\Models\Setting::get('contact.phone', '+971 4 321 8899');
    $contactEmail = \App\Models\Setting::get('contact.email', 'info@dubaitourbook.com');
    $contactSupportEmail = \App\Models\Setting::get('contact.support_email', 'support@dubaitourbook.com');
    $contactAddress = \App\Models\Setting::get('contact.address', 'Sheikh Mohammed bin Rashid Blvd, Downtown Dubai, United Arab Emirates');
    $contactWhatsapp = \App\Models\Setting::get('social.whatsapp', 'https://wa.me/971508887766');
    $contactHours = \App\Models\Setting::get('contact.working_hours', '24/7 VIP Concierge & Booking Desk');
@endphp

@section('title', 'Contact Us & VIP Concierge | ' . $siteName)
@section('meta_description', 'Get in touch with ' . $siteName . ' specialists to plan customized Dubai tour packages, private desert safaris, luxury hotel stays, or VIP yacht bookings.')

@section('content')

    <!-- Hero Header -->
    <section class="relative bg-deepblack pb-20 pt-36 text-white overflow-hidden">
        <!-- Ambient Background Glow -->
        <div class="absolute top-1/4 left-10 w-80 h-80 rounded-full bg-amber-500/15 blur-3xl pointer-events-none animate-float-slow"></div>
        <div class="absolute bottom-0 right-10 w-96 h-96 rounded-full bg-amber-600/15 blur-3xl pointer-events-none animate-float-reverse"></div>

        <div class="container mx-auto px-6 text-center relative z-10 max-w-4xl">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-gold/40 text-gold text-xs font-extrabold uppercase tracking-widest mb-4 shadow-xl">
                <span class="w-2 h-2 rounded-full bg-gold animate-ping"></span>
                24/7 VIP Concierge & Tour Inquiries
            </div>
            <h1 class="text-4xl font-extrabold md:text-6xl tracking-tight text-white mb-4">
                Get in Touch With Our <span class="text-gradient-gold">UAE Travel Experts</span>
            </h1>
            <p class="mt-3 text-gray-300 text-base md:text-lg max-w-2xl mx-auto font-light leading-relaxed">
                Whether you are planning a private desert safari, luxury hotel stay, or customized Emirates tour package, our team is at your service 24/7.
            </p>
        </div>
    </section>

    <!-- Main Content Section: Form + Contact Info -->
    <section class="py-20 bg-offwhite">
        <div class="container mx-auto px-6 max-w-7xl">
            @if(session('success'))
                <div class="mb-10 rounded-2xl border border-emerald-200 bg-emerald-50 p-6 text-emerald-900 font-semibold shadow-md flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg">Message Sent Successfully!</h4>
                        <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Left Column: Contact Form (7 cols) -->
                <div class="lg:col-span-7 bg-white rounded-3xl p-8 sm:p-10 shadow-2xl border border-gray-100/80">
                    <h2 class="text-2xl font-extrabold text-deepblack mb-2">Send Us a Message</h2>
                    <p class="text-gray-500 text-sm mb-8">Fill in the details below and our travel specialists will respond within 2 hours.</p>

                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Your Full Name <span class="text-rose-500">*</span></label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-4 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm" placeholder="e.g. Alexander Wright">
                            @error('name')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Email Address <span class="text-rose-500">*</span></label>
                                <input type="email" id="email" name="email" required value="{{ old('email') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-4 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm" placeholder="alexander@example.com">
                                @error('email')
                                    <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Phone / WhatsApp</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-4 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm" placeholder="+971 50 123 4567">
                                @error('phone')
                                    <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Inquiry Type / Subject</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-4 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm" placeholder="e.g. Booking Private Desert Safari & Heli Tour">
                            @error('subject')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Your Message <span class="text-rose-500">*</span></label>
                            <textarea id="message" name="message" required rows="5" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-4 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm" placeholder="Tell us about your dates, number of guests, or special preferences..."></textarea>
                            @error('message')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-gold text-deepblack font-extrabold py-4 px-8 shadow-xl hover:bg-deepblack hover:text-white transition-all duration-300 text-base flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Submit Concierge Request
                        </button>
                    </form>
                </div>

                <!-- Right Column: Office Cards & Contact Information (5 cols) -->
                <div class="lg:col-span-5 space-y-8">
                    <!-- Headquarters Card -->
                    <div class="bg-deepblack text-white rounded-3xl p-8 shadow-2xl border border-amber-500/20 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>
                        <h3 class="text-xl font-extrabold text-white mb-6 flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-gold text-deepblack flex items-center justify-center">
                                <svg class="w-4 h-4 text-deepblack" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            Dubai Headquarters
                        </h3>
                        <div class="space-y-4 text-sm">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gold flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <p class="text-gray-300 leading-relaxed">{{ $contactAddress }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}" class="text-gray-200 font-semibold hover:text-gold transition-colors">{{ $contactPhone }}</a>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <a href="mailto:{{ $contactEmail }}" class="text-gray-200 font-semibold hover:text-gold transition-colors">{{ $contactEmail }}</a>
                            </div>
                            @if($contactHours)
                            <div class="flex items-center gap-3 pt-2 border-t border-gray-800 text-xs text-gray-400">
                                <span class="text-gold font-bold">Hours:</span>
                                <span>{{ $contactHours }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Instant WhatsApp Concierge Box -->
                    <div class="bg-gradient-to-r from-emerald-950 via-gray-900 to-emerald-950 text-white rounded-3xl p-8 shadow-xl border border-emerald-500/30">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></div>
                            <span class="text-xs font-bold uppercase tracking-widest text-emerald-400">Instant VIP Support</span>
                        </div>
                        <h4 class="text-xl font-extrabold text-white mb-2">Need Urgent Assistance?</h4>
                        <p class="text-gray-300 text-sm mb-5">Chat directly with our lead travel concierge on WhatsApp for immediate bookings, custom desert tours, or itinerary changes.</p>
                        <a href="{{ $contactWhatsapp ?: 'https://wa.me/971508887766' }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2.5 w-full bg-emerald-500 text-deepblack font-extrabold py-3.5 px-6 rounded-xl hover:bg-emerald-400 transition-all text-sm shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            Start WhatsApp Chat
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
