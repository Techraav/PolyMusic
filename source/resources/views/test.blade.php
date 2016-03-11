@extends('layouts.app')

@section('content')

<div class="container">

	<form class="form-hozirontal" id="test" truc="ttt">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-btn">
					<button type="button" onclick="func2()" class="btn-file btn glyphicon glyphicon-folder-open">
						<input onchange="func(this)" class="input-file-hidden" type="file" />
					</button> 
				</span>
				<input type="text" class="filename form-control"/>
			</div>
		</div>		
	</form>



</div>
@stop

@section('js')

<script type="text/javascript">
	function func(el)
	{
		var form = $(el).parents('form')[0].getAttribute('id');
		var filename = $(el).val().replace(/C:\\fakepath\\/i, '');
		$('#'+form+' .filename').attr('value','Fichier : '+filename);
	}

	function func2()
	{
		$('input')[0].click();
	}
</script>

@stop