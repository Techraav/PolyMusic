<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Team Musique | @section('title') Accueil @show </title>
    <!-- Bootstrap CSS served from a CDN -->
    {{-- <link href="https://bootswatch.com/flatly/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="{{ URL::asset('/css/bootstrap.min.css')  }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/style.css')  }}" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
  <body>

  @include('layouts.app.nav')

    <br /> 
<!-- <div class="row div-breadcrumb">
  <div class="col-lg-12">
    <div class="container">
      <ul class="breadcrumb">
        <li><a href=" {{ url('/') }} ">Accueil</a></li>
        @yield('breadcrumb')
      </ul>
    </div>
  </div>
</div> -->
<div class="row">
  <div class="col-lg-9">
   <div class="container">

    @include('flash::message')
    @yield('content')

   </div>
  </div>
    {{-- SIDEBAR --}}
    <div class="col-lg-3">
        <div class="panel panel-welcome">
              <p align="center"><img src="{{URL::asset('/img/logo.png')}}" /></p>
        </div>

        @section('search')
        <div class="search-fieldset">
          <!-- <h1 class="search-title">Rechercher un cours</h1> -->
          <form action="{{ url('courses/search') }}" method="get">
            <div class="form-group">
              <div class="input-group"> 
                <input class="form-control input-sm" name="instrument" type="text" placeholder="Rechercher un cours par instrument" />
                <span class="input-group-btn">
                  <button class="btn btn-primary btn-sm" type="submit"><span class="{{ glyph('search') }}"></span></button>
                </span>       
              </div>
            </div>
          </form>

          <form action="{{ url('courses/search') }}" method="get">
            <div class="form-group">
              <div class="input-group"> 
                <input class="form-control input-sm" name="teacherfn" type="text" placeholder="Rechercher un cours par professeur (prénom)" />
                <span class="input-group-btn">
                  <button class="btn btn-primary btn-sm" type="submit"><span class="{{ glyph('search') }}"></span></button>
                </span>       
              </div>
            </div>
          </form>

          <form action="{{ url('courses/search') }}" method="get">
            <div class="form-group">
              <div class="input-group"> 
                <input class="form-control input-sm" name="teacherln" type="text" placeholder="Rechercher un cours par professeur (nom de famille)" />
                <span class="input-group-btn">
                  <button class="btn btn-primary btn-sm" type="submit"><span class="{{ glyph('search') }}"></span></button>
                </span>
              </div>
            </div>
          </form>

          <form action="{{ url('courses/search') }}" method="get">
            <div class="form-group">
              <select class="form-control input-sm" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option disabled selected>Rechercher un cours selon le jour</option>
                <option value="{{ url('courses/search?day=0')}}">Lundi</option>
                <option value="{{ url('courses/search?day=1')}}">Mardi</option>
                <option value="{{ url('courses/search?day=2')}}">Mercredi</option>
                <option value="{{ url('courses/search?day=3')}}">Jeudi</option>
                <option value="{{ url('courses/search?day=4')}}">Vendredi</option>
                <option value="{{ url('courses/search?day=5')}}">Samedi</option>
                <option value="{{ url('courses/search?day=6')}}">Dimanche</option>
              </select>
            </div>
          </form>
        </div>
        @show

        @include('layouts.app.news')

    </div>
</div>

    <footer class="footer">
      @include('layouts.common.footer')
    </footer>

    
    <script src="{{ URL::asset('/js/jquery.js')  }}"></script>
    <script src="{{ URL::asset('/js/bootstrap.min.js')  }}"></script>
    <script src="{{ URL::asset('/js/bootbox.min.js')  }}"></script>
    <script src="{{ URL::asset('/js/fileInput.js')  }}"></script>
    <script src="{{ URL::asset('/js/addons.js')  }}"></script>
    <script src="{{ URL::asset('/js/modals.js')  }}"></script>
    @yield('js') 
    <script>
      $('#flash-overlay-modal').modal();
    </script>
  </body>
</html>