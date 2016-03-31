@extends('layouts.app')

@section('title')
	{{ $user->first_name }} {{ $user->last_name }}
@stop

@section('breadcrumb')
    <li> <a href="{{ url('users') }}">Utilisateurs</a></li>
    <li class="active">{{ $user->first_name }} {{ $user->last_name }}</li>
@stop


@section('content')
<div class="jumbotron">
	<div class="profile">
		<h1 align="center">{{ $user->first_name}} {{ $user->last_name }}</h1>
		<br/>

		@if($user->id == Auth::user()->id || Auth::user()->level->level > 3)
			<div class="manage-user">
				<a href="{{ url('users/edit/'.$user->slug) }}" class="btn-edit glyphicon glyphicon-pencil"></a>
			</div>					
		@endif

		<div class="row col-md-5">
			<div class="profil-pict">
				<img src=" {{ URL::asset('/img/profil_pictures/'.$user->profil_picture) }} " title="profile picture"/>
			</div>
		</div>

		<div class="row col-md-7 infos-profile">
			<table>
				<tbody>
					<tr>
						<td>Adresse e-mail :</td>
						<td>{{ $user -> email }}</td>
					</tr>
					<tr>
						<td width="250">Date de naissance :</td>
						<td>{{ showDate($user -> birth_date, 'Y-m-j', 'j/m/Y') }}</td>
					</tr>						
					<tr>
						<td>Année d'étude :</td>
						<td>{{ $user->school_year == 0 ? 'Autre' : ($user->school_year == 1 || $user->school_year == 2 ? 'PeiP '.$user->school_year : $user->school_year.'ème année')}}</td>
					</tr>
					<tr>
						<td>Département :</td>
						<td>{{ App\Department::where('id', $user -> department_id)->first()->name }}</td>
					</tr>
					@if(Auth::user()->id == $user->id)
						<tr>
							<td>Téléphone :</td>
							<td>{{ $user->phone }}</td>
						</tr>
					@endif				
				</tbody>
			</table>
		</div>

		<div class="row col-md-12">
			<h2>Description :</h2>
			<p>
				{!! $user -> description !!}
			</p>		
		</div>
	</div>
</div>


@endsection