@extends('layouts.default')

@section('title')
Reports - Anually
@stop

@section('head') 
		
		<script src="{{URL::asset('js/jquery-jqplot/jquery.jqplot.js')}}"></script>
		<script src="{{URL::asset('js/jquery-jqplot/plugins/jqplot.dateAxisRenderer.js')}}"></script>
		<script src="{{URL::asset('js/jquery-jqplot/plugins/jqplot.logAxisRenderer.js')}}"></script>
		<script src="{{URL::asset('js/jquery-jqplot/plugins/jqplot.canvasTextRenderer.js')}}"></script>
		<script src="{{URL::asset('js/jquery-jqplot/plugins/jqplot.pointLabels.js')}}"></script>
		<script src="{{URL::asset('js/jquery-jqplot/plugins/jqplot.canvasAxisTickRenderer.js')}}"></script>
		<script src="{{URL::asset('js/jquery-jqplot/plugins/jqplot.highlighter.js')}}"></script>
		<script src="{{URL::asset('js/jquery-jqplot/plugins/jqplot.ohlcRenderer.js')}}"></script>
		<script src="{{URL::asset('js/jquery-jqplot/plugins/jqplot.barRenderer.js')}}"></script>
		<script src="{{URL::asset('js/jquery-jqplot/plugins/jqplot.cursor.js')}}"></script>
		<link rel="stylesheet" href="{{URL::asset('js/jquery-jqplot/jquery.jqplot.css')}}" />
	  
@stop

@section('body') 

@include('layouts.header', ['nav' => 'Reports'] )

<div class="row">
    <h1 class="text-center">
	@if (Input::get('invoiceType')) 
		{{ucfirst (Input::get('invoiceType'))}}
	@else 
		Outstanding 
	@endif 
	
	Invoices - Annually</h1>
</div>
<div class="row" id="chartContainer" style="visibility:hidden;" >
	@if(is_null($json) || $json == '[]')
	<div id="noData" class="col-md-12">No results found</div>
	@else
	<p>Click and drag to zoom in on a region</p>
	<div id="chart" class="col-md-12" style="height:500px; width:100%;"></div>
	@endif
	
</div>	

<div class="row" style="margin-top:50px;margin-bottom:50px;">
	<form class="form-inline" id="dateRange" action="{{action('ReportController@annually')}}" method="GET" >
		<div class="form-group">
			<input type="text" class="form-control" id="startDate" name="startDate"  placeholder="Start Date" value="{{Input::get('startDate')}}"  size="10">
									
			<span class="glyphicon glyphicon-minus " aria-hidden="true"></span>
						
			<input type="text" class="form-control" id="endDate" name="endDate"  placeholder="End Date" value="{{Input::get('endDate')}}"  size="10">
		</div>
		<div class="form-group" >
			{!! Form::label('invoiceType', 'Invoice Type:') !!}
			
			{!! Form::select('invoiceType', ['outstanding' => 'Outstanding Invoices', 'paid' => 'Paid Invoices'], Input::get('invoiceType')); !!}
		</div>
		
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Generate Report</button>
		</div>
	
	</form>

</div>

<script>

$(function() {
@if(!is_null($json) && $json != '[]')
	var data = $.parseJSON('{!! $json !!}');
	

	var plot1 = $.jqplot('chart', [data], {
			seriesDefaults: {
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
			axes:{
				xaxis:{
					renderer:$.jqplot.DateAxisRenderer,
					tickRenderer: $.jqplot.CanvasAxisTickRenderer,
					tickOptions:{formatString:'%Y', angle: -90},
					tickInterval: '25 weeks'
				}
			},
			
			cursor:{
				show: true, 
				zoom: true
			},
			highlighter: {
				show: true,
				sizeAdjust: 7.5
			}
			 });	
@endif					
	$('#chartContainer').css('visibility', 'visible');	


	$( "#startDate" ).datepicker({
      defaultDate: "+1w",
	  dateFormat: "{{$jquery_datepicker_dateFormat}}",
      onClose: function( selectedDate ) {
        $( "#endDate" ).datepicker( "option", "minDate", selectedDate );
      }
    });
	
    $( "#endDate" ).datepicker({
      defaultDate: "+1w",
	  dateFormat: "{{$jquery_datepicker_dateFormat}}",
      onClose: function( selectedDate ) {
        $( "#startDate" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

});
</script>


@stop