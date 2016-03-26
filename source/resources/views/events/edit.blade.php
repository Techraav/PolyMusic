@extends('layouts.app')

@section('title')
	Modifier un événement
@stop

@section('breadcrumb')
    <li> <a href="{{ url('events/list') }}">Événements</a></li>
    <li class="active">{{ ucfirst($event->name) }} </li>
@stop


@section('content')

	<div class="jumbotron jumbotron-form">
		<h1 align="center">Modification d'un événement</h1>
		<form method="post" action="{{ url('events/edit/'.$event->id) }}">
		{{ csrf_field() }}
			<input hidden name="id" id="id" value="{{ $event->id }}" />

			<div class="form-group">
				<label class="label-control">Nom :</label>
				<input type="text" class="form-control" name="name" required value="{{ $event->name }}"/>
			</div>

			<div class="form-group">
				<label class="label-control">Location :</label>
				<input type="text" class="form-control" name="location" required value="{{ $event->location }}"/>
			</div>

			<div class="form-group">
				<label class="label-control">Date :</label>
				<input type="date" class="form-control" name="date" required value="{{ $event->date }}"/>
			</div>

			<div class="form-group">
				<label class="label-control">Heure de début :</label>
				<input type="time" class="form-control" name="start" required value="{{ $event->start }}"/>
			</div>

			<div class="form-group">
				<label class="label-control">Heure de fin :</label>
				<input type="time" class="form-control" name="end" required value="{{ $event->end }}"/>
			</div>

			<div class="form-group">
				<label class="label-control">Informations complémentaires : </label> <span class="help-block inline"><i>(facultatif)</i></span>
				<textarea class="form-control" name="infos">{{ $event->infos }}</textarea>
			</div>
			<br />
			<div align="center" class="form-group row buttons">
				<button class="btn btn-default" type="reset">Réinitialiser</button>
				<button class="btn btn-primary" type="submit">Valider</button>
			</div>
		</form>	
	</div>

@stop

@section('js')

    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
	<script type="text/javascript">
		CKEDITOR.replace( 'infos' );
	</script>

@stop