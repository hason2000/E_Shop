<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImgFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => rand(0, 500),
            'link' => $this->faker->imageUrl()
        ];
    }
}
