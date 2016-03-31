@extends('layouts.app')

@section('title')
	{{ucfirst($article->title)}}
@endsection

@section('breadcrumb')
    <li class="active"> Articles</li>
@stop

@section('content')
<div class="jumbotron article">
	<div class="post-content">
		<h1 align="center">{{ ucfirst($article->title) }}</h1>
		@if($article->user_id == Auth::user()->id || Auth::user()->level->level > 3)
			<div class="manage">
				<button
						onclick='modalDelete(this)'
						link="{{ url('admin/article/delete') }}"
						id="{{ $article->id }}"
						title="Supprimer l'article"
						class="{{ glyph('trash') }}">
				</button>
				<a href="{{ url('admin/articles/edit/'.$article->slug) }}" class="btn-edit glyphicon glyphicon-pencil"></a>
			</div>
		@endif
		<span class="announcement-content">
		<h2 align="center"><i>Sujet : {{ ucfirst($article->subtitle) }}</i></h3>
		<br />
			{!! $article->content !!}
		</span>
	<hr class="colorgraph" />
		<h2 align="center">Galerie</h2>
		<span align="center" class="help-block"><i>Nombre total d'images : {{ $article->images->count() }}</i></span>

	@if($article->images->count() > 0)
	<div id="gallery">
		<table class="table">
			<tr>
				@foreach($images as $i)
					<td align="center"><img onclick="modalPicture(this)" title="{{ $i->description }}" src="{{ URL::asset('img/article_pictures/'.$i->name) }}" /></td>
				@endforeach
			</tr>
			<br />
			<a href="{{ url('articles/view/'.$article->slug.'/gallery') }}" class="all">Tout voir</a>
		</table>
	</div>
	@else
		<span class="help-block" align="center">Pas d'image pour le momemt.</span>
	@endif

		<br />
			<p align="right" class="post-infos">Rédigé par {!! printUserLinkV2($article->author) !!}, le {{ date_format($article['created_at'], 'd/m/Y') }}</p>
	</div>
</div>	


	<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer la news</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-danger"><b>Attention ! Cette action est irréversible !</b></p>
			         	<input hidden value="" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" class="btn btn-primary">Supprimer</button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>

@stop