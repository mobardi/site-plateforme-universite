@extends('layouts.app')

@section('title', 'Liste des cours')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Liste des cours</h1>
    <a href="{{ route('cours.create') }}" class="btn btn-outline-primary">Créer un cours</a>
    </div>

    <form action="{{ route('cours.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Rechercher par intitulé" value="{{ request()->query('q') }}">
            <button type="submit" class="btn btn-outline-secondary">Rechercher</button>
        </div>
    </form>


    <form method="GET" action="{{ route('cours.index') }}">
    <div class="form-group row mb-3">
        <label for="enseignant" class="col-md-2 col-form-label text-md-end">Liste par enseignant :</label>
        <div class="col-md-4">
            <select id="enseignant" name="enseignant" class="form-control">
                <option value="">Tous</option>
                @foreach ($enseignants as $enseignant)
                    <option value="{{ $enseignant->id }}" {{ request('enseignant') == $enseignant->id ? 'selected' : '' }}>{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
                @endforeach
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
                <th>Intitulé</th>
                <th>Enseignant</th>
                <th>Formation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cours as $cour)
                <tr>
                    <td>{{ $cour->intitule }}</td>
                    <td>{{ $cour->user->nom }} {{ $cour->user->prenom }}</td>
                    <td>{{ $cour->formation->intitule ?? '-' }}</td>
                    <td>
                        <a href="{{ route('cours.edit', $cour->id) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                        <form action="{{ route('cours.delete', $cour->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun cours trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection