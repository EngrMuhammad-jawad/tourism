<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Destination>
 */
class DestinationFactory extends Factory
{
    public function definition(): array
    {
        $city = fake()->unique()->city();

        return [
            'slug' => Str::slug($city),
            'name' => ['en' => $city],
            'country' => 'United Arab Emirates',
            'city' => $city,
            'description' => ['en' => fake()->paragraph()],
            'map_lat' => fake()->latitude(22.6, 26.1),
            'map_lng' => fake()->longitude(51.5, 56.4),
            'is_featured' => false,
            'status' => true,
            'sort_order' => 0,
        ];
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }
}
