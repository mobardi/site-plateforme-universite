@extends('layouts.app')

@section('title', 'Créer un utilisateur')

@section('content')
    <h1>Créer un utilisateur</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}">
        </div>
        <div class="form-group mb-3">
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom') }}">
        </div>
        <div class="form-group mb-3">
            <label for="login">Login :</label>
            <input type="login" name="login" id="login" class="form-control" value="{{ old('login') }}">
        </div>
        <div class="form-group mb-3">
            <label for="password">Mot de passe :</label>
            <input type="password" name="mdp" id="mdp" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label for="password_confirmation">Confirmation du mot de passe :</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label for="type">Type d'utilisateur :</label>
            <select id="type" name="type" class="form-control">
                <option value="etudiant" {{ old('type') === 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                <option value="enseignant" {{ old('type') === 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                <option value="admin" {{ old('type') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="formation_id">Formation :</label>
            <select id="formation_id" name="formation_id" class="form-control">
                <option value="">Aucune formation</option>
                @foreach ($formations as $formation)
                    <option value="{{ $formation->id }}" {{ old('formation_id') == $formation->id ? 'selected' : '' }}>{{ $formation->intitule }}</option>
                @endforeach
            </select>
        </div>
        <div class="d-flex align-items-center justify-content">
        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary mx-1">Retour</a>
        </div>
    </form>
@endsection
