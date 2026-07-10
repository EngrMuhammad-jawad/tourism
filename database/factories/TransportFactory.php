<?php

namespace Database\Factories;

use App\Enums\TransportType;
use App\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Transport>
 */
class TransportFactory extends Factory
{
    public function definition(): array
    {
        $type = fake()->randomElement(TransportType::cases());
        $name = ucwords(fake()->unique()->words(2, true)).' '.ucfirst($type->value);

        return [
            'type' => $type,
            'slug' => Str::slug($name),
            'name' => ['en' => $name],
            'description' => ['en' => fake()->sentence(15)],
            'capacity' => fake()->numberBetween(2, 50),
            'price' => fake()->randomFloat(2, 40, 600),
            'price_unit' => 'per_day',
            'status' => true,
        ];
    }
}
