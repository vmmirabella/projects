@extends('layouts.default')

@section('title')
Welcome
@stop

@section('head')

@stop

@section('body')
@include('layouts.header', ['nav' => 'Home'] )

<div class="row">
	<p>You have successfully logged in.</p>
</div> 
@stop