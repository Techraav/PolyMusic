<div class="panel-default panel panel-course-modif">
	<div class="panel-heading">
		    <p align="center"><a align="right" href="{{ url('admin/modifications/courses') }}"><b>Gestion de membres des cours</b></a></p>
	</div>
		<ul class="list-group">
			@forelse( App\CourseModification::orderBy('id', 'desc')->limit(5)->get() as $m)
			<li class="list-group-item modif-{{ $m->value }}">
			{{-- @if(App\Course::where('id', $m->course_id)->first()->user_id == Auth::user()->id) --}}
			@if($m->course->manager->id == Auth::user()->id)
				<b>
			@endif
				@if($m->value == 0)
					{!! printUserLinkV2($m->author) !!} <i>asked</i> to join course &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
				@elseif($m->value == 1)
					{!! printUserLinkV2($m->author) !!} <i>canceled</i> his demand to join course &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;.
				@elseif($m->value == 2)
					{!! printUserLinkV2($m->author) !!} <i>removed</i> {!! printUserLinkV2($m->user) !!} from &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
				@elseif($m->value == 3)
					{!! printUserLinkV2($m->author) !!} <i>added</i> {!! printUserLinkV2($m->user) !!} to &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
        @elseif($m->value == 4)
          {!! printUserLinkV2($m->author) !!} <i>named</i> {!! printUserLinkV2($m->user) !!} as teacher of &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;    
        @elseif($m->value == 5)
          {!! printUserLinkV2($m->author) !!} <i>downgraded</i> {!! printUserLinkV2($m->user) !!} to student of &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
				@endif
			{{-- @if(App\Course::where('id', $m->course_id)->first()->user_id == Auth::user()->id) --}}
			@if($m->course->manager->id == Auth::user()->id)
				</b>
			@endif        			
			</li>
			@empty
				<li class="list-group-item" align="center"> - </li>
			@endforelse
		</ul>
</div>