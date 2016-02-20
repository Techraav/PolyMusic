@extends('layouts.admin')

@section('content')

<div class="jumbotron">
	<h1>Les membres</h1>
	<p>Voici une liste des membres inscrits sur le site du Club Musique de Polytech Tours.</p>
	<p>Vous pouvez cliquer sur un membre pour accéder à son profil et donc gérer ses données.</p>
	<p>Seuls les administrateurs et autres membres ayant un level supérieur peuvent gérer le level des autres membres.</p>
	<p>Ceux qui apparaissent en rouge sont les membres bannis du site.</p>
	<hr />
	<p>Nombre total de membres incrits : {{ App\User::count() }}</p>
</div>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th width="300">Nom Prénom</th>
				<th width="400">Adresse e-mail</th>
				<th width="150">Département</th>
				<th width="150">Membre depuis le :</th>
				<th width="50" align="center">Level</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $u)
				<tr {{ $u->banned == 1 ? 'class=banned' : '' }}>
					<td >{!! printUserLink($u->id) !!}</td>
					<td>{{ $u->email }}</td>
					<td><a href="{{ url('admin/departments/'.$u->department_id.'/members') }}">{{ $u->department->name }} ({{ $u->department->short_name }})</a></td>
					<td>&nbsp; &nbsp; &nbsp; {{ date_format($u->created_at, 'j M Y') }}</td>
					<td align="center">	<a href="{{ url('admin/levels/'.$u->level->name.'/members') }}">{{ $u->level }}</a></td>
				</tr>
			@endforeach
			
		</tbody>
	</table>

	<div align="right">{!! $users->render() !!}</div>

@stop