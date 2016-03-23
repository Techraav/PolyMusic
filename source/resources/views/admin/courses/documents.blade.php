@extends('layouts.admin')

@section('content')

	<h1 align="center">{!! printLink('courses/show/'.$course->slug, ucfirst($course->name), ['title' => 'Voir la fiche du cours']) !!}</h1>
	<h4 class="help-block" align="center">{!! printLink('admin/courses/'.$course->slug.'/members', 'Gérer les membres') !!}</h4>
	<h5 align="center" class="help-block"><i>Responsable : {!! printUserLinkV2($course->manager) !!}</i></h5>
	<br />
	<h3 align="center">liste des documents {{ isset($filter) ? $filter : ''}} :</h3>
	<h5 align="center" class="help-block"><i>Nombre total de documents : {{ App\Document::where('course_id', $course->id)->count() }}</i></h5>
	
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
				<tr>
					<td align="center">{{ showDate($d->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
					<td align="center">{!! printUserLinkV2($d->author) !!}</td>
					<td>{!! printLink('files/documents/'.$d->name, ucfirst($d->title), ['target'	=> '_blank']) !!}</td>
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
				</tr>

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
	<br />
	<h3 align="center">Ajouter un document</h3>
	<br />
	<form class="col-lg-8 col-lg-offset-2" method="post" action="{{ url('admin/documents/store') }}" files="true" id="add-document" accept-charset="UTF-8" enctype="multipart/form-data">
	{{ csrf_field() }}
		<div class="form-group">
			<label class="label-control">Cours :</label>
			<input required type="text" disabled class="form-control" value="{{ ucfirst($course->name) }}" />
			<input required hidden name="course_id" value="{{ $course->id }}" />
		</div>

		<div class="form-group">
			<label class="label-control">Titre :</label>
			<input required type="text" class="form-control" name="title" value="" placeholder="Titre du document" />
		</div>

		<div class="form-group">
			<label class="label-control">Document :</label>
			{!! printFileInput('file', ['pdf'], true, ['application/pdf'], 'Seuls les fichiers au format PDF sont acceptés.') !!}
		</div>

		<div class="form-group">
			<label class="label-control">Description :</label>
			<textarea rows="4" class="form-control" name="description" placeholder="Decrivez votre document..."></textarea>
		</div>
				
		<div align="center"class="row buttons">
			<button type="reset" class="btn btn-default">Annuler</button> <button  type="submit" class="btn btn-primary">Valider</button>
		</div>
	</form>

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
