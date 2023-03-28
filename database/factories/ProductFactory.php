<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition()
    {
        $categories = Category::all()->pluck('uuid')->toArray();
        $brands = Brand::all()->pluck('uuid')->toArray();

        return [
            'category_uuid' => fake()->randomElement($categories),
            'uuid' => fake()->uuid(),
            'title' => fake()->word(),
            'price' => fake()->randomFloat(2, 0, 1000000000),
            'description' => fake()->sentence(10),
            'metadata' => json_encode(['brand' => fake()->randomElement($brands)]),
            'deleted_at' => null,
        ];
    }
}
