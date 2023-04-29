@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Connexion') }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('Nom d\'utilisateur') }}</label>

                    <div class="col-md-6">
                        <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login" autofocus>

                        @error('login')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row" style="margin-top:6px;">
                    <label for="mdp" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                    <div class="col-md-6">
                        <input id="mdp" type="password" class="form-control @error('mdp') is-invalid @enderror" name="mdp" required autocomplete="current-password">

                        @error('mdp')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0" style="margin-top:8px;">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-danger">
                            {{ __('Se connecter') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
