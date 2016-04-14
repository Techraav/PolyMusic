@extends('layouts.app')

@section('title')

@stop

@section('breadcrumb')
    <li> <a href="{{ url('courses/list') }}">Cours</a></li>
    <li>{{ ucfirst($course->name) }} </li>
    <li class="active">Documents </li>
@stop

@section('content')

	<div id="documents" class="tab-pane fade in documents photos" >
		<div class="content">
			@forelse ($course->documents as $d)
				<a title="Cliquez pour voir le document" class="pdf" href="{{ url('files/documents/'.$d->name )}}" target="_blank">
					<img class="article-picture" src="{{ URL::asset('img/pdf.png') }}"/>
					<span class="doc-infos">
						Date : {{ $d->created_at->format('d/m/Y') }} <br />
						Auteur : {{ $d->author->first_name }} {{ substr($d->author->last_name, 0, 1) }}
					</span>
					<span class="download {{ glyph('download-alt') }}"></span>
				</a>
			@empty
			<br />
				<i>Aucun document pour le moment.</i>
			@endforelse
			</div>
		<div class="link-all" align="right"><a class="all" href="{{ url('courses/'.$course->slug.'/documents') }}">Voir plus de documents </a>	</div>				
	</div>

@stop