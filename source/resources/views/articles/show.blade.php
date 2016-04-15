@extends('layouts.app')

@section('title')
	{{ucfirst($article->title)}}
@endsection

@section('breadcrumb')
    <li><a href="{{ url('articles/list') }}">Articles</a></li>
    <li class="active">{{ucfirst($article->title)}}</li>
@stop

@section('content')
<div class="jumbotron article">
	<div class="post-content">
		@if(!empty($article->course) || !empty($article->band))
			<div class="belongs-to">
				@if(!empty($article->course))
					<p class="text-danger">Cet article est une présentation du cours &laquo; {!! printLink('courses/show/'.$article->course->slug, ucfirst($article->course->name)) !!} &raquo;</p>
				@else
					<p class="text-danger">Cet article est une présentation du groupe &laquo; {!! printLink('bands/show/'.$article->band->slug, ucfirst($article->band->name)) !!} &raquo;</p>
				@endif
			</div>
		@endif
		<h1 align="center">{{ ucfirst($article->title) }}</h1>
		@if(Auth::check() && ($article->user_id == Auth::user()->id || Auth::user()->level->level > 3))
			<div class="manage">
				<button
						data-link="{{ url('admin/articles/delete') }}"
						data-id="{{ $article->id }}"
						title="Supprimer l'article"
						class="{{ glyph('trash') }} delete-button">
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

	@if($article->images->count() > 0)
		<span align="center" class="help-block"><i>Nombre total d'images : {{ $article->images->count() }}</i></span>
	<div id="gallery">
		<div class="scroll">
			<ul class="nav nav-pills">
				@foreach($images as $i)
					 <li><img onclick="modalPicture(this)" title="{{ $i->description }}" src="{{ URL::asset('img/article_pictures/'.$i->name) }}" /></li>
				@endforeach
				<br />
			</ul>
		</div>
	</div>
		<a href="{{ url('articles/view/'.$article->slug.'/gallery') }}" class="all">Tout voir</a>
	@else
		<span class="help-block" align="center">Pas d'image pour le moment.</span>
		<br />
	@endif


	@if(Auth::check() && Auth::user()->id == $article->author->id)

		<div class="row">
			<h3 align="center">Ajouter des images :</h3>
			<form enctype="multipart/form-data" class="col-lg-10 col-lg-offset-1" method="post" action="{{ url('admin/articles/gallery/add') }}">
	            {!! csrf_field() !!}
				<input name="id" value="{{$article->id}}" hidden />

		         {!! printFileInput('pictures[]', ['png','jpeg','jpg'], true, ['accept' => 'image/png, image/jpeg'], false, [], true) !!}		
		         <br />
		         <div align="center" class="buttons">
		         	<button type="submit" class="btn btn-primary">Valider</button>
		         </div>
			</form>
		</div>
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

	<div class="modal fade" id="modalPicture" role="dialog">
		<div class="modal-picture">
	        <div class="modal-body">
	        	<img id="picture" src="">
    			<p id="description"></p>
	        </div>
		</div>
	</div>

@stop