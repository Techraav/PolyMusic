<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Team Musique - Admin | @section('title') Back Office @show </title>

    <link href="{{ URL::asset('/css/bootstrap.css')  }}" rel="stylesheet">
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

  @include('layouts.admin.nav')

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
          <div class="panel panel-default">
              <div class="panel-heading">
                  <p align="center"><i><b>Administration</b></i></p>
              </div>
              <div class="panel-body">
                  <p>Bienvenue sur la zone d'administration du site.</p>
              </div>
          </div>

          @include('layouts.admin.course_modifications')

          @include('layouts.admin.modifications')

      </div>
  </div>
</div>

    <footer class="footer footer-admin">
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