@extends('layouts.admin')

@section('content')
		<div class="col-md-10 col-md-offset-1">

		<div class="jumbotron">
			<h1 align="center">Éditer un cours :</h1>
			<br />
			<form id="create-course" method="post" class="form-horizontal" action="{{ url('admin/courses/edit/'.$course->slug) }}">
				{{ csrf_field() }}
				
				<div class="form-group">
					<label for="name" class="control-label col-lg-2">Titre du cours :</label>
					<div class="col-lg-10">
						<input required class="form-control" type="text" name="name" id="name" value="{{ $course->name }}" placeholder="Ex : Cours de guitare débutant du lundi" />
					</div>
				</div>
				
				<div class="form-group">
					<label for="user_id" class="control-label col-lg-2">Responsable :</label>
					<div class="col-lg-10">
						<select name="user_id" @if(Auth::user()->level == 1) disabled @endif class="form-control">
							@if(Auth::user()->level == 1)
								<option value="{{ Auth::user()->id }}">{{ ucfirst(Auth::user()->first_name).' '.ucfirst(Auth::user()->last_name) }}</option>
							@else
								<optgroup label="Actuel :">
									<option value="{{ $course->user_id }}">{{ ucfirst(App\User::where('id', $course->user_id)->first()->first_name).' '.ucfirst(App\User::where('id', $course->user_id)->first()->last_name) }}</option>
								</optgroup>
								<optgroup label="Vous :">
									<option value="{{ Auth::user()->id }}">{{ ucfirst(Auth::user()->first_name).' '.ucfirst(Auth::user()->last_name) }}</option>
								</optgroup>
								<optgroup label="Tous :">
								@foreach (App\User::where('level', '>', '0')->orderBy('last_name')->get() as $user)
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
							<optgroup label="Actuel :">
								<option value="{{ $course->instrument_id }}"> {{ ucfirst(App\Instrument::where('id', $course->instrument_id)->first()->name) }}</option>
							</optgroup>
							<optgroup label="Tous :">
								@foreach (App\Instrument::orderBy('name')->get() as $instrument)
									<option value="{{ $instrument->id }}">{{ ucfirst($instrument->name) }}</option>
								@endforeach
							</optgroup>
						</select>
						<span class="help-block"><i>L'instrument recherché n'est pas dans la liste ? <a href="{{ url('admin/instruments') }}">Ajoutez-le</a>.</i></span>
					</div>
				</div>

				<div align="center" class="form-inline">
					<div class="form-group">
						<label for="day">Jour : 
						<select name="day" class="form-control">
							<option value="0" {{ $course->day == 0 ? 'selected' : '' }}>Lundi</option>
							<option value="1" {{ $course->day == 1 ? 'selected' : '' }}>Mardi</option>
							<option value="2" {{ $course->day == 2 ? 'selected' : '' }}>Mercredi</option>
							<option value="3" {{ $course->day == 3 ? 'selected' : '' }}>Jeudi</option>
							<option value="4" {{ $course->day == 4 ? 'selected' : '' }}>Vendredi</option>
							<option value="5" {{ $course->day == 5 ? 'selected' : '' }}>Samedi</option>
							<option value="6" {{ $course->day == 6 ? 'selected' : '' }}>Dimanche</option>
						</select></label>
					</div>	
					<div class="form-group">
						<label for="start">De : 
						<input required class="form-control" type="time" name="start" id="start" value="{{ $course->start }}" /></label>
					</div>
					<div class="form-group">
						<label for="end">à :
						<input required class="form-control" type="time" name="end" id="end" value="{{ $course->end }}"/></label>
					</div>
				</div>
				<br />

				<div class="form-group">
					<label for="infos" class="control-label col-lg-2">Informations complémentaires</label>
					<div class="col-lg-10">
						<textarea rows="3" name="infos" class="form-control">{{ $course->infos }} </textarea>
					</div>
				</div>
				
				<br />

				<div align="center"class="row">
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
@stop
