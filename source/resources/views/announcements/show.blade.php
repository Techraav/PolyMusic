@extends('layouts.app')

@section('content')

<div class="container">
	<h2>{{ $announcement->title }}</h2>
	<p>{{ $announcement->content}}</p>
	<p>Auteur : {{ App\User::where('id', $announcement->user_id)->first()->first_name }}</p>
</div>	
<hr />
@if(isset($comments))
	@foreach ($comments as $c)
		<p>{{ $c->content }}</p>
		<p>{{ App\User::where('id', $c->user_id)->first()->first_name }}</p>
	@endforeach
@else
	<p>Aucun commentaire.</p>
@endif

@stop