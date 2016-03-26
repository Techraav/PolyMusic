@extends('layouts.app')

@section('title')
	{{ ucfirst($band->name) }}
@stop

@section('breadcrumb')
    <li> <a href="{{ url('bands') }}">Groupes</a></li>
    <li class="active">{{ ucfirst($band->name) }} </li>
@stop

@section('content')

	<div class="jumbotron band-sheet">
		<div class=" row">
			<div class="col-lg-4 left">
				<h1 align="center">{{ ucfirst($band->name) }}</h1>
				<span class="help-block">Manager : {!! printUserLinkV2($band->manager) !!}</span>
		<!-- 		<br />
				<br /> -->
				<p align="center"><img class="band-picture" width="250" src=" {{ URL::asset('/img/band_pictures/'.$band->image) }} " /></p>
			</div>
			<div class="col-lg-8 right">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#members" data-toggle="tab" aria-expanded="true">Membres</a></li>
					<li><a href="#other" data-toggle="tab">Informations</a></li>
					<li><a href="#other" data-toggle="tab">Événements</a></li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div id="members" class="tab-pane fade active in members" >
						<!-- <h2 align="center">Membres :</h2> -->
						<br />
						<br />
						{{-- <table class="table table-striped">
							<!-- <thead>
								<tr>
									<td align="center"><b>Utilisateur</b></td>
									<td align="center"><b>Instrument</b></td>
								</tr>
							</thead> -->
							<tbody>
								@foreach($band->members as $m)
								<tr>
									<td align="center">{!! printUserLinkV2($m) !!} {!! $m->id == $band->user_id ? '<span class="help-block inline">(Manager)</span>' : '' !!}</td>
									<td align="center">{{ App\BandUser::where('user_id', $m->id)->where('band_id', $band->id)->first()->instrument->name }}</td>
								</tr>
								@endforeach
							</tbody> 
						</table> --}}

						@foreach($band->members as $m)
							<div class="member">
								<p align="center"><img class="profil-picture" src="{{ URL::asset('img/profil_pictures/'.$m->profil_picture) }}" /></p>
								<p align="center">{!! printUserLinkV2($m) !!} </p>
								<p class="instrument" align="center"><i>{{ App\BandUser::where('user_id', $m->id)->where('band_id', $band->id)->first()->instrument->name }}</i></p>
								@if ($m->id == $band->user_id)
									<p align="center"<span class="help-block inline">(Manager)</span></p>
								@endif
							</div>
						@endforeach
					</div>
					<div id="other" class="tab-pane fade">
						<p>fzipefbziefbiez</p>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop