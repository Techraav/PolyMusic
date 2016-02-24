@extends('layouts.admin')

@section('title')
	Instruments
@stop

@section('content')

	<div class="jumbotron">
		<h1>Gestion des instruments</h1>
		<p>Les instruments sont nécessaires à la création de cours et de membres de groupes, pour les classer par instrument.</p>
		<p>Il ne s'agit que d'une simple liste de noms d'instruments référencés sur votre site.</p>
		<p>Il est nécessaire d'être au minimum <b>{{ ucfirst(App\Level::where('level', 3)->first()->name) }}</b> supprimer un instrument qui est &laquo; utilisé &raquo; par au moins un cours ou un membre d'un groupe</p>
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
					<td align="center">{{ $i->players->count() == 0 ? '-' : $i->players->count() }}</td>
					<td align="center">
					@if($i->id != 1)
						<form method="post" action="{{ url('admin/instruments/delete/'.$i->id) }}">
						{{ csrf_field() }}
							<input hidden name="id" value="{{ $i->id }}" />
							@if( ($i->courses->count() == 0 && $i->players->count() == 0) || Auth::user()->level->level >= 3 )
							<button align="right" title="Supprimer l'instrument {{ $i->name }} ?" type="submit" class="glyphicon glyphicon-trash"></button>
							@else
							&nbsp;&nbsp; - &nbsp;
							@endif
							<a href="{{ url('admin/instruments/edit/'.$i->id) }}" title="Modifier l'instrument {{ $i->name }} ?"class="glyphicon glyphicon-pencil"></a>
						</form>
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
@stop
