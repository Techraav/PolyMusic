{{-- 
	Tu affiches la news en question avec la variable $news que je t'envoie. 
	Tu affiches un message warning en haut pour prévenir que c'est définitif
	tu créés un bouton (soit un bouton entouré d'un lien, soit un lien qui ressemble a un bouton) "Supprimer" qui mene vers news/delete/slug avec slug = le slug de la news en question
--}}

@extends('layouts.admin')

@section('content')
<div class="alert alert-dismissible alert-warning">
  <button type="button" class="close" data-dismiss="alert">&close;</button>
  <h4>Attention!</h4>
  <p>La suppression de la news est définitive</p>
</div>

<div class="container">
	<div class="jumbotron">
		<h1 align="center">Suppression de la news</h1>
		<div style="border: 3px solid rgb(195,195,195); padding-right: 15px; padding-left: 15px;">
			<h2>{{$news['title']}}</h2>
			<p>{{$news['content']}} <br/>
				<div style="color: gray; text-align: right; font-size: 12px; font-style: italic">Créée par 
					<a style="color:inherit" href="{{ url('user/'.App\User::where('id', $n['user_id'])->first()->slug)}}">
						<b>{{ App\User::where('id', $n['user_id'])->first()->first_name }}</b>
					</a> le {{date_format($n['created_at'], 'd/m/Y')}}
				</div>
			</p>
		</div>
		<p><a href="{{ url('admin/news/delete/'.$news['slug']) }}" class="btn btn-primary btn-lg">Supprimer</a></p>
	</div>	
</div>
@endsection