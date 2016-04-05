@extends('layouts.admin')

@section('title')
	Levels
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">Levels</li>
@stop

@section('content')

	@include('admin.levels.infos')
	
	@include('admin.levels.table')

	@include('admin.levels.modal-edit')

@stop

@section('js')

<script type="text/javascript">

		function dialogLevelEdit(el)
		{
			var id = el.getAttribute('level-id');
			var name = el.getAttribute('level-name');
			var infos = el.getAttribute('level-infos');
			var link = el.getAttribute('link');

			$('#modalEdit form').attr('action', link);
			$('#modalEdit #infos').html(infos);
			$('#modalEdit #name').attr('value', name);
			$('#modalEdit #id').attr('value', id);
			$('#modalEdit').modal('toggle');
		}	
</script>

@stop