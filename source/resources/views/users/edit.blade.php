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
	            	
	            		<div class="col-lg-4 col-lg-offset-1">	    
	            			<div class="profil-pict">
	            				<img src=" {{ URL::asset('/img/profil_pictures/'.$user->profil_picture) }} " title="profile picture"/>
	            				@if($user->id == Auth::user()->id && $user->profil_picture != "base_profil_picture.png")
									<button class="glyphicon glyphicon-trash profil-pict-remove delete-button" type="button" data-id="{{ $user->id }}" data-link="{{url("users/image/remove")}}"></button>
								@endif
	            			</div>
	            			@if($user->id == Auth::user()->id)
	            				<div class="form-group">            					
	            					<br/>            					
	            						{!! printFileInput('profil_picture', ['png','jpeg','jpg'], false, ['accept' => 'image/png, image/jpeg'], 'Formats acceptés: PNG et JPEG') !!}							
	            				</div>
            				@endif

	            		</div>

	            		<input name="id" value="{{ $user->id }}" hidden>

	            		<div class="col-lg-7 infos-profile">
							<table>
								<tbody>					
									<tr>
										<td>Année d'étude :</td>
										<td>
											<select class="form-control input-sm" name="school_year">
						                        <option value="1" {{$user->school_year == 1 ? 'selected' : ''}}>PeiP 1</option>
						                        <option value="2" {{$user->school_year == 2 ? 'selected' : ''}}>PeiP 2</option>
						                        <option value="3" {{$user->school_year == 3 ? 'selected' : ''}}>3ème année</option>
						                        <option value="4" {{$user->school_year == 4 ? 'selected' : ''}}>4ème année</option>
						                        <option value="5" {{$user->school_year == 5 ? 'selected' : ''}}>5ème année</option>
						                        <option value="0" {{$user->school_year == 0 ? 'selected' : ''}}>Autre...</option>
						                    </select>
					                    </td>
									</tr>
									<tr>
										<td>Département :</td>
										<td>
						                    <select class="form-control input-sm"  name="department_id">
						                         @foreach (App\Department::all()  as $d)
							                        @if($user->department_id == $d->id)
							                            <option value="{{ $d['id'] }}" selected> {{ $d['name'] }} ({{$d['short_name']}})</option>
							                        @else
							                            <option value="{{ $d['id'] }}"> {{ $d['name'] }} ({{$d['short_name']}})</option>
							                        @endif
							                     @endforeach
						                    </select>
										</td>
									</tr>
									<tr>
										<td>Téléphone :</td>
										<td><input type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" class="form-control input-sm" name="phone" value="{{ $user->phone }}"></td>
									</tr>



								</tbody>
							</table>
						</div>

	            		                

	            		<div class="row">
	            			<div class="col-lg-10 col-lg-offset-1">
		            			<div class="form-group">
									<h3> Description :</h3>

									<div >
										<textarea rows="4" name="description" class="form-control input-sm">{{ $user->description }}</textarea>
									</div>
								</div>
							</div>
	            		</div>
						
						<div class="form-group buttons">
					    	<div class="col-lg-8 col-lg-offset-2">
					    		<button type="reset" class="btn btn-default">Annuler</button>
					    		<button type="submit" class="btn btn-primary">Valider</button>
					    	</div>
					    </div>

					</fieldset>
		        </form>
			</div>	
	</div>
</div>

<div class="modal fade" id="modalDelete" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title">Supprimer votre photo de profil</h4>
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
		CKEDITOR.replace( 'description' );
	</script>
@stop

