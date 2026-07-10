<?php

namespace Database\Factories;

use App\Enums\ModerationStatus;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => null,
            'name' => fake()->name(),
            'country' => fake()->country(),
            'rating' => fake()->numberBetween(4, 5),
            'content' => fake()->paragraph(),
            'status' => ModerationStatus::Approved,
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => ModerationStatus::Pending]);
    }
}
