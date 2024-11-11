<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SchulNetz</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('Pictures/SchulNetz-logo-Official.png') }}" alt="Schulnetz Logo" style="height: 30px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Navigation umschalten">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @guest
                        <!-- Links für Gäste -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Einloggen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrieren</a>
                        </li>
                    @else
                        <!-- Authenticated User Links -->
                        @if (auth()->user()->is_teacher)
                            <!-- Links für Lehrer -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('KlasseVerwalten') }}">Klasse Verwalten</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('NoteVerwalten') }}">Note Verwalten</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('FachVerwalten') }}">Fach Verwalten</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('promotioncheck') }}">Promotionscheck</a>
                            </li>
                        @else
                            <!-- Links für Schüler -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('grades') }}">Notenübersicht</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('promotionsstand') }}">Promotionsstatus</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer bg-light text-center py-3 mt-4">
        <p>&copy; 2024 SchulNetz, Luzern. Alle Rechte vorbehalten.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @yield('scripts')
</body>
</html>
