@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Wilkommen zur Startwebseite</h1>
    <p>Sie haben sich erfolgreich eingeloggt.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/home/logout.js') }}"></script>
@endsection