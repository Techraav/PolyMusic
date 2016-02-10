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
		<h1 align="center">Modification de la news</h1>
        <form class="form-horizontal" role="form" method="post" action="{{ url('admin/news/edit/'.$news['slug']) }}">
            {!! csrf_field() !!}

    		<div class="form-group">
                <label for="title" class="col-md-4 control-label">Titre</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="title" value="{{ $news['title'] }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="textArea" class="col-md-4 control-label">Contenu de la news</label>

                <div class="col-md-6">
                    <textarea class="form-control" rows="10" name="content" required>{{ $news['content'] }}</textarea>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" checked required>Active
                        </label>
                    </div>
                </div>
            </div>
                
                <div class="form-group buttons">
                    <div class="col-md-4 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </div>
        </form>
	</div>
</div>
@endsection