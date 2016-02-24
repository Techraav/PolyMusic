@extends('layouts.admin')

@section('title')
	modifier un niveau
@stop

@section('content')

	@include('admin.levels.infos')

	<h2 align="center">Modifier le level</h2>
	<form method="post" action="{{ url('admin/levels/edit/'.$levelToEdit->level) }}">
		<table class="table">
		<tbody>
			<th>
			{{ csrf_field() }}
				<td>
				<select disabled class="form-control" name="level">
							<option value="{{ $levelToEdit->level }}">{{ $levelToEdit->level }}</option>
					</select>
				</td>
				<td><input required class="form-control" type="text" name="name" id="name" placeholder="Nom" value="{{ $levelToEdit->name }}"/></td>
				<td><input class="form-control" type="text" name="infos" id="infos" placeholder="Informations"  value="{{ $levelToEdit->infos }}"/></td>
				<td><button type="reset" class="btn btn-default">Annuler</button> <button type="submit" class="btn btn-primary">Valider</button></td>
			</th>
		</tbody>
		</table>
	</form>


	@include('admin.levels.table')


@stop