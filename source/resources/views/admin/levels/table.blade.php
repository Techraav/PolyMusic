<h2 align="center">Liste des niveaux :</h2>
	<br />
		<table class="table-levels table table-striped table-hover">
			<thead>
				<tr>
					<td align="center" width="50"><b>ID</b></td>
					<td align="center" width="100"><b>Level</b></td>
					<td width="200"><b>Nom</b></td>
					<td width="300"><b>Informations</b></td>
					<td align="center" width="200"><b>Nombre de membres</b></td>
					<td align="center" width="70"><b>Gérer</b></td>
				</tr>
			</thead>
			<tbody>
			@forelse($levels as $l)
				<tr>
					<td align="center">{{ $l->id }}</td>
					<td align="center">{{ $l->level }}</td>
					<td>
						<a href="{{ url('admin/levels/'.$l->name.'/members') }}">{{ $l->name }}</a>
					</td>
					<td>{{ $l->infos ? $l->infos : '-' }}</td>
					<td align="center">{{ $l->users()->count() }}</td>
					<td align="center">
						<a href="{{ url('admin/levels/edit/'.$l->level) }}" title="Modifier le level {{ $l->name }} ?"class="glyphicon glyphicon-pencil"></a>
					</td>
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
		<div align="right">{!! $levels->render()!!}</div>
		<br />