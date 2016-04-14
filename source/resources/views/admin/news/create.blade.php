@extends('layouts.admin')

@section('title')
    Créer une news
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li> <a href="{{ url('admin/news') }}">News</a></li>
    <li class="active">Créer un e news</li>
@stop

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 align="center">Création d'une news</h1>
        <form class="form-horizontal" role="form" method="post" action="{{ url('admin/news/create') }}">
            {!! csrf_field() !!}

            <div class="form-group">

              <div class="col-md-8 col-md-offset-2">
                <input type="text" class="form-control" name="title" placeholder="Titre" required>
              </div>
            </div>

            <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <label for="date">Date de publication : </label>                      
                    <input required type="date" name="date" class="form-control" value="{{ date( 'Y-m-d') }}" >
                </div>
            </div>


            <div class="form-group">

                <div class="col-md-8 col-md-offset-2">
                    <textarea class="form-control" rows="10" name="content" placeholder="Contenu de votre news..." required></textarea>
                </div>

                <div class="col-md-8 col-md-offset-2">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" checked>Active
                      </label>
                    </div>
                </div>
            </div>
            
            <div class="form-group buttons">
                <div class="col-md-4 col-md-offset-5">
                    <button type="submit" class="btn btn-primary">Publier</button>
                </div>
            </div>
        </form>        
    </div>
</div>
@endsection

@section('js')
    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'content' );
    </script>
@stop