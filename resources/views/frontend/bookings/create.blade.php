@extends('layouts.app')

@section('title', 'Book '.$bookable->name.' | UAE Tourism')

@section('content')
<section class="pt-32 pb-20 bg-offwhite min-h-screen">
    <div class="container mx-auto max-w-2xl px-6 py-8">
        <div class="mb-6 text-center">
            <span class="text-xs font-bold uppercase tracking-widest text-gold">Reservation Request</span>
            <h1 class="text-3xl font-bold text-deepblack mt-1">Complete Your Booking</h1>
            <p class="mt-2 text-lg font-semibold text-slate-700">{{ $bookable->name }}</p>
        </div>

        <form method="POST" action="{{ route('bookings.store') }}" class="space-y-6 rounded-3xl bg-white p-8 shadow-xl border border-gray-100">
            @csrf
            @php
                $type = $bookable instanceof \App\Models\TourPackage ? 'package' : ($bookable instanceof \App\Models\Room ? 'room' : 'transport');
                $price = match (true) {
                    $bookable instanceof \App\Models\TourPackage => $bookable->effectivePrice(),
                    $bookable instanceof \App\Models\Room => (float) $bookable->price_per_night,
                    $bookable instanceof \App\Models\Transport => (float) $bookable->price,
                    default => (float) ($bookable->price ?? 0),
                };
            @endphp
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="id" value="{{ $bookable->id }}">

            <!-- Service Summary Card -->
            <div class="rounded-2xl bg-amber-50/50 border border-amber-200/60 p-5 flex justify-between items-center">
                <div>
                    <span class="text-xs font-bold uppercase text-amber-800 tracking-wider">Unit Price</span>
                    <p class="text-2xl font-bold text-gold">${{ number_format($price, 2) }}</p>
                </div>
                <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-amber-100 text-amber-900 capitalize">{{ $type }}</span>
            </div>

            <div>
                <label for="travel_date" class="block text-sm font-bold text-gray-700">Travel / Check-in Date</label>
                <input type="date" id="travel_date" name="travel_date" min="{{ now()->toDateString() }}" value="{{ old('travel_date', now()->toDateString()) }}" class="mt-1.5 w-full rounded-xl border-gray-300 shadow-sm focus:border-gold focus:ring-gold text-sm p-3" required>
                @error('travel_date')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="adults" class="block text-sm font-bold text-gray-700">Adults (Age 12+)</label>
                    <input type="number" id="adults" name="adults" min="1" max="100" value="{{ old('adults', 1) }}" class="mt-1.5 w-full rounded-xl border-gray-300 shadow-sm focus:border-gold focus:ring-gold text-sm p-3" required>
                    @error('adults')
                        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="children" class="block text-sm font-bold text-gray-700">Children (Optional)</label>
                    <input type="number" id="children" name="children" min="0" max="100" value="{{ old('children', 0) }}" class="mt-1.5 w-full rounded-xl border-gray-300 shadow-sm focus:border-gold focus:ring-gold text-sm p-3">
                    @error('children')
                        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="payment_method" class="block text-sm font-bold text-gray-700">Payment Preference</label>
                <select id="payment_method" name="payment_method" class="mt-1.5 w-full rounded-xl border-gray-300 shadow-sm focus:border-gold focus:ring-gold text-sm p-3">
                    <option value="pay_later" @selected(old('payment_method') === 'pay_later')>Pay Later (Upon Arrival / Confirmation)</option>
                    <option value="online" @selected(old('payment_method') === 'online')>Online Payment (Credit / Debit Card)</option>
                </select>
                @error('payment_method')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="customer_note" class="block text-sm font-bold text-gray-700">Special Requests / Notes (Optional)</label>
                <textarea id="customer_note" name="customer_note" rows="3" placeholder="Flight details, dietary requirements, or special accommodations..." class="mt-1.5 w-full rounded-xl border-gray-300 shadow-sm focus:border-gold focus:ring-gold text-sm p-3">{{ old('customer_note') }}</textarea>
                @error('customer_note')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            @if($errors->any() && !$errors->has('travel_date') && !$errors->has('adults') && !$errors->has('payment_method'))
                <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm font-medium text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="w-full rounded-xl bg-deepblack py-4 font-bold text-white shadow-lg hover:bg-gold hover:text-deepblack transition-all duration-300 transform hover:-translate-y-0.5 text-base">Submit Booking Request</button>
        </form>
    </div>
</section>
@endsection
