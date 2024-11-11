<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route für die Anzeige der Startseite (GET)
// Diese Route zeigt die Homepage nur an, wenn der Benutzer nicht angemeldet ist
Route::get('/', function () {
    return view('homepage'); // Hauptseite
})->name('homepage')->middleware('guest'); // Nur für nicht angemeldete Benutzer

// Route für die Anzeige der Login-Seite (GET)
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest'); // Nur für nicht angemeldete Benutzer

// Route für das Absenden des Login-Formulars (POST)
Route::post('/login', [AuthController::class, 'webLogin'])->name('login.process');

// Route für die Registrierung-Seite (GET)
Route::get('/register', function () {
    return view('register');
})->name('register')->middleware('guest'); // Nur für nicht angemeldete Benutzer

// Route für das Absenden des Registrierungsformulars (POST)
Route::post('/register', [AuthController::class, 'webRegister'])->name('register.process');

// Dashboard-Route (Hauptseite nach Login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Route für den Logout
Route::post('/logout', [AuthController::class, 'webLogout'])->middleware('auth')->name('logout');

// Noten-Route
Route::get('/noten', function () {
    return view('noten');
})->middleware('auth')->name('grades');

// Promotionsstand-Route
Route::get('/promotionsstand', function () {
    return view('promotionsstand');
})->middleware('auth')->name('promotions');

// Einstellungen-Route
Route::get('/einstellungen', function () {
    return view('einstellungen');
})->middleware('auth')->name('settings');

// KlasseVerwalten-Route
Route::get('/KlasseVerwalten', function () {
    return view('KlasseVerwalten');
})->middleware('auth')->name('KlasseVerwalten');

// NoteVerwalten-Route
Route::get('/NoteVerwalten', function () {
    return view('NoteVerwalten');
})->middleware('auth')->name('NoteVerwalten');

// FachVerwalten-Route
Route::get('/FachVerwalten', function () {
    return view('FachVerwalten');
})->middleware('auth')->name('FachVerwalten');

// KlasseVerwalten-Route
Route::get('/promotioncheck', function () {
    return view('promotioncheck');
})->middleware('auth')->name('promotioncheck');

// KlasseVerwalten-Route
Route::get('/promotionsstand', function () {
    return view('promotionsstand');
})->middleware('auth')->name('promotionsstand');

