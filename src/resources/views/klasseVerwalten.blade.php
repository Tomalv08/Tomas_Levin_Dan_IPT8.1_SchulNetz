@extends('layouts.app')

@section('title', 'Klasse Verwalten')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/manageclass.css') }}">
@endsection

@section('content')
<div class="header">
    <h1 class="title">Klassenverwaltung</h1>
    <p class="subtitle">Hier kannst du die Schüler deiner Klasse verwalten</p>
</div>

<div class="student-management-container">
    <!-- Button zum Öffnen des Schüler-Hinzufügen-Formulars -->
    <div class="add-student-form">
        <button class="add-student-btn" onclick="toggleAddStudentForm()">Neuen Schüler hinzufügen</button>
    </div>

    <!-- Schüler-Hinzufügen-Formular -->
    <div id="student-form" class="student-form hidden">
        <!-- Dropdown zum Auswählen eines Schülers -->
        <select id="student-select" class="input">
            <option value="">Wählen Sie einen Schüler</option>
            <!-- Die Optionen werden dynamisch über JS geladen -->
        </select>
        <button class="confirm-add-btn" onclick="addStudent()">Hinzufügen</button>
    </div>

    <!-- Filter-Eingabe zur Suche nach Schülern -->
    <div class="filter-container">
        <input type="text" class="input filter-input" placeholder="Suche nach Name oder E-Mail" oninput="filterStudents()" id="filter-input">
    </div>

    <!-- Tabelle zur Anzeige der Schüler -->
    <div class="table-container">
        <table class="student-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>E-Mail</th>
                    <th>Aktion</th>
                </tr>
            </thead>
            <tbody id="student-list">
                <!-- Schüler-Daten werden hier dynamisch eingefügt -->
            </tbody>
        </table>
    </div>
</div>

<!-- CSRF-Token für AJAX-Anfragen -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/home/klasseverwalten.js') }}"></script>
@endsection
