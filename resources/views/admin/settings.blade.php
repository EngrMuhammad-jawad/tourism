@extends('layouts.admin')

@section('title', 'Website Settings & Branding')
@section('page_heading', 'Settings & Branding')

@section('content')
<div class="space-y-8" x-data="{ activeTab: 'contact' }">

    <!-- Header & Quick Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-black tracking-tight text-deepblack flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gold/15 text-gold border border-gold/30">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </span>
                Site Configuration &amp; Contact Info
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Manage your live business information, brand logo, contact details, and SEO for <strong>{{ $settings['general']['site_name'] ?? 'Dubai Tour Book' }}</strong> (dubaitourbook.com).
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm hover:border-gold hover:text-gold transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                View Live Site
            </a>
            <button type="submit" form="settings-main-form" class="inline-flex items-center gap-2 rounded-xl bg-gold px-5 py-2.5 text-xs font-black uppercase tracking-wider text-deepblack shadow-lg shadow-gold/20 hover:bg-yellow-400 hover:scale-[1.02] active:scale-[0.98] transition-all">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                Save All Settings
            </button>
        </div>
    </div>

    <!-- Live Preview Card -->
    <div class="rounded-3xl border border-amber-500/20 bg-gradient-to-r from-deepblack via-gray-900 to-deepblack p-6 text-white shadow-2xl relative overflow-hidden">
        <div class="absolute -right-16 -bottom-16 w-64 h-64 rounded-full bg-gold/10 blur-3xl pointer-events-none"></div>
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
            <div class="flex items-center gap-5">
                <div class="h-16 w-16 shrink-0 rounded-2xl bg-white/10 border border-gold/40 p-2.5 flex items-center justify-center shadow-lg">
                    <img src="{{ asset($settings['general']['logo'] ?? 'assets/images/logo.svg') }}" alt="Site Logo" class="max-h-full max-w-full object-contain" onerror="this.src='{{ asset('assets/images/logo-icon.svg') }}'">
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-gold/20 text-gold border border-gold/30">Live Branding</span>
                    <h3 class="text-xl font-black text-white mt-1">{{ $settings['general']['site_name'] ?? 'Dubai Tour Book' }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $settings['general']['tagline'] ?? 'Luxury Tours, Desert Safaris & VIP Experiences' }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs text-gray-300 w-full md:w-auto">
                <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                    <span class="text-gray-400 block text-[10px] uppercase font-bold tracking-wider">Direct Phone</span>
                    <span class="text-gold font-bold">{{ $settings['contact']['phone'] ?? '+971 4 321 8899' }}</span>
                </div>
                <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                    <span class="text-gray-400 block text-[10px] uppercase font-bold tracking-wider">Contact Email</span>
                    <span class="text-white font-semibold">{{ $settings['contact']['email'] ?? 'info@dubaitourbook.com' }}</span>
                </div>
                <div class="bg-white/5 rounded-xl p-3 border border-white/10 sm:col-span-2 lg:col-span-1">
                    <span class="text-gray-400 block text-[10px] uppercase font-bold tracking-wider">Official Domain</span>
                    <span class="text-emerald-400 font-bold">dubaitourbook.com</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="flex border-b border-gray-200 overflow-x-auto gap-2">
        <button type="button" @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'border-gold text-yellow-800 bg-gold/10 font-bold' : 'border-transparent text-slate-600 hover:text-slate-900 hover:border-slate-300 font-medium'" class="flex items-center gap-2 border-b-2 px-5 py-3 text-sm transition-all whitespace-nowrap rounded-t-xl">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            Contact &amp; Address Info
        </button>
        <button type="button" @click="activeTab = 'general'" :class="activeTab === 'general' ? 'border-gold text-yellow-800 bg-gold/10 font-bold' : 'border-transparent text-slate-600 hover:text-slate-900 hover:border-slate-300 font-medium'" class="flex items-center gap-2 border-b-2 px-5 py-3 text-sm transition-all whitespace-nowrap rounded-t-xl">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            General &amp; Logo Branding
        </button>
        <button type="button" @click="activeTab = 'social'" :class="activeTab === 'social' ? 'border-gold text-yellow-800 bg-gold/10 font-bold' : 'border-transparent text-slate-600 hover:text-slate-900 hover:border-slate-300 font-medium'" class="flex items-center gap-2 border-b-2 px-5 py-3 text-sm transition-all whitespace-nowrap rounded-t-xl">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
            Social Media Links
        </button>
        <button type="button" @click="activeTab = 'footer'" :class="activeTab === 'footer' ? 'border-gold text-yellow-800 bg-gold/10 font-bold' : 'border-transparent text-slate-600 hover:text-slate-900 hover:border-slate-300 font-medium'" class="flex items-center gap-2 border-b-2 px-5 py-3 text-sm transition-all whitespace-nowrap rounded-t-xl">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
            Footer &amp; About Text
        </button>
        <button type="button" @click="activeTab = 'seo'" :class="activeTab === 'seo' ? 'border-gold text-yellow-800 bg-gold/10 font-bold' : 'border-transparent text-slate-600 hover:text-slate-900 hover:border-slate-300 font-medium'" class="flex items-center gap-2 border-b-2 px-5 py-3 text-sm transition-all whitespace-nowrap rounded-t-xl">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            SEO &amp; Meta Tags
        </button>
        <button type="button" @click="activeTab = 'advanced'" :class="activeTab === 'advanced' ? 'border-gold text-yellow-800 bg-gold/10 font-bold' : 'border-transparent text-slate-600 hover:text-slate-900 hover:border-slate-300 font-medium'" class="flex items-center gap-2 border-b-2 px-5 py-3 text-sm transition-all whitespace-nowrap rounded-t-xl">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
            All Database Keys (Raw)
        </button>
    </div>

    <!-- Main Settings Form -->
    <form id="settings-main-form" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- TAB 1: Contact & Address Information -->
        <div x-show="activeTab === 'contact'" class="space-y-6">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-deepblack flex items-center gap-2">
                        <span class="text-gold">📞</span> Business Contact &amp; Physical Address
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Any changes made here will dynamically update in the website header, footer, contact page, and booking confirmations immediately.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="contact_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Official Telephone Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="contact_phone" name="contact[phone]" value="{{ old('contact.phone', $settings['contact']['phone'] ?? '+971 4 321 8899') }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm font-semibold text-deepblack focus:bg-white focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all shadow-sm" placeholder="+971 4 321 8899">
                        <p class="mt-1 text-[11px] text-slate-400">Displayed in Header, Footer, and Contact details.</p>
                    </div>

                    <div>
                        <label for="contact_whatsapp" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            WhatsApp VIP Concierge Number
                        </label>
                        <input type="text" id="contact_whatsapp" name="contact[whatsapp]" value="{{ old('contact.whatsapp', $settings['contact']['whatsapp'] ?? '+971 50 888 7766') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm font-semibold text-deepblack focus:bg-white focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all shadow-sm" placeholder="+971 50 888 7766">
                        <p class="mt-1 text-[11px] text-slate-400">Used for WhatsApp click-to-chat links.</p>
                    </div>

                    <div>
                        <label for="contact_email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Primary Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="contact_email" name="contact[email]" value="{{ old('contact.email', $settings['contact']['email'] ?? 'info@dubaitourbook.com') }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm font-semibold text-deepblack focus:bg-white focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all shadow-sm" placeholder="info@dubaitourbook.com">
                        <p class="mt-1 text-[11px] text-slate-400">Public contact email.</p>
                    </div>

                    <div>
                        <label for="contact_support_email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Bookings &amp; Support Email
                        </label>
                        <input type="email" id="contact_support_email" name="contact[support_email]" value="{{ old('contact.support_email', $settings['contact']['support_email'] ?? 'support@dubaitourbook.com') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm font-semibold text-deepblack focus:bg-white focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all shadow-sm" placeholder="booking@dubaitourbook.com">
                        <p class="mt-1 text-[11px] text-slate-400">Customer booking support desk.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label for="contact_address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Physical Dubai Headquarters Address <span class="text-red-500">*</span>
                        </label>
                        <textarea id="contact_address" name="contact[address]" rows="3" required class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm font-medium text-deepblack focus:bg-white focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all shadow-sm" placeholder="Sheikh Mohammed bin Rashid Blvd, Downtown Dubai, United Arab Emirates">{{ old('contact.address', $settings['contact']['address'] ?? 'Sheikh Mohammed bin Rashid Blvd, Downtown Dubai, United Arab Emirates') }}</textarea>
                        <p class="mt-1 text-[11px] text-slate-400">Full physical office address displayed on footer and contact page.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label for="contact_working_hours" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Working / Service Hours
                        </label>
                        <input type="text" id="contact_working_hours" name="contact[working_hours]" value="{{ old('contact.working_hours', $settings['contact']['working_hours'] ?? '24/7 VIP Concierge & Booking Desk') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm font-semibold text-deepblack focus:bg-white focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all shadow-sm" placeholder="24/7 VIP Concierge & Booking Desk">
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: General & Logo Branding -->
        <div x-show="activeTab === 'general'" class="space-y-6">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-deepblack flex items-center gap-2">
                        <span class="text-gold">✨</span> Brand Identity, Name &amp; Logo
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Control the brand presentation across the website.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="general_site_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Website / Brand Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="general_site_name" name="general[site_name]" value="{{ old('general.site_name', $settings['general']['site_name'] ?? 'Dubai Tour Book') }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm font-bold text-deepblack focus:bg-white focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all shadow-sm" placeholder="Dubai Tour Book">
                    </div>

                    <div>
                        <label for="general_site_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Canonical Site URL
                        </label>
                        <input type="url" id="general_site_url" name="general[site_url]" value="{{ old('general.site_url', $settings['general']['site_url'] ?? 'https://dubaitourbook.com') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm font-semibold text-deepblack focus:bg-white focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all shadow-sm" placeholder="https://dubaitourbook.com">
                    </div>

                    <div class="md:col-span-2">
                        <label for="general_tagline" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Brand Tagline
                        </label>
                        <input type="text" id="general_tagline" name="general[tagline]" value="{{ old('general.tagline', $settings['general']['tagline'] ?? 'Luxury Tours, Desert Safaris & VIP Experiences') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm font-medium text-deepblack focus:bg-white focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all shadow-sm" placeholder="Luxury Tours, Desert Safaris & VIP Experiences">
                    </div>

                    <!-- Logo Settings -->
                    <div class="md:col-span-2 border-t border-gray-100 pt-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-4">Logo &amp; Visual Emblem</h4>
                        <div class="flex flex-col sm:flex-row items-start gap-6">
                            <!-- Logo Preview Box -->
                            <div class="w-48 h-24 rounded-2xl bg-deepblack border border-gold/40 p-4 flex items-center justify-center shadow-md shrink-0">
                                <img src="{{ asset($settings['general']['logo'] ?? 'assets/images/logo.svg') }}" alt="Dubai Tour Book Logo" class="max-h-full max-w-full object-contain">
                            </div>

                            <div class="flex-1 space-y-4 w-full">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Upload New Logo (PNG, SVG, JPG, WEBP)</label>
                                    <input type="file" name="logo_upload" accept="image/*,.svg" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gold/15 file:text-yellow-800 hover:file:bg-gold hover:file:text-deepblack transition-all">
                                </div>
                                <div>
                                    <label for="general_logo" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Or Specify Logo Asset Path</label>
                                    <input type="text" id="general_logo" name="general[logo]" value="{{ old('general.logo', $settings['general']['logo'] ?? '/assets/images/logo.svg') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-xs text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: Social Media Links -->
        <div x-show="activeTab === 'social'" class="space-y-6">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-deepblack flex items-center gap-2">
                        <span class="text-gold">🌐</span> Official Social Media Profiles
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        These links will appear in the footer and contact sections of your site.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="social_facebook" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Facebook Page URL</label>
                        <input type="url" id="social_facebook" name="social[facebook]" value="{{ old('social.facebook', $settings['social']['facebook'] ?? 'https://facebook.com/dubaitourbook') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm" placeholder="https://facebook.com/dubaitourbook">
                    </div>

                    <div>
                        <label for="social_instagram" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Instagram Profile URL</label>
                        <input type="url" id="social_instagram" name="social[instagram]" value="{{ old('social.instagram', $settings['social']['instagram'] ?? 'https://instagram.com/dubaitourbook') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm" placeholder="https://instagram.com/dubaitourbook">
                    </div>

                    <div>
                        <label for="social_twitter" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">X (Twitter) Profile URL</label>
                        <input type="url" id="social_twitter" name="social[twitter]" value="{{ old('social.twitter', $settings['social']['twitter'] ?? 'https://x.com/dubaitourbook') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm" placeholder="https://x.com/dubaitourbook">
                    </div>

                    <div>
                        <label for="social_youtube" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">YouTube Channel URL</label>
                        <input type="url" id="social_youtube" name="social[youtube]" value="{{ old('social.youtube', $settings['social']['youtube'] ?? 'https://youtube.com/@dubaitourbook') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm" placeholder="https://youtube.com/@dubaitourbook">
                    </div>

                    <div class="md:col-span-2">
                        <label for="social_whatsapp_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">WhatsApp Direct Chat Link</label>
                        <input type="text" id="social_whatsapp_url" name="social[whatsapp]" value="{{ old('social.whatsapp', $settings['social']['whatsapp'] ?? 'https://wa.me/971508887766') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm" placeholder="https://wa.me/971508887766">
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: Footer & About Text -->
        <div x-show="activeTab === 'footer'" class="space-y-6">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-deepblack flex items-center gap-2">
                        <span class="text-gold">📝</span> Footer Information &amp; Multilingual Summary
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Configure what travelers see at the base of every page.
                    </p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="footer_copyright" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Copyright Statement <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="footer_copyright" name="footer[copyright]" value="{{ old('footer.copyright', $settings['footer']['copyright'] ?? '© 2026 Dubai Tour Book (dubaitourbook.com). All Rights Reserved.') }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm font-medium text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm">
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div>
                            <label for="footer_about_en" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">About Us (English)</label>
                            <textarea id="footer_about_en" name="footer[about_text_en]" rows="4" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-4 text-xs text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm">{{ old('footer.about_text_en', is_array($settings['footer']['about_text'] ?? null) ? ($settings['footer']['about_text']['en'] ?? '') : ($settings['footer']['about_text'] ?? '')) }}</textarea>
                        </div>
                        <div>
                            <label for="footer_about_ar" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">About Us (Arabic / العربية)</label>
                            <textarea id="footer_about_ar" name="footer[about_text_ar]" dir="rtl" rows="4" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-4 text-xs text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm">{{ old('footer.about_text_ar', is_array($settings['footer']['about_text'] ?? null) ? ($settings['footer']['about_text']['ar'] ?? '') : '') }}</textarea>
                        </div>
                        <div>
                            <label for="footer_about_ru" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">About Us (Russian / Русский)</label>
                            <textarea id="footer_about_ru" name="footer[about_text_ru]" rows="4" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-4 text-xs text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm">{{ old('footer.about_text_ru', is_array($settings['footer']['about_text'] ?? null) ? ($settings['footer']['about_text']['ru'] ?? '') : '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 5: SEO & Meta Tags -->
        <div x-show="activeTab === 'seo'" class="space-y-6">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-deepblack flex items-center gap-2">
                        <span class="text-gold">🔍</span> Search Engine Optimization (SEO)
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Fine-tune global Google indexing title, meta descriptions, and keywords for dubaitourbook.com.
                    </p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="seo_meta_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Default Site Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="seo_meta_title" name="seo[meta_title]" value="{{ old('seo.meta_title', $settings['seo']['meta_title'] ?? 'Dubai Tour Book | Luxury Tours, Desert Safaris & Dubai Experiences') }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm font-semibold text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm">
                        <p class="mt-1 text-[11px] text-slate-400">Recommended 50–65 characters for optimal Google search display.</p>
                    </div>

                    <div>
                        <label for="seo_meta_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Global Meta Description
                        </label>
                        <textarea id="seo_meta_description" name="seo[meta_description]" rows="3" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-4 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm">{{ old('seo.meta_description', $settings['seo']['meta_description'] ?? 'Book unforgettable Dubai tours, private desert safaris, Burj Khalifa tickets, luxury yachts, and customized holiday packages at dubaitourbook.com.') }}</textarea>
                        <p class="mt-1 text-[11px] text-slate-400">Summarizes your agency for Google and social previews (140-160 characters).</p>
                    </div>

                    <div>
                        <label for="seo_meta_keywords" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Global Keywords (Comma-separated)
                        </label>
                        <input type="text" id="seo_meta_keywords" name="seo[meta_keywords]" value="{{ old('seo.meta_keywords', $settings['seo']['meta_keywords'] ?? 'Dubai tour book, Dubai tours, luxury Dubai travel, desert safari Dubai, Burj Khalifa tickets, Dubai yacht rental, UAE holiday packages') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm text-deepblack focus:bg-white focus:border-gold focus:outline-none transition-all shadow-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Save Floating Bar -->
        <div class="sticky bottom-4 z-20 flex items-center justify-between rounded-2xl bg-deepblack/90 p-4 backdrop-blur border border-gold/30 shadow-2xl text-white">
            <div class="flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-gold/20 text-gold font-bold text-xs">⚡</span>
                <span class="text-xs font-medium text-gray-300 hidden sm:inline">Settings save automatically to database &amp; instant cache bust.</span>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-gold px-6 py-2.5 text-xs font-black uppercase tracking-wider text-deepblack shadow-lg shadow-gold/20 hover:bg-yellow-400 hover:scale-105 transition-all">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                Save All Changes
            </button>
        </div>
    </form>

    <!-- TAB 6: Advanced / Raw Settings Table -->
    <div x-show="activeTab === 'advanced'" class="space-y-6">
        <!-- Add New Setting Inline Form -->
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="text-base font-bold text-deepblack mb-4 flex items-center gap-2">
                <span>➕</span> Add Custom Setting Key
            </h3>
            <form method="POST" action="{{ route('admin.settings.raw.store') }}" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Group (e.g. contact, general)</label>
                    <input type="text" name="group" required class="w-full rounded-xl border border-gray-200 px-3 py-2 text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Key (e.g. emergency_phone)</label>
                    <input type="text" name="key" required class="w-full rounded-xl border border-gray-200 px-3 py-2 text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Value (String or JSON)</label>
                    <input type="text" name="value" required class="w-full rounded-xl border border-gray-200 px-3 py-2 text-xs">
                </div>
                <div>
                    <button type="submit" class="w-full rounded-xl bg-deepblack text-white px-4 py-2 text-xs font-bold hover:bg-gold hover:text-deepblack transition-colors">
                        Add Key
                    </button>
                </div>
            </form>
        </div>

        <!-- Raw Records Table -->
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-xs">
                    <thead class="bg-gray-50 uppercase tracking-wider text-slate-500 font-bold">
                        <tr>
                            <th class="px-6 py-3.5">Group</th>
                            <th class="px-6 py-3.5">Key</th>
                            <th class="px-6 py-3.5">Value</th>
                            <th class="px-6 py-3.5">Updated</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($rawSettings as $item)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-3 font-bold text-slate-700">
                                    <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-[11px]">{{ $item->group }}</span>
                                </td>
                                <td class="px-6 py-3 font-semibold text-gold">{{ $item->key }}</td>
                                <td class="px-6 py-3 text-slate-600 max-w-md truncate font-mono text-[11px]">
                                    {{ is_array($item->value) ? json_encode($item->value) : $item->value }}
                                </td>
                                <td class="px-6 py-3 text-slate-400 text-[11px]">{{ $item->updated_at?->diffForHumans() }}</td>
                                <td class="px-6 py-3 text-right">
                                    <form method="POST" action="{{ route('admin.settings.raw.destroy', $item) }}" class="inline" onsubmit="return confirm('Delete this setting key?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-rose-600 font-bold hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-gray-100 p-4">
                {{ $rawSettings->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
