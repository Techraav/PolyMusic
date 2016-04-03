@extends('layouts.app')

@section('content')
	<h2 align="center">{!!printLink('articles/view/'.$article->slug, ucfirst($article->title))!!}</h2>
	<span class="help-block" align="center">Auteur : {!! printUserLinkV2($article->author) !!}</span>
	<br />

	@if($article->images->count() > 0)
		<div align="center" id="gallery">
			@foreach($images as $i)
				<img onclick="modalPicture(this)" description="{{ $i->description }}" src="{{ URL::asset('img/article_pictures/'.$i->name) }}" />
			@endforeach
		</div>
	@else
		<span class="help-block" align="center">Pas d'image pour le momemt.</span>
	@endif

	<div align="right">{!! $images->render() !!}</div>

		<div class="modal fade" id="modalPicture" role="dialog">
		<div class="modal-picture">
	        <div class="modal-body">
	        	<img id="picture" src="">
    			<p id="description"></p>
	        </div>
		</div>
	</div>

@stop