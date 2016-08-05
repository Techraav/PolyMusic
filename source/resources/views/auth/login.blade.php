@extends('layouts.app')

@section('title')
    Connexion
@stop

@section('breadcrumb')
    <li class="active">Connexion </li>
@stop

@section('content')
    <div class="container">

        <div class="row" style="margin-top:20px">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <form class="form-horizontal" role="form" method="post" action="{{ url('auth/login') }}">
                    {!! csrf_field() !!}

                    <fieldset>
                        <h1>Connexion</h1>
                        <hr class="colorgraph">
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Adresse e-mail">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Mot de passe">
                        </div>

                        <div class="form-group" align="center">
                            <div class="g-recaptcha" data-sitekey="6LemUBsTAAAAAMytHw0RY9Y6VPtIUIG66yxUawyG"></div>
                        </div> 

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <button type="submit" class="btn btn-primary btn-block" >Connexion</button>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <button href="{{ url('auth/register') }}" class="btn btn-default btn-block">Register</button>
                            </div>
                        </div>
                        <!-- <a href="" class="btn btn-link pull-left ">Mot de passe oublié ?</a> -->
                    </fieldset>
                </form>
            </div>
        </div>

    </div>


@endsection
