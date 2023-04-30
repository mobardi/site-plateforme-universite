@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Modifier la séance</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.seanceupdate', ['planning'=>$planning->id]) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="cours_id" class="col-md-4 col-form-label text-md-right">{{ __('Cours') }}</label>

                                <div class="col-md-6">
                                    <select id="cours_id" name="cours_id" class="form-control @error('cours_id') is-invalid @enderror">
                                        @foreach ($cours as $c)
                                            <option value="{{ $c->id }}"  {{ $planning->cours_id == $c->id ? 'selected' : '' }}>{{ $c->intitule }}</option>
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
                                <label for="date_debut" class="col-md-4 col-form-label text-md-right">Date de début</label>

                                <div class="col-md-6">
                                    <input id="date_debut" type="datetime-local" class="form-control @error('date_debut') is-invalid @enderror" name="date_debut" value="{{ old('date_debut', $planning->date_debut)}}" required autocomplete="date_debut" autofocus>

                                    @error('date_debut')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date_fin" class="col-md-4 col-form-label text-md-right">Date de fin</label>

                                <div class="col-md-6">
                                    <input id="date_fin" type="datetime-local" class="form-control @error('date_fin') is-invalid @enderror" name="date_fin" value="{{ old('date_fin', $planning->date_fin)}}" required autocomplete="date_fin">

                                    @error('date_fin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-outline-primary">
                                        Enregistrer
                                    </button>
                                    <a href="{{ route('admin.planning') }}" class="btn btn-outline-secondary">
                                        Annuler
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
