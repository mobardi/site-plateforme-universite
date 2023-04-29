@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Liste des formations</h1>
        <a href="{{ route('formations.create') }}" class="btn btn-outline-primary">Ajouter une formation</a>
        </div>        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Intitulé</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formations as $formation)
                    <tr>
                        <th scope="row">{{ $formation->id }}</th>
                        <td>{{ $formation->intitule }}</td>
                        <td>
                            <a href="{{ route('formations.edit', ['formation' => $formation]) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                            <form action="{{ route('formations.delete', ['formation' => $formation]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette formation ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
