{{-- 
	Index des news
	Tu listes toutes les news avec un @forelse (regarde la doc, le forelse est super pratique). Variable : $news. tu récuperes les infos avec $news->title, $news->content (a la place de $news c'est la variable du foreach biensur) etc...
	Si l'utilisateur a un level > 0 ( @if(Auth::user()->level > 0) ) , tu rajoutes qqch pour modifier, qui link vers events/edit/slug avec slug qui est le slug de l'événement
 --}}

@extends('layouts.app')

@section('title')
	Annonces
@stop

@section('breadcrumb')
    <li class="active">Annonces</li>
@stop

@section('content')
	<div class="jumbotron">
		@if(Auth::check()	)
			@if(Auth::user()->level_id > 2)
				<a href="{{ url('admin/announcements') }}" title="Gérer les annonces" class="{{ glyph('cog') }}"></a>
			@endif
		@endif		
		<h1 >Les annonces !</h1>
		<p>Voici les annonces postées par les membres.</p>
		<p>Cliquez sur le titre d'une annonce pour la voir en entier.</p>
		<p>Vous souhaitez vendre ou acheter du matériel de musique ? Vous cherchez un groupes, ou des membres pour en monter un ? Publiez une annonce, les autres utilisateurs pourront y répondre en commentaire !</p>
		<hr class="colorgraph" />
		<p>Pour créer une annonce : <a href="{{url('announcements/create')}}" title="Créer une annonce">Cliquez ici !</a></p>		
	</div>
	<div class="row">
		<div align="center" class="col-lg-4 col-lg-offset-4">
			<h3 class="control-label">Fitlrer par catégorie :</h3>
			<select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
				<option disabled selected>Sélectionnez une catégorie...</option>
				<option value="0">Tout voir</option>
				@foreach(App\Category::with(['announcements' => function($query) { $query->validated(); }])->get() as $c)
					<option value="{{ url('announcements/list/category/'.$c->id) }}">{{ ucfirst($c->name) }} ({{ $c->announcements->count() }})</option>
				@endforeach
			</select>
			<br />
		</div>
	</div>
	<div class="row">
		@if(isset($announcements))
			<div class="announcement-list">
				@foreach($announcements as $a)
					<blockquote class="comment announcement col-lg-10 col-lg-offset-1">	
				    	<h2><a href="{{ url('announcements/view/'.$a->slug)}}">{{ucfirst($a->title)}}</a></h2>
<!-- 				    	<h3>{{$a->subject}}</h3>
 -->				    	<span class="help-block"><i>Catégorie : <a title="N'afficher que les annonces de cette catégorie" href="{{ url('announcements/list/category/'.$a->category->id) }}">{{ucfirst($a->category->name)}}</a></i></span>
				    	<p>{!! cut($a->content, 520, 'announcements/view/'.$a->slug) !!}</p>
				    	<hr class="colorgraph"/>
				    	<span class="announcement-infos announcement-index-infos">Rédigé le {{date_format($a['created_at'], 'd/m/Y \à H:i')}} Par {!! printUserLinkV2($a->author) !!} </span>
				    	<span class="nb-comments announcement-infos">
				    		Commentaires : {{ $a->comments->count() }}
				    	</span>
				    </blockquote>
				@endforeach
			</div>
		@else
		    <li class="list-group-item"><p>Aucune annonce n'a été publiée pour le moment.</p></li>  
		@endif

		<div align="right">
			{!! $announcements->render() !!}
		</div>
	</div>
@endsection 