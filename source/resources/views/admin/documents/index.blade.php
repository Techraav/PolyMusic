@extends('layouts.admin')

@section('content')

	<div class="jumbotron">
		<h1>Gestion des documents</h1>
		<p></p>
		<hr />
		<p>Nombre total de documents mis en ligne : {{ App\Document::count() }}</p>
	</div>

	<h2 align="center">Liste des documents</h2>
	@if(isset($filter))
		<h5 align="center" class="help-block"><i>Filtre : {{ $filter }} </i></h5>
	@endif

	<br />

	<table class="table table-hover table-stripped">
		<thead>
			<tr>
				<td align="center" width="150"><b>Date d'ajout</b></td>
				<td><b>Auteur</b></td>
				<td><b>Cours</b></td>
				<td><b>Titre du document</b></td>
				<td align="center"><b>Gérer</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($documents as $d)
				<tr>
					<td align="center">{{ showDate($d->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
					<td>{!! printUserLinkV2($d->author) !!}</td>
					<td>{!! printLink('courses/show/'.$d->author->slug, ucfirst($d->course->name)) !!}</td>
					<td>{!! printLink('files/documents/'.$d->name, ucfirst($d->title), ['target'	=> '_blank']) !!}</td>
					<td align="center" class="manage">
					@if(Auth::user()->level_id > 3 || $d->course->users->contains(Auth::user()))
						@if($d->validated == 1)
							<button 
									onclick="validation(this)"
									link="{{ url('admin/documents/unvalidate') }}"
									id="{{ $d->id }}"
									action="Invalider"
									msg="Voulez-vous vraiment invalider ce document ?"
									title="Invalider le document"
									class="{{ glyph('remove') }}">
							</button>
						@else
							<button 
									onclick="validation(this)"
									link="{{ url('admin/documents/validate') }}"
									id="{{ $d->id }}"
									action="Valider"
									msg="Voulez-vous vraiment valider ce document ?"
									title="Valider le document"
									class="{{ glyph('ok') }}">
							</button>
						@endif
					<button
							onclick="validation(this)"
							link="{{ url('admin/documents/delete') }}"
							id="{{ $d->id }}"
							action="Supprimer"
							msg="Attention ! Cette action est irréversible !"
							title="Supprimer le document"
							class="{{ glyph('trash') }}">
					</button>
					<a href="{{ url('admin/documents/edit/'.$d->id) }}" title="Modifier le document" class="{{ glyph('pencil') }}"> </a>
				@else
				-
				@endif
				</td>
				</tr>
			@empty
				<tr>
					<td align="center">-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td align="center">-</td>
				</tr>
			@endforelse
		</tbody>
	</table>
	
	<div align="right">{!! $documents->render(); !!}</div>
	<!-- Modal -->

	<div class="modal fade" id="modalValidation" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title"></h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-danger"><b></b></p>
			         	<input hidden value="" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" class="btn btn-primary">Valider</button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>	

@stop

@section('js')

<script type="text/javascript">
	function validation(el)
	{
		var id = el.getAttribute('id');
		var link = el.getAttribute('link');
		var action = el.getAttribute('action');
		var msg = el.getAttribute('msg');

		$("#modalValidation form .text-danger b").text(msg);
		$("#modalValidation #modal-title").text(action+' un document');
		$('#modalValidation #id').attr('value', id);
		$('#modalValidation form').attr('action', link);
		$('#modalValidation').modal('show');
	}
</script>

@stop

