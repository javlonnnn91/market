<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'provider_id' => $this->faker->address,
            'level' => 1,
        ];
    }

    public function withParent(Category $parent, int $level = null): CategoryFactory|Factory
    {
        return $this->state(function () use ($parent, $level) {
            return [
                'name' => $this->faker->word,
                'provider_id' => null,
                'parent_id' => $parent->id,
                'level' => $level ?? ($parent->level + 1),
            ];
        });
    }
}
