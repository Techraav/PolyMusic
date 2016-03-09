@extends('layouts.app')

@section('title')
	{{ucfirst($article->title)}}
@endsection

@section('content')
<div class="jumbotron">
	<div class="post-content">
		<h1 align="center">{{ ucfirst($article->title) }}</h1>
		@if($article->user_id == Auth::user()->id || Auth::user()->level->level > 3)
			<div class="manage">
				<a href="{{ url('admin/articles/edit/'.$article->slug) }}" class="btn-edit glyphicon glyphicon-pencil"></a>
			</div>
		@endif
		<span class="announcement-content">
		<h2 align="center"><i>Sujet : {{ ucfirst($article->subtitle) }}</i></h3>
		<br />
			{!! $article->content !!}
		</span>
		<br />
		<p align="right" class="announcement-infos">Rédigé par {!! printUserLinkV2($article->author) !!}, le {{ date_format($article['created_at'], 'd/m/Y') }}</p>
	</div>	
</div>
@stop