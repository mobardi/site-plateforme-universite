@extends('layouts.app')

@section('title', 'Création de compte')

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Création de compte') }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="nom" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                    <div class="col-md-6">
                        <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>

                        @error('nom')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="prenom" class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }}</label>

                    <div class="col-md-6">
                        <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom" autofocus>

                        @error('prenom')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('Nom d\'utilisateur') }}</label>

                    <div class="col-md-6">
                        <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login">

                        @error('login')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="mdp" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                    <div class="col-md-6">
                        <input id="mdp" type="password" class="form-control @error('mdp') is-invalid @enderror" name="mdp" required autocomplete="new-password">

                        @error('mdp')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="mdp_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirmation mot de passe') }}</label>

                    <div class="col-md-6">
                        <input id="mdp_confirmation" type="password" class="form-control" name="mdp_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="formation_id" class="col-md-4 col-form-label text-md-right">{{ __('Formation') }}</label>

                    <div class="col-md-6">
                        <select id="formation_id" name="formation_id" class="form-control">
                            <option value="">Je suis Enseignant/Admin</option>
                            @foreach ($formations as $formation)
                                <option value="{{ $formation->id }}">{{ $formation->intitule }}</option>
                            @endforeach
                        </select>


                    @error('formation_id')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0" style="margin-top:6px">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Créer un compte') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection