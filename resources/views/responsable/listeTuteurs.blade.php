@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 id="titreSessions">Liste des tuteurs</h1>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Nombre actuel</th>
                        <th scope="col">Nombre max</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($lesTuteurs as $unTuteur)
                    <tr>
                        <td>{{ $unTuteur->NOM_TUTEUR }}</td>
                        <td>{{ $unTuteur->PRENOM_TUTEUR }}</td>
                        <td>{{ $unTuteur->MAIL_TUTEUR }}</td>
                        <td>
                            <?=
                                DB::table('stage')
                                ->select()
                                ->where('ID_TUTEUR', $unTuteur->ID_TUTEUR)
                                ->count();
                            ?>
                        </td>
                        <td>{{ $unTuteur->NB_MAX }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <a class="btn btn-primary" href="addTuteur">Ajouter un tuteur</a>
    </div>
@stop
