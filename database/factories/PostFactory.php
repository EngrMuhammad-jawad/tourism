<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\BlogCategory;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = ucfirst(fake()->unique()->sentence(6));

        return [
            'user_id' => User::factory(),
            'blog_category_id' => BlogCategory::factory(),
            'slug' => Str::slug($title),
            'title' => ['en' => $title],
            'excerpt' => ['en' => fake()->sentence(20)],
            'content' => ['en' => fake()->paragraphs(6, true)],
            'meta_title' => $title,
            'meta_description' => fake()->sentence(18),
            'status' => PostStatus::Published,
            'published_at' => fake()->dateTimeBetween('-6 months'),
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => PostStatus::Draft, 'published_at' => null]);
    }
}
