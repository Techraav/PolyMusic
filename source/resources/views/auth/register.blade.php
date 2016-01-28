@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 align="center">Inscription</h1>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('auth/register') }}">
            {!! csrf_field() !!}

                @if($errors->any())
                    <div class="alert alert-dismissible alert-danger">
                        @foreach ($errors->all() as $e)
                            {{ $e }}
                        @endforeach
                    </div>
                @endif

            <div class="form-group">
                <label class="col-md-4 control-label">Prénom</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="first_name" value="">                                
                </div>
            </div>                        

            <div class="form-group">
                <label class="col-md-4 control-label">Nom</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="last_name" value="">                                
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Adresse e-mail</label>

                <div class="col-md-6">
                    <input type="email" class="form-control" name="email" value="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Date de naissance</label>

                <div class="col-md-6">
                    <input type="date" class="form-control" name="birth_date" value="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="school_year">Année d'étude</label>

                <div class="col-md-6">
                    <select class="form-control" name="school_year">
                        <option value="1">PeiP 1</option>
                        <option value="2">PeiP 2</option>
                        <option value="3">3ème année</option>
                        <option value="4">4ème année</option>
                        <option value="5">5ème année</option>
                        <option value="0">Autre...</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="department_id">Département</label>

                <div class="col-md-6">
                    <select class="form-control"  name="department_id">
                        @foreach ($departments as $d)
                            <option value="{{ $d['id'] }}"> {{ $d['name'] }} ({{$d['short_name']}})</option>
                        @endforeach
                        <option value="0">Autre...</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Mot de passe</label>

                <div class="col-md-6">
                    <input type="password" class="form-control" name="password">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Confirmation</label>

                <div class="col-md-6">
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
            </div>

            <div class="form-group buttons">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">Register</button> &nbsp;&nbsp;
                    <a href="{{ url('auth/login') }}"><button type="button" class="btn btn-default">Déjà inscrit ?</button></a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
