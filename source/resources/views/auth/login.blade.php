@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Connexion</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ url('auth/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="col-md-4 control-label">Adresse e-mail</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="">

                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Mot de passe</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Connexion
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Mot de passe oublié ?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
