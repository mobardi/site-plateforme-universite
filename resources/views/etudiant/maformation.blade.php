@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Ma Formation : {{ $formation->intitule }}</h1>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary mt-2">Retour</a>
        </div>
        <h4 style="color:darkgrey;">Les cours de : {{ $formation->intitule }}</h4>
        
        <form action="{{ route('etudiant.maformation') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Rechercher un cours" value="{{ request()->query('q') }}">
                <button type="submit" class="btn btn-outline-secondary">Rechercher</button>
            </div>
        </form>

        <table class="table">
            <thead>
                    <th scope="col">#</th>
                    <th scope="col">Intitulé</th>
                    <th scope="col">Action</th>
            </thead>
            <tbody>
                @forelse ($cours as $c)
                    <tr>
                        <th scope="row">{{ $c->id }}</th>
                        <td>{{ $c->intitule }}</td>
                        <td>
                            @if ($user->courss->contains($c))
                                <form action="{{ route('etudiant.desinscription', $c->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Se désinscrire</button>
                                </form>
                            @else
                                <form action="{{ route('etudiant.inscription', $c->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">S'inscrire</button>
                                </form>
                            @endif
                        </td>
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
