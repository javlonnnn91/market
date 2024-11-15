<?php

namespace Database\Factories;

use App\Models\StorageProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StorageProduct>
 */
class StorageProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'storage_id' => $this->faker->numberBetween(2, 4),
            'product_id' => $this->faker->numberBetween(2, 4),
            'batch_id' => $this->faker->numberBetween(2, 4),
            'quantity' => $this->faker->numberBetween(2, 4)
        ];

    }
}
