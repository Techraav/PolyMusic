<nav class="navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/"><span class="glyphicon glyphicon-music"></span> &nbsp;PolyMusic </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Les cours <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Présentation</a></li>
            <li><a href="#">Guitare</a></li>
            <li><a href="#">Piano</a></li>
            <li><a href="#">Basse</a></li>
          </ul>
        </li>
        <li><a href="#">Nos professeurs </a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Nous rejoindre <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Professeur</a></li>
            <li><a href="#">Élève</a></li>
          </ul>
        </li>
        <li><a href="#">Nous contacter </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      @if(Auth::guest())
        <li><a href="{{url('auth/register')}}">Inscription </a></li>
        <li><a href="{{url('auth/login')}}">Connexion </a></li>
      @else
        <li class="dropdown">
          <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-expanded="false">  <span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
          <ul class="dropdown-menu user-menu" role="menu">
            <li> <a href="{{ url('users/'.Auth::user()->slug) }}"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->first_name.' '.Auth::user()->last_name }}</a></li>
			@if(Auth::user()->level->level > 0)
           	<li><a href=" {{ url('admin') }} " class="admin-link"> <span class="glyphicon glyphicon-cog"></span> Administration</a></li>
           	@endif
            <li><a href="{{ url('auth/logout') }}"> <span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>
          </ul>
        </li>
      @endif
      </ul>
    </div>
  </div>
</nav>  