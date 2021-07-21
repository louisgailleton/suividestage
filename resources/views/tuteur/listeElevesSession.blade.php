@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 id="titreSessions">Session : {{ $uneSession->NOM_SESSION }}</h1>
        <a href="{{ url('/listeStagesTuteur') }}/{{ $uneSession->ID_SESSION }}" class="btn btn-primary">Afficher tous les élèves</a>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    @for ($j = 1; $j < $uneSession->COMPTERENDU_SESSION + 1; $j++)
                        <th scope="col">Compte-rendu {{ $j }}</th>
                    @endfor
                    <th scope="col">Rapport final</th>
                    <th scope="col">Maître de stage</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lesStages as $unStage)
                    <tr>
                        <td>{{ $unStage->NOM_ETUDIANT }}</td>
                        <td>{{ $unStage->PRENOM_ETUDIANT }}</td>
                        @for ($i = 1; $i < $uneSession->COMPTERENDU_SESSION + 1; $i++)
                            {{ $compteRendu = "" }}
                            @foreach($fichiers as $unFichier)

                                @if($unFichier->id_stage == $unStage->ID_STAGE)
                                    @if($unFichier->compte_rendu == $i)
                                        <span class="nomFichierAMasquer">{{ $compteRendu = "$unFichier->file_path" }}</span>
                                    @endif
                                @endif
                            @endforeach
                            @if($compteRendu != "")
                                <td><a href="../../../storage/app/public/{{ $compteRendu }}" download aria-label="Télécharger le rapport" class="btn btn-primary">Télécharger</a></td>
                            @else
                                <td><button class="btn btn-primary" disabled>Télécharger</button></td>
                            @endif
                        @endfor
                        @if($uneSession->RAPPORT_SESSION == true)
                            {{ $rapport = "" }}
                            @foreach($fichiers as $unFichier)
                                @if($unFichier->id_stage == $unStage->ID_STAGE)
                                    @if($unFichier->rapport_stage == 1)
                                        <span class="nomFichierAMasquer">{{ $rapport = "$unFichier->file_path" }}</span>
                                    @endif
                                @endif
                            @endforeach
                            @if($rapport != "")
                                <td><a href="../../../storage/app/public/{{ $rapport }}" download aria-label="Télécharger le rapport" class="btn btn-primary">Télécharger</a></td>
                            @else
                                <td><button class="btn btn-primary" disabled>Télécharger</button></td>
                            @endif
                        @else
                            <td></td>
                        @endif
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" aria-label="Voir les informations du maître de stage" data-target="#information{{ $unStage->ID_STAGE }}">Informations</button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="information{{ $unStage->ID_STAGE }}" tabindex="-1" role="dialog" aria-labelledby="informationModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Informations maître de stage</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul>
                                        <li>Nom : {{ $unStage->NOM_MAITRESTAGE }}</li>
                                        <li>Prénom : {{ $unStage->PRENOM_MAITRESTAGE }}</li>
                                        <li>Mail : {{ $unStage->MAIL_MAITRESTAGE }}</li>
                                        <li>Téléphone : {{ $unStage->TELEPHONE_MAITRESTAGE }}</li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
