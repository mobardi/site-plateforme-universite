@extends('layouts.app')

@section('title', 'Modifier utilisateur')

@section('content')
    <h1>Modifier utilisateur</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $user->nom }}">
        </div>
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $user->prenom }}">
        </div>
        <div class="form-group">
            <label for="login">Login</label>
            <input type="text" class="form-control" id="login" name="login" value="{{ $user->login }}">
        </div>
        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" class="form-control" id="mdp" name="mdp">
        </div>
        <div class="form-group">
            <label for="formation">Formation</label>
            <select class="form-control" id="formation" name="formation">
                <option value="">Choisir une formation</option>
                @foreach ($formations as $formation)
                    <option value="{{ $formation->id }}" {{ old('formation_id', $user->formation_id) == $formation->id ? 'selected' : '' }}>{{ $formation->intitule }}</option>
                @endforeach
            </select>
        </div>
        @if(!isset($user->type))
        <div class="mt-2">*Cet utilisateur demande de s'inscrire au sein de votre établissement. Pour l'accepter, changez son statut de Candidat à Etudiant.<br>
        En cas de refus, vous pourriez le supprimer depuis votre <a style="color:#FE2E2E;"href="{{ route('users.index') }}">index</a>.</div>

        @endif
        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control" id="type" name="type">
                <option value="etudiant" {{ old('type', $user->type) == 'etudiant' ? 'selected' : '' }}>Etudiant</option>
                <option value="enseignant" {{ old('type', $user->type) == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                <option value="admin" {{ old('type', $user->type) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="" {{ old('type', $user->type) == null ? 'selected' : '' }}>Candidat (en attente)</option>

            </select>
        </div>

        <button type="submit" class="btn btn-outline-primary mt-2">Enregistrer</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary mt-2">Annuler</a>
    </form>
@endsection
