<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachement>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_name' => fake()->word() . '.' . fake()->fileExtension(),
            'uploaded_by' => \App\Models\User::factory(),
            'file_path' => fake()->word(),
            'file_size' => fake()->randomNumber(2) . 'KB',
            'file_type' => fake()->word()
        ];
    }
}
