<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function checkPromotion(Request $request)
    {
        $user = $request->user();
    
        // Wenn der Benutzer ein Lehrer ist
        if ($user->students()->exists()) {
            $students = $user->students()->with('grades.subject')->get();
            $studentData = [];
    
            foreach ($students as $student) {
                $totalWeightedGrade = 0;
                $totalWeight = 0;
                $bmInsufficientGrades = 0; // Noten unter 4 in BM-Fächern
                $bmSubjectsBelow4 = 0; // BM-Fächer, deren Durchschnitt unter 4 liegt
                $informaticsAverage = 0; // Durchschnitt der Informatik-Fächer
                $informaticsSubjects = 0; // Anzahl der Informatik-Fächer

                // Gruppiere Noten nach Fach
                $gradesBySubject = $student->grades->groupBy('subject_id');
                
                foreach ($gradesBySubject as $subjectId => $grades) {
                    $subjectAverage = $grades->avg('grade');
                    $subjectType = $grades->first()->subject->type;

                    // Berechne Gesamtgewichtung und Noten
                    foreach ($grades as $grade) {
                        $totalWeightedGrade += $grade->grade * $grade->weight;
                        $totalWeight += $grade->weight;

                        // Prüfe, ob Note unter 4 und Fach ein BM-Fach ist
                        if ($subjectType === 'BM' && $grade->grade < 4.0) {
                            $bmInsufficientGrades++;
                        }
                    }

                    // Prüfe, ob Durchschnitt in BM-Fächern unter 4.0 liegt
                    if ($subjectType === 'BM' && $subjectAverage < 4.0) {
                        $bmSubjectsBelow4++;
                    }

                    // Berechne Durchschnitt der Informatik-Fächer
                    if ($subjectType === 'Informatik') {
                        $informaticsAverage += $subjectAverage;
                        $informaticsSubjects++;
                    }
                }

                // Durchschnitt aller Noten berechnen
                $average = $totalWeight ? $totalWeightedGrade / $totalWeight : 0;
                $informaticsAverage = $informaticsSubjects ? $informaticsAverage / $informaticsSubjects : 0;

                // Promotionsbedingungen
                $isPromoted = $average >= 4.0 
                    && $bmSubjectsBelow4 <= 2 
                    && $bmInsufficientGrades <= 2 
                    && $informaticsAverage >= 4.0;

                // Studentendaten speichern
                $studentData[] = [
                    'student_name' => $student->name,
                    'average' => round($average, 2),
                    'informaticsAverage' => round($informaticsAverage, 2),
                    'bmSubjectsBelow4' => $bmSubjectsBelow4,
                    'bmInsufficientGrades' => $bmInsufficientGrades,
                    'isPromoted' => $isPromoted,
                ];
            }

            return response()->json(['students' => $studentData], 200);
        } else {
            // Falls der Benutzer ein Schüler ist
            $grades = $user->grades()->with('subject')->get();
            $totalWeightedGrade = 0;
            $totalWeight = 0;
            $bmInsufficientGrades = 0;
            $bmSubjectsBelow4 = 0;
            $informaticsAverage = 0;
            $informaticsSubjects = 0;

            // Gruppiere Noten nach Fach
            $gradesBySubject = $grades->groupBy('subject_id');

            foreach ($gradesBySubject as $subjectId => $grades) {
                $subjectAverage = $grades->avg('grade');
                $subjectType = $grades->first()->subject->type;

                foreach ($grades as $grade) {
                    $totalWeightedGrade += $grade->grade * $grade->weight;
                    $totalWeight += $grade->weight;

                    if ($subjectType === 'BM' && $grade->grade < 4.0) {
                        $bmInsufficientGrades++;
                    }
                }

                if ($subjectType === 'BM' && $subjectAverage < 4.0) {
                    $bmSubjectsBelow4++;
                }

                if ($subjectType === 'Informatik') {
                    $informaticsAverage += $subjectAverage;
                    $informaticsSubjects++;
                }
            }

            $average = $totalWeight ? $totalWeightedGrade / $totalWeight : 0;
            $informaticsAverage = $informaticsSubjects ? $informaticsAverage / $informaticsSubjects : 0;
            $isPromoted = $average >= 4.0 && $bmSubjectsBelow4 <= 2 && $bmInsufficientGrades <= 2 && $informaticsAverage >= 4.0;

            return response()->json([
                'average' => round($average, 2),
                'informaticsAverage' => round($informaticsAverage, 2),
                'bmSubjectsBelow4' => $bmSubjectsBelow4,
                'bmInsufficientGrades' => $bmInsufficientGrades,
                'isPromoted' => $isPromoted
            ], 200);
        }
    }
    


    public function checkInformatikPromotion(Request $request)
    {
        $user = $request->user();
    
        if ($user->students()->exists()) {
            $students = $user->students()->with(['grades' => function($query) {
                $query->whereHas('subject', function ($query) {
                    $query->where('type', 'Informatik'); // Nur Informatik-Fächer auswählen
                });
            }])->get();
    
            $studentData = [];
    
            foreach ($students as $student) {
                $totalWeightedGrade = 0;
                $totalWeight = 0;
                $insufficientGrades = 0;
                $informatikSubjectsBelow4 = 0; // Anzahl der Informatik-Fächer mit Durchschnitt unter 4
    
                // Gruppiere die Informatik-Noten nach Fach
                $gradesBySubject = $student->grades->groupBy('subject_id');
    
                foreach ($gradesBySubject as $subjectId => $grades) {
                    $subjectAverage = $grades->avg('grade'); // Durchschnitt für das Fach
    
                    // Prüfe, ob der Durchschnitt des Informatik-Fachs unter 4 liegt
                    if ($subjectAverage < 4.0) {
                        $informatikSubjectsBelow4++;
                    }
    
                    // Berechne Gesamtgewichtung und Noten
                    foreach ($grades as $grade) {
                        $totalWeightedGrade += $grade->grade * $grade->weight;
                        $totalWeight += $grade->weight;
    
                        // Zähle ungenügende Noten
                        if ($grade->grade < 4.0) {
                            $insufficientGrades++;
                        }
                    }
                }
    
                $average = $totalWeight ? $totalWeightedGrade / $totalWeight : 0;
    
                // Promotionsregel: Durchschnitt aller Informatik-Noten >= 4 und nicht mehr als 2 ungenügende Noten
                $isPromoted = $average >= 4.0 && $informatikSubjectsBelow4 == 0 && $insufficientGrades <= 2;
    
                $studentData[] = [
                    'student_name' => $student->name,
                    'informatik_average' => round($average, 2),
                    'informatikSubjectsBelow4' => $informatikSubjectsBelow4,
                    'insufficientGrades' => $insufficientGrades,
                    'isInformatikPromoted' => $isPromoted,
                ];
            }
    
            return response()->json(['students' => $studentData]);
        } else {
            // Berechne Informatik-Noten für den authentifizierten Schüler
            $grades = $user->grades()->whereHas('subject', function ($query) {
                $query->where('type', 'Informatik'); // Nur Informatik-Fächer
            })->get();
    
            $totalWeightedGrade = 0;
            $totalWeight = 0;
            $insufficientGrades = 0;
            $informatikSubjectsBelow4 = 0;
    
            $gradesBySubject = $grades->groupBy('subject_id');
    
            foreach ($gradesBySubject as $subjectId => $grades) {
                $subjectAverage = $grades->avg('grade');
    
                if ($subjectAverage < 4.0) {
                    $informatikSubjectsBelow4++;
                }
    
                foreach ($grades as $grade) {
                    $totalWeightedGrade += $grade->grade * $grade->weight;
                    $totalWeight += $grade->weight;
    
                    if ($grade->grade < 4.0) {
                        $insufficientGrades++;
                    }
                }
            }
    
            $average = $totalWeight ? $totalWeightedGrade / $totalWeight : 0;
            $isPromoted = $average >= 4.0 && $informatikSubjectsBelow4 == 0 && $insufficientGrades <= 2;
    
            return response()->json([
                'informatik_average' => round($average, 2),
                'informatikSubjectsBelow4' => $informatikSubjectsBelow4,
                'insufficientGrades' => $insufficientGrades,
                'isInformatikPromoted' => $isPromoted,
            ]);
        }
    }
    

}
