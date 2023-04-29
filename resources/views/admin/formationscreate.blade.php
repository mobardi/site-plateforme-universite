@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ajouter une formation</h1>
        <form action="{{ route('formations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="intitule">Intitulé :</label>
                <input type="text" class="form-control" id="intitule" name="intitule" required>
            </div>
            
            <div class="d-flex align-items-center justify-content">
            <button type="submit" class="btn btn-primary my-2">Ajouter</button>
            <a href="{{ route('formations.index') }}" class="btn btn-secondary mx-1">Retour</a>
            </div>
        </form>
    </div>
@endsection
