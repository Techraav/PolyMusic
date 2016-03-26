@extends('layouts.admin')

@section('title')
    Back office
@stop

@section('breadcrumb')
    <li class="active">Administration</li>
@stop

@section('content')

	<div class="jumbotron">
		<h1>Back Office</h1>
		<p>Bienvenue sur le back office du site.</p>
		<p>Ici vous pouvez gérer les données du site en tant qu'administrateur.</p>
		<hr />
		<a class="btn btn-primary" href="about">En savoir plus</a> &nbsp; <a class="btn btn-primary" href="/">Quitter le back office</a>
	</div>
@stop