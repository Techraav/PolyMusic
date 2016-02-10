@extends('layouts.admin')

@section('content')
	
	<h1 align="center">{{ ucfirst($department->name) }}</h1>
	<h3 align="center">{{ $department->short_name }}</h3>
	<br />
	<ul class="list-group list-members list-hover col-md-4 col-md-offset-4">
		
		<h4 align="center" ><b>Membres :</b></h4>

		@forelse($users as $u)
		<li class="list-group-item">
			<a href=" {{ url('admin/users/'.$u->slug) }}">{{ ucfirst($u->last_name) }} {{ ucfirst($u->first_name) }}</a>
			@if($department->id != 1)
			<form method="post" action="{{ url('admin/departments/'.$department->id.'/members/remove') }}">
			{{ csrf_field() }}
				<input hidden name="department" value="{{ $department->id }}" />
				<input hidden name="user_id" value="{{ $u->id }}" />
				<button align="right" title="Retirer ce membre du {{ $department->short_name }} ?" type="submit" class="glyphicon glyphicon-trash"></button>
			</form>
			@endif
		</li>
			@empty
			<li align="center" class="list-group-item"> - </li>
			@endforelse
	</ul>

@stop