<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::factory(),
            'name' => ['en' => fake()->randomElement(['Standard Room', 'Deluxe Room', 'Junior Suite', 'Executive Suite', 'Royal Suite'])],
            'price_per_night' => fake()->randomFloat(2, 80, 1500),
            'capacity' => fake()->numberBetween(1, 6),
            'quantity' => fake()->numberBetween(1, 20),
            'status' => true,
        ];
    }
}
