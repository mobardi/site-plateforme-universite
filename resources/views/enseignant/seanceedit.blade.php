@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Modifier la séance</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('enseignant.seanceupdate', $planning->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="cours_id" class="col-md-4 col-form-label text-md-right">Cours</label>

                                <div class="col-md-6">
                                    <select id="cours_id" name="cours_id" class="form-control">
                                        @foreach($cours as $cours_item)
                                            <option value="{{ $cours_item->id }}" {{ $planning->cours_id == $cours_item->id ? 'selected' : '' }}>{{ $cours_item->intitule }}</option>
                                        @endforeach
                                    </select>

                                    @error('cours_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date_debut" class="col-md-4 col-form-label text-md-right">Date/Heure de début</label>

                                <div class="col-md-6">
                                    <input id="date_debut" type="datetime-local" class="form-control @error('date_debut') is-invalid @enderror" name="date_debut" value="{{ old('date_debut', $planning->date_debut)}}" required autocomplete="date_debut">

                                    @error('date_debut')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date_fin" class="col-md-4 col-form-label text-md-right">Date/Heure de fin</label>

                                <div class="col-md-6">
                                    <input id="date_fin" type="datetime-local" class="form-control @error('date_fin') is-invalid @enderror" name="date_fin" value="{{ old('date_fin', $planning->date_fin)}}" required autocomplete="date_fin">

                                    @error('date_fin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                                <div class="offset-md-4 mt-2">
                                    <button type="submit" class="btn btn-outline-primary">
                                    Modifier
                                    </button>
                                    <a href="{{ route('enseignant.planning') }}" class="btn btn-outline-secondary">
                                        Retour
                                    </a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection