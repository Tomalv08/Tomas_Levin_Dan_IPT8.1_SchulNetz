<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Tomas Alves',
            'email' => 'Tomas_TeixeiraAlves@sluz.ch',
            'password' => Hash::make('password123'), 
        ]);

        User::create([
            'name' => 'Levin Linder',
            'email' => 'Levin_Linder@sluz.ch',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Dan Krummenacher',
            'email' => 'Dan_Krummenacher@sluz.ch',
            'password' => Hash::make('password123'),
        ]);
    }
}