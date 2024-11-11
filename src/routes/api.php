<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ManageSubjectController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Diese Routen sind für die API der Anwendung zuständig. Hier
| definierst du Routen für die API-basierte Authentifizierung.
|
*/

// Registrierung über die API
Route::post('register', [AuthController::class, 'apiRegister']);

// Login über die API
Route::post('login', [AuthController::class, 'apiLogin']);

// Logout über die API (nur für authentifizierte Benutzer)
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'apiLogout']);

// Benutzerinformationen über die API abrufen
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->prefix('grades')->group(function () {
    Route::get('/', [GradeController::class, 'index']);
    Route::post('/', [GradeController::class, 'store']); 
    Route::put('/{id}', [GradeController::class, 'update']); 
    Route::delete('/{id}', [GradeController::class, 'destroy']);
});
    
Route::middleware('auth:sanctum')->get('/promotion/check', [PromotionController::class, 'checkPromotion']);
Route::middleware('auth:sanctum')->get('/promotion/informatik', [PromotionController::class, 'checkInformatikPromotion']);

Route::middleware('auth:sanctum')->prefix("class")->group(function () {
    Route::post('/assign', [ClassController::class, 'assignStudents']);
    Route::post('/remove', [ClassController::class, 'removeStudents']);
    Route::get('/list', [ClassController::class, 'listStudents']);
});
// Route zur Schülersuche
Route::middleware('auth:sanctum')->get('/students', [ClassController::class, 'Studentlist']);

Route::middleware('auth:sanctum')->prefix('subjects')->group(function () {
    Route::get('/', [ManageSubjectController::class, 'index']); // Alle Fächer abrufen
    Route::post('/', [ManageSubjectController::class, 'store']); // Neues Fach hinzufügen
    Route::put('/{id}', [ManageSubjectController::class, 'update']); // Fach bearbeiten
    Route::delete('/{id}', [ManageSubjectController::class, 'destroy']); // Fach löschen
});
