<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $post_id = Post::all()->pluck('id')->toArray();
        $user_id = User::all()->pluck('id')->toArray();
        $created_at = $this->faker->dateTimeBetween('-1 year', 'now');
        $updated_at = $this->faker->randomElement([null, $this->faker->dateTimeBetween($created_at, 'now')]);
        $deleted_at = $updated_at ? $this->faker->randomElement([null, $this->faker->dateTimeBetween($updated_at, 'now')]) : $this->faker->randomElement([null, $this->faker->dateTimeBetween($created_at, 'now')]);
        return [
            'content' => $this->faker->text(1000),
            'post_id' => Arr::random($post_id),
            'user_id' => Arr::random($user_id),
            'is_approved' => $this->faker->randomElement([0, 1]),
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'deleted_at' => $deleted_at
        ];
    }
}
