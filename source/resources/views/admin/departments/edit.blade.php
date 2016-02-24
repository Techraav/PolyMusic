@extends('layouts.admin')

@section('title')
	Modifier un département
@stop

@section('content')

	@include('admin.departments.infos')

	<h2 align="center">Modifier le département</h2>
	<form method="post" action="{{ url('admin/departments/edit/'.$depToEdit->id) }}">
		<table class="table">
		<tbody>
			<th>
			{{ csrf_field() }}
				<td><input required class="form-control" type="text" name="name" id="name" placeholder="Nom" value="{{ $depToEdit->name }}"/></td>
				<td><input class="form-control" type="text" name="short_name" id="short_name" placeholder="Informations"  value="{{ $depToEdit->short_name }}"/></td>
				<td><button type="reset" class="btn btn-default">Annuler</button> <button type="submit" class="btn btn-primary">Valider</button></td>
			</th>
		</tbody>
		</table>
	</form>

	@include('admin.departments.table')

@stop