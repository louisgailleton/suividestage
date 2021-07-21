@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 id="titreSessions">Liste des Sessions</h1>
        <ul class="list-group col-md-8 offset-md-2">
            @foreach($lesSessions as $uneSession)
                <li class="list-group-item">
                    {{ $uneSession->NOM_SESSION }}
                    <span class="boutonVoir"><a href="{{ url('/listeStages') }}/{{ $uneSession->ID_SESSION }}" class="btn btn-primary">Voir</a></span>
                </li>
            @endforeach
        </ul>
    </div>
@stop
