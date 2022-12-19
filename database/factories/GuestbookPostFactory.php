<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GuestbookPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'message' => $this->faker->paragraph(3),
            'cheffe' => rand(0, 10) <= 3 ? $this->faker->sentence(5) : '',
            'category' => 'no_autolearn_h',
            'spam_detection' => $this->faker->userAgent(),
        ];
    }
}
