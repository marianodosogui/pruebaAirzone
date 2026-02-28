<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'slug' => fake()->slug(),
            'picture' => fake()->imageUrl(),
            'short_content' => fake()->paragraph(),
            'content' => fake()->text(1000),
            'added' => now(),
            'updated' => now(),
            'comment' => true,
            'pending' => false,
            'public' => true,
            'active' => true,
        ];
    }
}
