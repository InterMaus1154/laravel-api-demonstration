<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        return [
            'category_id' => fake()->randomElement(Category::pluck('category_id')->toArray()),
            'user_id' => User::factory(),
            'product_name' => fake()->text(maxNbChars: 200),
            'product_price' => fake()->randomFloat(nbMaxDecimals: 1, max:1000),
            'product_stock' => fake()->randomNumber(nbDigits: 2),
            'product_hidden' => fake()->boolean()
        ];
    }
}
