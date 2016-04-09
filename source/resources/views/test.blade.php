@extends('layouts.app')

@section('content')

@section('title')
	Test
@stop

@section('breadcrumb')
    <li class="active">Test</li>
@stop


<div class="container">

		<div class="form-group col-lg-8 col-lg-offset-2">
	{!! printFileInput('profil_picture', ['png','jpeg','jpg'], false, ['accept' => 'image/png, image/jpeg'], 'Formats acceptés: PNG et JPEG', [], true) !!}
		</div>		
</div>



@stop

@section('headerjs')
<script type="text/javascript">
	$("#input-id").fileinput();
	$.fn.fileinput.defaults.showUpload = false;
</script>
@stop



