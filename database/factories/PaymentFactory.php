<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    public function definition()
    {
        $types = [
            'credit_card',
            'cash_on_delivery',
            'bank_transfer',
        ];

        $type = fake()->randomElement($types);

        switch ($type) {
            case 'credit_card':
                $details = json_encode([
                    "holder_name" => fake()->name(),
                    "number" => fake()->numberBetween(1000000000000000, 9999999999999999),
                    "ccv" => fake()->randomNumber(3),
                    "expire_date" => fake()->date('m/y'),
                ]);
                break;
            case 'cash_on_delivery' :
                $details = json_encode([
                    "first_name" => fake()->firstName(),
                    "last_name" => fake()->lastName(),
                    "address" => fake()->address(),
                ]);
                break;
            case 'bank_transfer' :
                $details = json_encode([
                    "swift" => fake()->regexify('[A-Za-z0-9]{11}'),
                    "iban" => fake()->regexify('[A-Za-z0-9]{34}'),
                    "name" => fake()->name(),
                ]);
        }

        return [
            'uuid' => fake()->uuid(),
            'type' => $type,
            'details' => $details,
        ];
    }
}
