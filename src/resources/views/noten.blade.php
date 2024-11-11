@extends('layouts.app')

@section('title', 'Notenübersicht')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/noten.css') }}">
@endsection 

@section('content')
    <div class="header">
        <h1 class="title">Notenübersicht</h1>
        <p class="subtitle">Hier findest du eine Übersicht deiner aktuellen Noten</p>
    </div>

    <div class="filter-container">
        <input type="text" class="search" placeholder="Fach suchen...">
        <button class="filter-btn">Filtern</button>
    </div>

    <div class="table-container">
        <table class="grades-table">
            <thead>
                <tr>
                    <th>Fach</th>
                    <th>Durchschnitt</th>
                    <th>Anzahl Noten</th>
                    <th>Letzte Note</th>
                    <th>Trend</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamisch generierte Daten werden hier eingefügt -->
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/home/noten.js') }}"></script>
@endsection
