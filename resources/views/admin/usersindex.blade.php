@extends('layouts.app')

@section('title', 'Liste des utilisateurs')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Liste des utilisateurs</h1>
        <a href="{{ route('users.create') }}" class="btn btn-outline-primary">Créer un utilisateur</a>
    </div>
    
    <form method="GET" action="{{ route('users.index') }}">
        <div class="form-group row mb-3">
            <label for="type" class="col-md-2 col-form-label text-md-end">Filtrer par type :</label>
            <div class="col-md-4">
                <select id="type" name="type" class="form-control">
                    <option value="">Tous</option>
                    <option value="etudiant" {{ request('type') === 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                    <option value="enseignant" {{ request('type') === 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                </select>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-danger">Filtrer</button>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Formation</th>
            <th>Type</th>
            <th class="ml-3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->nom }}</td>
                <td>{{ $user->prenom }}</td>
                <td>{{ $user->formation->intitule ?? '-' }}</td>
                <td>{{ $user->type ?? 'candidat*'}}</td>
                <td class="d-flex ml-3">
                    <div class="btn-group me-1">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                    </div>
                    <div class="btn-group">
                        <form action="{{ route('users.delete', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'utilisateur {{ $user->nom }} {{ $user->prenom }} ?')">Supprimer
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>*Lorsque vous voyez 'candidat*', cet utilisateur demande de s'inscrire au sein de votre établissement. Pour l'accepter, changez son statut de Candidat à Etudiant.</div>
@endsection
