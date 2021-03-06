@extends('layouts.admin')

@section('title')
	Utilisateurs
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">Utilisateurs</li>
@stop

@section('content')

<div class="jumbotron">
	<h1>Les membres</h1>
	<p>Voici une liste des membres inscrits sur le site de la Team Musique de Polytech Tours.</p>
	<p>Vous pouvez cliquer sur un membre pour accéder à son profil et donc gérer ses données.</p>
	<p>Seuls les administrateurs et autres membres ayant un level supérieur peuvent gérer le level des autres membres.</p>
	<p >Ceux qui apparaissent en rouge sont les membres bannis du site.</p>
	<hr />
	<p>Nombre total de membres incrits : {{ App\User::count() }}</p>
</div>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<td width="300"><b>Nom Prénom</b></td>
				<td width="400"><b>Adresse e-mail</b></td>
				<td align="center" width="150"><b>Département</b></td>
				<td align="center" width="210"><b>Membre depuis le :</b></td>
				<td width="50" align="center"><b>Level</b></td>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $u)
				<tr {{ $u->banned == 1 ? 'class=banned' : '' }}>
					<td >{!! printUserLinkV2($u) !!}</td>
					<td>{{ $u->email }}</td>
					<td align="center"><a href="{{ url('admin/departments/'.$u->department_id.'/members') }}">{{ $u->department->name }} ({{ $u->department->short_name }})</a></td>
					<td align="center">{{ showDate($u->created_at, 'Y-m-d H:i:s' , 'j M Y') }}</td>
					<td align="center">	<a href="{{ url('admin/levels/'.$u->level->name.'/members') }}">{{ ucfirst($u->level->name) }}</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<div align="right">{!! $users->render() !!}</div>

@stop