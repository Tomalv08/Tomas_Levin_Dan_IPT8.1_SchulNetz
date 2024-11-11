@extends('layouts.app')

@section('title', 'Fach Verwalten')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')
<div class="header">
        <h1 class="title">Fach verwalten</h1>
        <p class="subtitle">Verwalte die Fächer für BM und Informatik</p>
    </div>

    <div class="add-fach-form">
        <h2>Neues Fach hinzufügen</h2>
        <input type="text" id="new-fach-name" placeholder="Fachname">
        <select id="new-fach-type">
            <option value="BM">BM</option>
            <option value="Informatik">Informatik</option>
        </select>
        <button class="add-button" onclick="addSubject()">Hinzufügen</button>
    </div>

    <div class="filter-container">
        <input type="text" class="filter-input" placeholder="Suche nach Fachname..." oninput="filterSubjects()">
    </div>

    <div class="fach-table-container">
        <table class="fach-table">
            <thead>
                <tr>
                    <th>Fachname</th>
                    <th>Typ</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody id="fach-list">
            </tbody>
        </table>
    </div>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/home/fachverwalten.js') }}"></script>
@endsection
