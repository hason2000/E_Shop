<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 500; $i++) {
            DB::table('cart_product')->insert([
                'cart_id' => rand(1, 100),
                'product_id' => rand(1, 500),
                'amount' => rand(2, 5)
            ]);
        }
    }
}
