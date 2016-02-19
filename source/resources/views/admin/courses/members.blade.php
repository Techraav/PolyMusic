@extends('layouts.admin')

@section('content')
	
	<h1 align="center">{{ ucfirst($course->name) }}</h1>
	<span class="help-block" align="center">Responsable : {!! printUserLink($course->user_id) !!} </span>
	<span class="help-block" align="center">Instrument principal : {{ ucfirst(App\Instrument::where('id', $course->instrument_id)->first()->name) }}</span>
	<span class="help-block" align="center">Élève(s) : {{ $students->count() }}</span>
	<span class="help-block" align="center">Professeur(s) : {{ $teachers->count() }} </span>
	<span class="help-block" align="center">
		@if($waitingTeachers->count()+$waitingStudents->count() > 0) <b> @endif
			Demande(s) en attente : {{ $waitingTeachers->count()+$waitingStudents->count() }} 
		@if($waitingTeachers->count()+$waitingStudents->count() > 0) </b> @endif
	</span>

	@if($waitingTeachers->count()+$waitingStudents->count() > 0)
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
		@forelse($waitingStudents as $w)
			<tr>
				<td align="center">Élève</td>
				<td align="center">{{ date_format($w->created_at, 'd/m/Y') }}</td>
				<td align="center">{!! printUserLink($w->user_id) !!}</td>
				<td align="center"><i>{{ $w->message }}</i></td>
				<td align="center">
					<div class="controls">
					@if($course->user_id == Auth::user()->id || Auth::user()->level > 2)
						<form method="post" action="{{ url('admin/courses/'.$course->id.'/student/accept') }} ">
						{{ csrf_field() }}
							<input hidden name="user_id" value="{{ $w->user_id }}" />
							<button align="left" title="Accepter la demande ?" type="submit" class="glyphicon glyphicon-ok"></button>
						</form>
						<form method="post" action="{{ url('admin/courses/'.$course->id.'/student/remove') }}">
						{{ csrf_field() }}
							<input hidden name="user_id" value="{{ $w->user_id }}" />
							<button align="right" title="Refuser la demande ?" type="submit" class="glyphicon glyphicon-remove"></button>
						</form>
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

		@forelse($waitingTeachers as $w)
			<tr>
				<td align="center">Professeur</td>
				<td align="center">{{ date_format($w->created_at, 'd/m/Y') }}</td>
				<td align="center">{!! printUserLink($w->user_id) !!}</td>
				<td align="center"><i>{{ $w->message }}</i></td>
				<td align="center">
					<div class="controls">
					@if($course->user_id == Auth::user()->id || Auth::user()->level > 2)
						<form method="post" action="{{ url('admin/courses/'.$course->id.'/teacher/accept') }} ">
						{{ csrf_field() }}
							<input hidden name="user_id" value="{{ $w->user_id }}" />
							<button align="left" title="Accepter la demande ?" type="submit" class="glyphicon glyphicon-ok"></button>
						</form>

						<form method="post" action="{{ url('admin/courses/'.$course->id.'/teacher/remove') }}">
						{{ csrf_field() }}
							<input hidden name="user_id" value="{{ $w->user_id }}" />
							<button align="right" title="Refuser la demande ?" type="submit" class="glyphicon glyphicon-remove"></button>
						</form>
					@else
					-
					@endif
					</div>
				</td>			
			</tr>
		@empty
			<tr>
				<td align="center">Professeurs</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
			</tr>
		@endforelse
		</tbody>
	</table>
	@endif

	<br />
	<div class="col-md-4 col-md-offset-4">
		<ul class="list-group list-members list-hover">
			
			<h4 align="center" ><b>Professeurs :</b></h4>

			@forelse($teachers as $t)
			<li class="list-group-item">
				{!! printUserLink($t->user_id) !!}
				@if($course->user_id == Auth::user()->id || Auth::user()->level > 2)
				<form method="post" action="{{ url('admin/courses/'.$course->id.'/teacher/remove') }}">
				{{ csrf_field() }}
					<input hidden name="course" value="{{ $course->id }}" />
					<input hidden name="user_id" value="{{ $t->user_id }}" />
					<button align="right" title="Retirer ce professeur du cours {{ '"'.$course->name.'"' }} ?" type="submit" class="glyphicon glyphicon-trash"></button>
				</form>
				@endif
			</li>
				@empty
				<li align="center" class="list-group-item"> - </li>
				@endforelse
		</ul>

		<br />

		<ul class="list-group list-members list-hover">
			
			<h4 align="center" ><b>Élèves :</b></h4>

			@forelse($students as $t)
			<li class="list-group-item">
				{!! printUserLink($t->user_id) !!}
				@if($course->user_id == Auth::user()->id || Auth::user()->level > 2)
				<form method="post" action="{{ url('admin/courses/'.$course->id.'/student/remove') }}">
				{{ csrf_field() }}
					<input hidden name="course" value="{{ $course->id }}" />
					<input hidden name="user_id" value="{{ $t->user_id }}" />
					<button align="right" title="Retirer cet élève du cours {{ '"'.$course->name.'"' }} ?" type="submit" class="glyphicon glyphicon-trash"></button>
				</form>
				@endif
			</li>
				@empty
				<li align="center" class="list-group-item"> - </li>
				@endforelse
		</ul>
				<div align="right"> {!! $students->render() !!} </div>

	</div>

@stop