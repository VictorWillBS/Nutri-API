<?php

namespace Database\Factories;

use App\Enums\Products\ProductStatus;
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
            'code' => fake()->isbn10(),
            'name' => fake()->word(),
            'url' => fake()->url(),
            'data' => [],
            'status' => fake()->randomElement([
                ProductStatus::Draft,
                ProductStatus::Published,
                ProductStatus::Trashed
            ]),
            'imported_t' => now(),
        ];
    }
}
