<?php 
  $notifications = 0;
  if(Auth::check())
  {
    $notifications = App\Notification::where('user_id', Auth::user()->id)->where('new', 1)->count();
  }
?>

<nav class="navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/"><span class="glyphicon glyphicon-music"></span> &nbsp;Team Musique </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="{{ url('courses/list') }}"> Les cours</a></li>
        <!-- <li><a href="#">Nos professeurs </a></li> -->
        <li><a href="{{ url('news') }}">L'actu </a></li>
        <li><a href="{{ url('articles/list') }}">Articles </a></li>
        <li><a href="{{ url('announcements/list') }}">Annonces </a></li>
        <li class="disabled" title="Bientôt disponible..."><a href="#">Événements </a></li>
        <li title="Bientôt disponible..."><a href="{{ url('bands/list') }}">Les Groupes </a></li>
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Nous rejoindre <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Professeur</a></li>
            <li><a href="#">Élève</a></li>
          </ul>
        </li> -->
        <!-- <li><a href="#">Nous contacter </a></li> -->
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
			     @if(Auth::user()->level_id > 2)
           	<li><a href=" {{ url('admin') }} " class="admin-link"> <span class="glyphicon glyphicon-cog"></span> Administration</a></li>
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