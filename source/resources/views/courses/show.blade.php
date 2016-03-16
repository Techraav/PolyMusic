
@extends('layouts.app')

@section('content')
	
	<div class="jumbotron course-sheet">
		<div class="course-controls">
			@if(Auth::guest())
				<span class="help-block"><i>Vous souhaitez vous inscrire à ce cours ? {!! printLink('auth/login', 'Connectez-vous') !!} ou {!! printLink('auth/register', 'Inscrivez-vous') !!} dès maintenant !</i></span>
			@else
				@if($course->teachers->contains(Auth::user()))
					<span class="line-through"><button type="button" class="{{ glyph('education') }}"></button></span>
				@else
					<button type="button" class="{{ glyph('education') }}"></button>
				@endif

				@if($course->users->contains(Auth::user()))
					<strike> &nbsp;<p type="button" class="{{ glyph('blackboard') }}"></p>&nbsp; </strike>
				@else
					<button type="button" class="{{ glyph('blackboard') }}"></button>
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
						@foreach($course->users as $m)
							<div class="member">
								<p align="center"><a href="{{ url('users/'.$m->slug) }}"><img class="profil-picture" src="{{ URL::asset('img/profil_pictures/'.$m->profil_picture) }}" /></a></p>
								<p align="center"><a href="{{ url('users/'.$m->slug) }}">{{ $m->first_name }}</a> </p>
							</div>
						@endforeach
					</div>
					
					<div id="teachers" class="tab-pane fade in teachers members" >
							@foreach($course->teachers as $m)
								<div class="member">
									<p align="center"><a href="{{ url('users/'.$m->slug) }}"><img class="profil-picture" src="{{ URL::asset('img/profil_pictures/'.$m->profil_picture) }}" /></a></p>
									<p align="center"><a href="{{ url('users/'.$m->slug) }}">{{ $m->first_name }}</a> </p>
								</div>
							@endforeach
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

	  	<!-- Modal content-->
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>

		        <div class="modal-body">
		        	<img id="picture" src="">
        			<p id="description"></p>
		        </div>
		</div>
	</div>

@stop

@section('js')

<script type="text/javascript">
	function modalPicture(el)
	{
		var src = el.getAttribute('src');

		$('#modalPicture .modal-body #picture').attr('src', src);
		$('#modalPicture').modal('show');
	}

	$('#modalPicture .modal-body #picture').click(function() {
		$('#modalPicture').modal('hide');
	});

</script>

@stop