@extends('layouts.app')

@section('title')
    S'enregistrer
@stop

@section('breadcrumb')
    <li class="active"> Inscription </li>
@stop

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 align="center">Inscription</h1>
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('auth/register') }}">
                        {!! csrf_field() !!}
 
                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
                            <label class="control-label">&nbsp; Prénom : </label>

                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                        </div>                        

                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
                            <label class="control-label">&nbsp; Nom : </label>

                            <input type="text" class="form-control" name="last_name"  value="{{ old('last_name') }}"> 
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                            <label class="control-label">&nbsp; Adresse e-mail : </label>

                                <input type="email" class="form-control" name="email"  value="{{ old('email') }}">
                        </div>

                        <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : ''}}">
                            <label class="control-label">&nbsp; Date de naissance : </label>

                                <input type="date" class="form-control" name="birth_date" value="{{ old('birth_date') }}" placeholder="jj/mm/aaaa">
                                <span class="info"><i>&nbsp; Formats attendus : <b>jj/mm/aaaa</b> ou <b>aaaa-mm-jj</b>.</i></span>
                        </div>


                        <div class="form-group {{ $errors->has('school_year') ? 'has-error' : ''}}">
                            <label class="control-label" for="school_year"> &nbsp; Année d'étude : </label>

                                <select class="form-control" name="school_year">
                                    <option disabled selected>Sélectionnez une année d'étude...</option>
                                    <option {{ old('school_year') == 1 ? 'selected' : '' }} value="1">PeiP 1</option>
                                    <option {{ old('school_year') == 2 ? 'selected' : '' }} value="2">PeiP 2</option>
                                    <option {{ old('school_year') == 3 ? 'selected' : '' }} value="3">3ème année</option>
                                    <option {{ old('school_year') == 4 ? 'selected' : '' }} value="4">4ème année</option>
                                    <option {{ old('school_year') == 5 ? 'selected' : '' }} value="5">5ème année</option>
                                    <option {{ old('school_year') != null && old('school_year') == 0 ? 'selected' : '' }} value="0">Autre...</option>
                                </select>
                        </div>

                        <div class="form-group {{ $errors->has('department_id') ? 'has-error' : ''}}">
                            <label class="control-label" for="department_id"> &nbsp; Département : </label>

                                <select class="form-control"  name="department_id">
                                    <option disabled selected>Sélectionnez un département...</option>
                                    @foreach ($departments as $d)
                                        <option {{ old('department_id') == $d->id ? 'selected' : '' }} value="{{ $d['id'] }}"> {{ $d['name'] }} ({{$d['short_name']}})</option>
                                    @endforeach
                                </select>
                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                            <label class="control-label">&nbsp; Mot de passe : </label>

                                <input type="password" class="form-control" name="password">
                                @if($errors->has('password'))
                                    @foreach($errors->get('password') as $e)
                                    <span class="help-block">{{ $e }}</span>
                                    @endforeach
                                @endif
                        </div>

                        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                            <label class="control-label">&nbsp; Confirmation : </label>

                                <input type="password" class="form-control" name="password_confirmation">
                        </div>

                        <br />

                        <div class="form-group {{ $errors->has('g-recaptcha-response') ? 'has-error' : ''}}" align="center">
                            <div class="g-recaptcha" data-sitekey="6LemUBsTAAAAAMytHw0RY9Y6VPtIUIG66yxUawyG"></div>
                        </div>

                        <br />

                        <div class="form-group buttons">
                                <button type="submit" class="btn btn-primary">S'enregister</button> &nbsp;&nbsp;
                                <a href="{{ url('auth/login') }}"><button type="button" class="btn btn-default">Déjà inscrit ?</button></a>
                        </div>
                    </form>
                </div>    
        </div>
    </div>
</div>
@endsection
