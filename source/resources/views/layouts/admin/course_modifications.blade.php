<div class="panel-default panel panel-course-modif">
	<div class="panel-heading">
		    <p align="center"><a align="right" href="{{ url('admin/modifications/courses') }}"><b>Gestion de membres des cours</b></a></p>
	</div>
		<ul class="list-group">
			@forelse( App\CourseModification::orderBy('id', 'desc')->limit(5)->get() as $m)
			<li class="list-group-item modif-{{ $m->value }}">
			@if(App\Course::where('id', $m->course_id)->first()->user_id == Auth::user()->id)
				<b>
			@endif
				@if($m->value == 0)
					{!! printUserLink($m->author_id) !!} <i>asked</i> to join course &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
				@elseif($m->value == 1)
					{!! printUserLink($m->author_id) !!} <i>canceled</i> his demand to join course &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;.
				@elseif($m->value == 2)
					{!! printUserLink($m->author_id) !!} <i>removed</i> {!! printUserLink($m->user_id) !!} from &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
				@elseif($m->value == 3)
					{!! printUserLink($m->author_id) !!} <i>added</i> {!! printUserLink($m->user_id) !!} to &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
        @elseif($m->value == 4)
          {!! printUserLink($m->author_id) !!} <i>named</i> {!! printUserLink($m->user_id) !!} as teacher of &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;    
        @elseif($m->value == 5)
          {!! printUserLink($m->author_id) !!} <i>downgraded</i> {!! printUserLink($m->user_id) !!} to student of &laquo; <a href="{{ url('admin/courses/'.App\Course::where('id', $m->course_id)->first()->slug.'/members') }}">{{ App\Course::where('id', $m->course_id)->first()->name }}</a> &raquo;
				@endif
			@if(App\Course::where('id', $m->course_id)->first()->user_id == Auth::user()->id)
				</b>
			@endif        			
			</li>
			@empty
				<li class="list-group-item" align="center"> - </li>
			@endforelse
		</ul>
</div>