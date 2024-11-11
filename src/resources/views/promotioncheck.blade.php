@extends('layouts.app')

@section('title', 'Promotion check')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')
<div class="header">
        <h1 class="title">Promotionscheck</h1>
        <p class="subtitle">Prüfe die Promotionsbedingungen für BM und Informatik</p>
    </div>

    <div class="filter-container">
        <input type="text" class="filter-input" placeholder="Suche nach Namen..." oninput="filterPromotions()">
    </div>

    <div class="promotions-table-container">
        <h2>BM (Berufsmatura)</h2>
        <table class="promotions-table" id="bm-table">
        <thead>
        <tr>
            <th>Name der Person</th>
            <th>Notendurchschnitt</th>
            <th>Anzahl Fächer unter einer 4</th>
            <th>Anzahl Ungenügende Noten</th>
            <th>Promotionsbedingungen bestanden</th>
        </tr>
        </thead>
    <tbody></tbody>
        </table>

        <h2>Informatik</h2>
        <table class="promotions-table" id="informatik-table">
    <thead>
        <tr>
            <th>Name der Person</th>
            <th>Notendurchschnitt</th>
            <th>Anzahl Fächer unter einer 4</th>
            <th>Anzahl Ungenügende Noten</th>
            <th>Promotionsbedingungen bestanden</th>
        </tr>
    </thead>
    <tbody></tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/home/promotionscheck.js') }}"></script>
@endsection
