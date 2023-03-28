<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition()
    {
        $orderStatus = OrderStatus::factory()->create()->first()->id;
        $payment = Payment::factory()->create()->first()->id;
        $products = Product::all()->pluck('id')->toArray();
        $userIds = User::all()->pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement($userIds),
            'order_status_id' => $orderStatus,
            'payment_id' => $payment,
            'uuid' => fake()->uuid(),
            'products' => json_encode([['product' => fake()->randomElement($products), 'quantity' => fake()->randomNumber(1)]]),
            'address' => json_encode(['billing' => fake()->address(), 'shipping' => fake()->address()]),
            'delivery_fee' => fake()->randomFloat(2, 0, 999999),
            'amount' => fake()->randomFloat(2, 0, 9999999999),
            'shipped_at' => null,
        ];
    }
}
