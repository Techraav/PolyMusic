{{-- 
    Formulaire pour créer une news
    Tu peux regarder la gestion des erreurs (tape withErrors dans la barre de recherche de la doc) pour des erreurs plus ciblées (que le controller envoie si il y en a). hf
    Pour le formulaire : 
    Les données que j'attends : utilise les name suivants : title (input text), content (textarea), active (une checkbox, cochée de base (ca se fait en html)) 
    rajoute la propriété required sur les inputs pour que ca bloque si c'est pas rempli

--}}

@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 align="center">Création d'une news</h1>
        <form class="form-horizontal" role="form" method="post" action="{{ url('admin/news/create') }}">
            {!! csrf_field() !!}

            <div class="form-group">

              <div class="col-md-6 col-md-offset-3">
                <input type="text" class="form-control" name="title" placeholder="Titre" required>
              </div>
            </div>

            <div class="form-group">

                <div class="col-md-6 col-md-offset-3">
                    <textarea class="form-control" rows="10" name="content" placeholder="Contenu de votre news..." required></textarea>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" checked required>Active
                      </label>
                    </div>
                </div>
            </div>
            
            <div class="form-group buttons">
                <div class="col-md-4 col-md-offset-5">
                    <button type="submit" class="btn btn-primary">Publier</button>
                </div>
            </div>
        </form>        
    </div>
</div>
@endsection