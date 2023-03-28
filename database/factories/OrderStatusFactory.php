<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderStatus>
 */
class OrderStatusFactory extends Factory
{
    public function definition()
    {
        $statuses = ['New', 'In progress', 'Shipped', 'Delivered', 'Cancelled'];

        return [
            'uuid' => fake()->uuid(),
            'title' => fake()->randomElement($statuses),
        ];
    }
}
