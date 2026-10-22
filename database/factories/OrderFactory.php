<?php

namespace Database\Factories;

use App\Models\Model_Orden;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model_Orden>
 */
class OrderFactory extends Factory
{
    protected $model = Model_Orden::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'customer_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'shipping_address' => fake()->address(),
            'payment_method' => 'bank_transfer',
            'status' => 'confirmed',
            'total' => fake()->randomFloat(2, 1, 1000),
        ];
    }
}
