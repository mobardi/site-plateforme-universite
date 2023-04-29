@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier la formation {{ $formation->intitule }}</h1>
        <form action="{{ route('formations.update', ['formation' => $formation]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="intitule">Intitulé :</label>
                <input type="text" name="intitule" id="intitule" class="form-control" value="{{ old('intitule', $formation->intitule) }}" required>
            </div>
            <button type="submit" class="btn btn-primary my-2">Modifier</button>
            <a href="{{ route('formations.index') }}" class="btn btn-secondary">Retour</a>
        </form>
    </div>
@endsection
