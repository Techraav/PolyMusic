@extends('layouts.app')

@section('content')

@section('title')
	Test
@stop

@section('breadcrumb')
    <li class="active">Test</li>
@stop


<div class="container">

		<div class="form-group col-lg-5 col-lg-offset-2">
			{!! printFileInput('profil_picture', ['png','jpeg','jpg'], false, ['accept' => 'image/png, image/jpeg'], 'Formats acceptés: PNG et JPEG', [], true) !!}
		</div>	
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<div class="form-group col-lg-8 col-lg-offset-2">
			<input type="file" />
		</div>		
</div>



@stop



