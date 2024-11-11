@extends('layouts.app')

@section('title', 'Klasse Verwalten')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/manageclass.css') }}">
@endsection

@section('content')
<div class="header">
    <h1 class="title">Note verwalten</h1>
    <p class="subtitle">Verwalte die Noten der Schüler</p>
</div>

<div class="search-container">
    <input type="text" id="search-name" placeholder="Suche nach Namen" oninput="filterNotes()">
</div>

<div class="add-note-form">
    <h2>Neue Note hinzufügen</h2>
    
    <!-- Schüler Dropdown-Menü -->
    <label for="new-user-id">Schüler</label>
    <select id="new-user-id">
        <option value="">Wähle einen Schüler</option>
    </select>

    <!-- Fach Dropdown-Menü -->
    <label for="new-subject-id">Fach</label>
    <select id="new-subject-id">
        <option value="">Wähle ein Fach</option>
    </select>

    <input type="number" step="0.1" id="new-grade" placeholder="Note" min="1" max="6">
    <input type="text" id="new-description" placeholder="Beschreibung">
    <input type="number" id="new-weight" placeholder="Gewichtung" min="1">
    <button class="add-button" onclick="addNote()">Hinzufügen</button>
</div>

<div class="note-list-container" id="note-list-container">
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/home/notenverwalten.js') }}"></script>
@endsection
