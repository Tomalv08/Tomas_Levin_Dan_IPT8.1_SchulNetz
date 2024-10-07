<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Diese Routen sind für die Webansicht der Anwendung zuständig. Hier
| definierst du Routen für Login, Registrierung und Home-Seiten.
|
*/

// Route für die Anzeige der Login-Seite (GET)
Route::get('/login', function () {
    return view('login');
})->name('login');

// Route für das Absenden des Login-Formulars (POST)
Route::post('/login', [AuthController::class, 'webLogin'])->name('login.process');

// Route für die Registrierung-Seite (GET)
Route::get('/register', function () {
    return view('register');
})->name('register');

// Route für das Absenden des Registrierungsformulars (POST)
Route::post('/register', [AuthController::class, 'webRegister'])->name('register.process');

// Route für die Startseite (nach dem Login)
Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

// Root-Route zur Umleitung nach /home (nur für authentifizierte Benutzer)
Route::get('/', function () {
    return redirect('/home');
})->middleware('auth');

// Route für den Logout
Route::post('/logout', [AuthController::class, 'webLogout'])->middleware('auth')->name('logout');
