<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            DB::table('product_size')->insert([
                'product_id' => rand(1, 500),
                'size_id' => rand(1, 6),
                'amount' => rand(10, 20)
            ]);
        }
    }
}
