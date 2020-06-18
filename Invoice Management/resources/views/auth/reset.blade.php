<form method="POST" action="{{URL::action('Auth\PasswordController@postReset')}}">
    {!! csrf_field() !!}
    <input type="hidden" name="token" value="{{ $token }}">

    @include('errors.list')

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
        <button type="submit" class="btn btn-default" >
            Reset Password
        </button>
    </div>
</form>