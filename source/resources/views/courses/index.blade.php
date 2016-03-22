@extends('layouts.app')

@section('content')

	<div class="jumbotron">
		@if(Auth::check()	)
			@if(Auth::user()->level_id > 2)
				<a href="{{ url('admin/courses') }}" title="Gérer les cours" class="{{ glyph('cog') }}"></a>
			@endif
		@endif
		<h1>Les cours !</h1>
		<p>Voici la liste des cours proposé par la Team Musique !</p>
		<p>Cliquez sur le nom du cours pour avoir plus d'informations.</p>
	</div>

	<div class="row">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<td><b>Responsable</b></td>
					<td><b>Cours</b></td>
					<td align="center"><b>Jour</b></td>
					<td align="center"><b>Horaires</b></td>
					<td align="center"><b>Instrument</b></td>
				</tr>
			</thead>
			<tbody>
				@forelse($courses as $c)
					<tr>
						<td>{!! printUserlinkV2($c->manager) !!}</td>
						<td>{!! printLink('courses/show/'.$c->slug, ucfirst($c->name)) !!}</td>
						<td align="center">{{ ucfirst(day($c->day)) }}</td>
						<td align="center" >{{ date_format(date_create_from_format('H:i:s', $c->start), 'H:i') }} - {{ date_format(date_create_from_format('H:i:s', $c->end), 'H:i') }}</td>
						<td align="center">{{ ucfirst($c->instrument->name) }}</td>
					</tr>
				@empty
					<tr>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
					</tr>
				@endforelse
			</tbody>
		</table>
	</div>

	<div class="row">
		<h2 align="center">Filtrer la recherche</h2>
		<span align="center" class="help-block"><i>(Un seul à la fois)</i></span>
		@if($filter != false)
			<h4 align="center"><a class="help-block" href="{{ url('courses/list') }}">Annuler le filtre</a></h4>
		@endif
		<br />
		<div align="center" class="col-lg-4">
			<label class="control-label">Trier par jour :</label>
			<select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
				<option disabled selected>Sélectionnez un jour...</option>
				<option value="{{ url('courses/list/day/0') }}">Lundi</option>
				<option value="{{ url('courses/list/day/1') }}">Mardi</option>
				<option value="{{ url('courses/list/day/2') }}">Mercredi</option>
				<option value="{{ url('courses/list/day/3') }}">Jeudi</option>
				<option value="{{ url('courses/list/day/4') }}">Vendredi</option>
				<option value="{{ url('courses/list/day/5') }}">Samedi</option>
				<option value="{{ url('courses/list/day/6') }}">Dimanche</option>
			</select>
		</div>
		<div align="center" class="col-lg-4">
			<label class="control-label">Trier par responsable :</label>
			<select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
					<option disabled selected>Sélectionnez un responsable...</option>
				@forelse($allCourses as $c)
					<option value="{{ url('courses/list/manager/'.$c->manager->id ) }}">{{$c->manager->last_name}} {{$c->first_name}}</option>
				@empty

				@endforelse
			</select>
		</div>
		<div align="center" class="col-lg-4">
			<label class="control-label">Trier par instrument :</label>
			<select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
					<option disabled selected>Sélectionnez un instrument...</option>
				@forelse($allCourses as $c)
					<option value="{{ url('courses/list/instrument/'.$c->instrument->id ) }}">{{ ucfirst($c->instrument->name) }}</option>
				@empty

				@endforelse
			</select>
		</div>
	</div>

@stop
