@extends('layouts.app')

@section('title')
	Modifier une annonce
@stop

@section('breadcrumb')
    <li> <a href="{{ url('announcements/list') }}">Annonces</a></li>
    <li class="active">{{ ucfirst($announcement->name) }} </li>
@stop


@section('content')

	

@stop