<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address_id' => rand(0, 100),
            'name' => $this->faker->title(),
            'detail' => $this->faker->text(255),
            'img_shop' => $this->faker->imageUrl(),
            'web_site' => $this->faker->url()
        ];
    }
}
