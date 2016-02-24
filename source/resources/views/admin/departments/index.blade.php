@extends('layouts.admin')

@section('title')
	Départements
@stop

@section('content')

	@include('admin.departments.infos')

	@include('admin.departments.table')

@stop