@extends('layouts.app')

@section('title')
    Page introuvable
@stop

@section('breadcrumb')
    <li class="active"> Page introuvable </li>
@stop


@section('content')

<div class="container">
    <div class="content404">
        <h1 class="title">404</h1>
        <h2 class="subtitle">Oops, Something's wrong...</h2>
    </div>
</div>
<style>


    .content404 {
        text-align: center;
        display: block;
    }

    .title {
        font-size: 150px;
        margin-bottom:-20px;
    }

    .subtitle{
        font-size:20px;
        font-weight:normal;
        font-style: italic;
    }
</style>

@stop
