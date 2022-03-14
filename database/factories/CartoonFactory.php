<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartoonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'publish_on' => $this->faker->date(),
            'random_number' => sprintf("%05d", rand(0, 99999)),
            'rebus' => $this->faker->sentence(3),
        ];
    }
}
