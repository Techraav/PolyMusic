@extends('layouts.app')

@section('content')
	
		
	<h1 align="center">Rechercher un cours </h1>
	<div class="col-lg-6 col-lg-offset-3 search-result">
	
	@if(isset($error) && $error === true)
		<p align="center">Aucun résultat n'a été trouvé. Veuillez recommencer.</p>

	@else
		@if(isset($courses))

		<h4 class="help-block" align="center">Rechecher selon le jour </h4>
		<h4 class="help-block" align="center">Jour : {{ ucfirst(day($value)) }}</h4>
		<br />

		@if($courses->count() > 0)
			<ul class="list-group">
				<li align="center" class="list-group-item active">{{ ucfirst(day($value)) }} :</li>
				<ul class="list-group">
					@foreach($courses as $c)

						<a title="{{ $c->name }}" align="center" href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{!! cut($c->name, 60) !!}</a>

					@endforeach
				</ul>
			</ul>
		@else
			<p align="center">Aucun cours ne correspond à votre recherche.</p>
		@endif

		@elseif(isset($result))
			@if($search == 'instrument')

				<h4 class="help-block" align="center">Rechecher selon l'instrument </h4>
				<h4 class="help-block" align="center">Mot(s) clé(s) : {{ $value }}</h4>

				<br />

				<ul class="list-group">
					<?php $n = 0 ?>
					@foreach($result as $r)
						@if($r->courses->count() > 0)
						<?php $n++ ?>
						<li align="center" class="list-group-item active">{{ ucfirst($r->name) }} :</li>
						<ul class="list-group">
							@foreach($r->courses as $c)

								<a title="{{ $c->name }}" align="center" href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{!! cut($c->name, 60) !!}</a>

							@endforeach
						</ul>
						@endif
					@endforeach
					@if($n == 0)
						<p align="center">Aucun cours ne correspond à votre recherche.</p>
					@endif
				</ul>

			@elseif($search == 'teacherfn')

				<h4 class="help-block" align="center">Rechecher selon le prénom du professeur </h4>
				<h4 class="help-block" align="center">Mot(s) clé(s) : {{ $value }}</h4>

				<br />

				<ul class="list-group">
					<?php $n = 0 ?>
					@forelse($result as $r)
						@if($r->courseManaged->count() > 0)
						<?php $n++ ?>
						<li align="center" class="list-group-item active">{{ ucfirst($r->first_name).' '.ucfirst($r->last_name) }} :</li>
						<ul class="list-group">
							@foreach($r->courseManaged as $c)

								<a title="{{ $c->name }}" align="center" href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{!! cut($c->name, 60) !!}</a>

							@endforeach
						</ul>
						@endif
					@endforeach
					@if($n == 0)
						<p align="center">Aucun cours ne correspond à votre recherche.</p>
					@endif
				</ul>


			@elseif($search == 'teacherln')

				<h4 class="help-block" align="center">Rechecher selon le nom de famille du professeur </h4>
				<h4 class="help-block" align="center">Mot(s) clé(s) : {{ $value }}</h4>

				<br />

				<ul class="list-group">
					<?php $n = 0 ?>
					@forelse($result as $r)
						<?php $n++ ?>
						@if($r->courseManaged->count() > 0)
						<li align="center" class="list-group-item active">{{ ucfirst($r->first_name).' '.ucfirst($r->last_name) }} :</li>
						<ul class="list-group">
							@foreach($r->courseManaged as $c)

								<a title="{{ $c->name }}" align="center" href="{{ url('courses/show/'.$c->slug) }}" class="list-group-item">{!! cut($c->name, 60) !!}</a>

							@endforeach
						</ul>
						@endif
					@endforeach
					@if($n == 0)
						<p align="center">Aucun cours ne correspond à votre recherche.</p>
					@endif
				</ul>


			@endif
		@endif

	@endif

	</div>

@stop