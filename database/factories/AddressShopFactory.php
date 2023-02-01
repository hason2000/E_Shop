<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => rand(1, 100),
            'street' => $this->faker->title(),
            'ward' => $this->faker->title(),
            'city' => $this->faker->title(),
            'province' => $this->faker->title()
        ];
    }
}
