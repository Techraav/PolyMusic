{{-- 
    Formulaire pour créer une news
    Tu peux regarder la gestion des erreurs (tape withErrors dans la barre de recherche de la doc) pour des erreurs plus ciblées (que le controller envoie si il y en a). hf
    Pour le formulaire : 
    Les données que j'attends : utilise les name suivants : title (input text), content (textarea), active (une checkbox, cochée de base (ca se fait en html)) 
    rajoute la propriété required sur les inputs pour que ca bloque si c'est pas rempli

--}}

@extends('layouts.app')

@section('title')
    Créer une annonce
@stop

@section('breadcrumb')
    <li> <a href="{{ url('announcements/list') }}">Annonces</a></li>
    <li class="active">Créer une annonce</li>
@stop

@section('content')
    <div class="jumbotron">
        <h1 align="center">Créer une annonce</h1>

        <form class="form-horizontal" role="form" method="post" action="{{ url('announcements/create') }}">
            {!! csrf_field() !!}

            <div class="form-group">

              <div class="col-md-10 col-md-offset-1">
                <input type="text" class="form-control" name="title" id="title" required placeholder="Titre" value="">
              </div>
            </div>

            <div class="form-group">

              <div class="col-md-10 col-md-offset-1">
                <input type="text" class="form-control" name="subject" id="subject" required placeholder="Sujet" value="">
              </div>
            </div>

            <!-- <div class="form-group">

                <div class="col-md-10 col-md-offset-1">
                    <textarea class="form-control" rows="10" name="content" id="content" required placeholder="Contenu de votre annonce..."></textarea>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" checked required>Active
                      </label>
                    </div>
                </div>
            </div> -->
            
            <div class="form-group buttons" align="center">
                <div class="col-md-10 col-md-offset-1">
                    <button type="reset" class="btn btn-default">Annuler</button>
                    <button type="button" onclick="preview()" class="btn btn-primary">Prévisualiser</button>
                </div>
            </div>

              <!-- Modal -->
            <div class="modal fade" id="previewModal" role="dialog">
                <div class="modal-preview">
            
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Prévisualisation</h4>
                        </div>
                        <div class="jumbotron">
                            <div id="view" class="post-content">
                                <h1 align="center"></h1>
                                <span class="announcement-content">
                                    <h2 align="center">Sujet : <i></i></h3>
                                    <br />
                                    <p id="content" > </p>
                                </span>
                                <br />
                                <p align="right" class="post-infos">Rédigé par {!! printUserLinkV2(Auth::user()) !!}, le {{ date('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Valider et publier</button>
                        </div>

                    </div>
                </div>
            </div>

        </form>        
    </div>   
@endsection

@section('js')
    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'content' );
    </script>

    <script type="text/javascript">
        
        function preview(){

            var title   = $('#title').val();
            var subject = $('#subject').val();
            var content = CKEDITOR.instances.content.getData();

            $('#previewModal h1').html(title);
            $('#previewModal h2 i').html(subject);
            $('#previewModal #content').html(content);

            $('#previewModal').modal('toggle');
        }
        
    </script>

@stop