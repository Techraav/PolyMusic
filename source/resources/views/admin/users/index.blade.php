@extends('layouts.admin')

@section('content')

<div class="jumbotron">
	<h1>Les membres</h1>
	<p>Voici une liste des membres inscrits sur le site du Club Musique de Polytech Tours.</p>
	<p>Vous pouvez cliquer sur un membre pour accéder à son profil et donc gérer ses données.</p>
	<p>Seuls les administrateurs et autres membres ayant un level supérieur peuvent gérer le level des autres membres.</p>
	<hr />
	<p>Nombre total de membres incrits : {{ App\User::count() }}</p>
</div>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Nom Prénom</th>
				<th>Adresse e-mail</th>
				<th>Membre depuis le :</th>
				<th>Level</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $u)
				<tr>
					<td>{{ ucfirst($u->last_name) }} {{ucfirst($u->first_name) }}</td>
					<td>{{ $u->email }}</td>
					<td>{{ $u->created_at }}</td>
					<td>{{ $u->level }}</td>
				</tr>
			@endforeach
			
		</tbody>
	</table>

	{!! $users->render() !!}

@stop