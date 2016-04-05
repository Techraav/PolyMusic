@extends('layouts.app')

@section('title')
	{{ ucfirst($news->title) }}
@stop

@section('breadcrumb')
    <li> <a href="{{ url('news') }}">News</a></li>
    <li class="active">{{ ucfirst($news->title) }}</li>
@stop

@section('content')
		<blockquote class="comment frame-news col-lg-10 col-lg-offset-1">
			<h2><a title="Cliquez pour voir la news en entier" href="{{ url('news/view/'.$news['slug']) }}"> {{ucfirst($news->title)}}</a>{!! $active ? '' : '<p class="text-danger inactive" title="Cette news n\'est pas publique">(invalidée)</p>' !!}</h2>
				@if(Auth::check() && Auth::user()->level_id >= 3)
					<div class="manage">
						@if($news->active == 1)
							<button 
									onclick="modalToggle(this)"
									link="{{ url('admin/news/activate/0') }}"
									id="{{ $news->id }}"
									action="désactiver"
									title="Désactiver la news"
									msg="Voulez-vous vraiment désactiver cette news ?"
									class="{{ glyph('remove') }}">
							</button>
						@else
							<button 
									onclick="modalToggle(this)"
									link="{{ url('admin/news/activate/1') }}"
									id="{{ $news->id }}"
									action="activer"
									msg="Voulez-vous vraiment activer cette news ?"
									title="Activer la news"
									class="{{ glyph('ok') }}">
							</button>
						@endif
						<a class="glyphicon glyphicon-pencil" href="{{ url('admin/news/edit/'.$news['slug']) }}"></a>				
						<button 
								data-id="{{ $news->id }}" 
								data-link="{{ url('admin/news/delete') }}" 
								title="Supprimer la news"
								class="{{ glyph('trash') }} delete-button">
						</button>
					</div>
				@endif
			{!! $news['content'] !!} <br/>
				<div class="post-infos post-news-infos" align="right">Rédigée par 
					{!! printUserLinkV2($news->author) !!} le {{date_format($news['created_at'], 'd/m/Y \à H:i')}}.
				</div>
		</blockquote>
		<br/>

	  <!-- Modal -->
  	<div class="modal fade" id="modalDelete" role="dialog">
    	<div class="modal-dialog">
    
      	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 class="modal-title">Voulez-vous vraiment supprimer cette news ?</h4>
	        	</div>

		        <form id="modal-form" class="modal-form" method="post" action="">
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

@stop