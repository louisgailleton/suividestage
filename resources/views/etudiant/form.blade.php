@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 id="titreSessions" class="mb-5">Session n°{{ $session->ID_SESSION }}: {{ $session->NOM_SESSION }}</h1>

        <form method="POST" action="{{ url('envoieMail/') }}/{{ $_SESSION['num'] }}/{{ $session->ID_SESSION }}">
            @csrf
            {{--changer quand on aura l'authentification fonctionnelle--}}
            <h5 id="titre1 form">Rentrez ici les informations concernant votre entreprise de stage/alternance:</h5>

            <div class="form bg-primary p-4 mb-5">

                <div class="row mb-4">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom de l'entreprise" required>
                        <label for="nom">Nom de l'entreprise</label>
                    </div>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="rue" id="rue" placeholder="Adresse (Rue)" required>
                        <label for="rue">Adresse (Rue)</label>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="cp" id="cp" placeholder="Adresse (Code Postal)" required>
                        <label for="cp">Adresse (Code Postal)</label>
                    </div>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="ville" id="ville" placeholder="Adresse (Ville)" required>
                        <label for="ville">Adresse (Ville)</label>
                    </div>
                </div>

                <div class="row mx-0">
                    <input type="text" class="form-control" name="sujet" id="sujet" placeholder="Sujet du stage (ex: développement web)" required>
                    <label for="sujet">Sujet du stage</label>
                </div>

            </div>

            <h5 id="titre2 form">Rentrez ici les informations concernant votre maitre de stage/alternance:</h5>

            <div class="form bg-primary p-4 mb-5">

                <div class="row mb-4">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom" required>
                        <label for="lastname">Nom</label>
                    </div>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom" required>
                        <label for="firstname">Prénom</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
                        <label for="email">Email</label>
                    </div>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="tel" id="tel" placeholder="Téléphone" required>
                        <label for="tel">Téléphone</label>
                    </div>
                </div>

            </div>

            <div class="row d-flex justify-content-center">
                <button type="submit" class="btn btn-primary mb-3">Envoyer mes informations</button>
            </div>

        </form>

    </div>
@stop
