@extends('layouts.app')

@section('content')
	<h1 align="center">Modifiez votre commentaire :</h1>
	<br />
	<form method="post">
		{{ csrf_field() }}

		<div class="form-group">
			<textarea name="content" rows="10" class="form-control">{{ $comment->content }}</textarea>
		</div>

		<div class="form-group">
			<input type="submit" role="button" value="Valider" class="btn btn-primary btn-submit"/>
		</div>
	</form>
@stop

@section('js')

    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'content' );
    </script>

@stop