@extends('layouts.app')

@section('title')
	{{ucfirst($article->title)}}
@endsection

@section('breadcrumb')
    <li class="active"> Articles</li>
@stop

@section('content')
<div class="jumbotron">
	<div class="post-content">
		<h1 align="center">{{ ucfirst($article->title) }}</h1>
		@if($article->user_id == Auth::user()->id || Auth::user()->level->level > 3)
			<div class="manage">
				<button
						onclick='modalDelete(this)'
						link="{{ url('admin/news/delete') }}"
						id="{{ $news->id }}"
						title="Supprimer la news"
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