<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\User::create([
        'name' => 'Tomas',
        'email' => 'alves.t.tomas@gmail.com',
        'password' => bcrypt('password'),
    ]);

    \App\Models\User::create([
        'name' => 'Levin',
        'email' => 'Levin_Linder@sluz.ch',
        'password' => bcrypt('password'),
    ]);

    \App\Models\User::create([
        'name' => 'Dan',
        'email' => 'Dan_Krummenacher@sluz.ch',
        'password' => bcrypt('password'),
    ]);
}
}
