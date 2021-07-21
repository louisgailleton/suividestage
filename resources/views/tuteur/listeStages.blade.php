@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 id="titreSessions">Session : {{ $uneSession->NOM_SESSION }}</h1>
        <a href="{{ url('/listeEleveSessionsTuteur') }}/{{ $uneSession->ID_SESSION }}/{{ $_SESSION['id'] }}" class="btn btn-primary">Afficher mes élèves</a>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Entreprise</th>
                        <th scope="col">Maître de stage</th>
                        <th scope="col">Sujet</th>
                        <th scope="col">Ville</th>
                        <th scope="col">Tuteur</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($lesStages as $unStage)
                    <tr>
                        <td>{{ $unStage->NOM_ETUDIANT }}</td>
                        <td>{{ $unStage->PRENOM_ETUDIANT }}</td>
                        <td>{{ $unStage->NOM_ENTREPRISE }}</td>
                        <td>{{ $unStage->NOM_MAITRESTAGE }}</td>
                        <td>{{ $unStage->SUJET_STAGE }}</td>
                        <td>{{ $unStage->VILLE_ENTREPRISE }}</td>
                        @if($unStage->ID_TUTEUR == null)
                            <td><a href="{{ url('/envoiMailResponsable') }}/{{ $unStage->ID_STAGE }}/{{ $_SESSION['id'] }}" aria-label="Je veux être tuteur de l'étudiant: {{ $unStage->PRENOM_ETUDIANT }} {{ $unStage->NOM_ETUDIANT }}" class="btn btn-primary">Je veux être tuteur</a></td>
                        @else
                            <td>{{ $unStage->NOM_TUTEUR }}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
