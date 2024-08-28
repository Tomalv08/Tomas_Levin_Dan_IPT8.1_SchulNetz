<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
