<?php

namespace Database\Seeders;

use Database\Seeders\UsersTableSeeder;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    
    public function run()
    {
        $this->call(UsersTableSeeder::class);
    }
}

