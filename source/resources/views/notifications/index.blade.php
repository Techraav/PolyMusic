@extends('layouts.app')

@section('title')
	Notifications
@stop

@section('breadcrumb')
    <li class="active">Notifications</li>
@stop


@section('content')

	<h1 align="center"> Notifications </h1>
	<br />

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			
			<ul class="list-group notifications list-hover">
				@forelse($notifications as $n)
					<a {{ $n->link != '' ? 'href="'.url($n->link).'"' : ''}} class="list-group-item {{ $n->new == 1 ? 'new' : '' }}">
						<span class="time help-block">{{ date_format(date_create_from_format('Y-m-d H:i:s', $n->created_at), '\- \L\e d/m/Y\, \à H:i') }}</span>
						<p>{!! ucfirst($n->message) !!}</p>
					</a>

				@empty
					<li class="list-group-item">Aucune notification.</li>
				@endforelse
			</ul>

		</div>	
	</div>

	<div align="right">{!! $notifications->render()!!}</div>


@stop