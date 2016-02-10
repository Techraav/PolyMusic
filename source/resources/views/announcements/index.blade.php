{{-- 
	Index des news
	Tu listes toutes les news avec un @forelse (regarde la doc, le forelse est super pratique). Variable : $news. tu récuperes les infos avec $news->title, $news->content (a la place de $news c'est la variable du foreach biensur) etc...
	Si l'utilisateur a un level > 0 ( @if(Auth::user()->level > 0) ) , tu rajoutes qqch pour modifier, qui link vers events/edit/slug avec slug qui est le slug de l'événement
 --}}

@extends('layouts.app')

@section('content')
<<<<<<< HEAD
<h1 style="text-align: center">Annonces</h1>
@if(isset($announcements))
	@forelse($announcements as $a)
		<div style="border: 3px solid rgb(195,195,195); padding-right: 15px; padding-left: 15px;">
			<h2>{{$a['title']}}</h2>
			<p>{{$a['content']}} <br/>
				<div style="color: gray; text-align: right; font-size: 12px; font-style: italic">Créée par 
					<a style="color:inherit" href="{{ url('user/'.App\User::where('id', $a['user_id'])->first()->slug)}}">
						<b>{{ App\User::where('id', $a['user_id'])->first()->first_name }}</b>
					</a> le {{date_format($a['created_at'], 'd/m/Y')}}<br/>
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
=======
<div class="container">	
	<h1 style="text-align: center">Annonces</h1>
	@if(isset($announcements))
		<table class="table table-striped table-hover ">
			<thead>
			    <tr>
				    <th width="150">Date</th>
				    <th width="300">Auteur</th>
				    <th>Titre</th>
				    <th width="200">Objet</th>
			    </tr>
		 	</thead>	
			<tbody>
			@forelse($announcements as $a)
				<tr>
			    	<td>{{date_format($a['created_at'], 'd/m/Y')}}</td>
			    	<td><a href="{{ url('user/'.App\User::where('id', $a['user_id'])->first()->slug)}}">{{App\User::where('id', $a['user_id'])->first()->first_name}} {{App\User::where('id', $a['user_id'])->first()->last_name}}</a></td>
			    	<td><a href="{{ url('announcements/view/'.$a['slug'])}}">{{ucfirst($a['title'])}}</a></td>
			    	<td>{{$a['subject']}}</td>
			    </tr>
		@empty
			<tr>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tr>
		@endforelse
			</tbody>
		</table>
	@else
	    <li class="list-group-item"><p>Pas d'annonce pour le moment.</p></li>  
	@endif
>>>>>>> 01aca3a4181104c90d3ba699aa11978af496a0fa

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
</div>

@endsection 