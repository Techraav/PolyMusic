<?php 
	$cm = App\CourseModification::orderBy('id', 'desc')
			->with(['author', 
					'user', 
					'course'])
			->limit(5)->get();
?>

<div class="panel-default panel panel-course-modif">
	<div class="panel-heading">
		    <p align="center"><a align="right" href="{{ url('admin/modifications/courses') }}"><b>Gestion de membres des cours</b></a></p>
	</div>
		<ul class="list-group">
			@forelse( $cm as $m)
				<li class="list-group-item modif-{{ $m->value }}">
					@if($m->course->manager->id == Auth::user()->id)
						<b>
					@endif
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
					@if($m->course->manager->id == Auth::user()->id)
						</b>
					@endif        			
				</li>
			@empty
				<li class="list-group-item" align="center"> - </li>
			@endforelse
		</ul>
</div>