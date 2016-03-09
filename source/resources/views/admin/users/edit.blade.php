@extends('layouts.app')

@section('title')
	Modification {{ $user -> first_name }} {{ $user -> last_name }}
@stop

@section('content')
<div class="jumbotron">
	<div class="profile">
		<h1 align="center">{{ $user -> first_name }} {{ $user -> last_name }}</h1>
		<div class="row">
			<div class="profil-pict">
				<p align="center" ><img src=" {{ URL::asset('/img/profil_pictures/'.$user -> profil_picture) }} " alt=" profile picture "/></p>
			</div>
			<div class="infos-profile">
				
				<form class="form-horizontal" role="form" method="post" action="{{ url('admin/users/edit/'.$user->slug) }}">
	            {!! csrf_field() !!}                       

		            <div class="form-group-sm">
		                <label class="col-md-4 control-label">Adresse e-mail</label>

		                <div class="col-md-6">
		                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" disabled>
		                </div>
		            </div>

		            <div class="form-group-sm">
		                <label class="col-md-4 control-label">Date de naissance</label>

		                <div class="col-md-6">
		                    <input type="date" class="form-control" name="birth_date" value="{{ $user->birth_date }}" disabled>
		                </div>
		            </div>

		            <div class="form-group-sm">
		                <label class="col-md-4 control-label" for="school_year">Année d'étude</label>

		                <div class="col-md-6">
		                    <select class="form-control" name="school_year">
		                        <option value="1">PeiP 1</option>
		                        <option value="2">PeiP 2</option>
		                        <option value="3">3ème année</option>
		                        <option value="4">4ème année</option>
		                        <option value="5">5ème année</option>
		                        <option value="0">Autre...</option>
		                    </select>
		                </div>
		            </div>

		            <div class="form-group-sm">
		                <label class="col-md-4 control-label" for="department_id">Département</label>

		                <div class="col-md-6">
		                    <select class="form-control"  name="department_id">
		                         @foreach (App\Department::all()  as $d)
			                        @if($user->department_id == $d->id)
			                            <option value="{{ $d['id'] }}" selected> {{ $d['name'] }} ({{$d['short_name']}})</option>
			                        @else
			                            <option value="{{ $d['id'] }}"> {{ $d['name'] }} ({{$d['short_name']}})</option>
			                        @endif
			                     @endforeach
		                    </select>
		                </div>
		            </div>

		            @if(Auth::user()->id == $user->id)
		            	<div class="form-group-sm">
		            		<label class="col-md-4 control-label" for="phone">Téléphone</label>
		            	</div>

		            	<div class="col-md-6">
		                    <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
		                </div>
					@endif
		        </form>
			</div>	
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
@stop