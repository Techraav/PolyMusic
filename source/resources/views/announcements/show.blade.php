@extends('layouts.app')

@section('content')

	<h2>{{ $announcement->title }}</h2>
	<p>{{ $announcement->content}}</p>
	{{-- <p>Auteur : {{ App\User::where('id', $announcement->user_id)->first()->first_name) }}</p> --}}
	

@stop