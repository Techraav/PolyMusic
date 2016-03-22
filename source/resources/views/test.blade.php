@extends('layouts.app')

@section('content')

<div class="container">

	{!! Form::open(['files' => true]) !!}
<!-- 	<div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
 -->		<div class="form-group col-lg-8 col-lg-offset-2">

			{!! Form::submit() !!}

			{!! printFileInput('test', ['png','jpeg','jpg'], false, ['accept' => 'image/png, image/jpeg'], 'Seules les images au format PNG et JPEG sont acceptées.', []) !!}
		</div>		
	{!! Form::close() !!} 
</div>
@stop