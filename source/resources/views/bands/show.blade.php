@extends('layouts.app')

@section('content')

	<div class="jumbotron">
		<h1 align="center">{{ ucfirst($band->name) }}</h1>
		<div class=" row">
			<div class="col-lg-4">
				<h3 align="center"><img class="band-picture" width="300" src=" {{ URL::asset('/img/band_pictures/'.$band->image) }} " /></h3>
			</div>
			<div class="col-lg-8">
				<p align="center">Manager : {!! printUserLink($band->manager()->id) !!}</p>
				<br />
				<h2 align="center">Membres :</h2>
					@foreach($band->members as $m)
						<p align="center">{!! printUserLink($m->id) !!} ({{ App\BandUser::where('user_id', $m->id)->where('band_id', $band->id)->first()->instrument->name }})</p>
					@endforeach
			</div>
		</div>
	</div>

@stop