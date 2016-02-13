{{-- 
	Tu affiches la news en question avec la variable $news que je t'envoie. 
	Tu affiches un message warning en haut pour prévenir que c'est définitif
	tu créés un bouton (soit un bouton entouré d'un lien, soit un lien qui ressemble a un bouton) "Supprimer" qui mene vers news/delete/slug avec slug = le slug de la news en question
--}}

@extends('layouts.admin')

@section('title')
    Supprimer une news
@stop

@section('content')
<div class="container">
	<div class="alert alert-dismissible alert-warning">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <h4>Attention !</h4>
	  <p>La suppression de la news est définitive</p>
	</div>
	<h1 align="center">Suppression de la news</h1>
	<form class="form-horizontal" role="form" method="post">
            {!! csrf_field() !!}
		<div class="frame-news">
			<h2>{{$news['title']}}</h2>
			<p>{{$news['content']}} <br/>
				<div align="right" class="news-infos">Créée par 
					<a href="{{ url('user/'.App\User::where('id', $news['user_id'])->first()->slug)}}">
						<b>{{ App\User::where('id', $news['user_id'])->first()->first_name }}</b>
					</a> le {{date_format($news['created_at'], 'd/m/Y')}}
				</div>
			</p>
		</div><br/>
		<div class="form-group buttons">
                <div class="col-md-3 col-md-offset-10">
                    <button type="submit" class="btn btn-primary">Supprimer</button>
                </div>
            </div>
	</form>
</div>
@endsection