<?php

namespace Database\Seeders;

use App\Models\AddressShop;
use Illuminate\Database\Seeder;

class AddressShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AddressShop::factory()->count(100)->create();
    }
}
