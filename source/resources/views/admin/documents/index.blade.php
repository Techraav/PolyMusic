@extends('layouts.admin')

@section('content')

	<div class="jumbotron">
		<h1>Gestion des documents</h1>
		<p></p>
		<hr />
		<p>Nombre total de documents mis en ligne : {{ App\Document::count() }}</p>
	</div>

	<h2 align="center">Liste des documents</h2>
	@if(isset($filter))
		<h5 align="center" class="help-block"><i>Filtre : {{ $filter }} </i></h5>
	@endif

	<br />

	<table class="table table-hover table-stripped">
		<thead>
			<tr>
				<td align="center" width="150"><b>Date d'ajout</b></td>
				<td><b>Auteur</b></td>
				<td><b>Cours</b></td>
				<td><b>Titre du document</b></td>
				<td align="center"><b>Gérer</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($documents as $d)
				<tr>
					<td align="center">{{ showDate($d->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
					<td>{!! printUserLinkV2($d->author) !!}</td>
					<td>{!! printLink('courses/show/'.$d->author->slug, ucfirst($d->course->name)) !!}</td>
					<td>{!! printLink('files/documents/'.$d->name, ucfirst($d->title), ['target'	=> '_blank']) !!}</td>
					<td align="center" class="manage">
					@if(Auth::user()->level->level > 2)							
						@if($d->validated == 1)
						<button onclick="dialogDelete(this)" 
								id="{{ $d->id }}" 
								align="right" 
								link="{{ url('announcements/delete/'.$d->slug) }}"
								title="Supprimer le document {{ $d->title }} ?" 
								class="glyphicon glyphicon-trash">
						</button>
						@else
							&nbsp; <a title="Valider le document ?" class="glyphicon glyphicon-ok" href="{{ url('admin/documents/validate/'.$d->id) }}"></a>&nbsp;
						@endif

						<button onclick="dialogEdit(this)" 
								id="{{ $d->id }}" 
								href="{{ url('announcements/edit/'.$d->slug) }}"
								title="Modifier le document {{ $d->title }} ?"
								class="glyphicon glyphicon-pencil">
						</button>
					@else
						-
					@endif
				</td>
				</tr>
			@empty
				<tr>
					<td align="center">-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td align="center">-</td>
				</tr>
			@endforelse
		</tbody>
	</table>
	
	<div align="right">{!! $documents->render(); !!}</div>

@stop

