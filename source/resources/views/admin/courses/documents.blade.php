@extends('layouts.admin')

@section('content')

	<h1 align="center">{!! printLink('courses/'.$course->slug, ucfirst($course->name), ['title' => 'Voir la fiche du cours']) !!}</h1>
	<h5 align="center" class="help-block"><i>Géré par : {!! printUserLinkV2($course->manager) !!}</i></h5>
	<br />
	<h3 align="center">liste des documents {{ isset($filter) ? $filter : ''}} :</h3>
	<br />
	<table class="table table-hover table-striped"> 
		<thead>
			<tr>
				<td width="100" align="center"><b>Ajouté le</b></td>
				<td width="230" align="center"><b>Ajouté par</b></td>
				<td width="250"><b>Titre</b></td>
				<td width="340"><b>Description</b></td>
				<td align="center"><b>Validé</b></td>
				<td align="center"><b>Gérer</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($documents as $d)
				<td align="center">{{ showDate($d->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
				<td align="center">{!! printUserLinkV2($d->author) !!}</td>
				<td>{{ $d->title }}</td>
				<td>{!! cut($d->description, 40) !!}</td>
				<td class="manage" align="center">{!! printLink('admin/courses/'.$course->id.'/documents/validation/'.$d->validated, '', ['title' => 'N\'afficher que les documents '.($d->validated == 0 ? 'non validés' : 'validés').'.'], ['glyphicon', 'glyphicon-'.($d->validated == 0 ? 'remove' : 'ok')]) !!}</td>
				<td align="center">
				@if(Auth::user()->level_id > 3 || $course->users->contains(Auth::user()))
					@if($d->validated == 1)
						<button 
								onclick="validaton(this)"
								link="{{ url('admin/documents/unvalidate') }}"
								id="{{ $d->id }}"
								action="invalider"
								title="Invalider le document"
								class="{{ glyph('remove') }}">
						</button>
					@else
						<button 
								onclick="validaton(this)"
								link="{{ url('admin/documents/validate') }}"
								id="{{ $d->id }}"
								action="valider"
								title="Valider le document"
								class="{{ glyph('ok') }}">
						</button>
						<button
								onclick="delete(this)"
								link="{{ url('admin/documents/delete/'.$d->id) }}"
								id="{{ $d->id }}"
								title="Supprimer le document"
								class="{{ glyph('trash') }}"
						</button>
					@endif
					<button 
							onclick="edit(this)"
							link="{{ url('admin/documents/edit/'.$d->id) }}"
							id="{{ $d->id }}"
							title="Modifier le document"
							class="{{ glyph('pencil') }}">
					</button>
				@else
				-
				@endif
				</td>
			@empty
				<td align="center">-</td>
				<td align="center">-</td>
				<td>-</td>
				<td>-</td>
				<td align="center">-</td>
				<td align="center">-</td>
			@endforelse
		</tbody>
	</table>

	<div align="right">{!! $documents->render() !!}</div>

	<!-- Modal -->
	<div class="modal fade" id="modalValidation" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer un document</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-warning"><b>Attention ! Cette action est irréversible !</b></p>
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
	function validation(el)
	{
		var id = el.getAttribute('id');
		var link = el.getAttribute('link');
		var action = el.getAttribute('action');

		$("#modalValidation form .text-warning b").text('Voulez-s vraiment '+action+' ce document ?');
		$('#modalValidation #id').attr('value', id);
		$('#modalValidation form').attr('action', link);
		$('#modalValidation').modal('show');
	}

</script>

@stop