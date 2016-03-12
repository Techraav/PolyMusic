@extends('layouts.app')

@section('content')

<div class="container">

	<form class="form-hozirontal" id="test" truc="ttt">
		<div class="form-group col-lg-8 col-lg-offset-2">
			{!! printFileInput('coucou', ['pdf', 'svg', 'png']) !!}
		</div>		
	</form>
</div>
@stop