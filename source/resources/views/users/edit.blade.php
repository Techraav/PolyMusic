@extends('layouts.app')

@section('title')
	Modifier son profil
@stop

@section('breadcrumb')
    <li> <a href="{{ url('users') }}">Utilisateurs</a></li>
    <li class="active">{{ $user->first_name}} {{ $user->last_name }}</li>
@stop

@section('content')
<div class="jumbotron">
	<div class="profile">
		<h1 align="center">{{ $user->first_name}} {{ $user->last_name }}</h1>
		<br/>
			<div>				
				<form enctype="multipart/form-data" class="form-horizontal" role="form" method="post" action="{{ url('users/edit/'.$user->slug) }}">
	            {!! csrf_field() !!}
	            	<fieldset>

	            		<div class="row col-md-5">	    
	            			<div class="profil-pict">
	            				<img src=" {{ URL::asset('/img/profil_pictures/'.$user->profil_picture) }} " title="profile picture"/>
	            			</div>
            				<div class="form-group">            					
            					<br/>            					
            						{!! printFileInput('profil_picture', ['png','jpeg','jpg'], false, ['accept' => 'image/png, image/jpeg'], 'Formats acceptés: PNG et JPEG', []) !!}							
            				</div>

	            		</div>

	            		<input name="id" value="{{ $user->id }}" hidden>

	            		<div class="row col-md-7">
	            			<div class="form-group edit-infos-profile">
				                <label class="col-md-4 control-label" for="school_year">Année d'étude</label>

				                <div class="col-md-6">
				                    <select class="form-control input-sm" name="school_year">
				                        <option value="1" {{$user->school_year == 1 ? 'selected' : ''}}>PeiP 1</option>
				                        <option value="2" {{$user->school_year == 2 ? 'selected' : ''}}>PeiP 2</option>
				                        <option value="3" {{$user->school_year == 3 ? 'selected' : ''}}>3ème année</option>
				                        <option value="4" {{$user->school_year == 4 ? 'selected' : ''}}>4ème année</option>
				                        <option value="5" {{$user->school_year == 5 ? 'selected' : ''}}>5ème année</option>
				                        <option value="0" {{$user->school_year == 0 ? 'selected' : ''}}>Autre...</option>
				                    </select>
				                </div>
				            </div>

				            <div class="form-group edit-infos-profile">
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
				            	<div class="form-group edit-infos-profile">
				            		<label class="col-md-4 control-label" for="phone">Téléphone</label>

					            	<div class="col-md-6">
					                    <input type="text" class="form-control input-sm" name="phone" value="{{ $user->phone }}">
					                </div>
					            </div>
							@endif
	            		</div>                      

	            		<div class="row col-md-12">
	            			<div class="form-group">
								<label class="control-label col-md-offset-1" for="description">Description</label>

								<div >
									<textarea rows="4" name="description" class="form-control input-sm">{{ $user->description }}</textarea>
								</div>
							</div>

	            		</div>
						
						<div class="form-group">
					    	<div class="col-md-10 col-md-offset-5">
					    		<button type="reset" class="btn btn-default">Annuler</button>
					    		<button type="submit" class="btn btn-primary">Modifier</button>
					    	</div>
					    </div>

					</fieldset>
		        </form>
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