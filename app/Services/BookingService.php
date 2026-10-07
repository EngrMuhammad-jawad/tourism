<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Events\BookingCreated;
use App\Models\Booking;
use App\Models\Room;
use App\Models\TourPackage;
use App\Models\Transport;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookingService
{
    /**
     * Create a new booking and initialize pending payment inside a transaction.
     */
    public function createBooking(User $user, Model $bookable, array $data): Booking
    {
        $guests = (int) $data['adults'] + (int) ($data['children'] ?? 0);
        $unitPrice = $this->calculateUnitPrice($bookable);
        $totalPrice = $unitPrice * $guests;

        return DB::transaction(function () use ($user, $bookable, $data, $unitPrice, $totalPrice) {
            $booking = Booking::create([
                'user_id' => $user->id,
                'bookable_type' => $bookable::class,
                'bookable_id' => $bookable->id,
                'travel_date' => $data['travel_date'],
                'adults' => $data['adults'],
                'children' => $data['children'] ?? 0,
                'unit_price' => $unitPrice,
                'total_price' => $totalPrice,
                'payment_method' => $data['payment_method'],
                'status' => BookingStatus::Pending,
                'customer_note' => $data['customer_note'] ?? null,
            ]);

            $booking->payments()->create([
                'amount' => $booking->total_price,
                'method' => $booking->payment_method,
                'status' => PaymentStatus::Pending,
            ]);

            BookingCreated::dispatch($booking);

            return $booking;
        });
    }

    /**
     * Cancel an active booking and transition its status.
     */
    public function cancelBooking(Booking $booking): void
    {
        $booking->update([
            'status' => BookingStatus::Cancelled,
            'cancelled_at' => now(),
        ]);
    }

    /**
     * Determine unit price based on polymorphic bookable type.
     */
    public function calculateUnitPrice(Model $bookable): float
    {
        return match (true) {
            $bookable instanceof TourPackage => (float) $bookable->effectivePrice(),
            $bookable instanceof Room => (float) $bookable->price_per_night,
            $bookable instanceof Transport => (float) $bookable->price,
            default => (float) ($bookable->price ?? 0),
        };
    }
}
