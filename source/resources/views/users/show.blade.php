@extends('layouts.app')

@section('title')
	{{ $user -> first_name }} {{ $user -> last_name }}
@stop

@section('content')
<h1 align="center">Profil</h1>
<div class="jumbotron">
	<h2 align="center">{{ $user -> first_name }} {{ $user -> last_name }}</h2>
	<div class="row">
		<div class="profil-pict">
			<p align="center" ><img src=" {{ URL::asset('/img/profil_pictures/'.$user -> profil_picture) }} " alt=" profile picture "/></p>
		</div>
		<div class="infos-profile">
			<table>
				<tbody>
					<br/>
					<tr>	
						<td width="250">Nom :</td>
						<td>{{ $user -> last_name }}</td>
					</tr>
					<tr>
						<td>Prénom :</td>
						<td>{{ $user -> first_name }}</td>
					</tr>
					<tr>
						<td>Date de naissance :</td>
						<td>{{ showDate($user -> birth_date, 'Y-m-j', 'j/m/Y') }}</td>
					</tr>
					<tr>
						<td>Adresse e-mail :</td>
						<td>{{ $user -> email }}</td>
					</tr>
					<tr>
						<td>Année d'étude :</td>
						<td></td>
					</tr>
					<tr>
						<td>Département :</td>
						<td>{{ App\Department::where('id', $user -> department_id)->first()->name }}</td>
					</tr>					
				</tbody>
			</table>
		</div>	
	</div>
	<br/>
	<div class="description">
		<h2>Description :</h2>
		<p>
			{{ $user -> description}}
		</p>
	</div>
</div>


@endsection