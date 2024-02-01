<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Traits\UuidTrait;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    use UuidTrait;
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        // Create an admin user
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminadmin'),
            'is_admin' => true,
        ]);

        //Create a regular user
        User::create([
            'name' => 'ldicaprio',
            'email' => 'ldicaprio@example.com',
            'password' => Hash::make('123456'),
            'is_admin' => false,
        ]);

        
        User::create([
            'name' => 'mdamon',
            'email' => 'mdamon@example.com',
            'password' => Hash::make('123456'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'ajolie',
            'email' => 'ajolie@example.com',
            'password' => Hash::make('123456'),
            'is_admin' => false,
        ]);

    }
}
