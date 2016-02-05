{{-- 
	Index des news
	Tu listes toutes les news avec un @forelse (regarde la doc, le forelse est super pratique). Variable : $news. tu récuperes les infos avec $news->title, $news->content (a la place de $news c'est la variable du foreach biensur) etc...
	Si l'utilisateur a un level > 0 ( @if(Auth::user()->level > 0) ) , tu rajoutes qqch pour modifier, qui link vers events/edit/slug avec slug qui est le slug de l'événement
 --}}

@extends('layouts.app')

@section('content')
<h1 style="text-align: center">Annonces</h1>
@if(isset($announcements))
	@forelse($announcements as $a)
		<div style="border: 3px solid rgb(195,195,195); padding-right: 15px; padding-left: 15px;">
			<h2>{{$n['title']}}</h2>
			<p>{{$n['content']}} <br/>
				<div style="color: gray; text-align: right; font-size: 12px; font-style: italic">Créée par <a style="color:inherit" href="{{ url('user/'.App\User::where('id', $a['user_id'])->first()->slug)}}"><b>{{ App\User::where('id', $a['user_id'])->first()->first_name }}</b></a> le {{date_format($a['created_at'], 'd/m/Y')}}<br/>
				@if(Auth::check() && (Auth::user()->level >= 1 || (Auth::user()->first_name == App\User::where('id', $a['user_id'])->first()->first_name && Auth::user()->last_name == App\User::where('id', $a['user_id'])->first()->last_name)))
					<a href="{{ url('announcements/edit/'.$a['slug']) }}">Modifier l'annonce</a>
					<div align="right"><a href="{{ url('announcements/delete/'.$a['slug']) }}" style="color: inherit"><span class="glyphicon glyphicon-remove"></span></a></div>
				@endif
				</div>
			</p>
		</div>
		<br/>	
	@empty
	@endforelse
	@else
    <li class="list-group-item"><p>Pas d'annonce pour le moment.</p></li>  
@endif

<div style="text-align: right">
	<ul class="pagination pagination-sm">
	  <li class="disabled"><a href="#">&laquo;</a></li>
	  <li class="active"><a href="#">1</a></li>
	  <li><a href="#">2</a></li>
	  <li><a href="#">3</a></li>
	  <li><a href="#">4</a></li>
	  <li><a href="#">5</a></li>
	  <li><a href="#">&raquo;</a></li>
	</ul>
</div>

@endsection 