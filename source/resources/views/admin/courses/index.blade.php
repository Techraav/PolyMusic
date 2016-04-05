@extends('layouts.admin')

@section('title')
	Cours
@stop

@section('breadcrumb')
    <li> <a href="{{ url('admin') }}">Administration</a></li>
    <li class="active">Cours</li>
@stop

@section('content')

	<div class="jumbotron">
		<h1>Gestion des cours</h1>
		<p>Les cours proposés par la Team Musique sont référencés ici.</p>
		<p>Vous pouvez cliquer sur le nom du cours pour voir la liste des élèves et des professeurs.</p>
		<p>Un article est associé à chaque cours, vous pouvez cliquer sur le symbole à côté nom du cours pour le visionner.</p>
		<p>Un <b>{{ ucfirst(App\Level::find(3)->name) }}</b> peut gérer les cours qu'il a lui-même créé uniquement, et peut créer un cours dont il sera le responsable.</p>
		<p>Les <b>{{ ucfirst(App\Level::find(4)->name).'s' }}</b> et plus, en revanche, peuvent gérer tous les cours, et peuvent créer un cours en définissant un responsable (parmis les {{ App\Level::find(3)->name.'s' }} et plus).</p>
		<hr />
		<p>Nombre de total de cours créés : {{ App\Course::count() }}.</p>

	</div>

	<h2 align="center">Liste des cours :</h2>
	@if(isset($instrument) && $instrument)
		<h4 class="help-block" align="center"> Filtre : Instrument ({{ ucfirst($courses[0]->instrument->name) }}) </h4>
	@endif
	<br />
		<table class="table-levels table table-striped table-hover table-middle-align">
			<thead>
				<tr>
					<td><b>Instrument</b></td>
					<td><b>Cours</b></td>
					<td><b>Jour</b></td>
					<td align="center"><b>Horaires</b></td>
					<td align="center"><b>Responsable</b></td>
					<td align="center"><b>Élèves</b></td>
					<td align="center"><b>Profs</b></td>
					<td align="center"><b>Documents</b></td>
					<td align="center"><b>Demande(s)</b></td>
					<td width="20" align="right"> </td>
					<td width="20" align="center"><b>Gérer</b></td>
					<td width="20" align="left"></td>
				</tr>
			</thead>
			<tbody>
			@forelse($courses as $c)
				<tr>
					<!-- <td>{{ ucfirst($c->instrument->name) }}</td> -->
					<td>{!! printLink('admin/courses/instrument/'.$c->instrument->id, ucfirst($c->instrument->name)) !!}</td>
					<td>
						<a href="{{ url('admin/courses/'.$c->slug.'/members') }}">{{ $c->name }}</a> &nbsp;
						<a title="Voir l'article associé" class="glyphicon glyphicon-file" href="{{ url('articles/view/'.$c->article->slug) }}"></a></td>
					<td>{{ ucfirst(day($c->day)) }}</td>
					<td align="center" >{{ date_format(date_create_from_format('H:i:s', $c->start), 'H:i') }} - {{ date_format(date_create_from_format('H:i:s', $c->end), 'H:i') }}</td>
					</td>
					<td align="center">{!! printUserLinkV2($c->manager) !!}</td>
					<td align="center">{{ $c->users->count() }}</td>
					<td align="center">{{ $c->teachers->count() }}</td>
					<td align="center">{!! printLink('admin/courses/'.$c->id.'/documents', $c->documents->count()) !!}</td>
					<td align="center">
					 @if(App\CourseUser::where('course_id', $c->id)->where('validated', 0)->count() > 0)
							<p class="text-danger"> <b>{{ App\CourseUser::where('course_id', $c->id)->where('validated', 0)->count() }}</b></p>
					 @else
						<p>{{ App\CourseUser::where('course_id', $c->id)->where('validated', 0)->count() }}</p>
					 @endif
					</td>
					@if(Auth::user()->level_id > 3 || $course->user_id == Auth::user()->id)
						<td class="manage manage-left" align="right">
							@if($c->active == 1)
								<button 
										onclick="modalToggle(this)"
										link="{{ url('admin/courses/validate/0') }}"
										id="{{ $c->id }}"
										action="invalider"
										title="Suspendre le cours"
										msg="Voulez-vous vraiment suspendre ce cours ?"
										class="{{ glyph('remove') }}">
								</button>
							@else
								<button 
										onclick="modalToggle(this)"
										link="{{ url('admin/courses/validate/1') }}"
										id="{{ $c->id }}"
										action="valider"
										msg="Voulez-vous vraiment remettre ce cours en place ?"
										title="Remettre le cours en place "
										class="{{ glyph('ok') }}">
								</button>
							@endif
						</td>
						<td class="manage" align="center">
							<button
									data-link="{{ url('admin/courses/delete') }}"
									data-id="{{ $c->id }}"
									title="Supprimer le cours"
									class="{{ glyph('trash') }} delete-button">
							</button>
						</td>
						<td class="manage manage-right" align="left">
							<a href="{{ url('admin/courses/edit/'.$c->id) }}" title="Modifier le document" class="{{ glyph('pencil') }}"> </a>
						</td>
				@else
				<td></td><td align="center">-</td><td></td>
				@endif
				</tr>
			@empty
				<tr>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
				</tr>
			@endforelse

			</tbody>
		</table>

		<div align="right"> {!! $courses->render() !!} </div>
		<br />
		<div class="col-md-10 col-md-offset-1">
		<br />

		<div id="form" class="jumbotron">
			<h2 align="center">Créer un cours :</h2>
			<span align="center" class="help-block"><i>L'article est créé automatiquement. Vous serez redirigé vers celui-ci pour le compléter.</i></span>
			<br />
			<form id="create-course" method="post" class="form-horizontal" action="{{ url('admin/courses/create') }}">
				{{ csrf_field() }}
				
				<div class="form-group">
					<label for="name" class="control-label col-lg-2">Titre du cours :</label>
					<div class="col-lg-10">
						<input required class="form-control" type="text" name="name" id="name" placeholder="Ex : Cours de guitare débutant du lundi" />
					</div>
				</div>
				
				<div class="form-group">
					<label for="user_id" class="control-label col-lg-2">Responsable :</label>
					<div class="col-lg-10">
						<select name="user_id" @if(Auth::user()->level->level == 2) disabled @endif class="form-control">
							@if(Auth::user()->level->level == 2)
								<option value="{{ Auth::user()->id }}">{{ ucfirst(Auth::user()->first_name).' '.ucfirst(Auth::user()->last_name) }}</option>
							@else
								<optgroup label="Vous :">
									<option value="{{ Auth::user()->id }}">{{ ucfirst(Auth::user()->first_name).' '.ucfirst(Auth::user()->last_name) }}</option>
								</optgroup>
								<optgroup label="Tous :">
								@foreach (App\User::where('level_id', '>', 2)->orderBy('last_name')->get() as $user)
									<option value="{{ $user->id }}">{{ ucfirst($user->last_name).' '.ucfirst($user->first_name) }}</option>
								@endforeach
								</optgroup>
							@endif
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="instrument_id" class="control-label col-lg-2">Instrument :</label>
					<div class="col-lg-10">
						<select name="instrument_id" class="form-control">
								@foreach (App\Instrument::orderBy('name')->get() as $instrument)
									<option value="{{ $instrument->id }}">{{ ucfirst($instrument->name) }}</option>
								@endforeach
						</select>
						<span class="help-block"><i>L'instrument recherché n'est pas dans la liste ? <a href="{{ url('admin/instruments') }}">Ajoutez-le</a>.</i></span>
					</div>
				</div>

				<div align="center" class="form-inline">
					<div class="form-group">
						<label for="day">Jour : 
						<select name="day" class="form-control">
							<option value="0">Lundi</option>
							<option value="1">Mardi</option>
							<option value="2">Mercredi</option>
							<option value="3">Jeudi</option>
							<option value="4">Vendredi</option>
							<option value="5">Samedi</option>
							<option value="6">Dimanche</option>
						</select></label>
					</div>	
					<div class="form-group">
						<label for="start">De : 
						<input required class="form-control" type="time" name="start" id="start" /></label>
					</div>
					<div class="form-group">
						<label for="end">à :
						<input required class="form-control" type="time" name="end" id="end" /></label>
					</div>
				</div>
				<br />

				<div class="form-group">
					<label for="infos" class="control-label col-lg-2">Informations complémentaires</label>
					<div class="col-lg-10">
						<textarea rows="3" name="infos" class="form-control"></textarea>
					</div>
				</div>
				
				<br />

				<div align="center"class="row buttons">
					<button type="reset" class="btn btn-default">Annuler</button> <button  type="submit" class="btn btn-primary">Valider</button>
				</div>
			</form>
	    </div>
	    </div>

	<!-- Modal -->
	<div class="modal fade" id="modalToggle" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Suspendre/Reprendre un cours</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-warning"><b></b></p>
			         	<input hidden value="" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" id="button-toggle" class="btn btn-primary"></button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer un cours</h4>
	        	</div>

		        <form id="delete-form" class="modal-form" method="post" action="">
		        	{!! csrf_field() !!}
			        <div class="modal-body">
	        		<p class="text-danger"><b>Attention ! Cette action est irréversible !</b></p>
			         	<input hidden value="" name="id" id="id" />
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" class="btn btn-primary">Supprimer</button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>

@stop


@section('js')
    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
	<script type="text/javascript">
		CKEDITOR.replace( 'infos' );
	</script>
@stop