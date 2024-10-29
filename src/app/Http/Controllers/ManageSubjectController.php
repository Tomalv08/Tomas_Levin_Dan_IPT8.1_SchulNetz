<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class ManageSubjectController extends Controller
{
    // Alle Fächer abrufen
    public function index()
    {
        $subjects = Subject::all();
        return response()->json($subjects, 200);
    }

    // Neues Fach hinzufügen
    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if ($user->is_teacher) {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:BM,I', // Beispiel für die Typen
        ]);

        $subject = Subject::create($request->all());

        return response()->json($subject, 201);}
        else {
            return response()->json(['message' => 'Kein Lehrer.'], 403);
        }
    }

    // Fach bearbeiten
    public function update(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if ($user->is_teacher) {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|in:BM,I',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update($request->all());

        return response()->json($subject, 200);}
        else {
            return response()->json(['message' => 'Kein Lehrer.'], 403);
        }
    }

    // Fach löschen
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        
        // Überprüfen, ob der Benutzer authentifiziert ist
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // Überprüfen, ob der Benutzer ein Lehrer ist
        if ($user->is_teacher) {
            $subject = Subject::findOrFail($id);
            $subject->delete();
            
            return response()->json(['message' => 'Subject deleted successfully.'], 200); // 200 OK für JSON-Antwort
        } else {
            return response()->json(['message' => 'Kein Lehrerrecht'], 403);
        }
    }
    
}
