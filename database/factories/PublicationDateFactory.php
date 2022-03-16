<?php

namespace Database\Factories;

use App\Models\Cartoon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicationDateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cartoon_id' => Cartoon::factory()->create(),
            'publish_on' => $this->faker->date(),
        ];
    }
}
