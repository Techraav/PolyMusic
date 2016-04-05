@extends('layouts.admin')

@section('title')
    Annonces
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">Annonces</li>
@stop

@section('content')

	{{-- Infos --}}
	<div class="jumbotron">
		<h1 align="center">Gestion des annonces</h1>
		<p>Voici une vue densemble des annonces créées, validées ou non, triées par date de création.</p>
		<p>Vous pouvez cliquer sur le nom de l'auteur pour aller voir son profil.</p>
		<p>Vous pouvez cliquer sur le titre de l'annonce pour la consulter.</p>
		<p>Vous pouvez cliquer sur la catégorie pour n'afficher que les annonces de cette catégorie.</p>
		<p>Le bouton &laquo; supprimer &raquo; ne supprime pas définitivement une annonce, elle l'invalide seulement.</p>
		<p>Vous souhaitez créer une annonce ? {!! printLink('admin/announcements/create', 'Cliquez ici') !!} !</p>
		<hr />
		<p>Nombre total d'annonces créées : {{ App\Announcement::count() }}.</p>

	</div>



	{{-- Table --}}
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<td width="150" align="center"><b>Créé le</b></td>
				<td><b>Auteur</b></td>
				<td><b>Titre</b></td>
				<td align="center" width="100"><b>Categorie</b></td>
				<td width="100" align="center"><b>Validée</b></td>
				<td width="20"></td>
				<td width="20" align="center"><b>Gérer</b></td>
				<td width="20"></td>
			</tr>
		</thead>
		<tbody>
			@forelse($announcements as $a)
				<tr>
					<td align="center">{{ showDate($a->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
					<td>{!! printUserLinkV2($a->author) !!}</td>
					<td><a href="{{ url('announcements/view/'.$a->slug) }}">{{ ucfirst($a->title) }}</a></td>
					<td align="center"><a href="{{ url('admin/announcements/'.$a->category->id) }}">{{ ucfirst($a->category->name) }}</a></td>
					<td align="center" class="manage">
						<a href="{{ $a->validated == 1 ? url('admin/announcements/validated/1') : url('admin/announcements/validated/0') }}"
						   class="icon-validated glyphicon glyphicon-{{ $a->validated == 1 ? 'ok' : 'remove' }}">
						</a>
					</td>
					@if(Auth::user()->level_id > 3 || $a->user_id == Auth::user()->id)
						<td class="manage manage-left" align="right">
							@if($a->validated == 1)
								<button 
										onclick="modalToggle(this)"
										link="{{ url('announcements/validate/0') }}"
										id="{{ $a->id }}"
										action="invalider"
										title="Invalider l'annonce"
										msg="Voulez-vous vraiment invalider cette annonce ?"
										class="{{ glyph('remove') }}">
								</button>
							@else
								<button 
										onclick="modalToggle(this)"
										link="{{ url('announcements/validate/1') }}"
										id="{{ $a->id }}"
										action="valider"
										msg="Voulez-vous vraiment valider cette annonce ?"
										title="Valider l'annonce"
										class="{{ glyph('ok') }}">
								</button>
							@endif
						</td>
						<td class="manage" align="center">
							<button
									data-link="{{ url('announcements/delete') }}"
									data-id="{{ $a->id }}"
									title="Supprimer l'annonce"
									class="{{ glyph('trash') }} delete-button">
							</button>
						</td>
						<td class="manage manage-right" align="left">
							<a href="{{ url('announcements/edit/'.$a->slug) }}" title="Modifier l'annonce" class="{{ glyph('pencil') }}"> </a>
						</td>
				@else
				<td></td><td align="center">-</td><td></td>
				@endif

				</tr>
			@empty
			<td align="center">-</td>
			<td>-</td>
			<td>-</td>
			<td align="center">-</td>
			<td align="center">-</td>
			<td></td>
			<td align="center">-</td>
			@endforelse
		</tbody>
	</table>

	<div align="right"> {!! $announcements->render() !!} </div>

	{{-- Modals --}}
	<!-- Modal -->
	<div class="modal fade" id="modalToggle" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Valider/Invalider une annonce</h4>
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
	          		<h4 id="modal-title" class="modal-title">Supprimer une annonce</h4>
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