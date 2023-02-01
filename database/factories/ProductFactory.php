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
            'shop_id' => rand(1, 10),
            'category_id' => rand(1, 9),
            'brand_id' => rand(1, 6),
            'name' => $this->faker->title(),
            'price' => $this->faker->randomFloat(1, 10, 200),
            'detail' => $this->faker->text(100),
            'img_link' => $this->faker->imageUrl()
        ];
    }
}
