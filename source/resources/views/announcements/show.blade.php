@extends('layouts.app')

@section('content')
<div class="jumbotron">
	<div class="container">
		<h1 align="center">{{ ucfirst($announcement->title) }}</h1>
		<br />
		<span class="announcement-content">
		<h2 align="center"><i>{{ ucfirst($announcement->subject) }}</i></h3>
		<br />
			{!! $announcement->content !!}
		</span>
		<br />
		<p align="right" class="announcement-infos">Rédigé par <a href="{{ url('users/'.App\User::where('id', $announcement->user_id)->first()->slug) }}">{{ App\User::where('id', $announcement->user_id)->first()->first_name.' '.App\User::where('id', $announcement->user_id)->first()->last_name }}</a>, le {{ date_format($announcement['created_at'], 'd/m/Y') }}</p>
	</div>	
</div>

<div class="announcement-comments">
<h1 align="center">Commentaires</h1>
	@if(isset($comments))
		@foreach ($comments as $c)
		<blockquote>
			<h4><b>{{ App\User::where('id', $c->user_id)->first()->first_name }} {{ App\User::where('id', $c->user_id)->first()->last_name }}</b></h4>
	  		<span >
	  			<i>{!! $c->content !!}</i>
	  		</span>
	  		<br />
	  		<small>le 21/02/1996</small>
		</blockquote>
		@endforeach
	@else
	<p>Aucun commentaire pour le moment.</p>
	@endif
</div>

@stop