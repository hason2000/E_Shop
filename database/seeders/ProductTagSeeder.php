<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 500; $i++) {
            DB::table('product_tag')->insert([
                'product_id' => rand(1, 500),
                'tag_id' => rand(1, 50)
            ]);
        }
    }
}
