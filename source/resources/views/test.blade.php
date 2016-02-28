@extends('layouts.app')

@section('content')

<div class="container">

	<form method="POST" action="{{ url('test') }}">
	{{ csrf_field() }}
		<input  type="text" name="truc"/>
		<input type="submit" />
	</form>
	
	<button id="test">Test</button>

  
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


$('#test').on('click', function()
{
	$('form').submit();
});

var valide = false;
  
$('form').submit(function (e) {
	if (!valide) {
    e.preventDefault();
    
    bootbox.confirm("Are you sure?", (function (window) {
      return function (result) {
        if (result) {
          window.valide = true;
          $('form').submit();
        }
    	}
    })(window));
  }
});

</script>

@stop
