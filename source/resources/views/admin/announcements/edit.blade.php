{{-- 
	(Quasi pareil que pour create.blade.php)

	Formulaire pour modifier une news
	Les champs contiennent les données déja enregistrées (si tu sais pas comment récuperer les données je te guide un peu pour l'index)
	Tu peux regarder la gestion des erreurs (tape withErrors dans la barre de recherche de la doc) pour des erreurs plus ciblées (que le controller envoie si il y en a). hf
	Pour le formulaire : 
	Les données que j'attends : utilise les name suivants : title (input text), content (textarea), active (une checkbox, cochée si la news est active ($news->active == 1 ?) (ca se fait en html)) 
	rajoute la propriété required sur les inputs pour que ca bloque si c'est pas rempli

--}}

@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 align="center">Modifier une annonce</h1>
        
        <form class="form-horizontal" role="form" method="post" action="{{ url('admin/announcements/edit') }}">
            {!! csrf_field() !!}

            <div class="form-group">

              <div class="col-md-10 col-md-offset-1">
                <input type="text" class="form-control" name="title" required value="{{ $announcement->title }}">
              </div>
            </div>

            <div class="form-group">

                <div class="col-md-10 col-md-offset-1">
                    <textarea class="form-control" rows="10" name="content" required>{{ $announcement->content }}</textarea>
                </div>
            </div>
            
            <div class="form-group buttons">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>        
    </div>   

</div> 
@endsection
