<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Team Musique | @section('title') Accueil @show </title>

    <link href="{{ URL::asset('/css/bootstrap.min.css')  }}" rel="stylesheet">
    <link href="{{ URL::asset('js/file-input/css/fileinput.min.css') }}" media="all" rel="stylesheet" type="text/css" />

    <script src="{{ URL::asset('/js/jquery.js')  }}"></script>
    <script src="{{ URL::asset('/js/bootstrap.min.js')  }}"></script>
    <script src="{{ URL::asset('js/recaptcha/recaptcha.min.js') }}"></script>
    <script src="{{ URL::asset('/js/file-input/plugins/canvas-to-blob.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('/js/file-input/fileinput.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('/js/file-input/fileinput_locale_fr.js') }}"></script>

    @yield('headerjs')
  </head>
  <body>

  @include('layouts.app.nav')

    <br /> 

<div class="row">
  <div class="col-lg-9">
    <div class="row div-breadcrumb">
      <div class="col-lg-12">
        <ul class="breadcrumb">
          <li><a href=" {{ url('/') }} ">Accueil</a></li>
          @yield('breadcrumb')
        </ul>
      </div>
    </div>
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
                <input class="form-control input-sm" name="search" type="text" placeholder="Rechercher un cours..." />
                <span class="input-group-btn">
                  <button class="btn btn-primary btn-sm" type="submit"><span class="{{ glyph('search') }}"></span></button>
                </span>       
              </div>
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