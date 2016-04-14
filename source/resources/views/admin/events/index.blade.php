@extends('layouts.admin')

@section('title')
	Events
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">Événements</li>
@stop

@section('content')
	<div class="jumbotron">
		<h1>Gestion des événements</h1>
		<p>Voici une vue d'ensemble des événements créé.</p>
		<p>Vous souhaitez créer un événement ? {!! printLink('admin/events/create', 'Cliquez ici') !!} !</p>
		<hr />
		<p>Nombre total d'événements créés : {{ App\Event::count() }}.</p>
	</div>

	<h1 align="center">Liste des événements</h1>

	<br />
	
	<table class="table table-triped table-hover">
		<thead>
			<tr>
				<td align="center" width="150"><b>Date</b></td>
				<td><b>Créateur</b></td>
				<td><b>Nom</b></td>
				<td align="center" width="180"><b>Horaires</b></td>
				<td><b>Location</b></td>
				<td align="center"><b>Groupes</b></td>
				<td width="20" align="right"> </td>
				<td width="20" align="center"><b>Gérer</b></td>
				<td width="20" align="left"></td>
			</tr>
		</thead>
		<tbody>
			@forelse($events as $e)
				<tr>
					<td align="center">{{ ucfirst(printDay($e->day, true)) }} {{ $e->date->format('d/m/Y') }}</td>
					<td>{!! printUserLinkV2($e->manager) !!}</td>
					<td><a href="{{ url('events/manage/'.$e->id) }}">{{ $e->name }}</a>
						&nbsp;
						<a title="Voir la fiche de l'événement" class="glyphicon glyphicon-file" href="{{ url('events/show/'.$e->slug) }}"></a></td>
					<td align="center">{{ showDate($e->start, 'H:i:s', 'H:i') }} - {{ showDate($e->end, 'H:i:s', 'H:i')}} </td>
					<td>{{ $e->location }}</td>
					<td align="center"> {{ $e->bands->count() }} </td>
					@if(Auth::user()->level_id > 3 || $e->user_id == Auth::user()->id)
						<td class="manage manage-left" align="right">
							@if($e->active == 1)
								<button 
										onclick="modalToggle(this)"
										link="{{ url('admin/events/validate/0') }}"
										id="{{ $e->id }}"
										action="invalider"
										title="Invalider l'événement"
										msg="Voulez-vous vraiment invalider cet événement ?"
										class="{{ glyph('remove') }}">
								</button>
							@else
								<button 
										onclick="modalToggle(this)"
										link="{{ url('admin/events/validate/1') }}"
										id="{{ $e->id }}"
										action="valider"
										msg="Voulez-vous vraiment valider cet événement ?"
										title="Valider l'événement"
										class="{{ glyph('ok') }}">
								</button>
							@endif
						</td>
						<td class="manage" align="center">
							<button
									data-link="{{ url('events/delete') }}"
									data-id="{{ $e->id }}"
									title="Supprimer l'événement"
									class="{{ glyph('trash') }} delete-button">
							</button>
						</td>
						<td class="manage manage-right" align="left">
							<a href="{{ url('admin/documents/edit/'.$e->id) }}" title="Modifier le document" class="{{ glyph('pencil') }}"> </a>
						</td>
				@else
				<td></td><td align="center">-</td><td></td>
				@endif
				</tr>
			@empty
				<tr>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
				</tr>
			@endforelse
		</tbody>
	</table>

	
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