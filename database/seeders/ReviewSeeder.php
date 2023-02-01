<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 200; $i++) {
            DB::table('reviews')->insert([
                'product_id' => rand(1, 500),
                'user_id' => rand(1, 20),
                'rating' => random_int(1, 5),
                'content' => Str::random(25),
                'created_at' => date("") . now(),
                'updated_at' => date("") . now(),
            ]);
        }
    }
}
