<aside id="admin-sidebar" class="fixed inset-y-0 start-0 z-40 flex w-72 -translate-x-full flex-col border-e border-white/10 bg-deepblack text-white transition-transform duration-200 lg:translate-x-0" aria-label="Admin navigation">
    <div class="flex h-20 items-center justify-between border-b border-white/10 px-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-xl font-bold tracking-wide">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gold text-deepblack">U</span>
            UAE <span class="text-gold">Tourism</span>
        </a>
        <button type="button" data-admin-close class="rounded-lg p-2 text-gray-400 hover:bg-white/10 hover:text-white lg:hidden" aria-label="Close navigation">&#215;</button>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5">
        @foreach ($adminMenu as $item)
            @php
                $children = $item->children;
                $hasRoute = $item->route && \Illuminate\Support\Facades\Route::has($item->route);
                $isActive = $hasRoute && request()->routeIs($item->route);
            @endphp

            @if ($hasRoute)
                <a href="{{ route($item->route) }}" @class([
                    'flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-colors',
                    'bg-gold text-deepblack shadow-lg shadow-gold/10' => $isActive,
                    'text-gray-300 hover:bg-white/10 hover:text-white' => ! $isActive,
                ])>
                    <x-admin-icon :name="$item->icon ?: 'home'" class="h-5 w-5 shrink-0" />
                    <span>{{ $item->title }}</span>
                </a>
            @elseif ($item->route)
                <div class="flex cursor-not-allowed items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-500" title="This module is not available yet">
                    <x-admin-icon :name="$item->icon ?: 'home'" class="h-5 w-5 shrink-0" />
                    <span>{{ $item->title }}</span>
                    <span class="ms-auto rounded bg-white/10 px-1.5 py-0.5 text-[10px] uppercase tracking-wide">Soon</span>
                </div>
            @else
                <div class="mt-5 px-4 text-xs font-bold uppercase tracking-[0.14em] text-gold">{{ $item->title }}</div>
                <div class="mt-1 space-y-1">
                    @foreach ($children as $child)
                        @if (\Illuminate\Support\Facades\Route::has($child->route))
                            <a href="{{ route($child->route) }}" @class([
                                'block rounded-xl px-4 py-2.5 text-sm transition-colors',
                                'bg-white/10 text-white' => request()->routeIs($child->route),
                                'text-gray-400 hover:bg-white/10 hover:text-white' => ! request()->routeIs($child->route),
                            ])>{{ $child->title }}</a>
                        @else
                            <div class="flex cursor-not-allowed items-center justify-between rounded-xl px-4 py-2.5 text-sm text-gray-500" title="This module is not available yet">
                                <span>{{ $child->title }}</span><span class="text-[10px] uppercase tracking-wide">Soon</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        @endforeach
    </nav>

    <div class="border-t border-white/10 p-4 text-xs text-gray-400">
        Signed in as <span class="font-semibold text-gray-200">{{ auth()->user()->name }}</span>
    </div>
</aside>
