@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 id="titreSessions">Liste des Sessions</h1>
        {{-- <form class="form-inline mt-4 mb-4">
            <div class="col-md-8 offset-md-2 ">
              <div class="input-group input-group-search row">
                <input type="text" class="form-control col col-xl-10" placeholder="Rechercher une session">
                <button class="col-xl-2 col btn btn-outline-primary w-100" type="submit" id="button-addon2">Rechercher</button>
              </div>
            </div>
            
        </form> --}}
        
        <div class="mt-4">
            @foreach($lesSessions as $uneSession)
                <div class="card col-md-8 offset-md-2 mb-2 border shadow">
                    <div class="card-body">
                        <span class="titreSessionCard">{{ $uneSession->NOM_SESSION }}</span>
                        <span class="boutonVoir"><a href="{{ url('/listeStages') }}/{{ $uneSession->ID_SESSION }}" class="btn btn-primary">Voir</a></span>
                        <span class="boutonVoir"><a href="{{ url('/deleteSession') }}/{{ $uneSession->ID_SESSION }}" class="btn btn-danger">Supprimer</a></span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-5">
            <a class="btn btn-primary" href="addSession">Ajouter une session</a>
        </div>
    </div>
@stop
