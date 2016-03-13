<?php 
  $notifications = 0;
  if(Auth::check())
  {
    $notifications = App\Notification::where('user_id', Auth::user()->id)->where('new', 1)->count();
  }
?>

<nav class="navbar-default navbar-admin">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ url('admin') }}"><span class="glyphicon glyphicon-wrench"></span> &nbsp;Back Office </a>
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
            <li><a href="{{ url('admin/announcements') }} ">Annonces</a></li>
            <li><a href="{{ url('admin/articles') }}">Articles</a></li>
            <li><a href="{{ url('admin/categories') }}">Catégories</a></li>
            <li><a href="{{ url('admin/courses') }}">Cours</a></li>
            <li><a href="{{ url('admin/documents') }}">Document de cours</a></li>
            <li><a href="{{ url('admin/events') }}">Événements</a></li>
            <li><a href="{{ url('admin/bands') }}">Groupes</a></li>
            <li><a href="{{ url('admin/instruments') }}">Instruments</a></li>
            <li><a href="{{ url('admin/users') }}">Membres</a></li>
            <li><a href="{{ url('admin/news') }}">News</a></li>
            @if(Auth::user()->level->level > 1)
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
          <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-expanded="false">  <span class="glyphicon glyphicon-user">
                @if($notifications > 0)
                <span class="notification-number">
                  {{ $notifications }}      
                </span>
                @endif
          </span><span class="caret"></span></a>
          <ul class="dropdown-menu user-menu" role="menu">
            <li> <a href="{{ url('users/'.Auth::user()->slug) }}"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->first_name.' '.Auth::user()->last_name }}</a></li>
      @if(Auth::user()->level->level > 0)
            <li><a href=" {{ url('/') }} " class="admin-link"> <span class="glyphicon glyphicon-home"></span> Quitter le back office</a></li>
            @endif
            <li><a href="{{ url('notifications') }}"> 
              <span class="glyphicon glyphicon-bell">
                @if($notifications > 0)
                <span class="notification-number">
                  {{ $notifications }}      
                </span>
                @endif
              </span> Notifications</a>
            </li>
            <li><a href="{{ url('auth/logout') }}"> <span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>
          </ul>
        </li>
      @endif
      </ul>
    </div>
  </div>
</nav>  