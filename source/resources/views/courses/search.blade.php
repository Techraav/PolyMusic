@extends('layouts.app')

@section('title')
    Rechercher un cours
@stop

@section('breadcrumb')
    <li> <a href="{{ url('courses/list') }}">Cours</a></li>
    <li class="active">Recherche</li>
@stop

@section('content')

	<div class="row">
		<h1 align="center">Rechercher un cours </h1>
	    <div class="search-fieldset col-lg-6 col-lg-offset-3">
	      <!-- <h1 class="search-title">Rechercher un cours</h1> -->
	      <form action="{{ url('courses/search') }}" method="get">
	        <div class="form-group">
	          <div class="input-group"> 
	            <input class="form-control input-sm" name="search" type="text" placeholder="Rechercher un cours..." value="{{$search}}" />
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
                <h4 align="center">Cours :</h4>

    			<ul class="list-group">
    				<!-- <a class="list-group-item"></a> -->
    				<ul align="center" class="list-group">
    					@forelse($coursesTitle as $c)
                            @if ($c->active == 0)
                                @if(Auth::check() && Auth::user()->level_id > 2)
                                    <a href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{{ ucfirst($c->name) }}
                                        <span class="unvalidated">Non validé</span>
                                    </a>
                                @endif
                            @else
                                <a href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{{ ucfirst($c->name) }}</a>
                            @endif
    					@empty
    						<li class="list-group-item" align="center">-</li>
    					@endforelse
    				</ul>
    			</ul>
                <br />

    		</div>
    		<div class="col-lg-6">
    			{{-- CoursesDay --}}
                <h4 align="center">Jours : <i>{{ $day === -1 ? '-' : ucfirst(day($day)) }}</i></h4>

    			<ul class="list-group">
<!--     				<li class="list-group-item list-head"></li>
 -->    				<ul align="center" class="list-group">
    					@forelse($coursesDay as $c)
                            @if ($c->active == 0)
                                @if(Auth::check() && Auth::user()->level_id > 2)
                                    <a href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{{ ucfirst($c->name) }}
                                        <span class="unvalidated">Non validé</span>
                                    </a>
                                @endif
                            @else
                                <a href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{{ ucfirst($c->name) }}</a>
                            @endif
    					@empty
    						<li class="list-group-item" align="center">-</li>
    					@endforelse
    				</ul>
    			</ul>
                <br />    		
    		</div>
    	</div>

    	<div class="row">
    		<div class="col-lg-6">
    			{{-- Users --}}
                <h4 align="center"> Professeurs :</h4>
                
    			<ul class="list-group">
    				@foreach($users as $u)
    					@if($u->courses->count() > 0)
		    				<a class="list-group-item list-head" align="center" href="{{ url('users/'.$u->slug) }}">{{ $u->first_name.' '.$u->last_name }}</a>
		    				<ul align="center" class="list-group">
		    					@foreach($u->courses as $c)
                                    @if ($c->active == 0)
                                        @if(Auth::check() && Auth::user()->level_id > 2)
                                            <a href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{{ ucfirst($c->name) }}
                                                <span class="unvalidated">Non validé</span>
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{{ ucfirst($c->name) }}</a>
                                    @endif
		    					@endforeach
		    				</ul>
		    			@endif
    				@endforeach

    			</ul> 
                <br />
    		</div>
    		<div class="col-lg-6">
    			{{-- Instruments --}}
                <h4 align="center">Instruments :</h4>
                
    			<ul class="list-group">
    				@foreach($instruments as $i)
    					@if($i->courses->count() > 0)
		    				<li align="center" class="list-group-item list-head">{{ ucfirst($i->name) }}</li>
		    				<ul align="center" class="list-group">
		    					@foreach($i->courses as $c)
                                    @if ($c->active == 0)
                                        @if(Auth::check() && Auth::user()->level_id > 2)
                                            <a href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{{ ucfirst($c->name) }}
                                                <span class="unvalidated">Non validé</span>
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{{ ucfirst($c->name) }}</a>
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