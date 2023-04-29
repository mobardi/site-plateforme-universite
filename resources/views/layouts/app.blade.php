<!DOCTYPE html>
<html lang="en" data-bs-theme="dark" class="mb-5">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    
</head>
<body>
    <nav class="navbar" style="background-color: #dc3545;">
        <div class="container-fluid">
            <a class="btn btn-lg" href="/">Université Paris-XII</a>
            @if (Auth::check())
                <span class="navbar-text">
                {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                </span>
            @endif
            <div class="d-flex align-items-center">
                @if (Auth::check())
                    <a class="btn btn-outline-dark mx-2" href="{{ route('settings') }}">Paramètres</a>
                    <a href="{{ route('logout') }}" class="btn btn-outline-dark">Déconnexion</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container mt-5" bs-secondary-bg>
        @yield('content')
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
