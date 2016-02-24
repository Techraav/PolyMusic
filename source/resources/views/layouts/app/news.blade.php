<div class="panel panel-default panel-news">
    <div class="panel-heading">
        <p align="center"><a title="Tout voir" href="{{ url('news')}}"><i><b>Dernières news</b></i></a></p>
          @if(Auth::check() && Auth::user()->level->level >= 1)
         <a class="glyphicon glyphicon-plus" title="Ajouter une news" href="{{ url('admin/news/create') }}"></a>
          @endif
    </div>
        <ul class="list-group">
          @forelse( App\News::where('active', 1)->orderBy('id', 'desc')->limit(10)->get() as $n)
          <li class="list-group-item news-item">
              <div class="news-infos"><p><span>{{ showDate($n['created_at'], 'Y-m-d H:i:s', 'j M Y', false) }}</span></p></div> 
              <!-- <span class="trait"></span> -->
              <div class="content"><p><a href="{{ url('news/view/'.$n['slug'])}}">{{ strlen($n->title) > 40 ? substr($n->title, 0, 40).'...' :  $n->title }}</a></p></div>
              <span class="glyphicon glyphicon-menu-right"></span>
          </li>
          @empty
            <li class="list-group-item"><p>Pas de news pour le moment.</p></li>                  
          @endforelse
<!--                   @if(Auth::check() && Auth::user()->level->level >= 1)
            <li class="list-group-item"></li>
          @endif -->
        </ul>


    {{-- 2e VERSION --}}
    {{-- <table class="table">
    	<tbody>
        	@forelse( App\News::where('active', 1)->orderBy('id', 'desc')->limit(10)->get() as $n)
        	<tr height="25">
        		<td align="center" width="70"><span>{{ showDate($n['created_at'], 'Y-m-d H:i:s', 'j M Y', false) }}</span></td>
        		<td height="50" class="content"><a href="{{ url('news/view/'.$n['slug'])}}">{{ strlen($n->title) > 40 ? substr($n->title, 0, 40).'...' :  $n->title }}</a>
        		</td>
            <td><span class="glyphicon glyphicon-menu-right"></span></td>
        	</tr>
          @empty
          <td align="center">-</td>
          @endforelse
    	</tbody>
    </table> --}}
    {{-- --}}


    {{-- 1ere version --}}
     {{-- <ul class="list-group">
        @forelse( App\News::where('active', 1)->orderBy('id', 'desc')->limit(10)->get() as $n)
        <li class="list-group-item">
            <div class="news-infos"><p>{{ showDate($n['created_at'], 'Y-m-d H:i:s', 'j M Y', false) }}</p></div> 
          	<a href="{{ url('news/view/'.$n['slug'])}}">{{$n['title']}}</a>
        </li>
        @empty
          <li class="list-group-item"><p>Pas de news pour le moment.</p></li>                  
        @endforelse
        @if(Auth::check() && Auth::user()->level->level >= 1)
          <li class="list-group-item"><p><a href="{{ url('admin/news/create') }}">Ajouter une news</a></p></li>
        @endif
    </ul> --}}
    {{--  --}}
</div>