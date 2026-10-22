<?php

namespace Database\Factories;

use App\Models\Model_Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model_Producto>
 */
class ProductFactory extends Factory
{
    protected $model = Model_Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'category' => fake()->randomElement(['Despensa', 'Bebidas', 'Limpieza']),
            'price' => fake()->randomFloat(2, 1, 500),
            'stock' => fake()->numberBetween(0, 100),
            'image' => null,
            'is_active' => true,
        ];
    }
}
