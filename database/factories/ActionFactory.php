<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Action>
 */
class ActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commission_id' => \App\Models\Commission::factory(),
            'name' => fake()->word(),
            'details' => fake()->sentence(),
            'status' => fake()->randomElement(['pending', 'completed', 'active']),
            'deadline' => fake()->dateTimeThisYear()
        ];
    }
}
