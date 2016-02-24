@extends('layouts.admin')

@section('title')
	Instruments
@stop

@section('content')

	@include('admin.instruments.infos')

	@include('admin.instruments.table')

@stop
