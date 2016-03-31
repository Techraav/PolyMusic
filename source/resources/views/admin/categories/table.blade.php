<h2 align="center">Liste des catégories :</h2>
	<br />
		<table class="table-levels table table-striped table-hover">
			<thead>
				<tr>
					<td align="center" width="150"><b>ID</b></td>
					<td align="center"><b>Catégorie</b></td>
					<td align="center" width="200"><b>Articles</b></td>
					<td align="center" width="200"><b>Annonces</b></td>
					<td width="90" align="center"><b>Gérer</b></td>
				</tr>
			</thead>
			<tbody>
			@forelse($categories as $c)
				<tr>
					<td align="center">{{ $c->id }}</td>
					<td align="center"><a href="{{ url('categories/list/'.$c->id) }}">{{ $c->name }}</a></td>
					<td align="center">{{ $c->articles()->count() }}</td>
					<td align="center">{{ $c->announcements()->count() }}</td>
					@if(Auth::user()->level_id > 3)
						<td class="manage" align="center">
							&nbsp; 
							@if($c->id != 1 && $c->ic != 2)
								<button
										onclick='modalDelete(this)'
										link="{{ url('admin/categories/delete') }}"
										id="{{ $c->id }}"
										title="Supprimer cette catégorie"
										class="{{ glyph('trash') }}">
								</button>
								@else
								&nbsp; -&nbsp;
								@endif
							<button 
									onclick="dialogEditCategory(this)" 
									category-name="{{ $c->name }}" 
									category-id="{{ $c->id }}" 
									link="{{ url('admin/categories/edit') }}" 
									title="Modifier la catégorie {{ $c->name }} ?" 
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

		<div align="right">{!! $categories->render()!!}</div>

		<br />
		<div class="col-lg-8 col-lg-offset-2">
			<h2 align="center">Ajouter une catégorie :</h2>

			<form method="post" action="{{ url('admin/categories/create') }}">
				
					{{ csrf_field() }}
					
					<div class="form-group">
						<input required class="form-control" type="text" name="name" id="name" placeholder="Nom" />
					</div>
					
					<div align="center" class="form-group buttons">
						<button type="reset" class="btn btn-default">Annuler</button> <button type="submit" class="btn btn-primary">Valider</button>
					</div>					
			</form>
		</div>