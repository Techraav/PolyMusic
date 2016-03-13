@extends('layouts.app')

@section('content')

<div class="container">

	<form class="form-hozirontal" id="test" truc="ttt">
		<div class="form-group col-lg-8 col-lg-offset-2">
			{!! printFileInput('coucou', ['jpg', 'png'], ['image/jpeg', 'image/png'], 'Extensions acceptées : jpg, png, pdf.') !!}
		</div>		
	</form>
</div>
@stop