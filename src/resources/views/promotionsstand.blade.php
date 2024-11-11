@extends('layouts.app')

@section('title', 'Promotionsstatus')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/noten.css') }}">
@endsection 

@section('content')
<div class="promotions-container">
    <h1 class="promotions-title">Promotionsstand</h1>

    <!-- Tabs -->
    <div class="tabs">
        <button class="tab-button active" onclick="showCard('generalCard')" id="generalButton">Allgemein</button>
        <button class="tab-button" onclick="showCard('informatikCard')" id="informatikButton">Informatik</button>
    </div>

    <!-- Cards -->
    <div class="card active" id="generalCard">
        <h2 class="promotions-subtitle">Allgemeiner Promotionsstand</h2>
        <p class="promotions-info">Notendurchschnitt (BM & Informatik): <strong id="average">Lädt...</strong></p>
        <p class="promotions-info">Fächer unter Note 4 (BM): <strong id="bmSubjectsBelow4">Lädt...</strong></p>
        <p class="promotions-info">Anzahl ungenügende Noten (BM): <strong id="bmInsufficientGrades">Lädt...</strong></p>
        <p class="promotions-info">Promotionsbedingungen erfüllt: <strong id="isPromoted">Lädt...</strong></p>
    </div>

    <div class="card" id="informatikCard">
        <h2 class="promotions-subtitle">Promotionsstand Informatik</h2>
        <p class="promotions-info">Notendurchschnitt (Informatik): <strong id="informatik_average">Lädt...</strong></p>
        <p class="promotions-info">Fächer unter Note 4 (Informatik): <strong id="informatikSubjectsBelow4">Lädt...</strong></p>
        <p class="promotions-info">Anzahl ungenügende Noten (Informatik): <strong id="insufficientGrades">Lädt...</strong></p>
        <p class="promotions-info">Promotionsbedingungen erfüllt (Informatik): <strong id="isInformatikPromoted">Lädt...</strong></p>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/home/promotionsstand.js') }}"></script>
    <script>
       function showCard(cardId) {
        // Alle Karten und Buttons holen
        const cards = document.querySelectorAll('.card');
        const buttons = document.querySelectorAll('.tab-button');

        // Alle Karten ausblenden und Buttons deaktivieren
        cards.forEach(card => card.classList.remove('active'));
        buttons.forEach(button => button.classList.remove('active'));

        // Gewählte Karte anzeigen und Button aktivieren
        document.getElementById(cardId).classList.add('active');
        if (cardId === 'generalCard') {
            document.getElementById('generalButton').classList.add('active');
        } else {
            document.getElementById('informatikButton').classList.add('active');
        }
    }
    </script>
@endsection
