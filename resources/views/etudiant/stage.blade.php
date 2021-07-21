@extends('layouts.app')
@section('content')
    <div class="container">

        <h1 id="titreSessions" class="mb-5">Session n°{{ $session->ID_SESSION }}: {{ $session->NOM_SESSION }}</h1>

        <div class="row justify-content-md-center mb-5">

            <div class="col-md-6">

                <h3 id="titre1 form" class="h3 mx-auto mb-4" style="width: 116px;">Entreprise</h3>

                <p id="nom" class="h5">Nom:</p>
                <p>{{ $stage->NOM_ENTREPRISE }}</p>

                <p id="adresse" class="h5">Adresse:</p>
                <p>{{ $stage->ADRESSE_ENTREPRISE }}, {{ $stage->CP_ENTREPRISE }}, {{ $stage->VILLE_ENTREPRISE }}</p>

                <p id="sujet" class="h5">Sujet:</p>
                <p>{{ $stage->SUJET_STAGE }}</p>

            </div>

            <div class="col-md-6 border-left">

                <h3 id="titre1 form" class="h3 mx-auto mb-4" style="width: 176px;">Maitre de stage</h3>

                <p id="nom_prenom" class="h5">Nom - Prénom:</p>
                <p>{{ $stage->NOM_MAITRESTAGE }} - {{ $stage->PRENOM_MAITRESTAGE }}</p>

                <p id="adresse_mail" class="h5">E-mail:</p>
                <p>{{ $stage->MAIL_MAITRESTAGE }}</p>

                <p id="téléphone" class="h5">Téléphone:</p>
                <p>{{ $stage->TELEPHONE_MAITRESTAGE }}</p>

            </div>

        </div>

        <div class="row mb-3">
            <form method="POST" enctype="multipart/form-data" id="upload-file" action="{{ url('envoieFichier') }}/{{ $stage->ID_STAGE }}">
                @csrf
                <h5>Les fichiers doivent être de type .doc ou .pdf et ne pas dépasser 5 Mo.</h5>
                @for($i = 1; $i <= $session->COMPTERENDU_SESSION; $i ++)
                    {{ $disabled = "" }}
                    @foreach($fichiers as $unFichier)
                        @if($unFichier->id_stage == $stage->ID_STAGE)
                            @if($unFichier->compte_rendu == $i)
                                <span class="nomFichierAMasquer">{{ $disabled = "disabled" }}</span>
                            @endif
                        @endif
                    @endforeach

                <div class="form-group d-flex">
                    <label class="col-lg-5" for="compteRendu{{$i}}">Compte rendu {{ $i }} : </label>
                    <input type="file" class="form-control-file" name="compteRendu{{ $i }}" {{ $disabled }} id="compteRendu{{$i}}">
                </div>
                @endfor

                <div class="form-group d-flex">
                    @if($session->RAPPORT_SESSION)
                        {{ $disabled = "" }}
                        @foreach($fichiers as $unFichier)
                            @if($unFichier->id_stage == $stage->ID_STAGE)
                                @if($unFichier->rapport_stage == 1)
                                    <span class="nomFichierAMasquer">{{ $disabled = "disabled" }}</span>
                                @endif
                            @endif
                        @endforeach
                        <label class="col-lg-5" for="rapportSession">Rapport session : </label>
                        <input type="file" class="form-control-file" name="rapportSession" {{ $disabled }} id="rapportSession">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary" id="valider">Valider</button>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif



            </form>
        </div>

    </div>

@stop
