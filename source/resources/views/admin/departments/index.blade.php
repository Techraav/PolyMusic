@extends('layouts.admin')

@section('title')
	Départements
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">Départements</li>
@stop

@section('content')

	@include('admin.departments.infos')

	@include('admin.departments.table')

	@include('admin.departments.modal-edit')

	<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer un département</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-danger"><b>Attention ! Cette action est irréversible !</b></p>
			         	<input hidden value="" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" class="btn btn-primary">Supprimer</button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>

@stop

@section('js')

<script type="text/javascript">
		function dialogDepartmentEdit(el)
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