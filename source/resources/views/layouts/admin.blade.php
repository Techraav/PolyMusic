<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>PolyMusic | @section('title') Back Office @show </title>
    <!-- Bootstrap CSS served from a CDN -->
    {{-- <link href="https://bootswatch.com/flatly/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="{{ URL::asset('/css/bootstrap.min.css')  }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/style.css')  }}" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar-default navbar-admin">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ url('admin') }}"><span class="glyphicon glyphicon-home"></span> &nbsp;Back Office </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Créer/Ajouter <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ url('admin/articles/create') }} ">Article</a></li>
                <li><a href="{{ url('admin/courses/create') }} ">Cours</a></li>
                <li><a href="{{ url('admin/documents/create') }} ">Document de cours</a></li>
                <li><a href="{{ url('admin/events/create') }} ">Événement</a></li>
                <li><a href="{{ url('admin/news/create') }} ">News</a></li>
              </ul>
            </li>
            {{-- SUBSUBMENU EXAMPLE

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Gérer <span class="caret"></span></a>
	        	<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
					<li class="dropdown-submenu">
	                	<a href="#">Annonces</a>
	                	<ul class="dropdown-menu">
							<li><a href="#">Liste</a></li>
		                  	<li><a href="#">Second level</a></li>
		                  	<li><a href="#">Second level</a></li>
		                </ul>
		            </li>
	            </ul>
	        </li> 

	        --}}
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Gérer <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a style="color:red" href="{{ url('admin/announcements') }} ">Annonces</a></li>
                <li><a style="color:red" href="{{ url('admin/articles') }}">Articles</a></li>
                <li><a href="{{ url('admin/courses') }}">Cours</a></li>
                <li><a style="color:red" href="{{ url('admin/documents') }}">Document de cours</a></li>
                <li><a style="color:red" href="{{ url('admin/events') }}">Événements</a></li>
                <li><a style="color:red" href="{{ url('admin/bands') }}">Groupes</a></li>
                <li><a href="{{ url('admin/instruments') }}">Instruments</a></li>
                <li><a href="{{ url('admin/users') }}">Membres</a></li>
                <li><a style="color:red" href="{{ url('admin/news') }}">News</a></li>
                @if(Auth::user()->level > 1)
                <li class="divider"></li>
                <li><a href="{{ url('admin/departments') }}">Départements</a></li>
                <li><a href="{{ url('admin/levels') }}">Levels</a></li>
                @endif
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          @if(Auth::guest())
            <li><a href="{{url('auth/register')}}">Inscription </a></li>
            <li><a href="{{url('auth/login')}}">Connexion </a></li>
          @else
            <li class="dropdown">
              <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-expanded="false">  <span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>{!! printUserLink(Auth::user()->id) !!}</li>
                <li><a href="{{ url('') }}" class="admin-link">Quitter le back office</a></li>
                <li><a href="{{ url('auth/logout') }}">Déconnexion</a></li>
              </ul>
            </li>
          @endif
          </ul>
        </div>
      </div>
    </nav>
    <br /> 
<div class="row">
  <div class="col-lg-9">
  <div class="container">
    @include('flash::message')
    @yield('content')
  </div>
  </div>
    {{-- SIDEBAR --}}
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p align="center"><i><b>Administration</b></i></p>
            </div>
            <div class="panel-body">
                Bienvenue sur la zone d'administration du site.
            </div>
        </div>

        <div class="panel-default panel panel-course-modif">
        	<div class="panel-heading">
        		    <p align="center"><i><b>Gestion de membres des cours</b></i></p>
                <p class="panel-link"><a align="right" href="{{ url('admin/modifications/courses') }}">Tout voir</a></p>
        	</div>
        		<ul class="list-group">
        			@forelse( App\CourseModification::orderBy('id', 'desc')->limit(15)->get() as $m)
        			<li class="list-group-item modif-{{ $m->value }}">
        			@if(App\Course::where('id', $m->course_id)->first()->user_id == Auth::user()->id)
        				<b>
        			@endif
        				@if($m->value == 0)
        					{!! printUserLink($m->author_id) !!} <i>asked</i> to join course &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
        				@elseif($m->value == 1)
        					{!! printUserLink($m->author_id) !!} <i>canceled</i> his demand to join course &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;.
        				@elseif($m->value == 2)
        					{!! printUserLink($m->author_id) !!} <i>removed</i> {!! printUserLink($m->user_id) !!} from &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
        				@elseif($m->value == 3)
        					{!! printUserLink($m->author_id) !!} <i>added</i> {!! printUserLink($m->user_id) !!} to &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
        				@endif
        			@if(App\Course::where('id', $m->course_id)->first()->user_id == Auth::user()->id)
        				</b>
        			@endif        			
        			</li>
        			@empty
        				<li class="list-group-item" align="center"> - </li>
        			@endforelse
        		</ul>
        </div>


        <div class="panel panel-default panel-modifications">
            <div class="panel-heading">
                <p align="center"><i><b>Dernières modifications</b></i></p>
                <p class="panel-link"><a align="right" href="{{ url('admin/modifications') }}">Tout voir</a> </p>
            </div>
            <ul class="list-group">
                @forelse( App\Modification::orderBy('id', 'desc')->limit(5)->get() as $m)
                <li class="list-group-item">
                	<ul class="list-group">
                		<li class="list-group-item">
                			<b>Par</b> : <a href="{{ url('users/'.App\User::where('id', $m->user_id)->first()->slug) }}">{{ App\User::where('id', $m->user_id)->first()->first_name }}</a>, le {{ date_format($m->created_at, 'd/m/Y') }} à {{ date_format($m->created_at, 'H:i:s') }} 
                		</li>
                		<li class="list-group-item"><b>Table</b> : {{ $m->table }}</li>
                		<li class="list-group-item"><b>Infos</b> : {{ $m->message }}</li>
                	</ul>
                </li>
                @empty
                  <li class="list-group-item"><p>Aucune modification pour le moment.</p></li>                  
                @endforelse
            </ul>
        </div>
    </div>
</div>

    <footer class="footer footer-admin">
        <div class="container">
        </div>
    </footer>


    <script src="{{ URL::asset('/js/jquery.js')  }}"></script>
    <script src="{{ URL::asset('/js/bootstrap.min.js')  }}"></script>
    <script src="{{ URL::asset('/js/bootbox.min.js')  }}"></script>
    @yield('js') 

    <script>
      $('#flash-overlay-modal').modal();
    </script>
  </body>
</html>