@extends('layouts.app')

@section('title')
	LES NEEEEEEEEEEEWS
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
				<a href="{{ url('user/'.App\User::where('id', $news['user_id'])->first()->slug)}}">
					<b>{{ App\User::where('id', $news['user_id'])->first()->first_name }}</b>
				</a> le {{date_format($news['created_at'], 'd/m/Y')}}
			</div>
		</p>
	</div>
	<br/>	
@else
    <li class="list-group-item"><p>Cette news n'existe pas.</p></li>  
@endif

@endsection