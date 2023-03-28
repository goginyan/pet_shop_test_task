<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promotion>
 */
class PromotionFactory extends Factory
{
    public function definition()
    {
        $valid_from = fake()->dateTimeBetween('2023-01-01', '2023-11-30');

        return [
            'uuid' => fake()->uuid(),
            'title' => fake()->word(),
            'content' => fake()->sentence(10),
            'metadata' => json_encode(['valid_from' => $valid_from,
                                        'valid_to' => fake()->dateTimeBetween($valid_from, '2023-12-31'),
                                        'image' => null]),
        ];
    }
}
