<!DOCTYPE html>
<html lang="en" class="bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin dashboard') | UAE Tourism</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-100 font-sans text-slate-800 antialiased">
    @include('partials.admin-sidebar')
    <div id="admin-overlay" class="fixed inset-0 z-30 hidden bg-black/50 lg:hidden"></div>

    <div class="min-h-screen lg:ps-72">
        <header class="sticky top-0 z-20 flex h-20 items-center justify-between border-b border-gray-200 bg-white/90 px-4 backdrop-blur sm:px-8">
            <div class="flex items-center gap-3">
                <button type="button" data-admin-open class="rounded-xl p-2 text-slate-600 hover:bg-gray-100 lg:hidden" aria-label="Open navigation">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gold">Administration</p>
                    <h1 class="text-lg font-bold text-deepblack">@yield('page_heading', 'Dashboard')</h1>
                </div>
            </div>
            @php($frontendLocale = session('locale', config('localization.default')))
            <div class="flex items-center gap-3">
                <a href="{{ route('home', ['locale' => $frontendLocale]) }}" class="hidden text-sm font-medium text-slate-500 hover:text-gold sm:block">View site</a>
                <div class="hidden text-end sm:block">
                    <p class="text-sm font-semibold text-deepblack">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ auth()->user()->getRoleNames()->join(', ') }}</p>
                </div>
                <form method="POST" action="{{ route('logout', ['locale' => $frontendLocale]) }}">
                    @csrf
                    <button class="rounded-xl border border-gray-200 px-3 py-2 text-sm font-semibold text-slate-600 transition-colors hover:border-gold hover:text-deepblack">Sign out</button>
                </form>
            </div>
        </header>

        <main class="p-4 sm:p-8">
            @if (session('success'))
                <div id="success-toast" class="mb-6 flex items-center justify-between gap-3 rounded-xl border border-emerald-100 bg-emerald-50/80 p-4 text-sm font-medium text-emerald-800 shadow-sm backdrop-blur transition-all duration-500 animate-in fade-in slide-in-from-top-4">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-500 text-white shadow-sm shadow-emerald-500/30">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        </span>
                        <div>
                            <p class="font-bold text-emerald-950">Success</p>
                            <p class="text-xs text-emerald-700/90 mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('success-toast').remove()" class="rounded-lg p-1.5 text-emerald-600 hover:bg-emerald-100/50 hover:text-emerald-950 transition-colors" aria-label="Close">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div id="error-toast" class="mb-6 flex items-center justify-between gap-3 rounded-xl border border-rose-100 bg-rose-50/80 p-4 text-sm font-medium text-rose-800 shadow-sm backdrop-blur transition-all duration-500 animate-in fade-in slide-in-from-top-4">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-rose-500 text-white shadow-sm shadow-rose-500/30">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </span>
                        <div>
                            <p class="font-bold text-rose-950">Form Validation Errors</p>
                            <p class="text-xs text-rose-700/90 mt-0.5">Please check and correct the highlighted fields below.</p>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('error-toast').remove()" class="rounded-lg p-1.5 text-rose-600 hover:bg-rose-100/50 hover:text-rose-950 transition-colors" aria-label="Close">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('admin-overlay');
        const toggleSidebar = (show) => {
            sidebar.classList.toggle('-translate-x-full', !show);
            overlay.classList.toggle('hidden', !show);
        };
        document.querySelector('[data-admin-open]')?.addEventListener('click', () => toggleSidebar(true));
        document.querySelector('[data-admin-close]')?.addEventListener('click', () => toggleSidebar(false));
        overlay?.addEventListener('click', () => toggleSidebar(false));
    </script>
    @stack('scripts')
</body>
</html>
