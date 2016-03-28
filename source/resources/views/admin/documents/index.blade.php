@extends('layouts.admin')

@section('title')
    Documents
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">Documents</li>
@stop

@section('content')

	<div class="jumbotron">
		<h1>Gestion des documents</h1>
		<p>Voici une vue d'ensemble des documents mis en ligne pour les cours.</p>
		<p>Vous pouvez activer ou désactiver un document. Un document non validé n'est visible que pas les {{ ucfirst(App\Level::find(3)->name).'s' }} ou plus.</p>
		<p>Vous pouvez également supprimer un document. Attention, cette action est définitive.</p>
		<p>Le bouton &laquo; Modifier &raquo; vous permettra de mofifier le titre du document ainsi que sa description.</p>
		<hr />
		<p>Nombre total de documents en ligne : {{ App\Document::count() }}</p>
	</div>

	<h2 align="center">Liste des documents</h2>
	@if(isset($filter))
		<h5 align="center" class="help-block"><i>Filtre : {{ $filter }} </i></h5>
	@endif

	<br />

	<table class="table table-hover table-stripped">
		<thead>
			<tr>
				<td align="center" width="150"><b>Date d'ajout</b></td>
				<td><b>Auteur</b></td>
				<td><b>Cours</b></td>
				<td><b>Titre du document</b></td>
				<td width="20" align="right"> </td>
				<td width="20" align="center"><b>Gérer</b></td>
				<td width="20" align="left"></td>
			</tr>
		</thead>
		<tbody>
			@forelse($documents as $d)
				<tr>
					<td align="center">{{ showDate($d->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
					<td>{!! printUserLinkV2($d->author) !!}</td>
					<td>{!! printLink('courses/show/'.$d->course->slug, ucfirst($d->course->name)) !!}</td>
					<td>{!! printLink('files/documents/'.$d->name, ucfirst($d->title), ['target'	=> '_blank']) !!}</td>
					@if(Auth::user()->level_id > 3 || $d->course->users->contains(Auth::user()) || $d->course->user_id == Auth::user()->id)
						<td class="manage manage-left" align="right">
							@if($d->validated == 1)
								<button 
										onclick="modalToggle(this)"
										link="{{ url('admin/documents/validate/0') }}"
										id="{{ $d->id }}"
										action="invalider"
										title="Invalider le document"
										msg="Voulez-vous vraiment invalider ce document ?"
										class="{{ glyph('remove') }}">
								</button>
							@else
								<button 
										onclick="modalToggle(this)"
										link="{{ url('admin/documents/validate/1') }}"
										id="{{ $d->id }}"
										action="valider"
										msg="Voulez-vous vraiment valider ce document ?"
										title="Valider le document"
										class="{{ glyph('ok') }}">
								</button>
							@endif
						</td>
						<td class="manage" align="center">
							<button
									onclick='modalDelete(this)'
									link="{{ url('admin/documents/delete') }}"
									id="{{ $d->id }}"
									title="Supprimer le document"
									class="{{ glyph('trash') }}">
							</button>
						</td>
						<td class="manage manage-right" align="left">
							<a href="{{ url('admin/documents/edit/'.$d->id) }}" title="Modifier le document" class="{{ glyph('pencil') }}"> </a>
						</td>
				@else
				<td></td><td align="center">-</td><td></td>
				@endif
				</tr>
			@empty
				<tr>
					<td align="center">-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td></td>
					<td align="center">-</td>
					<td></td>
				</tr>
			@endforelse
		</tbody>
	</table>
	
	<div align="right">{!! $documents->render(); !!}</div>
	<!-- Modal -->

	<!-- Modal -->
	<div class="modal fade" id="modalToggle" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Valider/Invalider un document</h4>
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
	          		<h4 id="modal-title" class="modal-title">Supprimer un document</h4>
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

@section('js')

<script type="text/javascript">
	function edit(el)
	{

	}

</script>

@stop

