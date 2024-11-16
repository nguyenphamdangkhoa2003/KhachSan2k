<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'price' => fake()->numberBetween(1, 1000000),
            'children' => fake()->numberBetween(1, 10),
            'adult' => fake()->numberBetween(1, 10),
            'description' => fake()->text(),
        ];
    }
}
