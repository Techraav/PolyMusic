@extends('layouts.admin')

@section('title')
	Modifier un instrument
@stop

@section('content')

	@include('admin.instruments.infos')


	<h2 align="center">Modifier l'instruments</h2>
	<div class="col-md-10 col-md-offset-2">
		<form method="post" action="{{ url('admin/instruments/edit/'.$instruToEdit->id) }}">
			<table class="table">
			<tbody>
				<th>
				{{ csrf_field() }}
					<td><input required class="form-control" type="text" name="name" id="name" placeholder="Nom" value="{{ $instruToEdit->name }}"/></td>
					<td><button type="reset" class="btn btn-default">Annuler</button> <button type="submit" class="btn btn-primary">Valider</button></td>
				</th>
			</tbody>
			</table>
		</form>
	<br />
	</div>


	@include('admin.instruments.table')



@stop