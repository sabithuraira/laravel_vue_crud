<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name'     => $this->faker->name(),
            'quantity'     => $this->faker->randomDigit(),
            'price'     => $this->faker->randomDigit(),
        ];
    }
}
