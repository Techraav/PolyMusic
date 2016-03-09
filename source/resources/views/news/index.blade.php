{{-- 
	Index des news
	Tu listes toutes les news avec un @forelse (regarde la doc, le forelse est super pratique). Variable : $news. tu récuperes les infos avec $news->title, $news->content (a la place de $news c'est la variable du foreach biensur) etc...
	Si l'utilisateur a un level > 0 ( @if(Auth::user()->level > 0) ) , tu rajoutes qqch pour modifier, qui link vers events/edit/slug avec slug qui est le slug de l'événement
 --}}

@extends('layouts.app')

@section('title')
	News
@stop

@section('content')
<h1 style="text-align: center">News</h1>
	@forelse($news as $n)
		<div class="frame-news">
			<h2><a href="{{ url('news/view/'.$n['slug'])}}">{{$n['title']}}</a>
				@if(Auth::check() && Auth::user()->level->level >= 1)
					<a class="glyphicon glyphicon-pencil" href="{{ url('admin/news/edit/'.$n['slug']) }}"></a>				
					<button onclick="dialog(this)" news-id="{{ $n->id }}" link="{{ url('admin/news/delete/'.$n->id) }}" class="glyphicon glyphicon-trash" ></button>
				@endif
			</h2>
			<p>{!! $n['content'] !!} <br/>
				<div class="news-datas" align="right">Créée par 
					<b>{!! printUserLinkV2($n->author) !!}</b> le {{date_format($n['created_at'], 'd/m/Y')}}
				</div>
			</p>
		</div>
		<br/>	
	@empty
    	<h3 align="center"><i>Pas de news pour le moment.</i></h3>
	@endforelse

	<div align="right">
		{!! $news->render() !!}
	</div>

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