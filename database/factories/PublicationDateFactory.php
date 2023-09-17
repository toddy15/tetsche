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
        $cartoon = Cartoon::factory()->create();

        return [
            'cartoon_id' => $cartoon->id,
            'publish_on' => $cartoon->publish_on,
        ];
    }
}
