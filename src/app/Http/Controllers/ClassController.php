<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ClassController extends Controller
{
    public function assignStudents(Request $request)
    {
        $user = $request->user();

        // Prüfen, ob der Benutzer ein Lehrer ist
        if (!$user->is_teacher) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validierung der Schüler-IDs
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        // Schüler auswählen und dem Lehrer hinzufügen
        $user->students()->syncWithoutDetaching($request->student_ids);

        return response()->json(['message' => 'Students assigned successfully'], 201);
    }

    /**
     * Entfernen einer Gruppe von Schülern von einem Lehrer.
     */
    public function removeStudents(Request $request)
    {
        $user = $request->user();

        // Prüfen, ob der Benutzer ein Lehrer ist
        if (!$user->is_teacher) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validierung der Schüler-IDs
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        // Schüler von der Beziehung des Lehrers entfernen
        $user->students()->detach($request->student_ids);

        return response()->json(['message' => 'Students removed successfully'], 200);
    }

    /**
     * Liste aller Schüler eines bestimmten Lehrers anzeigen.
     */
    public function listStudents(Request $request)
    {
        $user = $request->user();

        // Prüfen, ob der Benutzer ein Lehrer ist
        if (!$user->is_teacher) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Alle Schüler des Lehrers abrufen
        $students = $user->students()->get();

        return response()->json(['students' => $students], 200);
    }
    
    public function Studentlist(Request $request) {
        $students = User::where('is_teacher', false)->get(); // Nur Schüler
        return response()->json($students);
    }
    
}
