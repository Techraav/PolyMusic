@extends('layouts.admin')

@section('title')
	Modifier un document
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li> <a href="{{ url('admin/documents') }}">Documents</a></li>
    <li class="active">Modifier un document</li>
@stop


@section('content')

	<div class="jumbotron">
		<h1>Modifier un document</h1>
		<form class="form form-horizontal" method="post" action="{{ url('admin/documents/update') }}">
		{{ csrf_field() }}
		<input hidden name="id" value="{{ $document->id }}"/>

			<div class="form-group">	
				<label class="label-control">Cours :</label>
				<input disabled class="form-control" value="{{ ucfirst($document->course->name) }}" />
			</div>

			<div class="form-group">	
				<label class="label-control">Auteur :</label>
				<input class="form-control" disabled value="{{ $document->author->first_name.' '.$document->author->last_name }}" />
			</div>

			<div class="form-group">	
				<label class="label-control">Titre :</label>
				<input class="form-control" name="title" value="{{ $document->title }}" />
			</div>

			<div class="form-group">	
				<label class="label-control">Description :</label>
				<textarea class="form-control" id="description" name="description" value="{{ $document->description }}" >{{ $document->description }}</textarea>
			</div>

			<div align="center"class="row">
				<button type="reset" class="btn btn-default">Annuler</button> <button  type="submit" class="btn btn-primary">Valider</button>
			</div>		
		</form>
	</div>

@stop

@section('js')

    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
	<script type="text/javascript">
		CKEDITOR.replace( 'description' );
	</script>
@stop