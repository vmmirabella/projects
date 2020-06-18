@extends('layouts.default')

@section('title')
Login
@stop

@section('body')
<h1>Login</h1>
  
<form method="POST" action="{{URL::action('Auth\AuthController@postLogin')}}">
    {!! csrf_field() !!}
	@include('errors.list')

    <div class="form-group">
        {!! Form::label('email', 'E-Mail:') !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'tabindex' => 1]) !!}
		<a href="{{URL::action('Auth\AuthController@getRegister')}}" tabindex="5">Register a new account?</a>
    </div>
	

    <div class="form-group">
        {!! Form::label('password', 'Password:') !!}
        {!! Form::password('password', ['class' => 'form-control','tabindex' => 2]) !!}
		<a href="{{URL::action('Auth\PasswordController@getEmail')}}" tabindex="6" >Forgot your password?</a>
    </div>
	
    <div class="form-group">
	{!! Form::label('remember', 'Remember me:') !!}
	{!! Form::checkbox('remember', null, null, ['id' =>'remember', 'tabindex' => 3]) !!}
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-default" tabindex="4">Login</button>
    </div>
</form>



@stop