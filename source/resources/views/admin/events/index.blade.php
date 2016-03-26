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
				<td width="80" align="center"><b>Gérer</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($events as $e)
				<tr>
					<td align="center">{{ printDay($e->day, true) }} {{ showDate($e->date, 'Y-m-d', 'd/m/Y') }}</td>
					<td>{!! printUserLinkV2($e->manager) !!}</td>
					<td><a href="{{ url('events/manage/'.$e->id) }}">{{ $e->name }}</a>
						&nbsp;
						<a title="Voir la fiche de l'événement" class="glyphicon glyphicon-file" href="{{ url('events/show/'.$e->slug) }}"></a></td>
					<td align="center">{{ showDate($e->start, 'H:i:s', 'H:i') }} - {{ showDate($e->end, 'H:i:s', 'H:i')}} </td>
					<td>{{ $e->location }}</td>
					<td align="center"> {{ $e->bands->count() }} </td>
					<td class="manage" align="center">
					@if(Auth::user()->level->level > 3 || Auth::user()->id == $e->user_id)							
						<button onclick="dialogDelete(this)"
								id="{{ $e->id }}"
								link="{{ url('events/delete/'.$e->id) }}"
								align="right" 
								title="Supprimer l'évenement {{ $e->name }} ?" 
								class="glyphicon glyphicon-trash">
						</button>

						<a href="{{ url('events/edit/'.$e->id) }}"  title="Modifier l'événement {{ $e->name }} ?" class="glyphicon glyphicon-pencil">	</a>
					@else
						-
					@endif
				</td>
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

	{{-- MODALS --}}
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer un événement</h4>
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
		function dialogDelete(el) {
			var id = el.getAttribute('id');
			var link = el.getAttribute('link');

			$('#modalDelete #id').attr('value', id);
			$('#modalDelete form').attr('action', link);
			$('#modalDelete').modal('show');
		}
	</script>

@stop