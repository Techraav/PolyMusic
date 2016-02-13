@extends('layouts.app')

@section('title')
	{{ucfirst($news['title'])}}
@stop

@section('content')
<h1 align="center">News</h1>
@if(isset($news))
	<div class="frame-news">
		<h2><a href="{{ url('news/view/'.$news['slug'])}}">{{$news['title']}}</a>
			@if(Auth::check() && Auth::user()->level >= 1)
				<a class="icon" href="{{ url('admin/news/edit/'.$news['slug']) }}"><span class="glyphicon glyphicon-pencil"></span></a>	
				<a class="icon" href="{{ url('admin/news/delete/'.$news['slug']) }}"><span class="glyphicon glyphicon-trash"></span></a>
			@endif
		</h2>
		<p>{!!$news['content']!!} <br/>
			<div align="right" class="news-infos">Créée par 
				<b>{!! printUserLink($news->user_id) !!}</b> le {{date_format($news['created_at'], 'd/m/Y')}}
			</div>
		</p>
	</div>
	<br/>	
@else
    <li class="list-group-item"><p>Cette news n'existe pas.</p></li>  
@endif

@endsection