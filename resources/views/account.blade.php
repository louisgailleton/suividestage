@extends('layouts.app')
@section('content')
<div class="container">
    <h1 id="titreSessions">Mon compte</h1>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card shadow">

                <div class="card-body">
                    <h3><?= $_SESSION['name'] ?></h3>
                    <h5>Status: {{ __('Vous etes connecté') }} </h5>
                    <hr>
                    <div class="row mt-5">
                        <div class="col-md-4 border-right">
                            <h4>Modifier mon mot de passe :</h4>
                            <form method="POST" action="{{ route('changePassword') }}" class="mt-4">
                                @csrf
                                <div class="form-group">
                                  <label for="old_mdp">Ancien mot de passe</label>
                                  <input type="text" class="form-control" id="old_mdp" name="old_mdp" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_mdp">Nouveau mot de passe</label>
                                    <input type="text" class="form-control" id="new_mdp" name="new_mdp" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_mdp">Confirmer mot de passe</label>
                                    <input type="text" class="form-control" id="confirm_mdp" name="confirm_mdp" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Modifier</button>
                            </form>
                            <?php

                            if(Session::get('change')){
                                if(Session::get('change') == 1){
                                    echo '  <div class="alert alert-danger mt-1" role="alert">
                                                Le champ confirmation est different du nouveau mot de passe!
                                            </div>';
                                    
                                }
                                if(Session::get('change') == 2){
                                    echo '  <div class="alert alert-danger mt-1" role="alert">
                                                Mot de passe incorrect!
                                            </div>';
                                }
                                if(Session::get('change') == 3){
                                    echo '  <div class="alert alert-success mt-1" role="alert">
                                                Votre mot de passe a bien été modifié.
                                            </div>';
                                }
                                if(Session::get('change') == 4){
                                    echo '  <div class="alert alert-danger mt-1" role="alert">
                                                Votre mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre!
                                            </div>';
                                }
                            }

                            ?>
                        </div>
                        <div class="col-md-8 ">
                            <h4>Accès rapides :</h4>
                            @if( isset($_SESSION['role']) && $_SESSION['role'] == 'responsable')
                                <a class="btn btn-primary mt-2 mb-2 w-100" href="{{ route('listeSessions') }}">{{ __('Acceder à la liste des sessions') }}</a>
                                <br>
                                <a class="btn btn-primary mt-2 mb-2 w-100" href="{{ route('listeTuteurs') }}">{{ __('Acceder à la liste des tuteurs') }}</a>
                                <br>
                                <a class="btn btn-primary mt-2 mb-2 w-100" href="addTuteur">{{ __('Ajouter un tuteur') }}</a>
                            @elseif( isset($_SESSION['role']) && $_SESSION['role'] == 'tuteur')
                                <a class="btn btn-primary mt-2 mb-2 w-100" href="{{ route('listeSessionsTuteur') }}">{{ __('Liste des sessions') }}</a>
                            @elseif( isset($_SESSION['role']) && $_SESSION['role'] == 'etudiant')
                                <a class="btn btn-primary mt-2 mb-2 w-100" href="{{ route('sessions', ['numEtudiant'=> $_SESSION['num']]) }}">{{ __('Accéder à mes sessions') }}</a>
                            @endif
                                <a class="btn btn-danger mt-2 mb-2 w-100" href="{{ route('logout') }}"> Déconnexion</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
