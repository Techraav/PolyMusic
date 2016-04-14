@extends('layouts.admin')

@section('title')
	Membres du cours
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li> <a href="{{ url('admin/courses') }}">Cours</a></li>
    <li> <a href="{{ url('courses/show/'.$course->slug) }}">{{ucfirst($course->name)}}</a></li>
    <li class="active">Membres</li>
@stop

@section('content')
	
	<h1 align="center">{!! printLink('courses/show/'.$course->slug, ucfirst($course->name)) !!}</h1>
	<h4 class="help-block" align="center">{!! printLink('admin/courses/'.$course->id.'/documents', 'Gérer les documents') !!}</h4>
	<span class="help-block" align="center">Responsable : {!! printUserLinkV2($course->manager) !!} </span>
	<span class="help-block" align="center">Instrument principal : {{ ucfirst(App\Instrument::where('id', $course->instrument_id)->first()->name) }}</span>
	<span class="help-block" align="center">Élève(s) : {{ $course->users->count() }}</span>
	<span class="help-block" align="center">Professeur(s) : {{ $course->teachers->count() }} </span>
	<span class="help-block" align="center">
		@if($course->waitingTeachers->count()+$course->waitingStudents->count() > 0) <b> @endif
			Demande(s) en attente : {{ $course->waitingTeachers->count()+$course->waitingStudents->count() }} 
		@if($course->waitingTeachers->count() + $course->waitingStudents->count() > 0) </b> @endif
	</span>

	@if($course->waitingTeachers->count() + $course->waitingStudents->count() > 0)
	<table class=" table table-hover table-striped">
		<thead>
			<tr>
				<td width="100" align="center"><b>Objet </b></td>
				<td width="100" align="center"><b>Date </b></td>
				<td width="300" align="center"><b>Utilisateur</b></td>
				<td align="center"><b>Message </b></td>
				<td width="150" align="center"><b>Gérer </b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($course->waitingStudents as $w)
				<tr>
					<td align="center"><p class="text-danger"><b>Élève</b></p></td>
					<td align="center">{{ date_format($w->created_at, 'd/m/Y') }}</td>
					<td align="center">{!! printUserLinkV2($w->user) !!}</td>
					<td align="center"><i>{{ $w->message }}</i></td>
					<td align="center">
						<div class="controls">
						@if($course->user_id == Auth::user()->id || Auth::user()->level_id > 3)
							<form method="post" action="{{ url('admin/courses/'.$course->id.'/student/accept') }} ">
							{{ csrf_field() }}
								<input hidden name="user_id" value="{{ $w->user->id }}" />
								<button align="left" title="Accepter la demande ?" type="submit" class="glyphicon glyphicon-ok"></button>
							</form>
							<button 
									data-id="{{$w->user->id}}" 
									align="right" 
									data-link="{{ url('admin/courses/'.$course->id.'/student/cancel') }}"
									title="Refuser la demande ?" 
									class="{{ glyph('remove') }} delete-button">
							</button>
						@else
							-
						@endif
						</div>



					</td>
				</tr>
			@empty
				<tr>
					<td align="center">Élève</td>
					<td align="center">-</td>
					<td align="center">-</td>
					<td align="center">-</td>
					<td align="center">-</td>
				</tr>
			@endforelse
			@forelse($course->waitingTeachers as $w)
				<tr>
					<td align="center"><p class="text-danger"><b>Professeur</b></p></td>
					<td align="center">{{ date_format($w->created_at, 'd/m/Y') }}</td>
					<td align="center">{!! printUserLinkV2($w->user) !!}</td>
					<td align="center"><i>{{ $w->message }}</i></td>
					<td align="center">
						<div class="controls">
						@if($course->user_id == Auth::user()->id || Auth::user()->level->level > 2)
							<form method="post" action="{{ url('admin/courses/'.$course->id.'/teacher/accept') }} ">
							{{ csrf_field() }}
								<input hidden name="user_id" value="{{ $w->user->id }}" />
								<button align="left" title="Accepter la demande ?" type="submit" class="glyphicon glyphicon-ok"></button>
							</form>
							<button
									data-id="{{$w->user->id}}" 
									align="right" 
									data-link="{{ url('admin/courses/'.$course->id.'/teacher/cancel') }}"
									title="Refuser la demande ?" 
									class="{{ glyph('remove') }} delete-button">
							</button>
						@else
						-
						@endif
						</div>
					</td>			
				</tr>
			@empty
				<tr>
					<td align="center">Professeur</td>
					<td align="center">-</td>
					<td align="center">-</td>
					<td align="center">-</td>
					<td align="center">-</td>
				</tr>
			@endforelse
		@endif
		</tbody>
	</table>

	<br />
	<div class="col-md-4 col-md-offset-4">
		<ul class="list-group list-members list-hover">
			
			<h4 align="center" ><b>Professeurs :</b></h4>
			@forelse($course->teachers as $t)
			<li class="list-group-item">
				{!! printUserLinkV2($t) !!}
				@if($course->user_id == Auth::user()->id || Auth::user()->level_id > 3)
					<button
							align="right" 
							data-id="{{ $t->id }}"
							data-link="{{ url('admin/courses/'.$course->id.'/teacher/remove') }}"
							title="Retirer ce professeur du cours {{ '"'.$course->name.'"' }} ?" 
							class="{{ glyph('remove') }} delete-button">
					</button>
				@endif
			</li>
				@empty
				<li align="center" class="list-group-item"> - </li>
				@endforelse
		</ul>

		<br />

		<ul class="list-group list-members list-hover">
			
			<h4 align="center" ><b>Élèves :</b></h4>

			@forelse($course->users as $t)
			<li class="list-group-item">
				{!! printUserLinkV2($t) !!}
				@if($course->user_id == Auth::user()->id || Auth::user()->level_id > 3)
					<button
							align="right" 
							data-id="{{ $t->id }}"
							data-link="{{ url('admin/courses/'.$course->id.'/student/remove') }}"
							title="Retirer cet élève du cours {{ '"'.$course->name.'"' }} ?" 
							class="{{ glyph('remove') }} delete-button">
					</button>
				@endif
			</li>
				@empty
				<li align="center" class="list-group-item"> - </li>
				@endforelse
		</ul>
	</div>

			<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer un membre</h4>
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

@stop