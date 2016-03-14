@extends('layouts.app')

@section('content')
	
	<div class="jumbotron course-sheet">
		<div class="row">
			<div class="menu col-lg-3">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#article" data-toggle="tab" aria-expanded="true">Présentation</a></li>
				<li><a href="#members" data-toggle="tab" aria-expanded="true" href="#">Membres</a></li>
				<li><a href="#teachers" data-toggle="tab" aria-expanded="true" href="#">Professeurs</a></li>
				<li><a href="#photos" data-toggle="tab" aria-expanded="true" href="#">Photos</a></li>
				<li><a href="#infos" data-toggle="tab" aria-expanded="true" href="#">Infos Complémentaires</a></li>
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
					
					<div id="article" class="tab-pane fade in article" >
						azertyuio
					</div>
					
					<div id="members" class="tab-pane fade in members" >
						sdfghjkl
					</div>
					
					<div id="teachers" class="tab-pane fade in teachers" >
						xcvbn,;:!
					</div>
					
					<div id="photos" class="tab-pane fade in photos" >
						
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

@stop
