<?php

namespace Database\Seeders;

use App\Models\Img;
use Illuminate\Database\Seeder;

class ImgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Img::factory()->count(1000)->create();
    }
}
