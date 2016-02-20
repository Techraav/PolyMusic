@extends('layouts.app')

@section('content')

    <div class="jumbotron">
        <h1>Bienvenue !</h1>
        <p>Bienvenue sur le site officiel du Club Musique de Polytech Tours !</p>
        <p>Vous pourrez y trouver toutes les informations nécessaires à propos du club.</p>
        @if(Auth::check() && Auth::user()->level->level > 0)
            <p>Vous souhaitez administrer le site ? Rendez-vous sur le <a href="admin">Back Office</a>.</p>
        @endif
        <hr />
        @if(Auth::guest())
            <p>Vous possédez déjà un compte ? <a href="auth/login">Connectez-vous</a> !</p>
            <p>Sinon, <a href="auth/register">inscrivez-vous</a> sans plus attendre !</p>
        @endif
        <a class="btn btn-primary" href="{{ url('about') }}">En savoir plus</a>
    </div>
@stop
