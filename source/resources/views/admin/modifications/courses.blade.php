@extends('layouts.admin')

@section('content')

	<div class="jumbotron">
		<h1> Modifications des membres des cours </h1>
		<p>Lorsque qu'un utilisateur s'inscrit à un cours, qu'il annule son inscription, qu'une inscription est refusée ou validée, ou qu'un membre d'un cours est supprimé, une modification est enregistrée automatiquement.</p>
		<p>Les modifications concernant les membres des cours sont différentes des modifications des données générales.</p>
		<p>Les lignes en gras concernent les cours dont vous êtes le responsable.</p>
		<p>Pour accéder aux modifications générales, <a href="{{ url('admin/modifications') }}">cliquez ici</a>.</p>
		<hr />
		<p>Nombre total de modifications effectuées : {{ App\CourseModification::count() }}</p>
	</div>

	<h2 align="center">Liste des modifications</h2>
	<h4 align="center">Cours concerné(s) : {!! $concerned !!}</h4>
	<br />

	<h4 align="center">Un seul cours vous intéresse ?</h4>
	<div class="col-md-4 col-md-offset-4">
		<form>
			<select class="form-control" name="course" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
			<option selected disabled>Selectionnez un cours...</option>
			<option value="{{ url('admin/modifications/courses')}}">Tous</option>
			@foreach(App\Course::orderBy('name')->get() as $c)
				<option value="{{ url('admin/modifications/courses/'.$c->id) }}">{{ ucfirst($c->name) }}</option>
			@endforeach
			</select>
		</form>	
	<br />
	</div>

	<table class="table table-hover table-striped table-modifs">
		<thead>
			<tr>
				<td width="250"><b>Auteur</b></td>
				<td width="250"><b>Utilisateur concerné</b></td>
				<td width="250"><b>Cours concerné</b></td>
				<td><b>Information</b></td>
			</tr>
		</thead>
		<tbody>
			@forelse($modifs as $m)
				<tr class="tr-modif-{{$m->value}} {{$m->course->user_id == Auth::user()->id ? 'bold' : '' }} ">
					<td>{!! printUserLinkV2($m->author) !!}</td>
					<td>{!! printUserLinkV2($m->user !!}</td>
					<td><a href="{{ url('course/'.App\Course::where('id', $m->course_id)->first()->slug) }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a></td>
					<td>
						<span class="modif-{{ $m->value}} ">
		        				@if($m->value == 0)
		        					{!! printUserLinkV2($m->author) !!} <i>asked</i> to join course &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
		        				@elseif($m->value == 1)
		        					{!! printUserLinkV2($m->author) !!} <i>canceled</i> his demand to join course &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;.
		        				@elseif($m->value == 2)
		        					{!! printUserLinkV2($m->author) !!} <i>removed</i> {!! printUserLinkV2($m->user) !!} from &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
		        				@elseif($m->value == 3)_id
		        					{!! printUserLinkV2($m->author) !!} <i>added</i> {!! printUserLinkV2($m->user) !!} to &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
		        				@endif
						</span>

					</td>
				</tr>
			@empty
			<tr>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
			</tr>
			@endforelse
		</tbody>
	</table>

	<div align="right">{!! $modifs->render() !!}</div>

@stop