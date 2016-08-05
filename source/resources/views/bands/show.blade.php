@extends('layouts.app')

@section('title')
	{{ ucfirst($band->name) }}
@stop

@section('breadcrumb')
    <li> <a href="{{ url('bands') }}">Groupes</a></li>
    <li class="active">{{ ucfirst($band->name) }} </li>
@stop

@section('content')

	<div class="jumbotron band-sheet">
		<div class=" row">
			<div class="col-lg-4 left">
				<h1 align="center">{{ ucfirst($band->name) }}</h1>
				<span class="help-block">Manager : {!! printUserLinkV2($band->manager) !!}</span>
		<!-- 		<br />
				<br /> -->
				<p align="center"><img class="band-picture" width="250" src=" {{ URL::asset('/img/band_pictures/'.$band->image) }} " /></p>
				<hr/>
				<h3 align="center">Gallerie</h3>
				<div class="images" align="center">
				@if($band->article->images->count() > 0)
					@foreach($band->article->images as $i)
						<img src="{{ URL::asset('img/article_pictures/'.$i->name) }}" />
					@endforeach
					<a class="all" href="{{ url('/articles/view/'.$band->article->slug.'/gallery') }} ">Tout Voir</a>
				@else
					<span class="empty">Aucune image pour le moment.</span>
				@endif
				</div>
			</div>
			<div class="col-lg-8 right">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#members" data-toggle="tab" aria-expanded="true">Membres</a></li>
					<li><a href="#infos" data-toggle="tab">Informations</a></li>
					<li><a href="#events" data-toggle="tab">Événements</a></li>
				</ul>
				<div class="tab-content">
					<div id="members" class="tab-pane fade active in members" >
						<!-- <h2 align="center">Membres :</h2> -->

						@foreach($band->members as $m)
							<a href="{{ url('users/'.$m->slug) }}" class="member">
								<p align="center"><img class="profil-picture" src="{{ URL::asset('img/profil_pictures/'.$m->profil_picture) }}" /></p>
								<p align="center" class="name"> {{ $m->first_name.' '.$m->last_name }} </p>
								<p class="instrument" align="center"><i>{{ App\BandUser::where('user_id', $m->id)->where('band_id', $band->id)->first()->instrument->name }}</i></p>
								@if ($m->id == $band->user_id)
									<p align="center"<span class="help-block inline">(Manager)</span></p>
								@endif
							</a>
						@endforeach
					</div>
					<div id="infos" class="tab-pane fade">
						{!! $band->article->content !!}
					</div>
					<div id="events" class="tab-pane fade">
						@forelse($band->events as $e)
							<a href="{{ url('events/show/'.$e->slug) }}" class="band-event">
								<p class="name">{{ucfirst($e->name)}}</p>
								<p class="where">{{ $e->location }}</p>
								<p class="when">{{ ucfirst(day($e->day))}} {{ $e->date->format('d/m/Y') }}, {{$e->start}} - {{$e->end}}</p>
							</a>
						@empty
							Aucun événement enregistré pour ce groupe.
						@endforelse

						<div class="see-all" align="right"><a href="{{ url('bands/'.$band->id.'/events') }}"><span class="{{ glyph('arrow-right') }}"></span>Voir tous les événements</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop