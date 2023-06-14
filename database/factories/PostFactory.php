<?php

namespace Database\Factories;

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
            'user_id' => fake()->numberBetween(1, 10),
            'title' =>  fake()->sentence(),
            'content' => fake()->paragraph(5),
            'status' => 1,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'),
        ];
    }
}
