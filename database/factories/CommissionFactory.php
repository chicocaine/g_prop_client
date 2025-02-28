<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commission>
 */
class CommissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'set_price' => fake()->randomFloat(2, 0, 1000),
            'details' => fake()->sentence(),
            'delivery_address' => fake()->address(),
            'status' => fake()->randomElement(['cancelled', 'completed', 'pending', 'active']),
            'deadline' => fake()->dateTimeThisYear(),
            'completed_at' => fake()->dateTimeThisYear()
        ];
    }
}
