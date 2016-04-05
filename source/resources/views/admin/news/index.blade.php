@extends('layouts.admin')

@section('title')
    News
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">News</li>
@stop

@section('content')

	<div class="jumbotron">
		<h1 align="center">Gestion des news</h1>
		<p>Voici une vue densemble des news créées, validées ou non.</p>
		<p>Vous souhaitez créer une news ? {!! printLink('admin/news/create', 'Cliquez ici') !!} !</p>
		<hr />
		<p>Nombre total de news créées : {{ App\News::count() }}.</p>
	</div>

	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<td width="150" align="center"><b>Créée le</b></td>
				<td><b>Auteur</b></td>
				<td><b>Titre</b></td>
				<td align="center" width="150"><b>Publiée le</b></td>
				<td width="100" align="center"><b>Validé</b></td>
				<td width="20" align="right"> </td>
				<td width="20" align="center"><b>Gérer</b></td>
				<td width="20" align="left"></td>
			</tr>
		</thead>
		<tbody>
			@forelse($news as $n)
				<tr>
					<td align="center">{{ showDate($n->created_at, 'Y-m-d H:i:s', 'd/m/Y') }}</td>
					<td>{!! printUserLinkV2($n->author) !!}</td>
					<td><a href="{{ url('news/view/'.$n->slug) }}">{{ ucfirst($n->title) }}</a></td>
					<td align="center">{{ showDate($n->published_at, 'Y-m-d', 'd/m/Y') }}</td>
					<td align="center" class="manage">
						<a href="{{ $n->active == 1 ? url('admin/news/validated/1') : url('admin/news/validated/0') }}"
						   class="icon-validated glyphicon glyphicon-{{ $n->active == 1 ? 'ok' : 'remove' }}">
						</a>
					</td>
					@if(Auth::user()->level_id > 3 || $n->user_id == Auth::user()->id)
						<td class="manage manage-left" align="right">
							@if($n->active == 1)
								<button 
										onclick="modalToggle(this)"
										link="{{ url('admin/news/activate/0') }}"
										id="{{ $n->id }}"
										action="désactiver"
										title="Désactiver la news"
										msg="Voulez-vous vraiment désactiver cette news ?"
										class="{{ glyph('remove') }}">
								</button>
							@else
								<button 
										onclick="modalToggle(this)"
										link="{{ url('admin/news/validate/1') }}"
										id="{{ $n->id }}"
										action="activer"
										msg="Voulez-vous vraiment activer cette news ?"
										title="Activer la news"
										class="{{ glyph('ok') }}">
								</button>
							@endif
						</td>
						<td class="manage" align="center">
							<button
									data-link="{{ url('admin/news/delete') }}"
									data-id="{{ $n->id }}"
									title="Supprimer la news"
									class="{{ glyph('trash') }} delete-button">
							</button>
						</td>
						<td class="manage manage-right" align="left">
							<a href="{{ url('admin/documents/edit/'.$n->id) }}" title="Modifier le document" class="{{ glyph('pencil') }}"> </a>
						</td>
				@else
				<td></td><td align="center">-</td><td></td>
				@endif	
				</tr>
			@empty

			@endforelse
		</tbody>
	</table>

	<div align="right"> {!! $news->render() !!} </div>

	<!-- Modal -->
	<div class="modal fade" id="modalToggle" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Activer/désactiver une news</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-warning"><b></b></p>
			         	<input hidden value="" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" id="button-toggle" class="btn btn-primary"></button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer une news</h4>
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