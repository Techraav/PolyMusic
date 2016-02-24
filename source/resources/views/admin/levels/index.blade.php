@extends('layouts.admin')

@section('title')
	Niveaux
@stop

@section('content')

	@include('admin.levels.infos')
	
	@include('admin.levels.table')

@stop