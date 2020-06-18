@extends('layouts.default')

@section('title')
Reports - Client
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
	Invoices - Client</h1>
</div>

<div class="row">
	{!! Form::open(['url' => 'reports/client', 'id' => 'clientReportForm' ]) !!}
	<div class="ui-front form-group">
		{!! Form::label('client[clientName]', 'Client:') !!}

		{!! Form::text('client[clientName]', null, ['class' => 'form-control', 'id' => 'clientList', 'placeholder' => 'Company Name - Client Name']) !!}
			
		{!! Form::input('hidden', 'companyName', null, ['id' => 'companyName']) !!}
		{!! Form::input('hidden', 'clientName', null, ['id' => 'clientName']) !!}
	</div>
	<div class="form-group" id='clientInfo'>
		@if(isset($rows) && isset($rows->client))
			@include('clients.view', ['rows' => $rows->client, 'hideModal' => true ] )
		@endif
	</div>
	<div class="form-group">
		{!! Form::label('startDate', 'Start Date:') !!}
		<input type="text" class="form-control" id="startDate" name="startDate"  placeholder="Start Date" value="{{Input::get('startDate')}}"  size="10">
		{!! Form::label('endDate', 'End Date:') !!}				
		<input type="text" class="form-control" id="endDate" name="endDate"  placeholder="End Date" value="{{Input::get('endDate')}}"  size="10">
	</div>
	<div class="form-group" >
		{!! Form::label('invoiceType', 'Invoice Type:') !!}
			
		{!! Form::select('invoiceType', ['outstanding' => 'Outstanding Invoices', 'paid' => 'Paid Invoices'], Input::get('invoiceType')); !!}
	</div>

	<div class="form-group text-left">
		<button type="button" id="ajax-submit-btn" class="btn btn-default">Generate Report</button> 
	</div>
	{!! Form::close() !!}
</div>

<div class="row" id="chartContainer" style="visibility:hidden;margin-bottom:100px;" >
	<p>Click and drag to zoom in on a region</p>
	<div id="noData" class="col-md-12" style="visibility:hidden;">No results found</div>
	<div id="chart" class="col-md-12" style="height:500px; width:100%;"></div>
	
</div>


<script>
	function log( message ) {
	  console.log(message);
	}
	
	
	$(function() {
		
		$('#clientReportForm').submit(function() {
			if ($.trim($("#clientList").val()) === "" ) {
				return false;
			}
		});
		
			$("#clientList").click(function( event ) {
			  event.preventDefault();
			});
			
			$( "#clientList" ).autocomplete({
			  source: "{{action('ReportController@getInvoiceClients')}}",
			  minLength: 0,
			  select: function( event, ui ) {
				  
				  $('#clientName').val(ui.item.clientName);
				  $('#companyName').val(ui.item.companyName);
				  
				log( ui.item );
				  
				  $.ajax({
					  method: "GET",
					  url: "{{action('ReportController@showClient')}}",
					  data: { 
						id : ui.item.id,
						
					  },
					})
					  .done(function( msg ) {
						$('#clientInfo').html(msg);
						
						
					  });		
			  }
			});
			
		$('#ajax-submit-btn').on('click', function(){
			$.ajax({
				  type: 'get',
				  url: "{{action('ReportController@client')}}",
				  data: $('#clientReportForm').serialize(),
				  dataType: 'json',
				  success: function(data){
					if(data == undefined || data.length < 1) {
						$('#chartContainer').css('visibility', 'hidden');
						$('#noData').css('visibility', 'visible');
						return;
					}
					
					$('#chart').empty();
					 
					var plot1 = $.jqplot('chart', [data], {
					seriesDefaults: {
						renderer:$.jqplot.BarRenderer,
						pointLabels: { show: true }
					},
					axes:{
						xaxis:{
							renderer:$.jqplot.DateAxisRenderer,
							tickRenderer: $.jqplot.CanvasAxisTickRenderer,
							tickOptions:{ angle: -90}
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
					
					
					$('#chartContainer').css('visibility', 'visible');
					
				  },
				  error: function(data){
					
					log(data.responseText);
					
					// Render the errors with js ...
				  }
				});
			
		});
		
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