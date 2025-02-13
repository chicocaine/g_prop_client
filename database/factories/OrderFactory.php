<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'order_details' => fake()->sentence(),
            'delivery_address' => fake()->address(),
            'status' => fake()->randomElement(['pending', 'completed', 'in progress']),
            'deadline' => fake()->dateTimeThisYear(),
        ];
    }
}
