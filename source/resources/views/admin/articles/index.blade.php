@extends('layouts.admin')

@section('title')
    Articles
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">Articles</li>
@stop

@section('content')

	<div class="jumbotron">
		<h1 align="center">Gestion des articles</h1>
		<p>Voici une vue d'ensemble des annonces.</p>
		<p>Vous pouvez valider ou invalider un article en cliquant sur les boutons <span class="{{ glyph('ok') }} glyph-text"></span> ou <span class="{{ glyph('remove') }} glyph-text"></span>. Seuls les articles validés seront visibles par les membres.</p>
		@if(Auth::user()->level_id == 3)
			<p>En tant que {{ ucfirst(Auth::user()->level->name) }}, vous pouvez modifier ou supprimer les articles que vous avez postés. Attention, la suppression est définitive !</p>
		@else
			<p>En tant que {{ ucfirst(Auth::user()->level->name) }}, vous pouvez modifier ou supprimer tous les articles mis en ligne. Attention, la suppression est définitive !</p>
		@endif
		<p>Vous souhaitez créer un article ? {!! printLink('admin/articles/create', 'Cliquez ici') !!} !</p>
		<hr />
		<p>Nombre total d'articles créés : {{ App\Article::count() }}.</p>
	</div>

	<h2 align="center">Liste des articles</h2>
	@if(isset($category) && $category != '')
		<h4 align="center" class="help-block">Catégorie : <i>{{ucfirst($category)}}</i></h4>
	@endif

	<br />

	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<td width="150" align="center"><b>Créé le</b></td>
				<td><b>Auteur</b></td>
				<td><b>Titre</b></td>
				<td align="center" width="100"><b>Categorie</b></td>	
				<td align="center" width="80"><b>Validé</b></td>			
				<td width="20"></td>
				<td align="center" width="20"><b>Gérer</b></td>
				<td width="20"></td>
			</tr>
		</thead>
		<tbody>
			@forelse($articles as $a)
				<tr>
					<td align="center">{{ showDate($a->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
					<td>{!! printUserLinkV2($a->author) !!}</td>
					<td><a href="{{ url('articles/view/'.$a->slug) }}">{{ ucfirst($a->title) }}</a></td>
					<td align="center"><a href="{{ url('admin/articles/category/'.$a->category->id) }}">{{ ucfirst($a->category->name) }}</a></td>
					<td align="center" class="manage">
						<a href="{{ $a->validated == 1 ? url('admin/articles/validated/1') : url('admin/articles/validated/0') }}"
						   class="icon-validated glyphicon glyphicon-{{ $a->validated == 1 ? 'ok' : 'remove' }}">
						</a>
					</td>
					@if(Auth::user()->level_id > 3 || $a->user_id == Auth::user()->id)
						<td class="manage manage-left" align="right">
							@if($a->validated == 1)
								<button 
										onclick="modalToggle(this)"
										link="{{ url('admin/articles/validate/0') }}"
										id="{{ $a->id }}"
										action="invalider"
										title="Invalider l'article"
										msg="Voulez-vous vraiment invalider cet article ?"
										class="{{ glyph('remove') }}">
								</button>
							@else
								<button 
										onclick="modalToggle(this)"
										link="{{ url('admin/articles/validate/1') }}"
										id="{{ $a->id }}"
										action="valider"
										msg="Voulez-vous vraiment valider cet article ?"
										title="Valider l'article"
										class="{{ glyph('ok') }}">
								</button>
							@endif
						</td>
						<td class="manage" align="center">
							<button
									onclick='modalDelete(this)'
									link="{{ url('admin/articles/delete') }}"
									id="{{ $a->id }}"
									title="Supprimer l'annonce"
									class="{{ glyph('trash') }}">
							</button>
						</td>
						<td class="manage manage-right" align="left">
							<a href="{{ url('articles/edit/'.$a->slug) }}" title="Modifier l'annonce" class="{{ glyph('pencil') }}"> </a>
						</td>
				@else
				<td></td><td align="center">-</td><td></td>
				@endif	
				</tr>
			@empty

			@endforelse
		</tbody>
	</table>

	<div align="right"> {!! $articles->render() !!} </div>

	<div class="modal fade" id="modalToggle" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Valider/Invalider un article</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-warning"><b></b></p>
			         	<input hidden value="" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" id="button-toggle" class="btn btn-primary"></button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer un article</h4>
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