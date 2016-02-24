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
@if(isset($news))
	@forelse($news as $n)
		<div class="frame-news">
			<h2><a href="{{ url('news/view/'.$n['slug'])}}">{{$n['title']}}</a>
				@if(Auth::check() && Auth::user()->level->level >= 1)
					<a class="icon" href="{{ url('admin/news/edit/'.$n['slug']) }}"><span class="glyphicon glyphicon-pencil"></span></a>				
					<a class="icon" href="{{ url('admin/news/delete/'.$n['slug']) }}"><span class="glyphicon glyphicon-trash"></span></a>
				@endif
			</h2>
			<p>{!! $n['content'] !!} <br/>
				<div class="news-infos" align="right">Créée par 
					<b>{!! printUserLink($n->user_id) !!}</b> le {{date_format($n['created_at'], 'd/m/Y')}}
				</div>
			</p>
		</div>
		<br/>	
	@empty
	@endforelse
@else
    <li class="list-group-item"><p>Pas de news pour le moment.</p></li>  
@endif

	<div align="right">
		{!! $news->render() !!}
	</div>

@endsection