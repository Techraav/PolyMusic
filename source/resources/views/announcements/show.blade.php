@extends('layouts.app')

@section('title')
	{{ ucfirst($announcement->title) }}
@stop

@section('breadcrumb')
    <li> <a href="{{ url('announcements/list') }}">Annonces</a></li>
    <li class="active">{{ ucfirst($announcement->title) }} </li>
@stop

@section('content')
<div class="jumbotron">
	<div class="post-content">
			<h1 align="center">{{ ucfirst($announcement->title) }} </h1>
			@if(Auth::check() && ($announcement->user_id == Auth::user()->id || Auth::user()->level->level > 3))
				<div class="manage">
					<a href="{{ url('announcements/edit/'.$announcement->slug) }}" class="btn-edit glyphicon glyphicon-pencil"></a>
					<button
							data-link="{{ url('announcements/delete') }}"
							data-id="{{ $announcement->id }}"
							title="Supprimer l'annonce"
							class="{{ glyph('trash') }} delete-button">
					</button>
				</div>
			@endif
			<span class="announcement-content">
			<h2 align="center"><i>Sujet : {{ ucfirst($announcement->subject) }}</i></h3>
			<br />
				{!! $announcement->content !!}
			</span>
			<br />
			<p align="right" class="post-infos">Rédigé par {!! printUserLinkV2($announcement->author) !!}, le {{ date_format($announcement['created_at'], 'd/m/Y') }}</p>
	</div>
</div>
<div class="announcement-comments">
<br />
<h1 align="center">Commentaires</h1>
<br />
	@if(isset($comments))
		@foreach ($comments as $c)
		<blockquote class="comment">
		<div class="row">
				<div class="comment-member col-sm-3">
					<h4 align="center"><b>{!! printUserLinkV2($c->author) !!}</b></h4>
					<p align="center"><img class="comment-pp" src=" {{ URL::asset('/img/profil_pictures/'.userData('profil_picture', $c->user_id)) }} " /></p>
					<span align="center" class="rang">{{ ucfirst(App\Level::where('level', userData('level', $c->user_id))->first()->name) }}</span>
				</div> 
		  		<div class="comment-content col-sm-9">
		  		<br />
		  			<span >
		  			{!! $c->content !!}
			  		</span>
			  		<br />
			  		<small class="date">Le {{ date_format($c->created_at, 'd/m/Y') }}, à {{date_format($c->created_at, 'H:i:s') }}</small>
			  		@if(Auth::check() && (Auth::user()->id == $c->user_id || Auth::user()->level->level > 1))
			  		<div class="comment-manage">
			  			@if(Auth::user()->id == $c->user_id)

				  			<a title="Modifier ce commentaire" target="_BLANK" href="{{ url('comment/edit/'.$c->id) }}" class="btn-edit glyphicon glyphicon-pencil"></a>

			  			@endif

				  			<button onclick="dialogDeleteComment(this)" 
						  			comment-id="{{$c->id}}" 
						  			link="{{ url('comment/delete') }}" 
						  			class="btn-delete glyphicon glyphicon-trash">
				  			</button>
			  		</div>
			  		@endif

		  		</div>
		</div>
		</blockquote>
		@endforeach
	@else
	<p>Aucun commentaire pour le moment.</p>
	@endif

	<div align="right"> {!! $comments->render() !!} </div>


	@if(Auth::check())

	<hr />
	<div class="col-md-10 col-md-offset-1">

		<h2 align="center">Ajouter un commentaire</h2>
		<br />
		<form action="{{ url('announcements/comment/create') }}" method="post">
		{{ csrf_field() }}
			<input hidden value="{{ $announcement->id }}" name="announcement_id" />

			<div class="form-group">
				<textarea required rows="8" class="form-control" placeholder="Votre commentaire..." name="comment_content"></textarea>
			</div>

			<div class="form-group">
				<input type="submit" role="button" value="Valider" class="btn btn-primary btn-submit"/>
			</div>
		</form>	
	</div>
	@endif
</div>


  <!-- Modals -->

  @include('announcements.modal-delete-announcement')

  @include('announcements.modal-delete-comment')



@stop


@section('js')

    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'comment_content' );
        CKEDITOR.replace( 'content' );
    </script>

<script type="text/javascript">
		function dialogDeleteComment(el)
		{
			var id = el.getAttribute('comment-id');
			var link = el.getAttribute('link');
			$('#formDeleteComment').attr('action', link);
			$('#formDeleteComment #comment_id').attr('value', id);
			$('#modalDeleteComment').modal('toggle');
		}
		
		function dialogEditComment(el)
		{
			var id = el.getAttribute('id');
			var content = el.getAttribute('content');
			var link = el.getAttribute('link');
			$('#formEditComment').attr('action', link);
			$('#formEditComment #comment_id').attr('value', id);
			CKEDITOR.instances.content.setData(content);
			$('#modalEditComment').modal('toggle');
		}

		function dialogDeleteAnnouncement(el)
		{
			var id = el.getAttribute('id');
			var link = el.getAttribute('link');
			$('#formDeleteAnnouncement').attr('action', link);
			$("#formDeleteAnnouncement #announcement_id").attr('value', id);
			$('#modalDeleteAnnouncement').modal('toggle');
		}
</script>

@stop