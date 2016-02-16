@extends('layouts.admin')

@section('content')

	<div class="jumbotron">
		<h1> Modifications des membres des cours </h1>
		<p>Lorsque qu'un utilisateur s'inscrit à un cours, qu'il annule son inscription, qu'une inscription est refusée ou validée, ou qu'un membre d'un cours est supprimé, une modification est enregistrée automatiquement.</p>
		<p>Les modifications concernant les membres des cours sont différentes des modifications des données générales.</p>
		<p>Pour accéder aux modifications générales, <a href="{{ url('admin/modifications') }}">cliquez ici</a>.</p>
		<hr />
		<p>Nombre total de modifications effectuées : {{ App\CourseModification::count() }}</p>
	</div>

	<h2 align="center">Liste des modifications</h2>
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<td width="250"><b>Auteur</b></td>
				<td width="250"><b>Utilisateur concerné</b></td>
				<td width="250"><b>Cours concerné</b></td>
				<td><b>Information</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($modifs as $m)
				<tr>
					<td>{!! printUserLink($m->author_id) !!}</td>
					<td>{!! printUserLink($m->user_id) !!}</td>
					<td><a href="{{ url('course/'.App\Course::where('id', $m->course_id)->first()->slug) }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a></td>
					<td></td>
				</tr>
			@empty
			<tr>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
			</tr>
			@endforelse
		</tbody>
	</table>

	{!! $modifs->render() !!}
@stop