<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(AddressSeeder::class);
        // $this->call(BlogSeeder::class);
        // $this->call(BrandSeeder::class);
        // $this->call(CartSeeder::class);
        // $this->call(CartProductSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(ImgSeeder::class);
         $this->call(ProductSeeder::class);
        // $this->call(ProductSizeSeeder::class);
        // $this->call(ProductTagSeeder::class);
        // $this->call(ReviewSeeder::class);
        // $this->call(ShopSeeder::class);
        // $this->call(TagSeeder::class);
//        $this->call(UserSeeder::class);
        // $this->call(AdminSeeder::class);
        // $this->call(AddressShopSeeder::class);
    }
}
