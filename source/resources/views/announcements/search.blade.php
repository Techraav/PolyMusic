@extends('layouts.app')

@section('title')
    Rechercher une annonce
@stop

@section('breadcrumb')
    <li> <a href="{{ url('announcements/list') }}">Annonces</a></li>
    <li class="active">Recherche</li>
@stop

@section('content')

	<div class="row">
		<h1 align="center">Rechercher une annonce </h1>
	    <div class="search-fieldset col-lg-6 col-lg-offset-3">
	      <!-- <h1 class="search-title">Rechercher un cours</h1> -->
	      <form action="{{ url('announcements/search') }}" method="get">
	        <div class="form-group">
	          <div class="input-group"> 
	            <input class="form-control input-sm" name="search" type="text" placeholder="Titre, auteur..." value="{{$search}}" />
	            <span class="input-group-btn">
	              <button class="btn btn-primary btn-sm" type="submit"><span class="{{ glyph('search') }}"></span></button>
	            </span>       
	          </div>
	        </div>
	      </form>
	    </div>
	</div>	

    <div class="row">
    	<h2 align="center"> Résultats pour &laquo; {{ $search }} &raquo; :</h2>
    	<br />


    	<div class="row">
    		<div class="col-lg-6">
    			{{-- CoursesTitle --}}
                <h4 align="center">Annonces :</h4>

    			<ul class="list-group">
    				<!-- <a class="list-group-item"></a> -->
    				<ul align="center" class="list-group">
    					@forelse($announcements as $a)
                            @if ($a->validated == 0)
                                @if(Auth::check() && Auth::user()->level_id > 2)
                                <a href="{{ url('announcements/view/'.$a->slug) }}" class="list-group-item">{{ ucfirst($a->title) }}
                                    <span class="unvalidated">Non validée</span>
                                </a>
                                @endif
                            @else
                                <a href="{{ url('announcements/view/'.$a->slug) }}" class="list-group-item">{{ ucfirst($a->title) }}</a>
                            @endif
    					@empty
    						<li class="list-group-item" align="center">-</li>
    					@endforelse
    				</ul>
    			</ul>
                <br />

    		</div>

    		<div class="col-lg-6">
    			{{-- Users --}}
                <h4 align="center"> Auteurs :</h4>
                
    			<ul class="list-group">
    				@foreach($users as $u)
    					@if($u->announcements->count() > 0)
		    				<a class="list-group-item list-head" align="center" href="{{ url('users/'.$u->slug) }}">{{ $u->first_name.' '.$u->last_name }}</a>
		    				<ul align="center" class="list-group">
		    					@foreach($u->announcements as $a)

                                    @if ($a->validated == 0)
                                        @if(Auth::check() && Auth::user()->level_id > 2)
                                        <a href="{{ url('announcements/view/'.$a->slug) }}" class="list-group-item">{{ ucfirst($a->title) }}
                                            <span class="unvalidated">Non validée</span>
                                        </a>
                                        @endif
                                    @else
                                        <a href="{{ url('announcements/view/'.$a->slug) }}" class="list-group-item">{{ ucfirst($a->title) }}</a>
                                    @endif
		    					@endforeach
		    				</ul>
		    			@endif
    				@endforeach

    			</ul> 
                <br />
    		</div>

    	</div>
    </div>
@stop