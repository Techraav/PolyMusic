@extends('layouts.admin')

@section('content')

	<div class="jumbotron">
		<h1>Gestion des départements</h1>
		<p>Les départements correspondent aux département dans lesquels les étudiants de l'école sont inscrits.</p>
		<p>Leur rôle est uniquement à titre informatif et n'a aucune influence sur quoi que ce soit sur le site.</p>
	</div>

	<h2 align="center">Modifier le département</h2>
	<form method="post" action="{{ url('admin/departments/edit/'.$depToEdit->id) }}">
		<table class="table">
		<tbody>
			<th>
			{{ csrf_field() }}
				<td><input required class="form-control" type="text" name="name" id="name" placeholder="Nom" value="{{ $depToEdit->name }}"/></td>
				<td><input class="form-control" type="text" name="short_name" id="short_name" placeholder="Informations"  value="{{ $depToEdit->short_name }}"/></td>
				<td><button type="reset" class="btn btn-default">Annuler</button> <button type="submit" class="btn btn-primary">Valider</button></td>
			</th>
		</tbody>
		</table>
	</form>


	<h2 align="center">Liste des départements :</h2>
	<br />
		<table class="table-levels table table-striped table-hover">
			<thead>
				<tr>
					<td align="center" width="50"><b>Acronyme</b></td>
					<th width="250">Nom complet</th>
					<td align="center" width="120"><b>Nombre de membres</b></td>
					<td align="center" width="100"><b>Gérer</b></td>
				</tr>
			</thead>
			<tbody>
			@forelse($departments as $d)
				<tr>
					<td align="center">
						<a href="{{ url('admin/departments/'.$d->id.'/members') }}">{{ $d->short_name }}</a>
					</td>
					<td>
						<a href="{{ url('admin/departments/'.$d->id.'/members') }}">{{ $d->name }}</a>
					</td>
					<td align="center">{{ App\User::where('department_id', $d->id)->count() }}</td>
					<td align="center">
					@if($d->id != 1)
						<form method="post" action="{{ url('admin/departments/delete/'.$d->id) }}">
						{{ csrf_field() }}
							<input hidden name="id" value="{{ $d->id }}" />
							<button align="right" title="Supprimer le départment {{ $d->name }} ?" type="submit" class="glyphicon glyphicon-trash"></button>
							<a href="{{ url('admin/departments/edit/'.$d->id) }}" title="Modifier le département {{ $d->name }} ?"class="glyphicon glyphicon-pencil"></a>
						</form>
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
				</tr>
			@endforelse

			</tbody>
		</table>

		<h2 align="center">Ajouter un Département :</h2>

		<form method="post" action="{{ url('admin/departments/create') }}">
			<table class="table">
			<tbody>
				<th>
				{{ csrf_field() }}
					<td><input required class="form-control" type="text" name="name" id="name" placeholder="Nom complet" /></td>
					<td><input required class="form-control" type="text" name="short_name" id="short_name" placeholder="Acronyme" /></td>
					<td><button type="reset" class="btn btn-default">Annuler</button> <button type="submit" class="btn btn-primary">Valider</button></td>
				</th>
			</tbody>
			</table>
		</form>


@stop