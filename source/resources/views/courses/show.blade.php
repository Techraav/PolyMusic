@extends('layouts.app')

@section('title')
	{{ ucfirst($course->name) }}
@stop

@section('breadcrumb')
    <li> <a href="{{ url('courses/list') }}">Cours</a></li>
    <li class="active">{{ ucfirst($course->name) }} </li>
@stop


@section('content')
	
	<div class="jumbotron course-sheet">
		@if(Auth::check()	)
			@if(Auth::user()->level_id > 2)
				<a href="{{ url('admin/courses/'.$course->slug.'/members') }}" title="Gérer les cours" class="{{ glyph('cog') }}"></a>
			@endif
		@endif
		<div class="course-controls">
			@if(Auth::guest())
				<span class="help-block"><i>Vous souhaitez vous inscrire à ce cours ? {!! printLink('auth/login', 'Connectez-vous') !!} ou {!! printLink('auth/register', 'Inscrivez-vous') !!} dès maintenant !</i></span>
			@else
				@if($course->users->contains(Auth::user()))
					<button type="button" data-value="-1" title="Se désinscrire de ce cours" class="{{ glyph('education') }} green control-button"></button>
				@else
					@if($course->unvalidatedUsers->contains(Auth::user()))
						<button disabled  title="Votre demande n'a pas encore été traitée." type="button" data-value="1" class="{{ glyph('education') }} control-button glyph-disabled"></button>
					@else
						<button type="button" data-value="1" title="S'inscrire à ce cours" class="{{ glyph('education') }} control-button"></button>
					@endif
				@endif

				@if($course->teachers->contains(Auth::user()))
					<button type="button"  data-value="-2" title="Ne plus enseigner ce cours" class="{{ glyph('blackboard') }} green control-button"></button>
				@else
					@if($course->unvalidatedTeachers->contains(Auth::user()))
						<button disabled  title="Votre demande n'a pas encore été traitée." type="button" data-value="2" class="{{ glyph('blackboard') }} control-button glyph-disabled"></button>
					@else
						<button type="button" data-value="2" title="Demander à devenir professeur sur ce cours" class="{{ glyph('blackboard') }} control-button"></button>
					@endif
				@endif
			@endif
		</div>

		<div class="row">
			<div class="menu col-lg-3">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#article" data-toggle="tab" aria-expanded="true">Présentation</a></li>
				<li><a href="#members" data-toggle="tab" aria-expanded="true" href="#">Membres</a></li>
				<li><a href="#teachers" data-toggle="tab" aria-expanded="true" href="#">Professeurs</a></li>
				<li><a href="#infos" data-toggle="tab" aria-expanded="true" href="#">Infos Complémentaires</a></li>
				<li><a href="#photos" data-toggle="tab" aria-expanded="true" href="#">Photos</a></li>
					@if( Auth::guest() || !($course->users->contains(Auth::user()) || $course->teachers->contains(Auth::user()) || Auth::user()->level_id > 3)) 
						<li class="disabled" title="Vous devez être inscit à ce cours ou être administrateur pour voir les documents de ce cours" >			
							<span title="Vous devez être connecté, inscrit et accepté à ce cours pour accédez aux documents." class="disabled-link">Documents</span>
						</li>
					@else
						<li title="Vous devez être inscit à ce cours ou être administrateur pour voir les documents de ce cours" >
							<a href="#documents" data-toggle="tab" aria-expanded="true" href="#">Documents</a>
						</li>
					@endif 

				@if( Auth::check() && ($course->teachers->contains(Auth::user()) || Auth::user()->level_id > 3)) 
					<li><a href="#modifications" data-toggle="tab" aria-expanded="true" href="#">Modifications</a></li>
				@endif
			</ul>
			</div>	
			<div class="course-content col-lg-9">
				<h1 align="center">{{ ucfirst($course->name) }}</h1>
				<h4 align="center" class="help-block"><i>Responsable : {!! printUserLinkV2($course->manager) !!}</i></h4>
				<div class="tab-content" id="myTabContent">
					
					<div id="article" class="tab-pane fade in article active" >
						{!! $course->article->content !!}
					</div>
					
					<div id="members" class="tab-pane fade in members" >

						@for ($i = 0; $i < ($course->users->count() > 10 ? 10 : $course->users->count()); $i++)
							<div class="member">
								<p align="center"><a href="{{ url('users/'.$course->users[$i]->slug) }}"><img class="profil-picture" src="{{ URL::asset('img/profil_pictures/'.$course->users[$i]->profil_picture) }}" /></a></p>
								<p align="center"><a href="{{ url('users/'.$course->users[$i]->slug) }}">{{ $course->users[$i]->first_name }}</a> </p>
							</div>
						@endfor
					</div>
					
					<div id="teachers" class="tab-pane fade in teachers members" >
						@for ($i = 0; $i < ($course->teachers->count() > 10 ? 10 : $course->teachers->count()); $i++)
							<div class="member">
								<p align="center"><a href="{{ url('users/'.$course->teachers[$i]->slug) }}"><img class="profil-picture" src="{{ URL::asset('img/profil_pictures/'.$course->teachers[$i]->profil_picture) }}" /></a></p>
								<p align="center"><a href="{{ url('users/'.$course->teachers[$i]->slug) }}">{{ $course->teachers[$i]->first_name }}</a> </p>
							</div>
						@endfor
					</div>
					
					<div id="photos" class="tab-pane fade in photos" >
						<div class="content">
							@foreach ($course->article->images as $i)
									<img title="{{ $i->description }}" data-title="{{ $i->title }}" class="article-picture" src="{{ URL::asset('img/article_pictures/'.$i->name) }}" onclick="modalPicture(this)" />
							@endforeach
						</div>
						<a class="all" href="{{ url('articles/view/'.$course->article->slug.'/gallery') }}">Tout Voir</a>
					</div>
					
					<div id="infos" class="tab-pane fade in infos col-lg-8 col-lg-offset-2" >
						<table class="table table-stripped">
							<tbody>
								<tr>
									<td align="right" class="head"><b>Jour :</b></td>
									<td align="left">{{ ucfirst(day($course->day)) }}</td>
								</tr>
								<tr>
									<td align="right" class="head"><b>Horaires : </b></td>
									<td align="left">{{ showDate($course->start, 'H:i:s', 'H:i') }} - {{ showDate($course->end, 'H:i:s', 'H:i')  }}</td>
								</tr>
								<tr>
									<td align="right" class="head"><b>Instrument : </b></td>
									<td align="left">{{ ucfirst($course->instrument->name) }}</td>
								</tr>
							</tbody>
						</table>
						<br />
						@if($course->infos != '')
							<p>Informations complémentaires :</p>
						@endif
						<i>{!! $course->infos !!}</i>
					</div>

					@if(Auth::check())
						@if($course->users->contains(Auth::user()) || $course->teachers->contains(Auth::user()) || Auth::user()->level_id > 3)
							<div id="documents" class="tab-pane fade in documents photos" >
								<div class="content">
									@forelse ($course->documents as $d)
										<a title="Cliquez pour voir le document" class="pdf" href="{{ url('files/documents/'.$d->name )}}" target="_blank">
											<img class="article-picture" src="{{ URL::asset('img/pdf.png') }}"/>
											<span class="doc-infos">
												Date : {{ showDate($d->created_at, 'Y-m-d H:i:s', 'd/m/Y') }} <br />
												Auteur : {{ $d->author->first_name }} {{ substr($d->author->last_name, 0, 1) }}
											</span>
											<span class="download {{ glyph('download-alt') }}"></span>
										</a>
									@empty
									<br />
										<i>Aucun document pour le moment.</i>
									@endforelse
									</div>
								<div class="link-all" align="right"><a class="all" href="{{ url('articles/view/'.$course->slug.'/documents') }}">Voir plus de documents </a>	</div>				
							</div>
						@endif
					@endif

					@if(Auth::check())
						@if($course->users->contains(Auth::user()) || $course->teachers->contains(Auth::user()) || Auth::user()->level_id > 3)
							<div id="modifications" class="tab-pane fade in modifications" >
								<ul class="list-group">
									@forelse( $course->modifications as $m)
										<li class="list-group-item modif-{{ $m->value }}">
											{!! printUserLinkV2($m->author) !!}
												@if($m->value == 0)
													<i>asked</i> to join course &laquo;
												@elseif($m->value == 1)
													<i>canceled</i> his demand to join course &laquo;
												@elseif($m->value == 2)
													<i>removed</i> {!! printUserLinkV2($m->user) !!} from &laquo;
												@elseif($m->value == 3)
													<i>added</i> {!! printUserLinkV2($m->user) !!} to &laquo;
										        @elseif($m->value == 4)
										          	<i>named</i> {!! printUserLinkV2($m->user) !!} as teacher of &laquo;
										        @elseif($m->value == 5)
								          			<i>downgraded</i> {!! printUserLinkV2($m->user) !!} to student of &laquo;
												@endif
													<a href="{{ url('admin/courses/'.$m->course->slug.'/members') }}">{{ $m->course->name }}</a> &raquo;   			
										</li>
									@empty
										<li class="list-group-item" align="center"> - </li>
									@endforelse
									@if($course->modifications->count() >= 10)
									@endif
										<div class="link-all" align="right"><a class="all" href="{{ url('admin/modifications/courses/'.$course->id) }}">Tout voir </a>	</div>
								</ul>					
							</div>
						@endif
					@endif
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalPicture" role="dialog">
		<div class="modal-picture">
	        <div class="modal-body">
	        	<img id="picture" src="">
    			<p id="description"></p>
	        </div>
		</div>
	</div>

	@if(Auth::check())
	<!-- Modal -->
	<div class="modal fade" id="modalControl" role="dialog">
		<div class="modal-dialog">

	  	<!-- Modal content-->
	      	<div class="modal-content">
	       	 	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title" class="modal-title"></h4>
	        	</div>

		        <form id="control-form" class="modal-form" method="post" action="{{ url('courses/user/management') }}">
		        {!! csrf_field() !!}
			        <div class="modal-body">
		        		<b><p id="warning" class="text-warning">		</p></b>
		        		<b><p id="danger" class="text-danger">		</p></b>
			         	<input hidden value="{{ $course->id }}" name="course_id" id="course_id" />
			         	<input hidden value="{{ Auth::user()->id }}" name="user_id" id="user_id" />
			         	<input hidden value="" name="value" id="value" />

			         	<div hidden id="control-textarea" class="form-group">
			         		<div class="form-group">
					         	<label class="control-label">Indiquez vos motivations et qualifications :</label>
					         	<textarea rows="5" max-length="255" class="form-control" id="message" name="message" placeholder="Préciser vos qualifications et motivations peut augmenter vos chances d'être accepté..."></textarea>
					         </div>
			         	</div>

			         	<div class="row">
				         	<div id="control-pw" class="form-group col-lg-8 col-lg-offset-2">
				         		<label>Entrez votre mot de passe :</label>
								<input hidden type="password" name="fakepwfield"/>
				         		<input class="form-control" type="password" id="password" name="password" />
				         	</div>
				         </div>
			        </div>
			        <div class="modal-footer">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          	<button type="submit" class="btn btn-primary">Valider</button>
			        </div>
				</form>

	   		</div>
		</div>
	</div>
	@endif

@stop

@section('js')
    <script src="{{ URL::asset('/js/ckeditor.js')  }}"></script>
@stop