@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card login-card shadow m-5 col-xl-10">
            <div class="row">
                <div class="col-xl-6 mt-5 mb-5">
                    <div class="">
                        {{-- <div class="card-header bg-primary text-white text-center">{{ __('Je me connecte') }}</div> --}}
        
                        <div class="card-body text-center">
                            
                            <img src="./img/account2.png" class="img-login">
                            
                            <?= (Session::get('error') ? '<div class="alert alert-danger mt-3" role="alert">' .Session::get('error') .'</div>' : '') ?>
        
                            <form method="POST" action="{{ route('verifyUser') }}" class="mt-5">
                                @csrf
        
                                <div class="form-group row d-flex justify-content-center mb-4">
        
                                    <div class="col-xl-8 login-form">
                                        <select name="type" id="type" class="form-control " required>
                                            <option selected disabled>Selectionner un type</option>
                                            <option value="1">Etudiant</option>
                                            <option value="2">Tuteur</option>
                                            <option value="3">Responsable</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row d-flex justify-content-center login-form mb-4" id="email_input">
                                    <div class="col-xl-8 login-form">
                                        <input id="email" type="email" placeholder="{{ __('Identifiant') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        <label for="email">Identifiant</label>
                                    </div>
                                </div>
        
                                <div class="form-group row d-flex justify-content-center login-form mb-4" id="num_input">
                                    <div class="col-xl-8 login-form">
                                        <input id="num" name="num" type="text" placeholder="{{ __('Numéro étudiant') }}" class="form-control" required autocomplete="num" autofocus>
                                        <label for="email">Numéro étudiant</label>
                                    </div>
                                </div>
        
                                <div class="form-group row d-flex justify-content-center login-form mb-4" id="pwd_input">
                                    <div class="col-xl-8 login-form">
                                        <input id="password" type="password" placeholder="{{ __('Mot de passe') }}" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                        <label for="email">Mot de passe</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-xl-8 offset-xl-2">
                                        <button type="submit" class="btn btn-primary w-100 btn-login">
                                            {{ __('Se connecter') }}
                                        </button>
                                        <br>
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Mot de passe oublié') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mt-5 mb-5 right-login-card d-none d-xl-block">
                    <h3>Connectez-vous</h3>
                    <p>Ce site est reservé aux étudiants et aux professeurs du campus Lyon 1 de Bourg-en-Bresse.</p>
                    <p>Si vous ne possedez pas de compte sur ce site merci de fermer cette page.</p>
                    <p>Des problèmes pour vous connecter? Transmettez un message au responsables des stages qui corrigera votre soucis.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
