@extends('layouts.app')

@section('title')
	News
@stop

@section('breadcrumb')
    <li class="active">News</li>
@stop


@section('content')
	<div class="jumbotron">
		@if(Auth::check()	)
			@if(Auth::user()->level_id > 2)
				<a href="{{ url('admin/news') }}" title="Gérer les news" class="{{ glyph('cog') }}"></a>
			@endif
		@endif	
		<h1 align="center">L'actu de la Team Musique !</h1>
		<p>Voici la liste des news, triées de la plus récente à la plus ancienne.</p>
		<p>Cliquez sur le titre d'une news pour la voir en entier.</p>
		@if(Auth::check() && Auth::user()->level_id >= 3)
			<hr class="colorgraph" />
			<p>Vous souhaitez créer une news ? {!! printLink('admin/news/create', 'Cliquez ici') !!} !</p>
		@endif
	</div>
		<br />
	<h1 align="center">Liste des news </h1>
	<br />

	@forelse($news as $n)
		<blockquote class="comment frame-news col-lg-10 col-lg-offset-1">
			<h2><a title="Cliquez pour voir la news en entier" href="{{ url('news/view/'.$n['slug'])}}">{{$n['title']}}</a></h2>
				@if(Auth::check() && Auth::user()->level_id >= 3)
					<div class="manage">
						<button
								data-link="{{ url('admin/news/delete') }}"
								data-id="{{ $n->id }}"
								title="Supprimer la news"
								class="{{ glyph('trash') }} delete-button">
						</button>
						<a class="glyphicon glyphicon-pencil" href="{{ url('admin/news/edit/'.$n['slug']) }}"></a>
					</div>
				@endif
			{!! cut($n['content'], 540, 'news/view/'.$n->slug) !!} <br/>
				<div class="post-infos post-news-infos" align="right">Rédigée par 
					{!! printUserLinkV2($n->author) !!} le {{date_format($n['created_at'], 'd/m/Y \à H:i')}}.
				</div>
		</blockquote>
		<br/>	
	@empty
    	<h3 align="center"><i>Pas de news pour le moment.</i></h3>
	@endforelse

	<div align="right">
		{!! $news->render() !!}
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer une news</h4>
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