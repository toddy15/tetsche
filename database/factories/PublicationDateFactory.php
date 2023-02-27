<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cartoon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicationDateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cartoon_id' => Cartoon::factory()->create(),
            'publish_on' => fake()->date(),
        ];
    }
}
