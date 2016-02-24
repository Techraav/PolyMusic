<h1>Test</h1>
@foreach ($d as $k => $v)
	{{$k.'  -  '.$v}} <br />
@endforeach
<br />

@foreach ($d as $k => $v)
	{{ str_slug($k)}}
@endforeach