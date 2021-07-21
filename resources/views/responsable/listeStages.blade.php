@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 id="titreSessions">Session : {{ $uneSession->NOM_SESSION }}</h1>
        <div class="table-responsive">
            <table class="table">
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
                       
                        @if ($unStage->NOM_TUTEUR != null)
                            <td>{{ $unStage->NOM_TUTEUR }}</td>
                        @else
    
                            <td class="">
                                <form class="form-group d-flex align-items-center" method="POST" action="{{ route('addTuteurStage') }}">
                                    @csrf
                                    <input type="text" class="form-control d-none" id="id_stage" name="id_stage" value="{{ $unStage->ID_STAGE }}">
                                    <select class="form-control" id="tuteur_select" name="id_tuteur">
                                        <option selected disabled>Choisir un tuteur</option>
                                    @foreach ($lesTuteurs as $unTuteur)
                                        <?php
                                            $nb_actuel = DB::table('stage')
                                            ->select()
                                            ->where('ID_TUTEUR', $unTuteur->ID_TUTEUR)
                                            ->count();

                                            $nb_max = DB::table('tuteur')
                                            ->select('NB_MAX')
                                            ->where('ID_TUTEUR', $unTuteur->ID_TUTEUR)
                                            ->first();

                                            if(intval($nb_actuel) < intval($nb_max->NB_MAX)){
                                                echo '<option value="' .$unTuteur->ID_TUTEUR .'">' .$unTuteur->PRENOM_TUTEUR .' ' .$unTuteur->NOM_TUTEUR .'</option>';
                                            }
                                        ?>
                                    @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary">Choisir</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a onClick='window.history.back();' class='btn btn-danger'>Retour</a>
            <button class="btn btn-primary" data-toggle="modal" data-target="#ModalUploadData">Importer des données</button>
            
        </div>
    </div>
    <div class="modal fade" id="ModalUploadData" tabindex="-1" aria-labelledby="ModalUploadData" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter des données</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <h4>Veuillez selectionner un fichier à importer:</h4>
                <form enctype="multipart/form-data" method="POST" action="{{ route('uploadFile') }}">
                    @csrf
                    <div class="form-group mt-3" hidden>
                        <input name="idsession" type="number" value="{{ $uneSession->ID_SESSION }}">
                    </div>
                    <div class="form-group mt-3">
                        <label for="exampleFormControlFile1" class="d-none">Importer un fichier</label>
                        <input name="file" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Importer</button>
                </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
@stop
