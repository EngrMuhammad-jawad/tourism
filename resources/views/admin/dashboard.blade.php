@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_heading', 'Dashboard')

@section('content')
    <div class="mb-8 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
        <div>
            <h2 class="text-2xl font-bold text-deepblack">Welcome back, {{ auth()->user()->name }}.</h2>
            <p class="mt-1 text-sm text-slate-500">Here is the latest snapshot of your tourism operation.</p>
        </div>
        <p class="text-sm text-slate-500">{{ now()->format('l, j F Y') }}</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @foreach ($cards as $card)
            <section class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">{{ $card['label'] }}</p>
                        <p class="mt-2 text-3xl font-bold text-deepblack">{{ number_format($card['value']) }}</p>
                    </div>
                    <span @class([
                        'rounded-xl p-3',
                        'bg-gold/15 text-yellow-700' => $card['color'] === 'gold',
                        'bg-violet-100 text-violet-700' => $card['color'] === 'violet',
                        'bg-blue-100 text-blue-700' => $card['color'] === 'blue',
                        'bg-amber-100 text-amber-700' => $card['color'] === 'amber',
                        'bg-emerald-100 text-emerald-700' => $card['color'] === 'emerald',
                    ])><x-admin-icon :name="$card['icon']" class="h-5 w-5" /></span>
                </div>
            </section>
        @endforeach
    </div>

    @can('bookings.view')
        <div class="mt-8 grid gap-6 xl:grid-cols-5">
            <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm xl:col-span-3">
                <div class="mb-5"><h3 class="font-bold text-deepblack">Booking activity</h3><p class="text-sm text-slate-500">New bookings over the last six months</p></div>
                <div class="h-72"><canvas id="monthly-bookings-chart"></canvas></div>
            </section>
            <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm xl:col-span-2">
                <div class="mb-5"><h3 class="font-bold text-deepblack">Booking statuses</h3><p class="text-sm text-slate-500">Current distribution</p></div>
                <div class="mx-auto h-72 max-w-xs"><canvas id="booking-status-chart"></canvas></div>
            </section>
        </div>

        <section class="mt-8 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5"><div><h3 class="font-bold text-deepblack">Latest bookings</h3><p class="text-sm text-slate-500">Most recently created reservation requests</p></div></div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm"><thead class="bg-gray-50 text-xs uppercase tracking-wide text-slate-500"><tr><th class="px-6 py-3">Reference</th><th class="px-6 py-3">Customer</th><th class="px-6 py-3">Service</th><th class="px-6 py-3">Travel date</th><th class="px-6 py-3">Total</th><th class="px-6 py-3">Status</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse ($latestBookings as $booking)
                        <tr class="text-slate-600"><td class="whitespace-nowrap px-6 py-4 font-semibold text-deepblack">{{ $booking->booking_number }}</td><td class="whitespace-nowrap px-6 py-4">{{ $booking->user->name }}</td><td class="px-6 py-4">{{ $booking->bookable?->name ?? 'Deleted service' }}</td><td class="whitespace-nowrap px-6 py-4">{{ $booking->travel_date->format('d M Y') }}</td><td class="whitespace-nowrap px-6 py-4">${{ number_format((float) $booking->total_price, 2) }}</td><td class="px-6 py-4"><span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold capitalize text-amber-700">{{ $booking->status->value }}</span></td></tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">No bookings have been created yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @endcan

    @can('users.view')
        <section class="mt-8 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-5"><h3 class="font-bold text-deepblack">Newest customers</h3><p class="text-sm text-slate-500">Recently registered customer accounts</p></div>
            <div class="divide-y divide-gray-100">@forelse ($latestCustomers as $customer)<div class="flex items-center justify-between px-6 py-4"><div><p class="font-semibold text-deepblack">{{ $customer->name }}</p><p class="text-sm text-slate-500">{{ $customer->email }}</p></div><p class="text-sm text-slate-500">{{ $customer->created_at->diffForHumans() }}</p></div>@empty <p class="px-6 py-12 text-center text-slate-500">No customer accounts have been created yet.</p>@endforelse</div>
        </section>
    @endcan
@endsection

@push('scripts')
    @can('bookings.view')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
        <script>
            const monthlyBookings = @json($monthlyBookings);
            const bookingStatuses = @json($bookingStatuses);
            new Chart(document.getElementById('monthly-bookings-chart'), { type: 'line', data: { labels: monthlyBookings.labels, datasets: [{ label: 'Bookings', data: monthlyBookings.values, borderColor: '#D4AF37', backgroundColor: 'rgba(212,175,55,.15)', fill: true, tension: .35, pointBackgroundColor: '#111111', pointRadius: 4 }] }, options: { maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { grid: { display: false } } } } });
            new Chart(document.getElementById('booking-status-chart'), { type: 'doughnut', data: { labels: bookingStatuses.labels, datasets: [{ data: bookingStatuses.values, backgroundColor: ['#D4AF37', '#2563eb', '#ef4444', '#64748b', '#16a34a'], borderWidth: 0 }] }, options: { maintainAspectRatio: false, cutout: '68%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, usePointStyle: true } } } } });
        </script>
    @endcan
@endpush
