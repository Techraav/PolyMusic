@extends('layouts.admin')

@section('title')
	Membres du département
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li> <a href="{{ url('admin/departments') }}">Départements</a></li>
    <li class="active">{{ ucfirst($department->name) }}</li>
@stop


@section('content')
	
	<h1 align="center">{{ ucfirst($department->name) }}</h1>
	<h3 align="center">{{ $department->short_name }}</h3>
	<br />
	<div class="col-md-4 col-md-offset-4">
		<ul class="list-group list-members list-hover">
			
			<h4 align="center" ><b>Membres :</b></h4>

			@forelse($users as $u)
			<li class="list-group-item">
				<a href=" {{ url('users/'.$u->slug) }}">{{ ucfirst($u->last_name) }} {{ ucfirst($u->first_name) }}</a>
				@if($department->id != 1)
					<button onclick="modalDelete(this)"
							align="right" 
							id="{{ $u->id }}"
							link="{{ url('admin/departments/'.$department->id.'/members/remove') }}"
							title="Retirer ce membre du {{ $department->short_name }} ?" 
							class="glyphicon glyphicon-trash">
					</button>
				@endif
			</li>
				@empty
				<li align="center" class="list-group-item"> - </li>
				@endforelse
		</ul>
				<div align="right"> {!! $users->render() !!} </div>

	</div>

				<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Retirer un membre du {{$department->short_name}}</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
			        	<p class="text-warning"><b>Il sera attribué au département {{ ucfirst(App\Department::find(1)->name) }}</b></p>
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