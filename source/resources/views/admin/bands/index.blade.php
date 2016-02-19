@extends('layouts.admin')

@section('content')

	<div class="jumbotron">
		<h1 align="center"> Gestion des groupes </h1>
		<p>Voici la liste des groupes, validés ou non, créés par les utilisateurs du site.</p>
		<p>Vous pouvez cliquer sur le nom d'un groupe pour accéder à l'article le concernant.</p>
		<p>Vous pouvez cliquer sur le nom du créateur pour accéder à son profil.</p>
		<p>Vous pouvez choisir de n'afficher que les groupes validés ou en attente de validation.</p>
		<p>Il faut être au moins {{ ucfirst(App\Level::where('level', 3)->first()->name) }} pour modifier ou supprimer un groupe.</p>
		<hr />
		<p>Nombre total de groupes : {{ App\Band::count() }}.</p>
	</div>

	<h2 align="center"> Liste des groupes </h2>
	<br />

	<table class="table table-striped table-hover table-bands">
		<thead>
			<tr>
				<td width="120" align="center"><b>Créé le</b></td>
				<td align="center"><b>Nom</b></td>
				<td width="300"><b>Créateur</b></td>
				<td width="100" align="center"><b>Membres</b></td>
				<td width="100" align="center"><b>Validé</b></td>
				<td width="100" align="center"><b>Gérer</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($bands as $b)
			<tr>
				<td align="center">{{ date_format($b->created_at, 'd/m/Y') }}</td>
				<td align="center"><a href="{{ url('bands/'.$b->slug) }}">{{ ucfirst($b->name) }}</a></td>
				<td>{!! printUserLink($b->user_id) !!}</td>
				<td align="center">{{ App\BandMember::where('band_id', $b->id)->count() }}</td>
				<td align="center"><span class="icon-validated glyphicon glyphicon-{{ $b->validated == 0 ? 'ok' : 'remove' }}"></span></td>
				<td align="center">
					@if($b->user_id == Auth::user()->id || Auth::user()->level > 1)
						<form method="post" action="{{ url('admin/bands/delete/'.$b->id) }}">
						{{ csrf_field() }}
							<input hidden name="id" value="{{ $b->id }}" />
							<button align="right" title="Supprimer le groupe {{ $b->name }} ?" type="submit" class="glyphicon glyphicon-trash"></button>
							<a href="{{ url('admin/departments/edit/'.$b->id) }}" title="Modifier le groupe {{ $b->name }} ?"class="glyphicon glyphicon-pencil"></a>
						</form>
					@else
						-
					@endif
				</td>			
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

	<div align="right"> {!! $bands->render() !!} </div>

@stop