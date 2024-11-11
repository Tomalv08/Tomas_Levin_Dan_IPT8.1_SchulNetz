@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="container">
        <header class="header">
            <h1>Willkommen auf dem neuen Schulnetz</h1>
            <p>Ein modernes System für alle deine schulischen Bedürfnisse. Wir bieten dir eine Plattform, um deine Noten, Stundenpläne und wichtige Informationen zentral zu verwalten. Einfacher Zugang und Benutzerfreundlichkeit stehen bei uns an erster Stelle.

                Starte jetzt mit dem Schulnetz und optimiere deine Schulorganisation!</p>
            <div class="button-container">
                <a href="{{ route('login') }}" class="submit-button">Einloggen</a>
                <a href="{{ route('register') }}" class="submit-button">Registrieren</a>
            </div>
        </header>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href=css/homepage.css>
@endsection
