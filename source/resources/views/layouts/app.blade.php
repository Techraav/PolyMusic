<!DOCTYPE html>
<html lang="fr">
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
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
  <body>

  @include('layouts.app.nav')

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
        <div class="panel panel-welcome">
              <!-- <p>Bienvenue sur le site du Club Musique de Polytech Tours !</p> -->
              <p align="center"><img src="{{URL::asset('/img/logo.png')}}" /></p>
        </div>

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
    @yield('js') 
    <script>
      $('#flash-overlay-modal').modal();
    </script>
  </body>
</html>