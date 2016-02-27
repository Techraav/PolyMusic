@extends('layouts.app')

@section('content')

<div class="container">

	<form method="post" action="#">
		<input  type="text" name="truc"/>
		<button type="submit"> Valider </button>
	</form>
  
</div>
@stop

@section('js')

<script type="text/javascript">

// $('form').submit(function(e){
// 	e.preventDefault();
// 	bootbox.confirm("Are you sure?", function(result) {
// 	  if(result)
// 	  	$('form').submit();
// 	});
// });


$('button').click(function (e){

	e.preventDefault();
	bootbox.confirm("Are you sure?", function (result) {
		if(result)
			$('form').submit();		
  });
});

</script>

@stop
