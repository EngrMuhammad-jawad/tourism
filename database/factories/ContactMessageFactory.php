<?php

namespace Database\Factories;

use App\Enums\ContactStatus;
use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->e164PhoneNumber(),
            'subject' => fake()->sentence(5),
            'message' => fake()->paragraph(),
            'status' => ContactStatus::New,
        ];
    }
}
