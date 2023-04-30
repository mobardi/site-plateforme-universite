@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Planning des enseignants</h1>
        <a href="{{ route('admin.seancecreate') }}" class="btn btn-outline-primary">Ajouter une séance</a>

    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Enseignant</th>
                <th>Intitulé du cours</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($plannings as $planning)
                <tr>
                    <td>{{ $planning->cours->user->nom }} {{ $planning->cours->user->prenom }}</td>
                    <td>{{ $planning->cours->intitule }}</td>
                    <td>{{ $planning->date_debut }}</td>
                    <td>{{ $planning->date_fin }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('admin.seanceedit', ['planning' => $planning->id]) }}" class="btn btn-outline-secondary mx-1">Modifier</a>
                            <form action="{{ route('admin.seancedelete', ['planning' => $planning->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette séance ?')">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
            <tr>
            <td colspan="4" class="text-center">Aucun planning actuellement.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection
