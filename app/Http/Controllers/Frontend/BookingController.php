<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\BookingStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\TourPackage;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.index', [
            'bookings' => $request->user()->bookings()
                ->with([
                    'payments',
                    'bookable' => function ($morphTo) {
                        $morphTo->morphWith([
                            Room::class => ['hotel'],
                            TourPackage::class => ['destination'],
                        ]);
                    },
                ])
                ->latest()
                ->paginate(12),
        ]);
    }

    public function create(Request $request)
    {
        $request->validate(['type' => ['required', Rule::in(['package', 'room', 'transport'])], 'id' => ['required', 'integer']]);

        return view('frontend.bookings.create', ['bookable' => $this->bookable($request->string('type')->toString(), $request->integer('id'))]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['package', 'room', 'transport'])],
            'id' => ['required', 'integer'],
            'travel_date' => ['required', 'date', 'after_or_equal:today'],
            'adults' => ['required', 'integer', 'min:1', 'max:100'],
            'children' => ['nullable', 'integer', 'min:0', 'max:100'],
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)],
            'customer_note' => ['nullable', 'string', 'max:2000'],
        ]);
        $bookable = $this->bookable($data['type'], $data['id']);
        $guests = $data['adults'] + ($data['children'] ?? 0);
        $unitPrice = match (true) {
            $bookable instanceof TourPackage => $bookable->effectivePrice(),
            $bookable instanceof Room => (float) $bookable->price_per_night,
            $bookable instanceof Transport => (float) $bookable->price,
            default => (float) ($bookable->price ?? 0),
        };

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'bookable_type' => $bookable::class,
            'bookable_id' => $bookable->id,
            'travel_date' => $data['travel_date'],
            'adults' => $data['adults'],
            'children' => $data['children'] ?? 0,
            'unit_price' => $unitPrice,
            'total_price' => $unitPrice * $guests,
            'payment_method' => $data['payment_method'],
            'status' => BookingStatus::Pending,
            'customer_note' => $data['customer_note'] ?? null,
        ]);

        $booking->payments()->create([
            'amount' => $booking->total_price,
            'method' => $booking->payment_method,
            'status' => PaymentStatus::Pending,
        ]);

        return redirect()->route('dashboard')->with('success', "Booking {$booking->booking_number} was submitted successfully.");
    }

    public function cancel(Request $request, Booking $booking)
    {
        abort_unless($booking->user_id === $request->user()->id, 403);
        abort_unless($booking->status->isCancellable(), 422, 'This booking can no longer be cancelled.');

        $booking->update(['status' => BookingStatus::Cancelled, 'cancelled_at' => now()]);

        return back()->with('success', 'Your booking has been cancelled.');
    }

    private function bookable(string $type, int $id): TourPackage|Room|Transport
    {
        $model = match ($type) {
            'package' => TourPackage::class,
            'room' => Room::class,
            'transport' => Transport::class,
        };
        $bookable = $model::findOrFail($id);

        abort_unless($bookable->status, 404);

        return $bookable;
    }
}
