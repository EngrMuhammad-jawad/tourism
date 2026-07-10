@extends('layouts.admin')

@section('title', 'Reports')
@section('page_heading', 'Reports')

@section('content')
    <div class="mb-8"><h2 class="text-2xl font-bold text-deepblack">Reports</h2><p class="mt-1 text-sm text-slate-500">Booking metrics and financial reporting will appear here as bookings are recorded.</p></div>
    <div class="grid gap-5 md:grid-cols-3"><div class="rounded-2xl bg-white p-6 shadow-sm"><p class="text-sm text-slate-500">Total bookings</p><p class="mt-2 text-3xl font-bold">{{ \App\Models\Booking::count() }}</p></div><div class="rounded-2xl bg-white p-6 shadow-sm"><p class="text-sm text-slate-500">Approved bookings</p><p class="mt-2 text-3xl font-bold">{{ \App\Models\Booking::where('status', 'approved')->count() }}</p></div><div class="rounded-2xl bg-white p-6 shadow-sm"><p class="text-sm text-slate-500">Completed revenue</p><p class="mt-2 text-3xl font-bold text-gold">${{ number_format((float) \App\Models\Booking::where('status', 'completed')->sum('total_price'), 2) }}</p></div></div>
@endsection
