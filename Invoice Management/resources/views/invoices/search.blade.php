@extends('layouts.default')

@section('title')
Invoices
@stop

@section('head') 
		<style>
			input {
				width: 100%;
			}
			
			.paidRow {
				background-color: gainsboro;
			}
		</style>
  
@stop

@section('body')  

		@include('layouts.header', ['nav' => 'Invoices'] )

        <div class="row">
            <h1 class="text-center">Invoices</h1>
        </div>
        <div class="row">

            <form class="form-inline " id="searchBar" action="invoices" method="GET" >
                <div class="col-xs-12 text-center" >
					<div class="form-group">
						<input type="text" class="form-control" name="search"  placeholder="Invoice number or client name..." value="{{Input::get('search')}}"  size="30">		

						<input type="text" class="form-control" id="startDate" name="startDate"  placeholder="Start Date" value="{{Input::get('startDate')}}"  size="10">
							
						<span class="glyphicon glyphicon-minus " aria-hidden="true"></span>
						
						<input type="text" class="form-control" id="endDate" name="endDate"  placeholder="End Date" value="{{Input::get('endDate')}}"  size="10">
					</div>
					<div class="form-group">
					<button type="submit" class="btn btn-primary">Search</button>
					</div>
                </div>
                
            </form>
			 
        </div>
        <br />
        <div class="row text-center">
			<div class="btn-group" >
				<button type="button" id="create-form-btn" class="btn btn-default" href="invoices/create" data-toggle="modal" data-target="#create-form">Create A New Invoice</button>
				
				<a class="btn btn-default" href="{{URL::action('InvoiceController@index')}}" role="button">View All Invoices</a>
			</div>
        </div>
        
        <hr />
		
      @include('invoices.searchresults')
      @include('invoices.delete')
	  @include('invoices.paidDate')
	  @include('invoices.emptyModal')
	  
	  <script>
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
	  
			
	  </script>

@stop	