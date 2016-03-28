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
			<h2><a title="Cliquez pour voir la news en entier" href="{{ url('news/view/'.$news['slug']) }}">{{ucfirst($news->title)}}</a></h2>
				@if(Auth::check() && Auth::user()->level_id >= 3)
					<div class="manage">
						<a class="glyphicon glyphicon-pencil" href="{{ url('admin/news/edit/'.$news['slug']) }}"></a>				
						<button 
								onclick="dialog(this)" 
								id="{{ $news->id }}" 
								link="{{ url('admin/news/delete') }}" 
								class="glyphicon glyphicon-trash" >
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
  	<div class="modal fade" id="myModal" role="dialog">
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
			         	<input hidden value="" name="news_id" id="news_id" />
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
		function dialog(el)
		{
			var id = el.getAttribute('news-id');
			var link = el.getAttribute('link');

			$('#modal-form').attr('action', link);
			$('#news_id').attr('value', id);
			$('#myModal').modal('toggle');
		}
</script>

@stop