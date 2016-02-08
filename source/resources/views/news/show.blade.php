@extends('layouts.app')

@section('content')
<h1 style="text-align: center">News</h1>
@if(isset($news))
	<div style="border: 3px solid rgb(195,195,195); padding-right: 15px; padding-left: 15px;">
		<h2>{{$news->title}}</h2>
		<p>{{$news->content}} <br/>
			<div style="color: gray; text-align: right; font-size: 12px; font-style: italic">Créée par <a style="color:inherit" href="{{ url('user/'.App\User::where('id', $news->user_id)->first()->slug)}}"><b>{{ App\User::where('id', $news->user_id)->first()->first_name }}</b></a> le {{date_format($news->created_at, 'd/m/Y')}}<br/>
			@if(Auth::check() && Auth::user()->level >= 1)
				<a href="{{ url('teacher/news/edit/'.$news->slug) }}">Modifier la news</a>
				<div align="right"><a href="{{ url('teacher/news/delete/'.$news->slug) }}" style="color: inherit"><span class="glyphicon glyphicon-remove"></span></a></div>
			@endif
			</div>
		</p>
	</div>
	<br/>	
@else
    <li class="list-group-item"><p>Cette news n'existe pas.</p></li>  
@endif

@endsection