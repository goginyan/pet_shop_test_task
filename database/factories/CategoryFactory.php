<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition()
    {
        $category = fake()->word();

        return [
            'uuid' => fake()->uuid(),
            'title' => $category,
            'slug' => fake()->slug(),
        ];
    }
}
