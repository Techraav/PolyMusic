<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>PolyMusic | @section('title') Accueil @show </title>
    <!-- Bootstrap CSS served from a CDN -->
    {{-- <link href="https://bootswatch.com/flatly/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="{{ URL::asset('/css/bootstrap.min.css')  }}" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">PolyMusic</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="/">Accueil </a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Les cours <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Présentation</a></li>
                <li><a href="#">Guitare</a></li>
                <li><a href="#">Piano</a></li>
                <li><a href="#">Basse</a></li>
              </ul>
            </li>
            <li><a href="{{url('news/create')}}">Nos professeurs </a></li>
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
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></li>
                <li><a href="#">Mes événements</a></li>
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
    @if (Session::has('flash_notification.message'))
    <div class="alert alert-{{ Session::get('flash_notification.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        {{ Session::get('flash_notification.message') }}
    </div>
@endif
    @yield('content')
  </div>
  </div>
    {{-- SIDEBAR --}}
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Welcome message
            </div>
            <ul class="list-group">
            
            </ul>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Dernières news
            </div>
            <ul class="list-group">
            
            </ul>
        </div>
    </div>
</div>

    <footer class="footer">
        <div class="container">
        </div>
    </footer>
    <style type="text/css">
        .footer{
            height: 75px;
            background-color :rgb(44, 62, 79);
            border-top: 10px solid rgb(74, 92, 109);
            position:relative;
            padding-top:10px;
        }

        .row{
            margin:0 !important;
        }

        body{
          padding-bottom:0px !important;
        }

        .glyphicon{
          -webkit-transition: all 0.1s ease-in-out;
          -moz-transition: all 0.1s ease-in-out;
          transition: all 0.1s ease-in-out;
        }

        .glyphicon-user{
          font-size:20px
        }

        .jumbotron>h1{
          margin-top:-20px;
          margin-bottom:30px;
        }

        form>.buttons button{
          width:48.5%;
        }



    </style>
    <script src="{{ URL::asset('/js/jquery.js')  }}"></script>
    @yield('js') 
    <script src="{{ URL::asset('/js/bootstrap.min.js')  }}"></script>
    <script>
      $('#flash-overlay-modal').modal();
    </script>
  </body>
</html>