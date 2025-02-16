<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
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
            'user_id' => \App\Models\User::factory(),
            'content' => fake()->sentence(),
            'is_read' => fake()->boolean()
        ];
    }
}
