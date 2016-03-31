@extends('layouts.admin')

@section('title')
	{{ ucfirst($name).'s' }}
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li> <a href="{{ url('admin/levels') }}">Levels</a></li>
    <li class="active">Membres</li>
@stop

@section('content')
	
	<h1 align="center">{{ ucfirst($name).'s' }}</h1>
	<h3 align="center">Level : {{ $level->level }}</h3>
	<br />
	<div class="col-md-4 col-md-offset-4">
		<ul class="list-group list-members list-hover">
			
			<h4 align="center" ><b>Membres :</b></h4>

			@forelse($users as $u)
			<li class="list-group-item">
				<a href=" {{ url('admin/users/'.$u->slug) }}">{{ ucfirst($u->last_name) }} {{ ucfirst($u->first_name) }}</a>
				@if($level->id > 1)
					<button onclick="modalDelete(this)"
							align="right" 
							id="{{ $u->id }}"
							link="{{ url('admin/levels/'.$level->id.'/members/remove') }}"
							title="Retirer ce membre des {{ $level->name }}s ?" 
							class="glyphicon glyphicon-trash">
					</button>
				@endif
			</li>
			@empty
				<li align="center" class="list-group-item"> - </li>
			@endforelse
		</ul>

		<div align="center">{!! $users->render()!!}</div>
</div>

	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Retirer un membre des {{ $level->name }}</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
			        	<p class="text-warning"><b>Il sera rétrogradé au level {{ App\Level::find(1)->name }}. Vous pouvez aller sur son profil pour lui attribuer un nouveau level.</b></p>
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

@stop