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
      
{{--    SUBSUBMENU EXAMPLE
        
        <li class="dropdown" style="position:relative">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Click Here <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
              <a class="trigger right-caret">Level 1</a>
              <ul class="dropdown-menu sub-menu">
                <li><a href="#">Level 2</a></li>
                <li><a href="#">Level 2</a></li>
                <li><a href="#">Level 2</a></li>
              </ul>
            </li>
            <li><a href="#">Level 1</a></li>
            <li><a href="#">Level 1</a></li>
          </ul>
        </li>

--}}


        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Publications <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li>
              <a class="trigger right-caret">Annonces</a>
              <ul class="dropdown-menu sub-menu">
                <li><a href="{{ url('admin/announcements') }} ">Gérer</a></li>
                <li><a href="{{ url('announcements/create') }} ">nouvelle annonce</a></li>
              </ul>
            </li>
            <li>
              <a class="trigger right-caret">Articles</a>
              <ul class="dropdown-menu sub-menu">
                <li><a href="{{ url('admin/articles') }} ">Gérer</a></li>
                <li><a href="{{ url('admin/articles/create') }} ">nouvel article</a></li>
              </ul>
            </li>
            <li>
              <a class="trigger right-caret">News</a>
              <ul class="dropdown-menu sub-menu">
                <li><a href="{{ url('admin/news') }} ">Gérer</a></li>
                <li><a href="{{ url('admin/news/create') }} ">nouvelle news</a></li>
              </ul>
            </li>
          </ul>
        </li>


        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Groupes &amp; Events <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('admin/bands') }}">Groupes</a></li>
            <li><a href="{{ url('admin/events') }}">Événements</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Cours &amp; Docs<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('admin/courses') }}">Cours</a></li>
            <li><a href="{{ url('admin/documents') }}">Document de cours</a></li>
          </ul>
        </li>

	    <li><a href="{{ url('admin/instruments') }}">Instruments</a></li>
        <li><a href="{{ url('admin/users') }}">Membres</a></li>

	    @if(Auth::user()->level_id > 3)
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Données <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('admin/categories') }}">Catégories</a></li>
            <li><a href="{{ url('admin/departments') }}">Départements</a></li>
            <li><a href="{{ url('admin/levels') }}">Levels</a></li>
          </ul>
        </li>
        @endif
        
      </ul>
      <ul class="nav navbar-nav navbar-right">

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
            <li><a href=" {{ url('/') }} " class="admin-link"> <span class="glyphicon glyphicon-home"></span> Quitter le back office</a></li>
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
      </ul>
    </div>
  </div>
</nav>  

