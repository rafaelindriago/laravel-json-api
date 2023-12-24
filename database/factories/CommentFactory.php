<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content'   => fake()->paragraph(3, true),
        ];
    }

    /**
     * Indicate that the model's should be hidden.
     */
    public function hidden(): static
    {
        return $this->state(fn(array $attributes) => [
            'hidden_at' => now(),
        ]);
    }
}
