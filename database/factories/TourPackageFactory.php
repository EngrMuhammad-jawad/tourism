<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\TourPackage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TourPackage>
 */
class TourPackageFactory extends Factory
{
    public function definition(): array
    {
        $name = ucwords(fake()->unique()->words(3, true)).' Tour';
        $days = fake()->numberBetween(1, 7);

        return [
            'destination_id' => Destination::factory(),
            'slug' => Str::slug($name),
            'name' => ['en' => $name],
            'summary' => ['en' => fake()->sentence(12)],
            'description' => ['en' => fake()->paragraphs(3, true)],
            'price' => fake()->randomFloat(2, 25, 900),
            'sale_price' => null,
            'duration_days' => $days,
            'duration_nights' => max(0, $days - 1),
            'max_guests' => fake()->numberBetween(4, 30),
            'included_services' => ['en' => ['Hotel pickup & drop-off', 'Professional guide', 'Bottled water']],
            'excluded_services' => ['en' => ['Personal expenses', 'Travel insurance']],
            'available_from' => now()->subMonth(),
            'available_to' => now()->addYear(),
            'is_featured' => false,
            'status' => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }
}
