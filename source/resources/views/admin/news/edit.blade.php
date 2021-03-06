@extends('layouts.admin')

@section('title')
    Modifier une news
@stop
@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li> <a href="{{ url('admin/news') }}">News</a></li>
    <li class="active">Modifier une news</li>
@stop

@section('content')
<div class="container">
	<div class="jumbotron">
		<h1 align="center">Modification de la news</h1>
        <form class="form-horizontal" role="form" method="post" action="{{ url('admin/news/edit/'.$news['slug']) }}">
            {!! csrf_field() !!}

    		<div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <input type="text" class="form-control" name="title" value="{{ $news['title'] }}" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <label for="date">Date de publication : </label> 
                    <input required type="date" name="date" class="form-control" value="{{ $news->published_at }}" >
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <textarea class="form-control" rows="10" name="content" required>{{ $news['content'] }}</textarea>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="active" {{ $news->active == 0 ? '' : 'checked' }}>Active
                        </label>
                    </div>
                </div>
            </div>
                
                <div class="form-group buttons">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="submit" class="btn btn-primary">Modifier</button>
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