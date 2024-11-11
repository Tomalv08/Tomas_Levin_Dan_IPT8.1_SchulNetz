@extends('layouts.app')

@section('title', 'Registrieren - Schulnetz')

@section('content')
    <!-- Header -->
    <header class="header text-center">
        <h1>Registrieren</h1>
        <p>Bitte registriere dich mit deinem Namen, E-Mail-Adresse und Passwort.</p>
    </header>

    <!-- Register Form -->
    <main class="login-container">
        <form method="POST" action="{{ route('register') }}" class="login-form">
            @csrf
            <div class="form-group">
                <label for="name">Vollständiger Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            </div>
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
            <div class="form-group">
                <label for="password_confirmation">Passwort bestätigen</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="submit-button">Registrieren</button>
        </form>
    </main>
@endsection
