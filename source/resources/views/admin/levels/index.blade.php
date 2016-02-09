@extends('layouts.admin')

@section('content')

	<div class="jumbotron">
		<h1>Gestion des niveaux de permissions</h1>
		<p>Les niveaux permettent de définir une hiérarchie entre les membres.</p>
		<p>Plus le niveau d'un membre est élevé plus il est suceptible de posséder beaucoup de droits.</p>
		<p>Le niveau le plus faible est l'invité (non connecté), qui ne possède quasiment aucun droit.</p>
		<p>Le niveau le plus fort définit un Webmaster du site. Il possède tous les droits et peut gérer les données comme bon lui semble.</p>
	</div>

	<h2 align="center">Liste des niveaux :</h2>
	<br />
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th width="100">Level</th>
					<th width="200">Nom</th>
					<th width="300">Informations</th>
					<th width="170">Nombre de membres</th>
					<th width="300">Gérer</th>
				</tr>
			</thead>
			<tbody>
			@forelse($levels as $l)
				<tr>
					<td>{{ $l->level }}</td>
					<td><a href="{{ url('admin/levels/'.$l->name.'/members') }}">{{ $l->name }}</a></td>
					<td>{{ $l->infos ? $l->infos : '-' }}</td>
					<td align="center">{{ App\User::where('level', $l->level)->count() }}</td>
					<td>-</td>
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

		<h2 align="center">Ajouter un Level :</h2>

		<form method="post" action="{{ url('admin/levels/create') }}">
			<table class="table">
			<tbody>
				<th>
				{{ csrf_field() }}
					<td>
					<select class="form-control" name="level">
							@foreach ($levelNotUsed as $k)
								<option value="{{ $k }}">{{ $k }}</option>
							@endforeach
						</select>
					</td>
					<td><input required class="form-control" type="text" name="name" id="name" placeholder="Nom" /></td>
					<td><input class="form-control" type="text" name="infos" id="infos" placeholder="Informations" /></td>
					<td><button type="reset" class="btn btn-default">Annuler</button> <button type="submit" class="btn btn-primary">Ajouter</button></td>
				</th>
			</tbody>
			</table>
		</form>


@stop