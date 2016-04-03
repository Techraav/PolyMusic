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
	<div class="row">
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
					@if(($user->id == Auth::user()->id || Auth::user()->level->level > 3) && $user->profil_picture != "base_profil_picture.png")
						<button class="glyphicon glyphicon-trash profil-pict-remove" type="button" onclick="modalDelete(this)" id="{{ $user->id }}" link="{{url("users/image/remove")}}"></button>
					@endif
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
</div>

<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer votre photo de profil</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-danger"><b>Attention ! Cette action est irréversible !</b></p>
			         	<input hidden value="" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" class="btn btn-primary">Supprimer</button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>


@endsection