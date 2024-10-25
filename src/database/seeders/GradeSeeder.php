<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\TeacherStudent;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Hol dir den Lehrer
        $teacher = User::where('is_teacher', true)->first();

        // Hol dir die Schüler
        $students = User::where('is_teacher', false)->get(); // Nur Schüler

        // Testnamen für die BM-Fächer
        $testNamesBM = [
            'Deutsch' => ['Bildanalyse', 'Textverständnis', 'Grammatikprüfung'],
            'Mathematik' => ['Geometrie', 'Algebra', 'Statistik'],
            'Französisch' => ['Vokabeltest', 'Grammatiktest', 'Leseverständnis'],
            'Englisch' => ['Listening Comprehension', 'Essay Writing', 'Vocabulary Quiz'],
            'Finanz- und Rechnungswesen' => ['Bilanzen erstellen', 'Kostenrechnung', 'Finanzanalyse'],
            'Wirtschaft und Recht' => ['Rechtliche Grundlagen', 'Wirtschaftsrecht', 'Marktanalyse'],
            'Geschichte und Politik' => ['Quellenanalyse', 'Historische Interpretation', 'Politik der Gegenwart']
        ];

        foreach ($students as $student) {
            // Prüfen, ob die Beziehung bereits existiert
            $exists = TeacherStudent::where('teacher_id', $teacher->id)
                ->where('student_id', $student->id)
                ->exists();

            if (!$exists) {
                // Füge den Schüler dem Lehrer hinzu (teacher_student Beziehung)
                TeacherStudent::create([
                    'teacher_id' => $teacher->id,
                    'student_id' => $student->id,
                ]);
            }

            // Hol dir alle relevanten Fächer (Informatik und BM)
            $subjects = Subject::whereIn('type', ['Informatik', 'BM'])->get();

            // Füge für jedes Fach Noten hinzu
            foreach ($subjects as $subject) {
                if ($subject->type === 'BM') {
                    // Füge für BM-Fächer drei Noten hinzu
                    if (isset($testNamesBM[$subject->name])) {
                        for ($i = 0; $i < 3; $i++) { // Drei Noten pro Fach
                            $testName = $testNamesBM[$subject->name][array_rand($testNamesBM[$subject->name])]; // Wähle einen zufälligen Testnamen

                            // Überprüfen, ob die Note bereits existiert
                            $gradeExists = Grade::where('user_id', $student->id)
                                ->where('subject_id', $subject->id)
                                ->where('description', "{$subject->name} - {$testName}")
                                ->exists();

                            if (!$gradeExists) {
                                // Erstelle die Note
                                Grade::create([
                                    'user_id' => $student->id,
                                    'subject_id' => $subject->id,
                                    'grade' => rand(3, 6), // Beispielwerte zwischen 3 und 6
                                    'description' => "{$subject->name} - {$testName}",
                                    'weight' => 1
                                ]);
                            }
                        }
                    }
                } elseif ($subject->type === 'Informatik') {
                    // Füge für Informatik-Fächer fortlaufende Testnamen hinzu
                    for ($i = 1; $i <= 3; $i++) { // Drei Noten pro Fach
                        $testName = "{$subject->name} Test {$i}"; // Generiere fortlaufende Testnamen

                        // Überprüfen, ob die Note bereits existiert
                        $gradeExists = Grade::where('user_id', $student->id)
                            ->where('subject_id', $subject->id)
                            ->where('description', "{$subject->name} - {$testName}")
                            ->exists();

                        if (!$gradeExists) {
                            // Erstelle die Note
                            Grade::create([
                                'user_id' => $student->id,
                                'subject_id' => $subject->id,
                                'grade' => rand(3, 6), // Beispielwerte zwischen 3 und 6
                                'description' => "{$subject->name} - {$testName}",
                                'weight' => 1
                            ]);
                        }
                    }
                }
            }
        }
    }
}
