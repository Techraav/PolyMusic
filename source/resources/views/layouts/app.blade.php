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
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">PolyMusic</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="#">Acceuil </a></li>
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
            <li><a href="{{url('auth/register')}}">Inscription </a></li>
            <li><a href="{{url('auth/login')}}">Connexion </a></li>
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
                Welcome message
            </div>
            <ul class="list-group">
            
            </ul>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Lastest news
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
        .alert{
          opacity:0.7;
        }
        body{
          padding-bottom:0px !important;
        }
        a.videoLink{
          font-weight:bold;
          text-decoration:none !important;
          margin-left:15px;
        }
        a.videoLink:hover{
          text-decoration:underline !important;
        }
        .likedislike{
          text-decoration:none !important;
          color:gray;
          transition:all 0.1s ease-in-out;
          -moz-transition:all 0.1s ease-in-out;
          -webkit-transition:all 0.1s ease-in-out;
          font-size:22px !important;
        }
        .like:hover, .liked, .validated, .validate:hover{
          color:#2C7F2C !important;
          font-weight:bold;
        }
        .dislike:hover, .disliked, .unvalidated, .unvalidate:hover{
          color:#B93A3A !important;
          font-weight:bold;
        }
        .likeForm button, .validation button, .glyphicon{
          background:none;
          border:none;
          width:30px;
        }
        .musicTable{
          overflow:auto;
        }
        .validation button{
          width:33px;
          color: #AFAEAE;
          font-size:26px !important;
        }
        .glyphicon{
          -webkit-transition: all 0.1s ease-in-out;
          -moz-transition: all 0.1s ease-in-out;
          transition: all 0.1s ease-in-out;
        }
        .controls{
          font-size:18px;
          margin:-5px;
          color:gray;
        }
        .controls:hover{
          color:inherit;
        }
        .mindNumber{
          font-size:11px;
          color:gray;
          margin-left:-5px;
        }
        .playOn{
          color:inherit !important;
        }
        .selectedLine{
          background-color:#D4DFE8 !important;
        }
        tr{
          transition: background-color 0.3s ease-in-out;
          -webkit-transition: background-color 0.3s ease-in-out;
          -moz-transition: background-color 0.3s ease-in-out;
        }
        table .orderBar a{
          display:block;
          text-decoration:none !important;
          color: #2C3E50;
        }
        table .orderBar td:hover{
          background-color:rgb(212, 223, 232);
        }
        table .orderBar td{
          height:30px;
          max-width:150px;
          transition: all 0.2s ease-in-out;
          -webkit-transition: all 0.2s ease-in-out;
          -moz-transition: all 0.2s ease-in-out;
        }
        td{
          vertical-align: middle !important;
        }
        .orderBar .glyphicon{
          display:none;
          font-size:12px;
          transition: all 0.3s ease-in-out;
          -webkit-transition: all 0.3s ease-in-out;
          -moz-transition: all 0.3s ease-in-out;
          opacity:0.9;
        }
        .orderBar td:hover .glyphicon{
          display:inline;
        }
        .mind, .validation{
          display:inline;
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