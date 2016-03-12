@extends('layouts.app')

@section('content')

<div class="container">

	<form class="form-hozirontal" id="test" truc="ttt">
		<div class="form-group">
			<button onclick="clickFile()" type="button" class="filename form-control">
				<span type="button" class="btn-file btn glyphicon glyphicon-folder-open">
					<input onchange="fileInput(this)" data-extension="pdf" class="input-file-hidden" type="file" />
				</span> 
				<span id="name"></span>
			</button>
		</div>		
	</form>
</div>
@stop