@extends('layouts.app')

@section('title', 'Créer un cours')

@section('content')
<h1>Créer un cours</h1>
<form action="{{ route('cours.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="intitule" class="form-label">Intitulé :</label>
        <input type="text" name="intitule" id="intitule" class="form-control" value="{{ old('intitule') }}" required>
    </div>

    <div class="mb-3">
        <label for="enseignant_id" class="form-label">Enseignant :</label>
        <select name="enseignant_id" id="enseignant_id" class="form-control" required>
            <option value="">-- Sélectionnez un enseignant --</option>
            @foreach ($enseignants as $enseignant)
                <option value="{{ $enseignant->id }}" {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="formation_id" class="form-label">Formation :</label>
        <select name="formation_id" id="formation_id" class="form-control">
            <option value="">-- Sélectionnez une formation --</option>
            @foreach ($formations as $formation)
                <option value="{{ $formation->id }}" {{ old('formation_id') == $formation->id ? 'selected' : '' }}>{{ $formation->intitule }}</option>
            @endforeach
        </select>
    </div>
    <div class="d-flex align-items-center justify-content">
    <button type="submit" class="btn btn-primary">Créer</button>
    <a href="{{ route('cours.index') }}" class="btn btn-secondary mx-1">Retour</a>
    </div>
</form>
@endsection