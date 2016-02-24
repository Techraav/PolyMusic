<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>PolyMusic | @section('title') Back Office @show </title>
    <!-- Bootstrap CSS served from a CDN -->
    {{-- <link href="https://bootswatch.com/flatly/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="{{ URL::asset('/css/bootstrap.min.css')  }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/style.css')  }}" rel="stylesheet">
  </head>
  <body>

  @include('layouts.admin.nav')

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
                <p align="center"><i><b>Administration</b></i></p>
            </div>
            <div class="panel-body">
                Bienvenue sur la zone d'administration du site.
            </div>
        </div>

        @include('layouts.admin.course_modifications')

        @include('layouts.admin.modifications')

    </div>
</div>

    <footer class="footer footer-admin">
      @include('layouts.common.footer')
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