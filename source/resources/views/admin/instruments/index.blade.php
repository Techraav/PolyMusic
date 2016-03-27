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
					<td align="center" width="100"><b>Gérer</b></td>
				</tr>
			</thead>
			<tbody>
			@forelse($instruments as $i)
				<tr>
					<td align="center">{{ ucfirst($i->name) }}</td>
					<td align="center">{{ $i->courses->count() == 0 ? '-' : $i->courses->count() }}</td>
					<td align="center">{{ $i->bands->count() == 0 ? '-' : $i->players->count() }}</td>
					<td align="center">
					@if($i->id != 1)
						@if( ($i->courses->count() == 0 && $i->players->count() == 0) || Auth::user()->level->level >= 3 )
							<button onclick="dialogDelete(this)" name="{{ $i->name }}" id="{{ $i->id }}" link="{{ url('admin/instruments/delete/'.$i->id) }}" align="right" title="Supprimer l'instrument {{ $i->name }} ?" type="submit" class="glyphicon glyphicon-trash"></button>
						@else
							&nbsp;&nbsp; - &nbsp;
						@endif
							<button onclick="dialogEdit(this)" name="{{ $i->name }}" id="{{ $i->id }}"  link="{{ url('admin/instruments/edit/'.$i->id) }}" title="Modifier l'instrument {{ $i->name }} ?"class="glyphicon glyphicon-pencil"></button>
					@else - @endif
					</td>
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

	@include('admin.instruments.modal-delete')

	@include('admin.instruments.modal-edit')

@stop

@section('js')

<script type="text/javascript">
		function dialogDelete(el)
		{
			var id = el.getAttribute('id');
			var name = el.getAttribute('name');
			var link = el.getAttribute('link');

			$('#modalDelete form').attr('action', link);
			$('#modalDelete h4').html("Supprimer l'instrument &laquo; " + name + " &raquo; ?");
			$('#modalDelete #instrument_id').attr('value', id);
			$('#modalDelete').modal('toggle');
		}

		function dialogEdit(el)
		{
			var id = el.getAttribute('id');
			var name = el.getAttribute('name');
			var link = el.getAttribute('link');

			$('#modalEdit form').attr('action', link);
			$('#modalEdit #name').attr('value', name);
			$('#modalEdit #intrument_id').attr('value', id);
			$('#modalEdit').modal('toggle');
		}	
</script>

@stop
