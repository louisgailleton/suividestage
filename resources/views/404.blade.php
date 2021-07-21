@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card not-found shadow">
                <div class="card-body ">
                    <h3 class="text-center">Page introuvable</h3>
                    <h4 class="text-center">Retournez sur la page principale pour retrouver votre chemin...</h4>
                    <a class="btn btn-primary text-center" href="{{ route('home') }}">Accueil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection   