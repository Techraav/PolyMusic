@extends('layouts.admin')

@section('title')
    Créer une annonce
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li> <a href="{{ url('admin/announcements') }}">Annonces</a></li>
    <li class="active">Créer une annonce</li>
@stop


@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 align="center">Créer une annonce</h1>

        <form class="form-horizontal" role="form" method="post" action="{{ url('admin/announcements/create') }}">
            {!! csrf_field() !!}

            <div class="form-group">

              <div class="col-md-10 col-md-offset-1">
                <input type="text" class="form-control" name="title" required placeholder="Titre" value="">
              </div>
            </div>

            <div class="form-group">

                <div class="col-md-10 col-md-offset-1">
                    <textarea class="form-control" rows="10" name="content" required placeholder="Contenu de votre annonce..."></textarea>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" checked required>Active
                      </label>
                    </div>
                </div>
            </div>
            
            <div class="form-group buttons">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">Publier</button>
                </div>
            </div>
        </form>        
    </div>   

</div> 
@endsection