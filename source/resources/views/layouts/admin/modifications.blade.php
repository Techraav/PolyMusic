<?php 
    $modif = App\Modification::orderBy('id', 'desc')->with('user')->limit(5)->get(['message', 'user_id', 'id', 'table', 'created_at'])
?>

<div class="panel panel-default panel-modifications">
    <div class="panel-heading">
        <p align="center"><a align="right" href="{{ url('admin/modifications') }}"><b>Dernières modifications</b></a></p>
    </div>
    <ul class="list-group">
        @forelse( $modif as $m)
        <li class="list-group-item">
        	<ul class="list-group">
                <li class="list-group-item">
                    <b>Par</b> : {!! printUserLinkV2($m->user) !!}, le {{ date_format($m->created_at, 'd/m/Y') }} à {{ date_format($m->created_at, 'H:i:s') }} 
                </li>
        		<li class="list-group-item"><b>Table</b> : {{ $m->table }}</li>
        		<li class="list-group-item"><b>Infos</b> : {{ $m->message }}</li>
        	</ul>
        </li>
        @empty
          <li class="list-group-item"><p>Aucune modification pour le moment.</p></li>                  
        @endforelse
    </ul>
</div>