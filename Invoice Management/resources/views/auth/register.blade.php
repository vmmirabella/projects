@extends('layouts.default')

@section('title')
Register
@stop

@section('body')
<h1>Register</h1>  

<form method="POST" action="{{URL::action('Auth\AuthController@postRegister')}}">
    {!! csrf_field() !!}
	@include('errors.list')

    <div class="form-group">
		{!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', 'E-Mail:') !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Password:') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Confirm Password:') !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-default">Register</button>
    </div>
</form>
@stop