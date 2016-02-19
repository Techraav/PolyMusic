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
    <link href="{{ URL::asset('/css/style.css')  }}" rel="stylesheet">
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
          <a class="navbar-brand" href="/"><span class="glyphicon glyphicon-home"></span> &nbsp;PolyMusic </a>
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
    			@if(Auth::user()->level > 0)
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
                <p align="center"><i><b>Bienvenue !</b></i></p>
            </div>
            <ul class="list-group">
            
            </ul>
        </div>
        <div class="panel panel-default panel-news">
            <div class="panel-heading">
                <p align="center"><a href="{{ url('news')}}"><i><b>Dernières news</b></i></a></p>
                  @if(Auth::check() && Auth::user()->level >= 1)
                 <a class="glyphicon glyphicon-plus" title="Ajouter une news" href="{{ url('admin/news/create') }}"></a>
                  @endif
            </div>
                <ul class="list-group">
                  @forelse( App\News::where('active', 1)->orderBy('id', 'desc')->limit(10)->get() as $n)
                  <li class="list-group-item news-item">
                      <div class="news-infos"><p><span>{{ showDate($n['created_at'], 'Y-m-d H:i:s', 'j M Y', false) }}</span></p></div> 
                      <!-- <span class="trait"></span> -->
                      <div class="content"><p><a href="{{ url('news/view/'.$n['slug'])}}">{{ strlen($n->title) > 40 ? substr($n->title, 0, 40).'...' :  $n->title }}</a></p></div>
                      <span class="glyphicon glyphicon-menu-right"></span>
                  </li>
                  @empty
                    <li class="list-group-item"><p>Pas de news pour le moment.</p></li>                  
                  @endforelse
<!--                   @if(Auth::check() && Auth::user()->level >= 1)
                    <li class="list-group-item"></li>
                  @endif -->
                </ul>


            {{-- 2e VERSION --}}
            {{-- <table class="table">
            	<tbody>
                	@forelse( App\News::where('active', 1)->orderBy('id', 'desc')->limit(10)->get() as $n)
                	<tr height="25">
                		<td align="center" width="70"><span>{{ showDate($n['created_at'], 'Y-m-d H:i:s', 'j M Y', false) }}</span></td>
                		<td height="50" class="content"><a href="{{ url('news/view/'.$n['slug'])}}">{{ strlen($n->title) > 40 ? substr($n->title, 0, 40).'...' :  $n->title }}</a>
                		</td>
                    <td><span class="glyphicon glyphicon-menu-right"></span></td>
                	</tr>
	                @empty
	                <td align="center">-</td>
	                @endforelse
            	</tbody>
            </table> --}}
            {{-- --}}


            {{-- 1ere version --}}
             {{-- <ul class="list-group">
                @forelse( App\News::where('active', 1)->orderBy('id', 'desc')->limit(10)->get() as $n)
                <li class="list-group-item">
                    <div class="news-infos"><p>{{ showDate($n['created_at'], 'Y-m-d H:i:s', 'j M Y', false) }}</p></div> 
                  	<a href="{{ url('news/view/'.$n['slug'])}}">{{$n['title']}}</a>
                </li>
                @empty
                  <li class="list-group-item"><p>Pas de news pour le moment.</p></li>                  
                @endforelse
                @if(Auth::check() && Auth::user()->level >= 1)
                  <li class="list-group-item"><p><a href="{{ url('admin/news/create') }}">Ajouter une news</a></p></li>
                @endif
            </ul> --}}
            {{--  --}}
        </div>
    </div>
</div>

    <footer class="footer">
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