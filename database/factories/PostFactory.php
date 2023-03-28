<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition()
    {
        $title = fake()->sentence(3);

        return [
            'uuid' => fake()->uuid(),
            'title' => $title,
            'slug' => fake()->slug(),
            'content' => fake()->sentence(10),
            'metadata' => json_encode(['author' => fake()->name()]),
        ];
    }
}
