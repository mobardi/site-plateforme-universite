@extends('layouts.app')

@section('title', 'Modifier un cours')

@section('content')
    <h1>Modifier un cours</h1>

    <form method="POST" action="{{ route('cours.update', $cour->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="intitule">Intitulé :</label>
            <input type="text" name="intitule" id="intitule" class="form-control @error('intitule') is-invalid @enderror" value="{{ old('intitule', $cour->intitule) }}" required>
            @error('intitule')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="enseignant_id">Enseignant :</label>
            <select name="enseignant_id" id="enseignant_id" class="form-control @error('enseignant') is-invalid @enderror" required>
                <option value="">-- Associer un enseignant --</option>
                @foreach($enseignants as $enseignant)
                    <option value="{{ $enseignant->id }}">
                        {{ $enseignant->nom }} {{ $enseignant->prenom }}
                    </option>
                @endforeach
            </select>
            @error('enseignant')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="formation_id" class="form-label">Formation :</label>
            <select name="formation_id" id="formation_id" class="form-control">
                <option value="">-- Sélectionnez une formation --</option>
                @foreach ($formations as $formation)
                    <option value="{{ $formation->id }}" >{{ $formation->intitule }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-outline-primary">Modifier</button>
    </form>
@endsection
