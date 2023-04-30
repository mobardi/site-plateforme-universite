@extends('layouts.app')

@section('content')
    <h1>Créer une séance</h1>

    <form method="POST" action="{{ route('admin.seancestore') }}">
        @csrf

        <div class="form-group">
            <label for="cours_id">Cours</label>
            <select class="form-control" id="cours_id" name="cours_id">
                @foreach($cours as $cours)
                    <option value="{{ $cours->id }}">{{ $cours->intitule }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="enseignant_id">Enseignant</label>
            <select class="form-control" id="enseignant_id" name="enseignant_id">
                @foreach($enseignants as $enseignant)
                    <option value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date_debut">Date et heure de début</label>
            <input type="datetime-local" class="form-control" id="date_debut" name="date_debut" required>
        </div>

        <div class="form-group">
            <label for="date_fin">Date et heure de fin</label>
            <input type="datetime-local" class="form-control" id="date_fin" name="date_fin" required>
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
@endsection