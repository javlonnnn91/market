<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'tin' => (string)$this->faker->numberBetween(100000000, 999999999),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}