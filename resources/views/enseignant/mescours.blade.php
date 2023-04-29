@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mes cours</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nom du cours</th>
                <th>Formation</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cours as $c)
            <tr>
                <th>{{ $c->intitule }}</td>
                <td>{{ $c->formation->intitule }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun cours trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
