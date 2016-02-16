@extends('layouts.admin')

@section('content')

	<div class="jumbotron">
		<h1> Modifications des données </h1>
		<p>Lorsque qu'une donées est crée, supprimée ou modifiée, une &laquo; modification &raquo; est automatiquement créée.</p>
		<p>Elles permettent de garder une trace des modifications effectuées sur le site.</p>
		<p>Pour accéder aux modifications concernant les membres des cours, <a href="{{ url('admin/modifications/courses') }}">cliquez ici</a>.</p>
		<hr />
		<p>Nombre total de modifications effectuées : {{ App\Modification::count() }}</p>
	</div>

	<h2 align="center">Liste des modifications</h2>
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<td width="200"><b>Utilisateur</b></td>
				<td width="200"><b>Table(s)</b></td>
				<td><b>Message</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($modifs as $m)
				<tr>
					<td>{!! printUserLink($m->user_id) !!}</td>
					<td>{{ $m->table }}</td>
					<td>{{ $m->message }}</td>
				</tr>
			@empty
			<tr>
				<td> - </td>
				<td> - </td>
				<td> - </td>
			</tr>
			@endforelse
		</tbody>
	</table>

	{!! $modifs->render() !!}

@stop