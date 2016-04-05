<h2 align="center">Liste des départements :</h2>
	<br />
		<table class="table-levels table table-striped table-hover">
			<thead>
				<tr>
					<td align="center" width="50"><b>Acronyme</b></td>
					<th width="250">Nom complet</th>
					<td align="center" width="120"><b>Nombre de membres</b></td>
					<td align="center" width="100"><b>Gérer</b></td>
				</tr>
			</thead>
			<tbody>
			@forelse($departments as $d)
				<tr>
					<td align="center">
						<a href="{{ url('admin/departments/'.$d->id.'/members') }}">{{ $d->short_name }}</a>
					</td>
					<td>
						<a href="{{ url('admin/departments/'.$d->id.'/members') }}">{{ $d->name }}</a>
					</td>
					<td align="center">{{ $d->users->count() }}</td>
					@if($d->id != 1 && Auth::user()->level_id > 3)
						<td class="manage" align="center">
							<button
									data-link="{{ url('admin/departments/delete') }}"
									data-id="{{ $d->id }}"
									title="Supprimer ce département"
									class="{{ glyph('trash') }} delete-button">
							</button>
							<button 
									onclick="dialogDepartmentEdit(this)"
									name="{{ $d->name}}"
									short-name="{{ $d->short_name }}"
									id="{{ $d->id }}"
									link="{{ url('admin/departments/edit/'.$d->id) }}" 
									title="Modifier le département {{ $d->name }} ?"
									class="glyphicon glyphicon-pencil">
							</button>
						</td>
					@else
					<td align="center">-</td>
					@endif
					</tr>
			@empty
				<tr>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
				</tr>
			@endforelse

			</tbody>
		</table>

		<div align="right"> {!! $departments->render() !!} </div>

		<h2 align="center">Ajouter un Département :</h2>

		<form method="post" action="{{ url('admin/departments/create') }}">
			<table class="table">
			<tbody>
				<tr>
				{{ csrf_field() }}
					<td><input required class="form-control" type="text" name="name" id="name" placeholder="Nom complet" /></td>
					<td><input required class="form-control" type="text" name="short_name" id="short_name" placeholder="Acronyme" /></td>
					<td class="td-buttons"><button type="reset" class="btn btn-default">Annuler</button> <button type="submit" class="btn btn-primary">Valider</button></td>
				</tr>
			</tbody>
			</table>
		</form>