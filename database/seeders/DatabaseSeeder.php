<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\JWTToken;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\User;
use Database\Factories\JWTTokenFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Promotion::factory(10)->create();
        Post::factory(10)->create();
        Brand::factory(10)->create();
        Category::factory(10)->create();
        Product::factory(50)->create();
        Order::factory(10)->create();
    }
}
