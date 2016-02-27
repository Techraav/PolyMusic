@extends('layouts.admin')

@section('title')
	Départements
@stop

@section('content')

	@include('admin.departments.infos')

	@include('admin.departments.table')

	@include('admin.departments.modal-delete')

	@include('admin.departments.modal-edit')

@stop

@section('js')

<script type="text/javascript">
		function dialogDelete(el)
		{
			var id = el.getAttribute('id');
			var name = el.getAttribute('name');
			var link = el.getAttribute('link');

			$('#modalDelete form').attr('action', link);
			$('#modalDelete h4').html("Supprimer le départment &laquo; " + name + " &raquo; ?");
			$('#modalDelete #department_id').attr('value', id);
			$('#modalDelete').modal('toggle');
		}

		function dialogEdit(el)
		{
			var id = el.getAttribute('id');
			var name = el.getAttribute('name');
			var sname = el.getAttribute('short-name');
			var link = el.getAttribute('link');

			$('#modalEdit form').attr('action', link);
			$('#modalEdit #department_id').attr('value', id);
			$('#modalEdit #name').attr('value', name);
			$('#modalEdit #short_name').attr('value', sname);
			$('#modalEdit').modal('toggle');
		}	
</script>

@stop