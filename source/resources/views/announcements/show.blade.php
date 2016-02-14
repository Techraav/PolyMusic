@extends('layouts.app')

@section('title')
	{{ ucfirst($announcement->title) }}
@stop

@section('content')
<div class="post-content">
		<h1 align="center">{{ ucfirst($announcement->title) }}</h1>
		<span class="announcement-content">
		<h2 align="center"><i>Sujet : {{ ucfirst($announcement->subject) }}</i></h3>
		<br />
			{!! $announcement->content !!}
		</span>
		<br />
		<p align="right" class="announcement-infos">Rédigé par {!! printUserLink($announcement->user_id) !!}, le {{ date_format($announcement['created_at'], 'd/m/Y') }}</p>
</div>

<div class="announcement-comments">
<br />
<h1 align="center">Commentaires</h1>
<br />
	@if(isset($comments))
		@foreach ($comments as $c)
		<blockquote class="comment">
		<div class="row">
				<div class="comment-member">
					<h4 align="center"><b>{!! printUserLink($c->user_id) !!}</b></h4>
					<p align="center"><img class="comment-pp" src=" {{ URL::asset('/img/profil_pictures/'.userData('profil_picture', $c->user_id)) }} " /></p>
					<span align="center" class="rang">{{ ucfirst(App\Level::where('level', userData('level', $c->user_id))->first()->name) }}</span>
				</div> 
		  		<div class="comment-content">
		  		<br />
		  			<span >
		  			<i>{!! $c->content !!}</i>
			  		</span>
			  		<br />
			  		<small class="date">Le {{ date_format($c->created_at, 'd/m/Y') }}, à {{date_format($c->created_at, 'H:i:s') }}</small>
			  		@if(Auth::user()->id == $c->user_id || Auth::user()->level > 1)
			  		<div class="comment-manage">
			  			@if(Auth::user()->id == $c->user_id)
			  			<a href="{{ url('comment/edit/'.$c->id) }}" class="btn-edit glyphicon glyphicon-pencil"></a>
			  			@endif
			  			<a href="{{ url('comment/delete/'.$c->id) }}" class="btn-delete glyphicon glyphicon-remove"></a>
			  		</div>
			  		@endif

		  		</div>
		</div>
		</blockquote>
		@endforeach
	@else
	<p>Aucun commentaire pour le moment.</p>
	@endif
	@if(Auth::check())

	<hr />
	<div class="col-md-10 col-md-offset-1">

		<h2 align="center">Ajouter un commentaire</h2>
		<br />
		<form action="{{ url('announcements/comment/create') }}" method="post">
		{{ csrf_field() }}
			<input hidden value="{{ $announcement->id }}" name="announcement_id" />

			<div class="form-group">
				<textarea rows="8" class="form-control" placeholder="Votre commentaire..." name="content"></textarea>
			</div>

			<div class="form-group">
				<input type="submit" role="button" value="Valider" class="btn btn-primary btn-submit"/>
			</div>
		</form>	</div>
	@endif
</div>

@stop