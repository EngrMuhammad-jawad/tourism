<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question' => ['en' => fake()->sentence().'?'],
            'answer' => ['en' => fake()->paragraph()],
            'sort_order' => fake()->numberBetween(0, 100),
            'status' => true,
        ];
    }
}
