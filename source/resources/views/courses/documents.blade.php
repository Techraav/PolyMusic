@extends('layouts.app')

@section('title')

@stop

@section('breadcrumb')
    <li> <a href="{{ url('courses/list') }}">Cours</a></li>
    <li>{{ ucfirst($course->name) }} </li>
    <li class="active">Documents </li>
@stop

@section('content')

		<div class="all-documents" id="documents" class="tab-pane fade in documents photos" >
			<div class="content">
				@forelse ($course->documents as $d)
					<a title="Cliquez pour voir le document" class="pdf" href="{{ url('files/documents/'.$d->name )}}" target="_blank">
						<img class="doc-img" src="{{ URL::asset('img/pdf.png') }}"/>
						<span class="doc-infos" title="Ajouté le {{$d->created_at->format('d/m/Y')}} par {{ $d->author->first_name.' '.$d->author->last_name }}">
							{{ $d->created_at->format('d/m/Y') }} <br />
							{{ $d->author->first_name }} 
						</span>
						<span class="download {{ glyph('download-alt') }}"></span>
					</a>
				@empty
					<br />
					<i>Aucun document pour le moment.</i>
				@endforelse			</div>
		</div>

		<div align="right">
			{!! $documents->render() !!}
		</div>
@stop