<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartoonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'publish_on' => fake()->unique()->date(),
            'random_number' => sprintf('%05d', rand(0, 99999)),
            'rebus' => fake()->sentence(3),
        ];
    }
}
