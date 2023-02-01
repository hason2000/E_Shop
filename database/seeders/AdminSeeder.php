<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'username' => 'admintest1',
            'password' => bcrypt('123456'),
            'phone_number' => '0967093640',
            'email' => 'sonhabg2000@gmail.com',
            'role' => '1',
        ]);
    }
}
