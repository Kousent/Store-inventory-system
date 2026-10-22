<?php

namespace Database\Factories;

use App\Models\Model_Orden;
use App\Models\Model_OrdenItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model_OrdenItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = Model_OrdenItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Model_Orden::factory(),
            'product_id' => null,
            'product_name' => fake()->words(3, true),
            'unit_price' => fake()->randomFloat(2, 1, 500),
            'quantity' => fake()->numberBetween(1, 5),
            'subtotal' => fake()->randomFloat(2, 1, 1000),
        ];
    }
}
