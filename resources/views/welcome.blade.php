<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel avec Bootstrap</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container vh-100 d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="display-4 mb-4">Bienvenue sur {{ config('app.name') }}</h1>

        @if (Route::has('login'))
            <div class="mb-3">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-success me-2">Dashboard</a>
                @else
                    <a href="{{ route('boardgames.index') }}" class="btn btn-primary me-2">Jeux</a>
                    <a href="{{ route('login') }}" class="btn btn-primary me-2">Se connecter</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-primary">S'inscrire</a>
                    @endif
                @endauth
            </div>
        @endif

        <footer class="mt-5 text-muted small">
            Laravel {{ Illuminate\Foundation\Application::VERSION }} (PHP {{ PHP_VERSION }})
        </footer>
    </div>

    <!-- Bootstrap JS (optionnel, pour composants interactifs) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>
