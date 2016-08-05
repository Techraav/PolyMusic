@extends('layouts.app')

@section('title')
	Groupes
@stop

@section('breadcrumb')
    <li class="active">Groupes</li>
@stop


@section('content')

	<div class="jumbotron">
		@if(Auth::check()	)
			@if(Auth::user()->level_id > 2)
				<a href="{{ url('admin/bands') }}" title="Gérer les groupes" class="{{ glyph('cog') }}"></a>
			@endif
		@endif
		<h1>Les Groupes !</h1>
		<p>Voici la liste des groupes créés au sein de l'école !</p>
		<p>Cliquez sur le nom du groupe pour avoir plus d'informations.</p>
	</div>

	<div class="row">
		@if($bands->count() > 0)
			<div id="bands">
				@foreach($bands as $b)
					<a href="{{ url('bands/show/'.$b->slug) }}" class="band">
						<h1 align="center">{{ ucfirst($b->name) }}</h1>
						<img src="{{ url('img/band_pictures/'.$b->image) }}">
						<p class="members">
							<?php  
								// $members = $b->members[0]->first_name .' '. $b->members[0]->last_name; 
								// for($i=1; $i < $b->members->count(); $i++)
								// {
								// 	$members .= ', '.$b->members[$i]->first_name .' '. $b->members[$i]->last_name;
								// }
								// echo $members;
							?>
							@forelse($b->members as $m)
								{{ ucfirst($m->first_name) }} {{ ucfirst($m->last_name) }} <br />
							@empty
								Aucun membre
							@endforelse
						</p>
					</a> 
				@endforeach
			</div>
		@else
			<p align="center">Aucun groupe n'a été créé pour le moment...</p>
		@endif
	</div>

	<div align="right">
		{!! $bands->render() !!}
	</div>

@stop
