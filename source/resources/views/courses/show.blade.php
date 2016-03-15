
@extends('layouts.app')

@section('content')
	
	<div class="jumbotron course-sheet">
		<div class="row">
			<div class="menu col-lg-3">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#article" data-toggle="tab" aria-expanded="true">Présentation</a></li>
				<li><a href="#members" data-toggle="tab" aria-expanded="true" href="#">Membres</a></li>
				<li><a href="#teachers" data-toggle="tab" aria-expanded="true" href="#">Professeurs</a></li>
				<li><a href="#infos" data-toggle="tab" aria-expanded="true" href="#">Infos Complémentaires</a></li>
				<li><a href="#photos" data-toggle="tab" aria-expanded="true" href="#">Photos</a></li>
				<li 
					@if( Auth::guest() || !($course->users->contains(Auth::user()) || $course->teachers->contains(Auth::user()) || Auth::user()->level_id > 3)) 
						class="disabled" title="Vous devez être inscit à ce cours ou être administrateur pour voir les documents de ce cours"
					@endif 
					>
					<a href="#documents" data-toggle="tab" aria-expanded="true" href="#">Documents</a>
				</li>
				@if( Auth::check() && ($course->teachers->contains(Auth::user()) || Auth::user()->level_id > 3)) 
					<li><a href="#modifications" data-toggle="tab" aria-expanded="true" href="#">Modifications</a></li>
				@endif
			</ul>
			</div>	
			<div class="col-lg-9">
				<h1 align="center">{{ ucfirst($course->name) }}</h1>
				<h4 align="center" class="help-block"><i>Responsable : {!! printUserLinkV2($course->manager) !!}</i></h4>
				<div class="tab-content" id="myTabContent">
					
					<div id="article" class="tab-pane fade in article active" >
						{!! $course->article->content !!}
					</div>
					
					<div id="members" class="tab-pane fade in members" >
						@foreach($course->users as $m)
							<div class="member">
								<p align="center"><img class="profil-picture" src="{{ URL::asset('img/profil_pictures/'.$m->profil_picture) }}" /></p>
								<p align="center"><a href="{{ url('users/'.$m->slug) }}">{{ $m->first_name }}</a> </p>
							</div>
						@endforeach
					</div>
					
					<div id="teachers" class="tab-pane fade in teachers members" >
						@foreach($course->teachers as $m)
							<div class="member">
								<p align="center"><img class="profil-picture" src="{{ URL::asset('img/profil_pictures/'.$m->profil_picture) }}" /></p>
								<p align="center"><a href="{{ url('users/'.$m->slug) }}">{{ $m->first_name }}</a> </p>
							</div>
						@endforeach
					</div>
					
					<div id="photos" class="tab-pane fade in photos" >
						@foreach ($course->article->images as $i)
								<img title="{{ $i->description }}" data-title="{{ $i->title }}" class="article-picture" src="{{ URL::asset('img/article_pictures/'.$i->name) }}" onclick="modalPicture(this)" />
						@endforeach
						<a class="all" href="{{ url('articles/view/'.$course->article->slug.'/gallery') }}">Tout voir</a>
					</div>
					
					<div id="infos" class="tab-pane fade in infos" >
						
					</div>
					
					<div id="documents" class="tab-pane fade in documents" >
						
					</div>
					
					<div id="modifications" class="tab-pane fade in modifications" >
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalPicture" role="dialog">
		<div class="modal-picture">

	  	<!-- Modal content-->
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>

		        <div class="modal-body">
		        	<img id="picture" src="">
        			<p id="description"></p>
		        </div>
		</div>
	</div>

@stop

@section('js')

<script type="text/javascript">
	function modalPicture(el)
	{
		var src = el.getAttribute('src');

		$('#modalPicture .modal-body #picture').attr('src', src);
		$('#modalPicture').modal('show');
	}

	$('#modalPicture .modal-body #picture').click(function() {
		$('#modalPicture').modal('hide');
	});

</script>

@stop