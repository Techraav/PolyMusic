@extends('layouts.app')

@section('title')
	Modification {{ $user -> first_name }} {{ $user -> last_name }}
@stop

@section('content')
<div class="jumbotron">
	<div class="profile">
		<h1 align="center">{{ $user -> first_name }} {{ $user -> last_name }}</h1>
		<div class="row">
			<div class="profil-pict">
				<p align="center" ><img src=" {{ URL::asset('/img/profil_pictures/'.$user -> profil_picture) }} " alt=" profile picture "/></p>
			</div>
			<div>
				
				<form class="form-horizontal" role="form" method="post" action="{{ url('admin/users/edit/'.$user->slug) }}">
	            {!! csrf_field() !!}
	            	<fieldset>                   

			            <div class="form-group">
			                <label class="col-md-4 control-label" for="email">Adresse e-mail</label>

			                <div class="col-md-6">
			                    <input type="email" class="form-control input-sm" name="email" value="{{ $user->email }}" readonly>
			                </div>
			            </div>

			            <div class="form-group">
			                <label class="col-md-4 control-label" for="birth_date">Date de naissance</label>

			                <div class="col-md-6">
			                    <input type="date" class="form-control input-sm" name="birth_date" value="{{ showDate($user->birth_date, 'Y-m-d', 'd/m/Y') }}" readonly>
			                </div>
			            </div>

			            <div class="form-group">
			                <label class="col-md-4 control-label" for="school_year">Année d'étude</label>

			                <div class="col-md-6">
			                    <select class="form-control input-sm" name="school_year">
			                        <option value="1">PeiP 1</option>
			                        <option value="2">PeiP 2</option>
			                        <option value="3">3ème année</option>
			                        <option value="4">4ème année</option>
			                        <option value="5">5ème année</option>
			                        <option value="0">Autre...</option>
			                    </select>
			                </div>
			            </div>

			            <div class="form-group">
			                <label class="col-md-4 control-label" for="department_id">Département</label>

			                <div class="col-md-6">
			                    <select class="form-control input-sm"  name="department_id">
			                         @foreach (App\Department::all()  as $d)
				                        @if($user->department_id == $d->id)
				                            <option value="{{ $d['id'] }}" selected> {{ $d['name'] }} ({{$d['short_name']}})</option>
				                        @else
				                            <option value="{{ $d['id'] }}"> {{ $d['name'] }} ({{$d['short_name']}})</option>
				                        @endif
				                     @endforeach
			                    </select>
			                </div>
			            </div>

			            @if(Auth::user()->id == $user->id)
			            	<div class="form-group">
			            		<label class="col-md-4 control-label" for="phone">Téléphone</label>

				            	<div class="col-md-6">
				                    <input type="text" class="form-control input-sm" name="phone" value="{{ $user->phone }}">
				                </div>
				            </div>
						@endif

						<div class="from-group">
							<label class="col-md-4 control-label" for="profil_picture">Photo de profil</label>

							<div class="col-md-6">
								<input type="file" name="profil_picture" accecpt="image/*" id="photo">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="description">Description</label>

							<div class="col-md-10">
								<textarea rows="3" name="description" class="form-control input-sm" required></textarea>
							</div>
						</div>

						<div class="form-group">
					    	<div class="col-lg-10 col-lg-offset-2">
					    		<button type="reset" class="btn btn-default">Annuler</button>
					    		<button type="submit" class="btn btn-primary">Modifier</button>
					    	</div>
					    </div>

					</fieldset>
		        </form>
			</div>	
		</div>
	</div>
</div>
@stop

@section('js')
    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
	<script type="text/javascript">
		CKEDITOR.replace( 'description' );
	</script>
@stop