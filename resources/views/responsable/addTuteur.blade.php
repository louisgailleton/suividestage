@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Ajouter un tuteur') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('addOneTuteur') }}">
                            @csrf
    
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Nom du tuteur') }}</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Prénom du tuteur') }}</label>
    
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="fistname" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Email du tuteur') }}</label>
    
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Nombre max d\'élèves à charge') }}</label>
    
                                <div class="col-md-6">
                                    <input type="number" min="0" class="form-control" name="nbMax" required autofocus>
                                </div>
                            </div>
                            <div class="alert alert-primary" role="alert">
                                Son mot de passe lui sera envoyé par mail
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Ajouter le tuteur') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
