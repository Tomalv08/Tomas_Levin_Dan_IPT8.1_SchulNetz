<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use App\Models\User;

class GradeController extends Controller
{
    // Alle Noten abrufen
    public function index(Request $request)
    {
        // Authentifizierten Benutzer abrufen
        $user = $request->user();

        // Überprüfen, ob ein Benutzer authentifiziert ist
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Überprüfen, ob der Benutzer ein Lehrer ist (is_teacher)
        if ($user->is_teacher) {
            // Lehrer: Noten der Schüler abrufen
            $students = $user->students()->with('grades.subject')->get();

            if ($students->isEmpty()) {
                return response()->json(['message' => 'Keine Schüler oder Noten gefunden.'], 404);
            }

            $studentData = [];

            // Für jeden Schüler die Noten und den Durchschnitt berechnen
            foreach ($students as $student) {
                $totalWeightedGrade = 0;
                $totalWeight = 0;

                // Eindeutige Noten basierend auf der Kombination von user_id, subject_id und description
                $grades = $student->grades->unique(function ($item) {
                    return $item['user_id'] . '-' . $item['subject_id'] . '-' . $item['description'];
                });

                foreach ($grades as $grade) {
                    $totalWeightedGrade += $grade->grade * $grade->weight; // gewichtete Note
                    $totalWeight += $grade->weight; // Gesamtgewichtung
                }

                // Berechnung des Durchschnitts
                $average = $totalWeight ? $totalWeightedGrade / $totalWeight : 0;

                // Speichern der Noten und des Durchschnitts für jeden Schüler
                $studentData[] = [
                    'student_name' => $student->name,
                    'grades' => $grades,
                    'average' => round($average, 2), // Durchschnitt runden
                ];
            }

            // Rückgabe der Daten für den Lehrer
            return response()->json(['students' => $studentData], 200);
        } else {
            // Schüler: Nur eigene Noten abrufen
            $grades = $user->grades()->with('subject')->get()->unique(function ($item) {
                return $item['user_id'] . '-' . $item['subject_id'] . '-' . $item['description'];
            });

            if ($grades->isEmpty()) {
                return response()->json(['message' => 'Keine Noten gefunden.'], 404);
            }

            $totalWeightedGrade = 0;
            $totalWeight = 0;

            // Berechnung des gewichteten Notendurchschnitts
            foreach ($grades as $grade) {
                $totalWeightedGrade += $grade->grade * $grade->weight; // gewichtete Note
                $totalWeight += $grade->weight; // Gesamtgewichtung
            }

            // Berechnung des Durchschnitts
            $average = $totalWeight ? $totalWeightedGrade / $totalWeight : 0;

            // Rückgabe der Noten und des Durchschnitts für den Schüler
            return response()->json([
                'grades' => $grades,
                'average' => round($average, 2), // Durchschnitt runden
            ], 200);
        }
    }

    // Neue Note hinzufügen
    public function store(Request $request)
{
    // Authentifizierten Benutzer abrufen
    $user = $request->user();

    // Überprüfen, ob ein Benutzer authentifiziert ist
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Überprüfen, ob der Benutzer ein Lehrer ist
    if ($user->is_teacher) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:1|max:6',
            'description' => 'nullable|string',
            'weight' => 'nullable|integer|min:1',
        ]);

        $grade = Grade::create($request->all());

        return response()->json($grade, 201);
    } else {
        return response()->json(['message' => 'Kein Lehrer.'], 403);
    }
}


    // Note bearbeiten
    public function update(Request $request, $id)
    {
        // Authentifizierten Benutzer abrufen
        $user = $request->user();

        // Überprüfen, ob ein Benutzer authentifiziert ist
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Überprüfen, ob der Benutzer ein Lehrer ist (is_teacher)
        if ($user->is_teacher) {
            $request->validate([
                'grade' => 'sometimes|numeric|min:1|max:6',
                'description' => 'sometimes|nullable|string',
                'weight' => 'sometimes|nullable|integer|min:1',
            ]);

            $grade = Grade::findOrFail($id);
            $grade->update($request->all());

            return response()->json($grade, 200);
        } else {
            return response()->json(['message' => 'Kein Lehrer.'], 403);
        }
    }

    // Note löschen
    // Note löschen
public function destroy(Request $request, $id)
{
    // Authentifizierten Benutzer abrufen
    $user = $request->user();

    // Überprüfen, ob ein Benutzer authentifiziert ist
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Überprüfen, ob der Benutzer ein Lehrer ist (is_teacher)
    if ($user->is_teacher) {
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return response()->json(['message' => 'Grade deleted successfully.'], 200); // Angepasste Antwort mit JSON
    } else {
        return response()->json(['message' => 'Kein Lehrer.'], 403);
    }
}

}
