@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 id="titreSessions">Liste des Sessions</h1>
        <ul class="list-group col-md-8 offset-md-2">
            @foreach($sessions as $session)
                <li class="list-group-item">
                    {{ $session->NOM_SESSION }}
                    <span class="boutonVoir"><a href="{{ url('infos') }}/{{ $session->ID_SESSION }}" class="btn btn-primary">Voir</a></span>
                </li>
            @endforeach
        </ul>
    </div>
@stop