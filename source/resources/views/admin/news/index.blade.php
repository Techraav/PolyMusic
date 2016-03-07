@extends('layouts.admin')

@section('content')

	<div class="jumbotron">
		<h1 align="center">Gestion des news</h1>
		<p>Voici une vue densemble des news créées, validées ou non.</p>
	</div>

	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<td width="150" align="center"><b>Créée le</b></td>
				<td><b>Auteur</b></td>
				<td><b>Titre</b></td>
				<td align="center" width="150"><b>Publiée le</b></td>
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
					<td align="center" class="manage">
						<a href="{{ $n->active == 1 ? url('admin/news/validated/1') : url('admin/news/validated/0') }}"
						   class="icon-validated glyphicon glyphicon-{{ $n->active == 1 ? 'ok' : 'remove' }}">
						</a>
					</td>
					<td align="center" class="manage">
					@if(Auth::user()->level_id > 2)		
						@if($n->active == 1)					
							<button onclick="dialogDelete(this)" 
									slug="{{ $n->slug }}" 
									align="right" 
									link="{{ url('admin/news/delete/'.$n->slug) }}" 
									title="Supprimer la news ?" 
									class="glyphicon glyphicon-trash">
							</button>
						@else
							&nbsp; <a title="Activer la news ?" class="glyphicon glyphicon-plus" href="{{ url('admin/news/activate/'.$n->id) }} "></a>&nbsp;
						@endif
						<a class="glyphicon glyphicon-pencil" href="{{ url('admin/news/edit/'.$n['slug']) }}"></a>	
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

	<div class="modal fade" id="myModal" role="dialog">
    	<div class="modal-dialog">
    
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 class="modal-title">Voulez-vous vraiment supprimer cette news ?</h4>
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
			$('#news_slug').attr('value', slug);
			$('#myModal').modal('toggle');
		}
</script>

@stop