@extends('layouts.app')

@section('title')
	Modifier un article
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li> <a href="{{ url('admin/articles') }}">Articles</a></li>
    <li class="active">Modifier un article</li>
@stop


@section('content')

<div class="jumbotron">
	<h1 align="center">Modifier un article</h1>

	<form class="form-horizontal" role="form" method="post" action="{{ url('admin/articles/edit/'.$article->slug) }}">
		{!! csrf_field() !!}

		<div class="form-group">
        	<div class="col-md-10 col-md-offset-1">
        		<input type="text" class="form-control" name="title" required placeholder="Titre" value="{{ $article->title }}">
        	</div>
        </div>

        <div class="form-group">
        	<div class="col-md-10 col-md-offset-1">
        		<input type="text" class="form-control" name="subtitle" placeholder="Sous-titre" value="{{ $article->subtitle }}">
        	</div>
        </div>

        <div class="form-group">
			<div class="col-md-10 col-md-offset-1">
				<select class="form-control" name="category-id" required="">
					@foreach( App\Category::orderBy('id', 'desc')->get() as $c)
						@if($c->id == $article->category_id)
							<option selected value="{{$c->id}}">{{$c->name}}</option>
						@else
							<option value="{{$c->id}}">{{$c->name}}</option>
						@endif							
					@endforeach
				</select>					
			</div>
		</div>
			
		<div class="form-group">
			<div class="col-md-10 col-md-offset-1">
				<textarea rows="3" name="content" class="form-control" placeholder="Contenu de votre article..." required>{{ $article->content }}</textarea>
			</div>
		</div>

		<div class="form-group buttons">
            <div class="col-md-4 col-md-offset-5">
                <button type="submit" class="btn btn-primary">Modifier</button>
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