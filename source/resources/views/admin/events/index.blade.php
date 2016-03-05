@extends('layouts.admin')

@section('title')
	Events
@stop()

@section('content')
	<div class="jumbotron">
		<h1>Gestion des événements</h1>
		<p>Voici une vue d'ensemble des événements créé.</p>
	</div>

	<h1>Liste des événements</h1>
	<table class="table table-triped table-hover">
		<thead>
			<tr>
				<td align="center" width="150"><b>Date</b></td>
				<td><b>Créateur</b></td>
				<td><b>Nom</b></td>
				<td align="center" width="180"><b>Horaires</b></td>
				<td><b>Location</b></td>
				<td width="80"><b>Gérer</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($events as $e)
				<tr>
					<td align="center">{{ printDay($e->day, true) }} {{ showDate($e->date, 'Y-m-d', 'd/m/Y') }}</td>
					<td>{!! printUserLink($e->user_id	) !!}</td>
					<td>{{ $e->name }}</td>
					<td align="center">{{ $e->start }} - {{ $e->end }} </td>
					<td>{{ $e->location }}</td>
					<td align="center">
					@if(Auth::user()->level->level > 2)							
						<button
								align="right" 
								title="Supprimer l'évenement {{ $e->name }} ?" 
								class="glyphicon glyphicon-trash">
						</button>

						<button 
								title="Modifier l'événement {{ $e->name }} ?"
								class="glyphicon glyphicon-pencil">
						</button>
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
@stop