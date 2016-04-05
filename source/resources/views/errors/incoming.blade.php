@extends('layouts.app')

@section('title')
    Bientôt disponnible...
@stop

@section('breadcrumb')
    <li class="active"> Fonctionnalité à venir </li>
@stop


@section('content')

<div class="container">
    <div class="content">
        <h1 class="title">Be patient...</h1>
        <h2 class="subtitle">...incoming feature !</h2>
    </div>
</div>
<style>


    .content {
        text-align: center;
        display: block;
    }

    .title {
        font-size: 80px;
        margin-bottom:-20px;
    }

    .subtitle{
        font-size:30px;
        font-weight:normal;
        font-style: italic;
        text-indent:200px;
    }
</style>

@stop
