@extends('layouts.app')

@section('title')
	Gestion d'un événement
@stop

@section('breadcrumb')
    <li> <a href="{{ url('events') }}">Événements</a></li>
    <li class="active">{{ ucfirst($event->name) }} </li>
@stop


@section('content')

	<div class="col-lg-8 col-lg-offset-2">
		<h1 align="center">{{ ucfirst($event->name) }} </h1>
		<h4 class="help-block" align="center">Créateur : {!! printUserLinkV2($event->manager) !!}</h4>
		<br />

		<h3 align="center">Groupes asociés à l'événement :</h3>
		<br />
		
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<td width="300"><b>Manager</b></td>
					<td><b>Groupe</b></td>
					<td align="center" width="100"><b>Gérer</b></td>
				</tr>
			</thead>
			<tbody>
				@forelse($event->bands as $b)
					<tr>
						<td>{!! printUserLinkV2($b->manager) !!}</td>
						<td><a href="{{ url('bands/show/'.$b->slug) }}">{{ ucfirst($b->name) }}</a></td>
						<td align="center" class="manage">
							@if($b->user_id == Auth::user()->id || Auth::user()->level_id > 2)
								<button 
										onclick="dialogDelete(this)"
										link="{{ url('admin/events/'.$event->id.'/removeband') }}"
										id="{{ $b->id }}"
										title="Retirer ce groupe de l'événement ?"
										class="glyphicon glyphicon-trash">
								</button>
							@else
								-
							@endif
						</td>
					</tr>
				@empty
					<tr>
						<td> - </td>
						<td> - </td>
						<td align="center"> - </td>
					</tr>
				@endforelse
			</tbody>
		</table>

	<hr />
	<br />

	<h3 align="center">Ajouter un groupe :</h3>
	<br />
	<table class="table table-hover table-striped">
			<thead>
				<tr>
					<td width="300"><b>Manager</b></td>
					<td><b>Groupe</b></td>
					<td width="100" align="center"><b>Ajouter</b></td>
				</tr>
			</thead>
			<tbody>
				@foreach($bands as $b)
					<?php $n = 0 ?>
					@if(!$b->events->contains($event->id))
						<?php $n += 1 ?>
						<tr>
							<td>{!! printUserLinkV2($b->manager) !!}</td>
							<td><a href="{{ url('bands/show/'.$b->slug) }}">{{ ucfirst($b->name) }}</a></td>
							<td align="center" class="manage">
								@if($b->user_id == Auth::user()->id || Auth::user()->level_id > 2)
									<form method="post" action="{{ url('admin/events/'.$event->id.'/addband/'.$b->id) }}">
										{{ csrf_field() }}
										<button type="submit" title="Ajouter ce groupe de l'événement ?" class="glyphicon glyphicon-plus"></button>
									</form>
								@else
									-
								@endif
							</td>
						</tr>
					@endif
				@endforeach
				@if($n == 0)
					<tr>
						<td> - </td>
						<td> - </td>
						<td align="center"> - </td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>	

	<div align="right"> {!! $bands->render() !!} </div>


	{{-- MODAL --}}

	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Retirer le groupe de l'événement</h4>
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

			$('#modalDelete form').attr('action', link);
			$('#modalDelete #id').attr('value', id);
			$('#modalDelete').modal('show');
		}
	</script>

@stop