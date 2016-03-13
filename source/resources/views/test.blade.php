@extends('layouts.app')

@section('content')

<div class="container">

	<form class="form-hozirontal" id="test" truc="ttt">
	{{ csrf_field() }}
		<div class="form-group col-lg-8 col-lg-offset-2">
			{!! printFileInput('coucou', ['jpg', 'png'], ['image/jpeg', 'image/png'], 'Extensions acceptées : jpg, png, pdf.') !!}
		</div>		
	</form> 

	<!-- AFFICHE : -->

	<div class="row"></div>
	<form id="truc" method="post">
		<div class="form-control file-control">
			<button onclick="clickFile()" type="button" class="btn-file glyphicon glyphicon-folder-open">
				<input onchange="fileInput(this)" data-extension="['jpg', 'png']" accept="image/jpeg, image/png" class="input-file-hidden" type="file" id="file" name="coucou" />
			</button>
			<input type="checkbox" name="check" id="file-check" hidden />
			<span id="file-name"></span>
			<button type="button" id="exit" class="exit" data-dismiss="alert" aria-hidden="true">×</button>
		</div>

		<button type="submit">Valider</button>
	</form>
</div>
@stop