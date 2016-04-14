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
		<p>Vous souhaitez vendre ou acheter du matériel de musique ? Vous cherchez un groupe, ou des membres pour en monter un ? Publiez une annonce, les autres utilisateurs pourront y répondre en commentaire !</p>
		<hr class="colorgraph" />
		<p>Pour créer une annonce : <a href="{{url('announcements/create')}}" title="Créer une annonce">Cliquez ici !</a></p>		
	</div>

	<div class="row">
		<h3 align="center">Rechercher un article </h3>
	    <div class="search-fieldset col-lg-6 col-lg-offset-3">
	      <!-- <h1 class="search-title">Rechercher un cours</h1> -->
	      <form action="{{ url('announcements/search') }}" method="get">
	        <div class="form-group">
	          <div class="input-group"> 
	            <input class="form-control input-sm" name="search" type="text" placeholder="titre, auteur..."/>
	            <span class="input-group-btn">
	              <button class="btn btn-primary btn-sm" type="submit"><span class="{{ glyph('search') }}"></span></button>
	            </span>       
	          </div>
	        </div>
	      </form>
	    </div>
	</div>

	<div class="row">
		<div align="center" class="col-lg-6 col-lg-offset-3">
			<h3 class="control-label">Fitlrer par catégorie :</h3>
			<select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
				<option disabled selected>Sélectionnez une catégorie...</option>
				<option value="{{ url('announcements/list/category/0') }}">Tout voir</option>
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
						@if(Auth::check() && Auth::user()->level_id >= 3)
							<div class="manage">
								<button
										data-link="{{ url('announcements/delete') }}"
										data-id="{{ $a->id }}"
										title="Supprimer l'annonce"
										class="{{ glyph('trash') }} delete-button">
								</button>
								<a class="glyphicon glyphicon-pencil" href="{{ url('announcements/edit/'.$a->slug) }}"></a>
							</div>
						@endif
{{-- 				    	<h3>{{$a->subject}}</h3>
--}}			    	<span class="help-block"><i>Catégorie : <a title="N'afficher que les annonces de cette catégorie" href="{{ url('announcements/list/category/'.$a->category->id) }}">{{ucfirst($a->category->name)}}</a></i></span>
				    	<p>{!! cut($a->content, 540, 'announcements/view/'.$a->slug) !!}</p>
				    	<hr class="colorgraph"/>
				    	<span class="post-infos announcement-index-infos">Rédigé le {{date_format($a['created_at'], 'd/m/Y \à H:i')}} par {!! printUserLinkV2($a->author) !!} </span>
				    	<span class="nb-comments post-infos">
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

		<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer une annonce</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-danger"><b>Attention ! Cette action est irréversible !</b></p>
			         	<input hidden value="" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" class="btn btn-primary">Supprimer</button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>
@endsection 