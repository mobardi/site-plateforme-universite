@extends('layouts.app')

@section('title', 'Université')

@section('content')
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
    <div class="row">
        <div class="col-md-12">
            <h1>Bienvenue sur notre site web!</h1>
            @if (Auth::check())
                <p>Bonjour, {{ Auth::user()->prenom }} {{ Auth::user()->nom }}.</p>
                @if (isset(Auth::user()->formation_id) && !isset(Auth::user()->type))
                <p>Vous êtes candidat, votre dossier est en cours de traitement. Vous ne pourrez donc pas encore accéder à toutes les fonctionnalités de notre site.</p>
                @endif
                @else
                <p>Veuillez vous connecter ou créer un compte pour accéder aux fonctionnalités du site de l'Université.</p>
            @endif
        </div>
        <div>
            <!-- Dashboard Admin -->
            @if(Auth::check() && Auth::user()->type === 'admin')
            <a href="{{ route('users.index') }}" class="btn btn-outline-primary">Liste des utilisateurs</a>
            <a href="{{ route('cours.index') }}" class="btn btn-outline-primary">Liste des cours</a>
            <a href="{{ route('formations.index') }}" class="btn btn-outline-primary">Liste des formations</a>
            @endif

            <!-- Dashboard Etudiant -->
            @if(Auth::check() && Auth::user()->type === 'etudiant')
            <a href="{{ route('etudiant.maformation') }}" class="btn btn-outline-primary">Ma formation</a>
            <a href="{{ route('etudiant.planning') }}" class="btn btn-outline-primary">Mon planning</a>
            @endif

            <!-- Dashboard Enseignant -->
            @if(Auth::check() && Auth::user()->type === 'enseignant')
            <a href="{{ route('enseignant.mescours') }}" class="btn btn-outline-primary">Mes cours</a>
            <a href="{{ route('enseignant.planning') }}" class="btn btn-outline-primary">Mon planning</a>
            @endif
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            @if (Auth::check())
                <a href="{{ route('logout') }}" class="btn btn-outline-danger">Déconnexion</a>
            @else
                <a href="{{ route('login.form') }}" class="btn btn-outline-danger">Se connecter</a>
                <a href="{{ route('register.form') }}" class="btn btn-outline-secondary">Créer un compte</a>
            @endif
        </div>
    </div>
@endsection
