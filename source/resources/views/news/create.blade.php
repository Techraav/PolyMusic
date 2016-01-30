{{-- 
	Formulaire pour créer une news
	Tu peux regarder la gestion des erreurs (tape withErrors dans la barre de recherche de la doc) pour des erreurs plus ciblées (que le controller envoie si il y en a). hf
	Pour le formulaire : 
	Les données que j'attends : utilise les name suivants : title (input text), content (textarea), active (une checkbox, cochée de base (ca se fait en html)) 
	rajoute la propriété required sur les inputs pour que ca bloque si c'est pas rempli

--}}

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 align="center">Création d'une nouvelle</h1>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('news/create') }}">
            {!! csrf_field() !!}

            <div class="form-group">
              <label for="inputEmail" class="col-md-4 control-label">Titre</label>

              <div class="col-md-6">
                <input type="text" class="form-control" name="title" required>
              </div>
            </div>

            <div class="form-group">
                <label for="textArea" class="col-md-4 control-label">Contenu de la nouvelle</label>

                <div class="col-md-6">
                    <textarea class="form-control" rows="10" name="content" required></textarea>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" checked required>Active
                      </label>
                    </div>
                </div>
            </div>
            
            <div class="form-group buttons">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">Publier</button>
                </div>
            </div>
        </form>        
    </div>
</div>
@endsection