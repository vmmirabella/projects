@extends('layouts.default')

@section('title')
Reports
@stop


@section('body')  

		@include('layouts.header', ['nav' => 'Reports'] )

        <div class="row">
            <h1 class="text-center">Reports</h1>
        </div>
		<div class="row">
            <p class="text-left">Choose a type of report to generate</p>
        </div>
		<div class="row">
			<ul>
				<li><a href="{{action('ReportController@client')}}">Client Report</a></li>
				<li><a href="{{action('ReportController@annually')}}">Annual Report</a></li>
				<li><a href="{{action('ReportController@monthly')}}">Monthly Report</a></li>
			</ul>
		</div>
		
@stop