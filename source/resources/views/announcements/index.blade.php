{{-- 
	Index des news
	Tu listes toutes les news avec un @forelse (regarde la doc, le forelse est super pratique). Variable : $news. tu récuperes les infos avec $news->title, $news->content (a la place de $news c'est la variable du foreach biensur) etc...
	Si l'utilisateur a un level > 0 ( @if(Auth::user()->level > 0) ) , tu rajoutes qqch pour modifier, qui link vers events/edit/slug avec slug qui est le slug de l'événement
 --}}

@extends('layouts.app')

@section('title')
	Annonces
@stop

@section('content')

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
			    	<td>{!! printUserLinkV2($a->author) !!}</td>
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

	<div align="right">
		{!! $announcements->render() !!}
	</div>
</div>

@endsection 