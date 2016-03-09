@extends('layouts.admin')

@section('title')
	Cours
@stop

@section('content')

	<div class="jumbotron">
		<h1>Gestion des cours</h1>
		<p>Les cours proposés par le Club Musique sont référencés ici.</p>
		<p>Vous pouvez cliquer sur le nom du cours pour voir la liste des élèves et des professeurs.</p>
		<p>Un article est associé à chaque cours, vous pouvez cliquer sur le symbole à côté nom du cours pour le visionner.</p>
		<p>Un <b>professeur</b> peut gérer les cours qu'il a lui-même créé uniquement, et peut créer un cours dont il sera le responsable.</p>
		<p>Les <b>admins</b> et plus, en revanche, peuvent gérer tous les cours, et peuvent créer un cours en définissant un responsable (parmis les professeurs et plus).</p>
		<hr />
		<p>Nombre de total de cours créés : {{ App\Course::count() }}.</p>

	</div>

	<h2 align="center">Liste des cours :</h2>
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
					<td align="center"><b>Gérer</b></td>
				</tr>
			</thead>
			<tbody>
			@forelse($courses as $c)
				<tr>
					<!-- <td>{{ ucfirst(App\Instrument::where('id', $c->instrument_id)->first()->name) }}</td> -->
					<td>{{ucfirst($c->instrument->name)}}</td>
					<td>
						<a href="{{ url('admin/courses/'.$c->slug.'/members') }}">{{ $c->name }}</a> &nbsp;
						<a title="Voir l'article associé" class="glyphicon glyphicon-file" href="{{ url('articles/view/'.App\Article::where('id', $c->article_id)->first()->slug) }}"></a></td>
					<td>{{ ucfirst(day($c->day)) }}</td>
					<td align="center" >{{ date_format(date_create_from_format('H:i:s', $c->start), 'H:i') }} - {{ date_format(date_create_from_format('H:i:s', $c->end), 'H:i') }}</td>
					</td>
					<td align="center">{!! printUserLinkV2($c->manager) !!}</td>
					<td align="center">{{ App\CourseUser::where('course_id', $c->id)->where('level', 0)->count() }}</td>
					<td align="center">{{ App\CourseUser::where('course_id', $c->id)->where('level', 1)->count() }}</td>
					<td align="center"><a href="{{ url('admin/documents/course/'.$c->id) }}">{{ App\Document::where('course_id', $c->id)	->count() }}</a></td>
					<td align="center">
					 @if(App\CourseUser::where('course_id', $c->id)->where('validated', 0)->count() > 0)
							<p class="text-danger"> <b>{{ App\CourseUser::where('course_id', $c->id)->where('validated', 0)->count() }}</b></p>
					 @else
						<p>{{ App\CourseUser::where('course_id', $c->id)->where('validated', 0)->count() }}</p>
					 @endif
					</td>
					<td align="center">
						@if( Auth::user()->level->level >= 3 || $c->user_id == Auth::user()->id )
							<button onclick="dialogDelete(this)"
									name="{{ ucfirst($c->name) }}"
									id="{{ $c->id }}"
									link="{{ url('admin/courses/delete/'.$c->id) }}" 
									align="right" 
									title="Supprimer le cours {{ $c->name }} ? (définitif)" 
									type="submit"
						 			class="glyphicon glyphicon-trash">
							</button>

							<a href="{{ url('admin/courses/edit/'.$c->id) }}" title="Modifier le cours {{ $c->name }} ?"class="glyphicon glyphicon-pencil"></a>
						@else
							&nbsp;&nbsp; - &nbsp;
						@endif
					</td>
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
								@foreach (App\User::where('level_id', '>', 1)->orderBy('last_name')->get() as $user)
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
@stop


@section('js')
    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
	<script type="text/javascript">
		CKEDITOR.replace( 'infos' );
	</script>

	<script type="text/javascript">
		function dialogDelete(el)
		{
			var id = el.getAttribute('id');
			var name = el.getAttribute('name');
			var link = el.getAttribute('link');

			$('#modalDelete form').attr('action', link);
			$('#modalDelete h4').html("Supprimer le groupe &laquo; " + name + " &raquo; ?");
			$('#modalDelete #band_id').attr('value', id);
			$('#modalDelete').modal('toggle');
		}
	</script>

@stop