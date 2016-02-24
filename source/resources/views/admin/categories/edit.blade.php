@extends('layouts.admin')

@section('title')
	Niveaux
@stop

@section('content')

	@include('admin.categories.infos')

	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<h2 align="center">Modifier une catégorie :</h2>

		<form method="post" action="{{ url('admin/categories/edit') }}">
			
				{{ csrf_field() }}

				<input name="category_id" value="{{ $catToEdit->id }}" hidden/>
				
				<div class="form-group">
					<input required class="form-control" type="text" name="name" id="name" value="{{ $catToEdit->name }}" />
				</div>
				
				<div align="center" class="form-group buttons">
					<button type="reset" class="btn btn-default">Annuler</button> <button type="submit" class="btn btn-primary">Valider</button>
				</div>					
			</form>
		</div>	
	</div>	
	<br />

	@include('admin.categories.table')

@stop