@extends('layouts.app')

@section('content')

	<button id="btn" class="btn btn-primary" onclick="test()">Test</button>
	<form id="form" method="post">
		{{ csrf_field() }}
		<input id="submit" data-id="1" type="button" value="Valider" role="button" class="btn btn-primary">
	</form> 

	<style type="text/css">
		#form{
			display:none;
		}
	</style>

@stop