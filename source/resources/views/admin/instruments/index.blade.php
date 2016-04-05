@extends('layouts.admin')

@section('title')
	Instruments
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">Intruments</li>
@stop

@section('content')

<div class="jumbotron">
	<h1>Gestion des instruments</h1>
	<p>Les instruments sont nécessaires à la création de cours et de membres de groupes, pour les classer par instrument.</p>
	<p>Il ne s'agit que d'une simple liste de noms d'instruments référencés sur votre site.</p>
	<p>Il est nécessaire d'être au minimum <b>{{ ucfirst(App\Level::where('level', 3)->first()->name) }}</b> supprimer un instrument qui est &laquo; utilisé &raquo; par au moins un cours ou un membre d'un groupe</p>
	<hr />
	<p>Nombre total d'instruments créés : {{ App\Instrument::count() }}.</p>
</div>

	<h2 align="center">Liste des instruments :</h2>
	<br />
		<table class="table-levels table table-striped table-hover">
			<thead>
				<tr>
					<td align="center" width="50"><b>Instrument</b></td>
					<td align="center" width="250"><b>Cours</b></td>
					<td align="center" width="120"><b>Groupes</b></td>					
					<td width="50" align="center"><b>Gérer</b></td>
				</tr>
			</thead>
			<tbody>
			@forelse($instruments as $i)
				<tr>
					<td align="center">{{ ucfirst($i->name) }}</td>
					<td align="center">{{ $i->courses->count() == 0 ? '-' : $i->courses->count() }}</td>
					<td align="center">{{ $i->bands->count() == 0 ? '-' : $i->players->count() }}</td>
					@if(Auth::user()->level_id > 3 && $i->id != 1)
						<td class="manage" align="center">
							<button
									data-link="{{ url('admin/instruments/delete') }}"
									data-id="{{ $i->id }}"
									title="Supprimer cet instrument"
									class="{{ glyph('trash') }} delete-button">
							</button>
							<button 
									data-id="{{ $i->id }}"
									data-link="{{ url('admin/instruments/edit') }}"
									data-name="{{ $i->name }}"
									title="Modifier la catégorie" 
									class="{{ glyph('pencil') }} edit-instrument-button"> 
							</button>
						</td>
					@else
					<td align="center">-</td>
					@endif
				</tr>
			@empty

				<tr>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
				</tr>
			@endforelse

			</tbody>
		</table>

		<div align="right"> {!! $instruments->render() !!} </div>
		<br />
			<h2 align="center">Ajouter un Instrument :</h2>
		<div class="col-md-10 col-md-offset-2">

			<form method="post" action="{{ url('admin/instruments/create') }}">
				<table class="table">
				<tbody>
					<tr>
					{{ csrf_field() }}
						<td><input required class="form-control" type="text" name="name" id="name" placeholder="Nom complet" /></td>
						<td><button type="reset" class="btn btn-default">Annuler</button> <button type="submit" class="btn btn-primary">Valider</button></td>
					</tr>
				</tbody>
				</table>
			</form>
	    </div>


	@include('admin.instruments.modal-edit')


	<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer un instrument</h4>
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
