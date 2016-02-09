@extends('layouts.admin')

@section('content')
	
	<h1 align="center">{{ ucfirst($name).'s' }}</h1>
	<h3 align="center">Level : {{ $level }}</h3>
	<br />
	<ul class="list-group list-members list-hover col-md-4 col-md-offset-4">
		
		<h4 align="center" ><b>Membres :</b></h4>

		@forelse($users as $u)
		<li class="list-group-item">
			<a href=" {{ url('admin/users/'.$u->slug) }}">{{ $u->last_name }} {{ $u->first_name }}</a>
			@if($level > 0)
			<form method="post" action="{{ url('admin/levels/'.$name.'/members/remove') }}">
			{{ csrf_field() }}
				<input hidden name="level" value="{{ $level }}" />
				<input hidden name="user_id" value="{{ $u->id }}" />
				<button align="right" title="Retirer ce membre des {{ $name.'s ?' }}" type="submit" class="glyphicon glyphicon-trash"></button>
			</form>
			@endif
		</li>
			@empty
			<li align="center" class="list-group-item"> - </li>
			@endforelse
	</ul>

@stop