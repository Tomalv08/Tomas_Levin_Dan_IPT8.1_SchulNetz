<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\TeacherStudent; // Importiere das Pivot-Modell

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Erstelle Lehrer
        $teacher = User::create([
            'name' => 'Tomas Alves',
            'email' => 'Tomas_TeixeiraAlves@sluz.ch',
            'password' => Hash::make('password123'),
            'is_teacher' => true, // Tomas ist ein Lehrer
        ]);

        // Erstelle Schüler
        $student1 = User::create([
            'name' => 'Levin Linder',
            'email' => 'Levin_Linder@sluz.ch',
            'password' => Hash::make('password123'),
            'is_teacher' => false, // Levin ist ein Schüler
        ]);

        $student2 = User::create([
            'name' => 'Dan Krummenacher',
            'email' => 'Dan_Krummenacher@sluz.ch',
            'password' => Hash::make('password123'),
            'is_teacher' => false, // Dan ist ein Schüler
        ]);

        // Weisen Sie die Schüler dem Lehrer zu (in der Pivot-Tabelle teacher_student)
        // Hier stellen wir sicher, dass wir die richtige Beziehung verwenden
        $teacher->students()->attach([$student1->id, $student2->id]);
    }
}
