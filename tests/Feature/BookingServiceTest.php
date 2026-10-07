<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_service_creates_booking_and_payment(): void
    {
        $user = User::factory()->create();
        $destination = Destination::create([
            'slug' => 'dubai-marina',
            'name' => 'Dubai Marina',
            'country' => 'United Arab Emirates',
            'city' => 'Dubai',
            'description' => 'Luxury waterfront living.',
            'status' => true,
        ]);

        $package = TourPackage::create([
            'destination_id' => $destination->id,
            'slug' => 'luxury-yacht-cruise',
            'name' => 'Luxury Yacht Cruise',
            'summary' => 'VIP yacht tour.',
            'description' => 'Full day VIP yacht tour in Dubai.',
            'price' => 150.00,
            'status' => true,
        ]);

        $service = app(BookingService::class);
        $booking = $service->createBooking($user, $package, [
            'travel_date' => now()->addDays(5)->format('Y-m-d'),
            'adults' => 2,
            'children' => 1,
            'payment_method' => PaymentMethod::Online->value,
            'customer_note' => 'Window seating preferred.',
        ]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'user_id' => $user->id,
            'unit_price' => 150.00,
            'total_price' => 450.00, // 3 guests * 150
            'status' => BookingStatus::Pending->value,
        ]);

        $this->assertDatabaseHas('payments', [
            'booking_id' => $booking->id,
            'amount' => 450.00,
            'status' => PaymentStatus::Pending->value,
        ]);
    }
}
