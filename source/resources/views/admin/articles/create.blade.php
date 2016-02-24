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

            	<div class="col-md-10 col-md-offset-1">
            		<input type="text" class="form-control" name="subtitle" placeholder="Sous-titre" value="">
            	</div>

				
				
			</div>
		</form>
		
	</div>

@stop