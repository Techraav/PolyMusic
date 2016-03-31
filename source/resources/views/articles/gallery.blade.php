@extends('layouts.app')

@section('content')
	<h2 align="center">{!!printLink('articles/view/'.$article->slug, ucfirst($article->title))!!}</h2>
	<span class="help-block" align="center">Auteur : {!! printUserLinkV2($article->author) !!}</span>
	<br />

	@if($article->images->count() > 0)
		<div align="center" id="gallery">
			@foreach($article->images as $i)
				<img src="{{ URL::asset('img/article_pictures/'.$i->name) }}" />
			@endforeach
		</div>
	@else
		<span class="help-block" align="center">Pas d'image pour le momemt.</span>
	@endif

@stop