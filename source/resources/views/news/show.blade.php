@extends('layouts.app')

@section('title')
	{{ ucfirst($news['title']) }}
@stop

@section('content')
<h1 style="text-align: center">News</h1>
		<div class="frame-news">
			<h2><a href="{{ url('news/view/'.$news['slug'])}}">{{$news['title']}}</a>
				@if(Auth::check() && Auth::user()->level->level >= 1)
					<a class="glyphicon glyphicon-pencil" href="{{ url('admin/news/edit/'.$news['slug']) }}"></a>				
					<button onclick="dialog(this)" news-id="{{ $news->id }}" link="{{ url('admin/news/delete/'.$news->id) }}" class="glyphicon glyphicon-trash" ></button>
				@endif
			</h2>
			<p>{!! $news['content'] !!} <br/>
				<div class="news-datas" align="right">Créée par 
					<b>{!! printUserLinkV2($news->author) !!}</b> le {{date_format($news['created_at'], 'd/m/Y')}}
				</div>
			</p>
		</div>
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