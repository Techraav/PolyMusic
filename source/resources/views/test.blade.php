@extends('layouts.app')

@section('content')

@section('title')
	Test
@stop

@section('breadcrumb')
    <li class="active">Test</li>
@stop


<div class="container">

	{!! Form::open(['files' => true]) !!}
		<div class="form-group col-lg-8 col-lg-offset-2">
			<input name="test" />
			{!! Form::submit() !!}
		</div>		
	{!! Form::close() !!} 
</div>
@stop

