<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Hotel>
 */
class HotelFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->company().' Hotel';

        return [
            'destination_id' => Destination::factory(),
            'slug' => Str::slug($name),
            'name' => ['en' => $name],
            'star_rating' => fake()->numberBetween(3, 5),
            'description' => ['en' => fake()->paragraphs(2, true)],
            'address' => fake()->streetAddress(),
            'status' => true,
        ];
    }
}
