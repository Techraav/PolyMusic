@extends('layouts.admin')

@section('content')

	<div class="jumbotron">
		<h1 align="center">Gestion des articles</h1>
		<p>Voici une vue densemble des annonces.</p>
		<hr />
		<p>Nombre total d'articles créés : {{ App\Article::count() }}.</p>
	</div>

	<h2 align="center">Liste des articles</h2>
	@if(isset($category) && $category != '')
		<h4 align="center" class="help-block">Catégorie : <i>{{ucfirst($category)}}</i></h4>
	@endif

	<br />

	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<td width="150" align="center"><b>Créé le</b></td>
				<td><b>Auteur</b></td>
				<td><b>Titre</b></td>
				<td align="center" width="100"><b>Categorie</b></td>	
				<td align="center" width="80"><b>Validé</b></td>			
				<td align="center" width="100"><b>Gérer</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($articles as $a)
				<tr>
					<td align="center">{{ showDate($a->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
					<td>{!! printUserLinkV2($a->author) !!}</td>
					<td><a href="{{ url('articles/view/'.$a->slug) }}">{{ ucfirst($a->title) }}</a></td>
					<td align="center"><a href="{{ url('admin/articles/'.$a->category->id) }}">{{ ucfirst($a->category->name) }}</a></td>
					<td align="center" class="manage">
						<a href="{{ $a->validated == 1 ? url('admin/articles/validated/1') : url('admin/articles/validated/0') }}"
						   class="icon-validated glyphicon glyphicon-{{ $a->validated == 1 ? 'ok' : 'remove' }}">
						</a>
					</td>
					<td align="center" class="manage">

					@if(Auth::user()->level->level > 2)	
						@if($a->validated == 1)
							<button onclick="dialogDelete(this)" 
									slug="{{ $a->slug }}" 
									align="right" 
									link="{{ url('admin/articles/delete/'.$a->slug) }}" 
									title="Supprimer l'article ?" 
									class="glyphicon glyphicon-trash">
							</button>
						@else
							&nbsp; <a title="Valider l'article ?" class="glyphicon glyphicon-ok" href="{{ url('admin/articles/validate/'.$a->id) }}"></a>&nbsp;						
						@endif						
						<a class="glyphicon glyphicon-pencil" href="{{ url('admin/articles/edit/'.$a['slug']) }}"></a>	
					@else
						-
					@endif
				</td>			
				</tr>
			@empty

			@endforelse
		</tbody>
	</table>

	<div align="right"> {!! $articles->render() !!} </div>

	<div class="modal fade" id="myModal" role="dialog">
    	<div class="modal-dialog">
    
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 class="modal-title">Voulez-vous vraiment supprimer cet article ?</h4>
	        	</div>

		        <form id="modal-form" class="modal-form" method="post" action="">
		        {!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-danger"><b>Attention ! Cette action est irréversible !</b></p>
			         	<input hidden value="" name="user_id" id="user_id" />
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
		function dialogDelete(el)
		{
			var slug = el.getAttribute('news-slug');
			var link = el.getAttribute('link');

			$('#modal-form').attr('action', link);
			$('#articles_slug').attr('value', slug);
			$('#myModal').modal('toggle');
		}
</script>

@stop