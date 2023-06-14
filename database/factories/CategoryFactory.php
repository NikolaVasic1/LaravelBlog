<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $created_at = $this->faker->dateTimeBetween('-1 year', 'now');
        $updated_at = $this->faker->dateTimeBetween($created_at, 'now');
        return [
            'parent_id' => null,
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->randomElement([null, $this->faker->paragraph()]),
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
    }
}
