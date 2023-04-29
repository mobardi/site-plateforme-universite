@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1>Mon planning</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Intitulé du cours</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Enseignant</th>
            </tr>
        </thead>
        <tbody>
            @forelse($plannings as $planning)
            <tr>
                <td>{{ $planning->cours->intitule }}</td>
                <td>{{ $planning->date_debut }}</td>
                <td>{{ $planning->date_fin }}</td>
                <td>{{ $planning->cours->user->nom }} {{ $planning->cours->user->prenom }}</td>
            </tr>
            @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucun planning actuellement.</td>
                    </tr>
            @endforelse
        </tbody>
    </table>
@endsection
