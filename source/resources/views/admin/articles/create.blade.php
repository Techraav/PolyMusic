@extends('layouts.app')

@section('title')
	Créer un article
@stop

@section('content')

	<div class="jumbotron">
		<h1 align="center">Créer un article</h1>

		<form class="form-horizontal" role="form" method="post" action="{{ url('admin/articles/create') }}">
			{!! csrf_field() !!}

			<div class="form-group">
            	<div class="col-md-10 col-md-offset-1">
            		<input type="text" class="form-control" name="title" required placeholder="Titre" value="">
            	</div>
            </div>

            <div class="form-group">
            	<div class="col-md-10 col-md-offset-1">
            		<input type="text" class="form-control" name="subtitle" placeholder="Sous-titre" value="">
            	</div>
            </div>

            <div class="form-group">
				<div class="col-md-10 col-md-offset-1">
					<select class="form-control" name="category-id" required="">
						<option disabled selected>Choisissez une catégorie...</option>
						@foreach( App\Category::orderBy('id', 'desc')->get() as $c)
							<option value="{{$c->id}}">{{$c->name}}</option>							
						@endforeach
					</select>					
				</div>
			</div>
				
			<div class="form-group">
				<div class="col-md-10 col-md-offset-1">
					<textarea rows="3" name="content" class="form-control" placeholder="Contenu de votre article..." required></textarea>
				</div>
			</div>

			<div class="form-group buttons">
                <div class="col-md-4 col-md-offset-5">
                    <button type="submit" class="btn btn-primary">Publier</button>
                </div>
            </div>
	
		</form>
		
	</div>

@stop

@section('js')
    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
	<script type="text/javascript">
		CKEDITOR.replace( 'content' );
	</script>
@stop