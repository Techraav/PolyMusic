@extends('layouts.admin')

@section('content')

	<h1 align="center">{!! printLink('courses/'.$course->slug, ucfirst($course->name), ['title' => 'Voir la fiche du cours']) !!}</h1>
	<h5 align="center" class="help-block"><i>Géré par : {!! printUserLinkV2($course->manager) !!}</i></h5>
	<br />
	<h3 align="center">liste des documents {{ isset($filter) ? $filter : ''}} :</h3>
	<br />
	<table class="table table-hover table-striped"> 
		<thead>
			<tr>
				<td width="100" align="center"><b>Ajouté le</b></td>
				<td width="230"align="center"><b>Ajouté par</b></td>
				<td width="250"><b>Titre</b></td>
				<td width="340"><b>Description</b></td>
				<td align="center"><b>Validé</b></td>
				<td align="center"><b>Gérer</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($course->documents as $d)
				<td align="center">{{ showDate($d->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
				<td align="center">{!! printUserLinkV2($d->author) !!}</td>
				<td>{{ $d->title }}</td>
				<td>{!! cut($d->description, 40) !!}</td>
				<td class="manage" align="center">{!! printLink('admin/courses/'.$course->id.'/documents/'.$d->validated, '', ['title' => 'N\'afficher que les documents '.($d->validated == 0 ? 'non validés' : 'validés').'.'], ['glyphicon', 'glyphicon-'.($d->validated == 0 ? 'remove' : 'ok')]) !!}</td>
				<td align="center">
				@if(Auth::user()->level_id > 3 || $course->users->contains(Auth::user()))
					@if($d->validated == 1)
						<button 
								title="invalider le document"
								class="{{ glyph('remove') }}">
						</button>
					@else
						<button 
								title="valider le document"
								class="{{ glyph('ok') }}">
						</button>
					@endif
					<button 
							title="modifier le document"
							class="{{ glyph('pencil') }}">
					</button>
				@else
				-
				@endif
				</td>
			@empty

			@endforelse
		</tbody>
	</table>
@stop