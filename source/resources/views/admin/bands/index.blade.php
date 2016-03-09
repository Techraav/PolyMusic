@extends('layouts.admin')

@section('title')
	Groupes
@stop

@section('content')

	<div class="jumbotron">
		<h1 align="center"> Gestion des groupes </h1>
		<p>Voici la liste des groupes, validés ou non, créés par les utilisateurs du site.</p>
		<p>Vous pouvez cliquer sur le nom d'un groupe pour accéder à l'article le concernant.</p>
		<p>Vous pouvez cliquer sur le nom du créateur pour accéder à son profil.</p>
		<!-- <p>Vous pouvez choisir de n'afficher que les groupes validés ou en attente de validation.</p> -->
		<p>Il faut être au moins <b>Admin</b> pour modifier ou supprimer un groupe.</p>
		<p>Pour valider ou invalider une groupe, il faut cliquer cliquer sur &laquo; modifier &raquo;.</p>
		<hr />
		<p>Nombre total de groupes : {{ App\Band::count() }}.</p>
	</div>

	<h2 align="center"> Liste des groupes </h2>
	<br />

	<table class="table table-striped table-hover table-bands">
		<thead>
			<tr>
				<td width="120" align="center"><b>Créé le</b></td>
				<td align="center"><b>Nom</b></td>
				<td width="300"><b>Créateur</b></td>
				<td width="100" align="center"><b>Membres</b></td>
				<td width="100" align="center"><b>Validé</b></td>
				<td width="100" align="center"><b>Gérer</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($bands as $b)
			<tr>
				<td align="center">{{ date_format($b->created_at, 'd/m/Y') }}</td>
				<td align="center"><a href="{{ url('bands/'.$b->slug) }}">{{ ucfirst($b->name) }}</a></td>
				<td>{!! printUserLinkV2($b->manager) !!}</td>
				<td align="center">{{ $b->members()->count() }}</td>
				<td align="center"><span class="icon-validated glyphicon glyphicon-{{ $b->validated == 1 ? 'ok' : 'remove' }}"></span></td>
				<td align="center">
					@if(Auth::user()->level->level > 2)							
						<button onclick="dialogDelete(this)" 
								id="{{ $b->id }}" 
								name="{{ $b->name }}" 
								link="{{ url('admin/bands/delete/'.$b->id) }}" 
								align="right" 
								title="Supprimer le groupe {{ $b->name }} ?" 
								class="glyphicon glyphicon-trash">
						</button>

						<button onclick="dialogEdit(this)" 
								id="{{ $b->id }}" 
								name="{{ $b->name }}" 
								infos="{{ $b->infos }}"
								manager-id="{{ $b->user_id }}"
								manager="{{ $b->manager()->first_name.' '.$b->manager()->last_name }}"
								validated="{{ $b->validated }}"
								link="{{ url('admin/bands/edit/'.$b->id) }}" 
								title="Modifier le groupe {{ $b->name }} ?"
								class="glyphicon glyphicon-pencil">
						</button>
					@else
						-
					@endif
				</td>			
			</tr>
			@empty
			<tr>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
			</tr>
			@endforelse
		</tbody>
	</table>

	<div align="right"> {!! $bands->render() !!} </div>

	@include('admin.bands.modal-delete')

	@include('admin.bands.modal-edit')

@stop

@section('js')
    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'infos' );
    </script>

<script type="text/javascript">
		function dialogDelete(el)
		{
			var id = el.getAttribute('id');
			var name = el.getAttribute('name');
			var link = el.getAttribute('link');

			$('#modalDelete form').attr('action', link);
			$('#modalDelete h4').html("Supprimer le groupe &laquo; " + name + " &raquo; ?");
			$('#modalDelete #band_id').attr('value', id);
			$('#modalDelete').modal('toggle');
		}

		function dialogEdit(el)
		{
			var id = el.getAttribute('id');
			var name = el.getAttribute('name');
			var link = el.getAttribute('link');
			var infos = el.getAttribute('infos');
			var manager_id = el.getAttribute('manager-id');
			var manager = el.getAttribute('manager');
			var validated = el.getAttribute('validated');

			var html = '<option selected value="' + manager_id + '">' + manager + '</option>';

			console.log(html);



			$('#modalEdit form').attr('action', link);
			$('#modalEdit #name').attr('value', name);
			$('#modalEdit #band_id').attr('value', id);
			$('#modalEdit #manager').attr('value', manager);
			$('#modalEdit #user_id').attr('value', manager_id);
			$('#modalEdit #validated').attr('checked', validated == 1);
			CKEDITOR.instances.infos.setData(infos);
			$('#modalEdit').modal('toggle');
		}	
</script>

@stop