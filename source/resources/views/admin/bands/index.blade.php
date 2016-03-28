@extends('layouts.admin')

@section('title')
	Groupes
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">Groupes</li>
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
				<td width="20" align="right"> </td>
				<td width="20" align="center"><b>Gérer</b></td>
				<td width="20" align="left"></td>
			</tr>
		</thead>
		<tbody>
			@forelse($bands as $b)
			<tr>
				<td align="center">{{ date_format($b->created_at, 'd/m/Y') }}</td>
				<td align="center"><a href="{{ url('bands/show/'.$b->slug) }}">{{ ucfirst($b->name) }}</a></td>
				<td>{!! printUserLinkV2($b->manager) !!}</td>
				<td align="center">{{ $b->members()->count() }}</td>
				<td align="center"><span class="icon-validated glyphicon glyphicon-{{ $b->validated == 1 ? 'ok' : 'remove' }}"></span></td>
				@if(Auth::user()->level_id > 3 || $b->user_id == Auth::user()->id)
					<td class="manage manage-left" align="right">
						@if($b->validated == 1)
							<button 
									onclick="modalToggle(this)"
									link="{{ url('bands/validate/0') }}"
									id="{{ $b->id }}"
									action="invalider"
									title="Invalider le document"
									msg="Voulez-vous vraiment invalider ce groupe ?"
									class="{{ glyph('remove') }}">
							</button>
						@else
							<button 
									onclick="modalToggle(this)"
									link="{{ url('bands/validate/1') }}"
									id="{{ $b->id }}"
									action="valider"
									msg="Voulez-vous vraiment valider ce groupe ?"
									title="Valider le document"
									class="{{ glyph('ok') }}">
							</button>
						@endif
					</td>
					<td class="manage" align="center">
						<button
								onclick='modalDelete(this)'
								link="{{ url('bands/delete') }}"
								id="{{ $b->id }}"
								title="Supprimer le groupe"
								class="{{ glyph('trash') }}">
						</button>
					</td>
					<td class="manage manage-right" align="left">
						<a href="{{ url('admin/documents/edit/'.$b->id) }}" title="Modifier le document" class="{{ glyph('pencil') }}"> </a>
					</td>
				@else
				<td></td><td align="center">-</td><td></td>
				@endif		
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

	<!-- Modal -->
	<div class="modal fade" id="modalToggle" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Valider/Invalider un groupe</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-warning"><b></b></p>
			         	<input hidden value="" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" id="button-toggle" class="btn btn-primary"></button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer un grope</h4>
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
    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'infos' );
    </script>
@stop