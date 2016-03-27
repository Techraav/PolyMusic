@extends('layouts.admin')

@section('title')
    Catégories
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">Catégories</li>
@stop

@section('content')

	@include('admin.categories.infos')

	@include('admin.categories.table')

	@include('admin.categories.modal-delete')

	@include('admin.categories.modal-edit')


@stop

@section('js')

<script type="text/javascript">
		function dialogDelete(el)
		{
			var id = el.getAttribute('category-id');
			var name = el.getAttribute('category-name');
			var link = el.getAttribute('link');

			$('#modalDelete form').attr('action', link);
			$('#modalDelete h4').html('Supprimer la catégorie &laquo; ' + name + ' &raquo; ?');
			$('#modalDelete #category_id').attr('value', id);
			$('#modalDelete').modal('toggle');
		}

		function dialogEdit(el)
		{
			var id = el.getAttribute('category-id');
			var name = el.getAttribute('category-name');
			var link = el.getAttribute('link');

			$('#modalEdit form').attr('action', link);
			$('#modalEdit #name').attr('value', name);
			$('#modalEdit #category_id').attr('value', id);
			$('#modalEdit').modal('toggle');
		}	
</script>

@stop