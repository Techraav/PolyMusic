<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>PolyMusic | Admin </title>
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
          <a class="navbar-brand" href="{{ url('admin') }} ">Back Office</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="{{ url('admin') }}">Accueil </a></li>
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
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Gérer <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ url('admin/announcements') }} ">Annonces</a></li>
                <li><a href="{{ url('admin/articles') }}">Articles</a></li>
                <li><a href="{{ url('admin/courses') }}">Cours</a></li>
                <li><a href="{{ url('admin/departments') }}">Départements</a></li>
                <li><a href="{{ url('admin/documents') }}">Document de cours</a></li>
                <li><a href="{{ url('admin/events') }}">Événements</a></li>
                <li><a href="{{ url('admin/bands') }}">Groupes</a></li>
                <li><a href="{{ url('admin/instruments') }}">Instruments</a></li>
                <li><a href="{{ url('admin/levels') }}">Levels</a></li>
                <li><a href="{{ url('admin/members') }}">Les membres</a></li>
                <li><a href="{{ url('admin/news') }}">News</a></li>
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
                <li><a href="#">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></li>
                <li><a href="{{ url('') }}" class="admin-link">Retour sur le site</a></li>
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
  <div class="col-md-9">
  <div class="container">
    @include('flash::message')
    @yield('content')
  </div>
  </div>
    {{-- SIDEBAR --}}
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Administration
            </div>
            <div class="panel-body">
                Bienvenue sur la zone d'administration du site.
            </div>
            <ul class="list-group">
            
            </ul>
        </div>
        <div class="panel panel-default panel-modifications">
            <div class="panel-heading">
                Dernières modifications
            </div>
            <ul class="list-group">
                @forelse( App\Modification::orderBy('id', 'desc')->limit(5)->get() as $m)
                <li class="list-group-item">
                	<ul class="list-group">
                		<li class="list-group-item">
                			<b>Par</b> : <a href="{{ url('users/'.App\User::where('id', $m->id)->first()->slug) }}">{{ App\User::where('id', $m->id)->first()->first_name }}</a>, le {{ date_format($m->created_at, 'd/m/Y') }} à {{ date_format($m->created_at, 'H:i:s') }} 
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
    @yield('js') 
    <script src="{{ URL::asset('/js/bootstrap.min.js')  }}"></script>
    <script>
      $('#flash-overlay-modal').modal();
    </script>
  </body>
</html>