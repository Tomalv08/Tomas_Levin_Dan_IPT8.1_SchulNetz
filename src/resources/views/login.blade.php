@extends('layouts.app')

@section('title', 'Login - Schulnetz')

@section('content')
    <!-- Header -->
    <header class="header text-center mb-4">
        <h1>Login</h1>
        <p>Bitte melde dich mit deiner E-Mail-Adresse und Passwort an.</p>
    </header>

    <!-- Login Form -->
    <main class="login-container">
        <form method="POST" action="{{ route('login') }}" class="login-form" id="login-form">
            @csrf
            <div class="form-group">
                <label for="email">E-Mail-Adresse</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Passwort</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @error('password')
                    <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="submit-button">Anmelden</button>

            <!-- Dynamische Fehleranzeige für ungültige Login-Daten -->
            @if(session('errors'))
                <div class="error-message" style="color: red;">
                    {{ session('errors')->first() }}
                </div>
            @endif
        </form>
    </main>
@endsection
