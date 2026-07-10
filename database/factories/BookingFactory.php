<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Enums\PaymentMethod;
use App\Models\Booking;
use App\Models\TourPackage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        $adults = fake()->numberBetween(1, 4);
        $children = fake()->numberBetween(0, 3);
        $unitPrice = fake()->randomFloat(2, 25, 900);

        return [
            'user_id' => User::factory(),
            'bookable_type' => TourPackage::class,
            'bookable_id' => TourPackage::factory(),
            'travel_date' => fake()->dateTimeBetween('+3 days', '+3 months'),
            'adults' => $adults,
            'children' => $children,
            'unit_price' => $unitPrice,
            'total_price' => round($unitPrice * ($adults + $children), 2),
            'payment_method' => fake()->randomElement(PaymentMethod::cases()),
            'status' => fake()->randomElement(BookingStatus::cases()),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => BookingStatus::Pending]);
    }
}
