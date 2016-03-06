@extends('layouts.admin')

@section('content')

	<div class="jumbotron">
		<h1 align="center">Gestion des news</h1>
		<p>Voici une vue densemble des news créées, validées ou non.</p>
	</div>

	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<td width="150" align="center"><b>Créé le</b></td>
				<td><b>Auteur</b></td>
				<td><b>Titre</b></td>
				<td align="center" width="150"><b>Publié le</b></td>
				<td width="100" align="center"><b>Validé</b></td>
				<td align="center" width="100"><b>Gérer</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($news as $n)
				<tr>
					<td align="center">{{ showDate($n->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
					<td>{!! printUserLink($n->user_id) !!}</td>
					<td><a href="{{ url('news/view/'.$n->slug) }}">{{ ucfirst($n->title) }}</a></td>
					<td align="center">{{ showDate($n->published_at, 'Y-m-d', 'd/m/Y') }}</td>
					<td align="center"><span class="icon-validated glyphicon glyphicon-{{ $n->validated == 1 ? 'ok' : 'remove' }}"></span></td>
					<td align="center">
					@if(Auth::user()->level->level > 2)							
						<button onclick="dialogDelete(this)" 
								id="{{ $n->id }}" 
								align="right" 
								title="Supprimer la news ?" 
								class="glyphicon glyphicon-trash">
						</button>

						<button onclick="dialogEdit(this)" 
								id="{{ $n->id }}" 
								link="{{ url('news/edit/'.$n->slug) }}"
								title="Modifier le groupe ?"
								class="glyphicon glyphicon-pencil">
						</button>
					@else
						-
					@endif
				</td>			
				</tr>
			@empty

			@endforelse
		</tbody>
	</table>

	<div align="right"> {!! $news->render() !!} </div>

	{{-- Modals --}}
	<!-- Modal -->
	<div class="modal fade" id="modalEdit" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Modifier une annonce</h4>
	        	</div>

		        <div class="modal-body">
        			<iframe id="edit" frameborder="0" src=""></iframe>
		        </div>

		        <div class="modal-footer">
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
		          	<button type="submit" class="btn btn-primary">Supprimer</button>
		        </div>
	   		</div>
		</div>
	</div>

@stop

@section('js')

	<script type="text/javascript">
		function dialogEdit(el) {
			var slug = el.getAttribute('slug');
			var link = el.getAttribute('link');
			$('iframe#edit').attr('src', link);
			$('#modalEdit').modal('show');
		}
	</script>

@stop