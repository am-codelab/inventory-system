<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $purchasePrice = fake()->randomFloat(2, 5, 500);

        return [
            'category_id'    => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'code'           => strtoupper(fake()->unique()->bothify('PRD-#####')),
            'name'           => fake()->words(rand(2, 4), true),
            'description'    => fake()->optional()->sentence(),
            'purchase_price' => $purchasePrice,
            'sale_price'     => $purchasePrice * fake()->randomFloat(2, 1.10, 1.80),
            'stock'          => fake()->numberBetween(0, 200),
            'minimum_stock'  => fake()->numberBetween(0, 20),
            'is_active'      => fake()->boolean(95),
        ];
    }
}
