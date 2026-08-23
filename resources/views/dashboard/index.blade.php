@extends('layouts.app')
@section('title', 'My Bookings | UAE Tourism')
@section('content')
<section class="pt-32 pb-20 bg-offwhite min-h-screen">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-gold mb-1">Customer Portal</p>
                <h1 class="text-4xl font-bold text-deepblack">My Bookings</h1>
                <p class="mt-1 text-gray-600">Track and manage your luxury travel itineraries.</p>
            </div>
            <a class="inline-flex items-center gap-2 rounded-xl bg-deepblack px-5 py-3 text-sm font-semibold text-white transition hover:bg-gold hover:text-deepblack shadow-md shadow-black/5" href="{{ route('account.edit') }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Account settings
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-deepblack text-white text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Reference</th>
                            <th class="px-6 py-4">Service</th>
                            <th class="px-6 py-4">Travel Date</th>
                            <th class="px-6 py-4">Guests</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Payment</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-amber-50/20 transition-colors">
                                <td class="px-6 py-4 font-bold text-deepblack tracking-wide">{{ $booking->booking_number }}</td>
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-slate-800">{{ $booking->bookable?->name ?? 'Unavailable service' }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 font-medium">{{ $booking->travel_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-slate-600 font-medium">{{ $booking->totalGuests() }}</td>
                                <td class="px-6 py-4 font-bold text-gold text-base">${{ number_format((float) $booking->total_price, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700 capitalize">
                                        {{ str_replace('_', ' ', $booking->payment_method->value) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClass = match($booking->status->value) {
                                            'approved', 'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'cancelled', 'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
                                            default => 'bg-slate-50 text-slate-700 border-slate-200',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-bold uppercase tracking-wider {{ $statusClass }}">
                                        {{ $booking->status->value }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-end">
                                    @if($booking->status->isCancellable())
                                        <form method="POST" action="{{ route('bookings.cancel', $booking) }}" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                            @csrf
                                            <button class="rounded-lg px-3 py-1.5 text-xs font-bold text-rose-600 border border-rose-200 hover:bg-rose-600 hover:text-white transition-colors">Cancel</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    <p class="text-base font-semibold text-gray-700">No bookings found</p>
                                    <p class="text-xs text-gray-400 mt-1">Explore our destinations and packages to place your first reservation.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($bookings->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-slate-50/50">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
