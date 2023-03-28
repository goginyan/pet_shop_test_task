<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    public function definition()
    {
        $brand = fake()->word();

        return [
            'uuid' => fake()->uuid(),
            'title' => $brand,
            'slug' => fake()->slug(),
        ];
    }
}
