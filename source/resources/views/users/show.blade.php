@extends('layouts.app')

@section('title')
	{{ $user->first_name }} {{ $user->last_name }}
@stop

@section('breadcrumb')
    <li class="active">{{ $user->first_name }} {{ $user->last_name }}</li>
@stop


@section('content')
<div class="jumbotron">
	<div class="profile">
		<div class="row">
			<h1 align="center">{{ $user->first_name}} {{ $user->last_name }}</h1>
			<br/>

			@if($user->banned == 1)
				<span class="text-danger user-banned">Cet utilisateur a été banni.</span>
			@endif

			@if(Auth::check() && ($user->id == Auth::user()->id || Auth::user()->level_id > 3))
				<div class="manage-user manage">
					@if($user->banned == 0)
						<button 
								id="bannish"
								title="Bannir {{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}" 
								class="{{ glyph('ban-circle') }} ban-control">
						</button>
					@else
						<button 
								id="unbannish"
								title="Débannir {{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}" 
								class="{{ glyph('ok-circle') }} ban-control">
						</button>

					@endif
					<a title="{{ $user->id != Auth::user()->id ? 'Modifier ce profil' : 'Modifier votre profil' }}" href="{{ url('users/edit/'.$user->slug) }}" class="btn-edit glyphicon glyphicon-pencil"></a>
				</div>					
			@endif

			<div class="col-lg-3 col-lg-offset-1">
				<div class="profil-pict">
					<img onclick="modalPicture(this)" src=" {{ URL::asset('/img/profil_pictures/'.$user->profil_picture) }} " title="Cliquez pour voir l'image en grand"/>
					@if(Auth::check() && ($user->id == Auth::user()->id && $user->profil_picture != App\User::$defaultImage))
						<button title="Supprimer la photo de profile" class="glyphicon glyphicon-trash profil-pict-remove delete-button" type="button" data-id="{{ $user->id }}" data-link="{{url("users/image/remove")}}"></button>

					@endif
				</div>
			</div>

			<div class="col-lg-7 infos-profile">
				<table>
					<tbody>
						<tr>
							<td width="250">Date de naissance :</td>
							<td>{{ $user->birth_date->format('d/m/Y') }}</td>
						</tr>						
						<tr>
							<td>Année d'étude :</td>
							<td>{!! $user->school_year == 0 ? 'Non renseigné' : ($user->school_year == 1 || $user->school_year == 2 ? 'PeiP '.$user->school_year : $user->school_year.'<sup>ème</sup> année')!!}</td>
						</tr>
						<tr>
							<td>Département :</td>
							<td>{{ $user->department_id == 1 || $user->department_id == 2 ? 'Non renseigné' : ucfirst($user->department->name).' ('.$user->department->short_name.')' }}</td>
						</tr>
						@if(Auth::check() && Auth::user()->level_id > 2)
							<tr>
								<td>Téléphone :</td>
								<td>{{ $user->phone == '' ? 'Non renseigné' : $user->phone}}</td>
							</tr>
						@endif

						@if(Auth::check())
						<tr>
							<td>Adresse e-mail :</td>
							<td>{{ $user->email }}</td>
						</tr>
						@endif

						@if($user->level_id > 2)
						<tr>
							<td>Statut :</td>
							<td>{{ ucfirst($user->level->name) }}</td>
						</tr>
						@endif

						<tr>
							<td>Membre depuis le :</td>
							<td>{{ $user->created_at->format('d/m/Y') }}</td>
						</tr>

					</tbody>
				</table>
			</div>
			<br />
		</div>
		
		<div class="row">
		<br />
			<div class="col-lg-10 col-lg-offset-1">
			<h3 align="left">Cours suivis et enseignés : </h3>
				<div class="courses-table">
					<div class="table table-hidden" id="table">
						<table class="courses">
							<thead>
								<tr>
									<td align="center">Cours suivis</td>
									<td align="center">Cours enseignés</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="center">
										@forelse($user->coursesStudent as $c)
											{!! printLink('courses/show/'.$c->slug, ucfirst($c->name)) !!} <br />
										@empty
										-
										@endforelse
									</td>
									<td align="center">
										@forelse($user->coursesteacher as $c)
											{!! printLink('courses/show/'.$c->slug, ucfirst($c->name)) !!} <br />
										@empty
										-
										@endforelse	
									</td>
								</tr>
							</tbody>
						</table>
					</div>


					<div align="center" class="open-tab" id="open-tab" title="Voir les cours auxquels {{ucfirst($user->first_name)}} est inscrit.">
	<!-- 					<p align="center">Voir les cours auxquels {{ucfirst($user->first_name)}} est inscrit.</p>
	 -->					<span class="{{ glyph('menu-down')}}"></span>
					</div>
					<div align="center" class="close-tab table-hidden" id="close-tab" title="Masquer les cours auxquels {{ucfirst($user->first_name)}} est inscrit.">
	<!-- 					<p align="center">Masquer les cours auxquels {{ucfirst($user->first_name)}} est inscrit.</p>
	 -->					<span class="{{ glyph('menu-up')}}"></span>
					</div>
				</div>	
			</div>		
		</div>

		<div class="row">
			<br />
			<div class="col-lg-10 col-lg-offset-1">
				<h3>Description :</h3>
				<span class="description">
					{!! $user->description == '' ? "<p>Aucune description pour le moment.</p>" : $user->description !!}
				</span>		
			</div>	
		</div>

		@if(Auth::check())
			@if(Auth::user()->id != $user->id)
				@if(Auth::user()->level_id == 5 || (Auth::user()->level_id == 4 && $user->level_id < 4 ))

				<hr class="colorgraph" />
				<div class="row">
					<h3 align="center">Modifier le level de cet utilisateur :</h3>
					<form method="post" action=" {{ url('users/updatelevel') }} ">
					{!! csrf_field() !!}
						<div class="col-lg-4 col-lg-offset-3">
							<input hidden name="id" value="{{ $user->id }}" />

							<select class="form-control" name="level">
								@foreach(App\Level::where('id', '!=', '2')->orderBy('id', 'asc')->get() as $level)
									<option value="{{ $level->id }}" {{ $level->id == $user->level_id ? 'selected' : '' }}>{{ ucfirst($level->name) }}</option>
								@endforeach
							</select>
						</div>

						<div class="buttons col-lg-3">
							<button type="submit" class="btn btn-primary">Valider</button>
						</div>	

					</form>
				</div>

				@endif 
			@endif
		@endif


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

	<div class="modal fade" id="modalPicture" role="dialog">
		<div class="modal-picture">
	        <div class="modal-body">
	        	<img id="picture" src="">
    			<p id="description"></p>
	        </div>
		</div>
	</div>


	<div class="modal fade" id="modalBannish" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Bannir {{ ucfirst($user->first_name).' '.ucfirst($user->last_name) }}</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="{{ url('admin/users/bannish') }}">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-danger"><b>Cet utilisateur ne pourra plus se connecter à son compte.</b></p>
			         	<input hidden value="{{ $user->id }}" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" class="btn btn-primary">Bannir</button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>


	<div class="modal fade" id="modalUnbannish" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Débannir {{ ucfirst($user->first_name).' '.ucfirst($user->last_name) }}</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="{{ url('admin/users/unbannish') }}">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-warning"><b>Cet utilisateur pourra de nouveau se connecter à son compte.</b></p>
			         	<input hidden value="{{ $user->id }}" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" class="btn btn-primary">Débannir</button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>


@endsection