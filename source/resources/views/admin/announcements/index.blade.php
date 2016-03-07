@extends('layouts.admin')

@section('content')

	{{-- Infos --}}
	<div class="jumbotron">
		<h1 align="center">Gestion des annonces</h1>
		<p>Voici une vue densemble des annonces créées, validées ou non, triées par date de création.</p>
		<p>Vous pouvez cliquer sur le nom de l'auteur pour aller voir son profil.</p>
		<p>Vous pouvez cliquer sur le titre de l'annonce pour la consulter.</p>
		<p>Vous pouvez cliquer sur la catégorie pour n'afficher que les annonces de cette catégorie.</p>
		<p>Le bouton &laquo; supprimer &raquo; ne supprime pas définitivement une annonce, elle l'invalide seulement.</p>
		<hr />
		<p>Nombre total d'annonces créées : {{ App\Announcement::count() }}.</p>

	</div>



	{{-- Table --}}
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<td width="150" align="center"><b>Créé le</b></td>
				<td><b>Auteur</b></td>
				<td><b>Titre</b></td>
				<td align="center" width="100"><b>Categorie</b></td>
				<td width="100" align="center"><b>Validée</b></td>
				<td align="center" width="100"><b>Gérer</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($announcements as $a)
				<tr>
					<td align="center">{{ showDate($a->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
					<td>{!! printUserLink($a->user_id) !!}</td>
					<td><a href="{{ url('announcements/view/'.$a->slug) }}">{{ ucfirst($a->title) }}</a></td>
					<td align="center"><a href="{{ url('admin/announcements/'.$a->category->id) }}">{{ ucfirst($a->category->name) }}</a></td>
					<td align="center" class="manage">
						<a href="{{ $a->validated == 1 ? url('admin/announcements/validated/1') : url('admin/announcements/validated/0') }}"
						   class="icon-validated glyphicon glyphicon-{{ $a->validated == 1 ? 'ok' : 'remove' }}">
						</a>
					</td>
					<td align="center" class="manage">
					@if(Auth::user()->level->level > 2)							
						@if($a->validated == 1)
						<button onclick="dialogDelete(this)" 
								id="{{ $a->id }}" 
								align="right" 
								link="{{ url('announcements/delete/'.$a->slug) }}"
								title="Supprimer l'annonce {{ $a->name }} ?" 
								class="glyphicon glyphicon-trash">
						</button>
						@else
							&nbsp; <a title="Valider l'annonce ?" class="glyphicon glyphicon-ok" href="{{ url('admin/announcements/validate/'.$a->id) }}"></a>&nbsp;
						@endif

						<a href="{{ url('announcements/edit/'.$a->slug) }}"
								title="Modifier l'annonce {{ $a->name }} ?"
								class="glyphicon glyphicon-pencil">
						</a>
					@else
						-
					@endif
				</td>			
				</tr>
			@empty

			@endforelse
		</tbody>
	</table>

	<div align="right"> {!! $announcements->render() !!} </div>

	{{-- Modals --}}
	<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Modifier une annonce</h4>
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
		function dialogDelete(el) {
			var id = el.getAttribute('id');
			var link = el.getAttribute('link');

			$('#modalDelete form').attr('action', link);
			$('#modalDelete #id').attr('value', id);
			$('#modalDelete').modal('show');
		}
	</script>

@stop