@extends('layouts.default')

@section('title')
Login
@stop

@section('body')
<h1>Reset Password</h1>
  
<form method="POST" action="{{URL::action('Auth\PasswordController@postEmail')}}">
    {!! csrf_field() !!}

    @include('errors.list')

    <div class="form-group">
        {!! Form::label('email', 'E-Mail:') !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-default" >
            Send Password Reset Link
        </button>
    </div>
</form>
@stop