<div class="form-group">
		{!! Form::label('invoiceNumber', 'Invoice Number') !!}
		{!! Form::text('invoiceNumber', null , ['class' => 'form-control', 'disabled' => "" ]) !!}
	</div>

<div class="form-group">
		@if($submitButtonText != 'Add Invoice')
			{!! Form::label('created_at', 'Date Created') !!}
		
			{!! Form::text('created_at', isset($rows) ? $rows->created_at->format($carbon_dateFormat) : null, ['class' => 'form-control datepicker', 'disabled' => 'true' ]) !!}
		@endif
			
	</div>
<div class="form-group">
		{!! Form::label('dueDate', 'Due Date') !!}
		{!! Form::text('dueDate', isset($rows) ? $rows->dueDate->format($carbon_dateFormat) : null, ['class' => 'form-control datepicker']) !!}
	</div>
	
<div class="form-group">

		{!! Form::label('client[clientName]', 'Client:') !!}
		

		{!! Form::text('client[clientName]', isset($rows) ? $rows->client->companyName .' - '. 	$rows->client->clientName : null, ['class' => 'form-control', 'id' => 'clientList', 'placeholder' => 'Company Name - Client Name']) !!}
			
		{!! Form::input('hidden', 'client_id', isset($rows) ? $rows->client->id : null, ['id' => 'client_id']) !!}
		
		
	</div>
	
	<div class="form-group" id='clientInfo'>
		@if(isset($rows) && isset($rows->client))
			@include('clients.view', ['rows' => $rows->client, 'hideModal' => true ] )
		@endif
	</div>
	
	<div class="form-group" id="lineItems">
	
                <div class="row" style="font-weight: bold">
                    

                     <div class="col-xs-3">
                         Hours
                     </div>

                     <div class="col-xs-3">
                         Service Name
                     </div>
					 <div class="col-xs-3">
                         Total
                     </div>
					 <div class="col-xs-3">
                        Action
                    </div>
                </div>
		@if(isset($rows) && count($rows->InvoiceLineItems) > 0)
			
			@for ($i = 0; $i < count($rows->InvoiceLineItems); $i++)
				
				<div class="row">
					
                    <div class="col-xs-3">
                        {!! Form::text('invoiceLineItems['.($i+1).'][totalHours]', $rows->InvoiceLineItems[$i]->totalHours, [ 'min' => 1, 'class' => 'totalHours' ] ) !!}
                    </div>

                     <div class="col-xs-3">
                         {!! Form::text('invoiceLineItems['.($i+1).'][name]', $rows->InvoiceLineItems[$i]->name, [ 'class' => 'serviceList']) !!}
                     </div>

                     <div class="col-xs-3">
                         {!! Form::text( 'invoiceLineItems['.($i+1).'][totalPrice]', $rows->InvoiceLineItems[$i]->totalPrice, ['disabled' => "", 'class' => 'totalPrice']) !!}
						 {!! Form::input('hidden', 'invoiceLineItems['.($i+1).'][flatRate]', $rows->InvoiceLineItems[$i]->flatRate, ['class' => 'flatRate']) !!}
						 
						 {!! Form::input('hidden', 'invoiceLineItems['.($i+1).'][hourlyRate]', $rows->InvoiceLineItems[$i]->hourlyRate, ['class' => 'hourlyRate']) !!}
						 
						 {!! Form::input('hidden', 'invoiceLineItems['.($i+1).'][shortDescription]', $rows->InvoiceLineItems[$i]->shortDescription, ['class' => 'shortDescription']) !!}
						 
						 {!! Form::input('hidden', 'invoiceLineItems['.($i+1).'][longDescription]', $rows->InvoiceLineItems[$i]->longDescription, ['class' => 'longDescription']) !!}
                     </div> 
					 <div class="col-xs-3">
						@if($i != 0)
                         <button type="button" class="btn btn-danger removeLine">Remove</button>
						@endif
                     </div>
					 
                </div>
			@endfor
		@else
			<div class="row">
					
                    <div class="col-xs-3">
                        {!! Form::text('invoiceLineItems[1][totalHours]', 1, [ 'min' => 1, 'class' => 'totalHours' ] ) !!}
                    </div>

                     <div class="col-xs-3">
                         {!! Form::text('invoiceLineItems[1][name]', null, [ 'class' => 'serviceList']) !!}
                     </div>

                     <div class="col-xs-3">
                         {!! Form::text( 'invoiceLineItems[1][totalPrice]', null, ['disabled' => "", 'class' => 'totalPrice']) !!}
						 {!! Form::input('hidden', 'invoiceLineItems[1][flatRate]', null, ['class' => 'flatRate']) !!}
						 
						 {!! Form::input('hidden', 'invoiceLineItems[1][hourlyRate]', null, ['class' => 'hourlyRate']) !!}
						 
						 {!! Form::input('hidden', 'invoiceLineItems[1][shortDescription]', null, ['class' => 'shortDescription']) !!}
						 
						 {!! Form::input('hidden', 'invoiceLineItems[1][longDescription]', null, ['class' => 'longDescription']) !!}
                     </div> 
					 <div class="col-xs-3">
                         
                     </div>
					 
                </div>
		@endif

	</div>
	
	<div class="row">
		<div class="col-xs-3">
			<button type="button" class="btn btn-danger addLine">Add Service</button>
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('subtotal', 'Subtotal') !!}
		{!! Form::text('subtotal', null, ['class' => 'form-control', 'id' => 'subtotal', 'disabled' => "" ]) !!}
	</div>
	<div class="form-group">
		{!! Form::label('taxRate', 'Tax Rate') !!}
		{!! Form::text( 'taxRate', 0, ['class' => 'form-control', 'id' => 'taxRate'  ]) !!}
	</div>
	<div class="form-group">
		{!! Form::label('total', 'Total') !!}
		{!! Form::text('total', 0, ['class' => 'form-control', 'id' => 'total', 'disabled' => ""  ]) !!}
	</div>
	
	<div class="form-group text-right">
		<button type="button" id="ajax-submit-btn" class="btn btn-default" onclick="{{$onClick}}">{{$submitButtonText}}</button> 
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	</div>
	
	<script>
		function log( message ) {
		  console.log(message);
		}
		
		function genRow(){
			var html = '<div class="row"><div class="col-xs-3"><input min="1" name="invoiceLineItems[][totalHours]" class="totalHours"  value="1"></div><div class="col-xs-3"><input name="invoiceLineItems[][name]" class="serviceList" type="text" value=""></div><div class="col-xs-3"><input disabled name="invoiceLineItems[][totalPrice]" class="totalPrice"   value=""><input name="invoiceLineItems[][flatRate]" class="flatRate" type="hidden" value=""><input name="invoiceLineItems[][hourlyRate]" class="hourlyRate" type="hidden" value=""><input name="invoiceLineItems[][shortDescription]" class="shortDescription" type="hidden" value=""><input name="invoiceLineItems[][longDescription]" class="longDescription" type="hidden" value=""></div><div class="col-xs-3"><button type="button" class="btn btn-danger removeLine">Remove</button></div></div>';
			
			return html;
		}
		
		function recalculateIDs(){
			$('.totalHours').each(function(i, obj) {
				$(this).attr('name', 'invoiceLineItems['+(i+1)+'][totalHours]');
			});
			
			$('.serviceList').each(function(i, obj) {
				$(this).attr('name', 'invoiceLineItems['+(i+1)+'][name]');
			});
			
			$('.totalPrice').each(function(i, obj) {
				$(this).attr('name', 'invoiceLineItems['+(i+1)+'][totalPrice]');
			});
			
			$('.flatRate').each(function(i, obj) {
				$(this).attr('name', 'invoiceLineItems['+(i+1)+'][flatRate]');
			});
			
			$('.hourlyRate').each(function(i, obj) {
				$(this).attr('name', 'invoiceLineItems['+(i+1)+'][hourlyRate]');
			});
			
			$('.shortDescription').each(function(i, obj) {
				$(this).attr('name', 'invoiceLineItems['+(i+1)+'][shortDescription]');
			});
			
			$('.longDescription').each(function(i, obj) {
				$(this).attr('name', 'invoiceLineItems['+(i+1)+'][longDescription]');
			});
			
		}
		
		function calculateTotals(){
			var sum = 0.00;
			$(".totalPrice").each(function(){
				sum += +$(this).val();
			});
					
			var taxRate = parseFloat($('#taxRate').val())/100;
			$('#subtotal').val(sum.toFixed(2));
			$('#total').val((sum * (1 + taxRate)).toFixed(2)  );
		}
		
		function applyHandlers(){
			
			$( ".serviceList" ).autocomplete({
			  appendTo: $('.ui-autocomplete-input').parent(),
			  source: "{{action('InvoiceController@serviceList')}}",
			  minLength: 0,
			  select: function( event, ui ) {
				log( ui.item ?
				  "Selected: " + ui.item.value + " aka " + ui.item.id :
				  "Nothing selected, input was " + this.value );
				
				//TODO: update name attribute for laravel? This may not be needed.
				
				var hours = $(this).closest('div.row').children(':nth-child(1)').find('input').val();
				
				if(!hours)
					hours = 1;
				
				
				
				var price = parseFloat(ui.item.flatRate) + (parseFloat(ui.item.hourlyRate)*parseFloat(hours));
				
				log("Hours " + hours + " HourlyRate "+ ui.item.hourlyRate + " Flat Rate "+ ui.item.flatRate +" Price " + price);
				
				//update price of service you just changed
				var previousPrice = $(this).closest('div.row').children(':nth-child(3)').find('input').val();
				
				var priceBox = $(this).closest('div.row').children(':nth-child(3)').children('.totalPrice').val(price.toFixed(2));
				
				$(this).closest('div.row').children(':nth-child(3)').children('.flatRate').val(ui.item.flatRate);
				$(this).closest('div.row').children(':nth-child(3)').children('.hourlyRate').val(ui.item.hourlyRate);
				$(this).closest('div.row').children(':nth-child(3)').children('.shortDescription').val(ui.item.shortDescription);
				$(this).closest('div.row').children(':nth-child(3)').children('.longDescription').val(ui.item.longDescription);

				calculateTotals();
				  
			  }
			});
			
			
			
			$('.removeLine').on('click', function(){
				$(this).parent().parent().remove();

				recalculateIDs();

				calculateTotals();
	
			});
			
			$('#taxRate').on('input', function() {
				calculateTotals();	
			});
			
			$('.totalHours').on('input', function(){
				
				var hours = 1;
				
				if($(this).val())
					hours = parseFloat($(this).val());
				
				var flatRate = $(this).closest('div.row').children(':nth-child(3)').children('.flatRate').val();
				
				var hourlyRate = $(this).closest('div.row').children(':nth-child(3)').children('.hourlyRate').val();
				
				var price = parseFloat(flatRate) + parseFloat(hourlyRate)*hours;
					
				$(this).closest('div.row').children(':nth-child(3)').children('.totalPrice').val(price.toFixed(2));
				
				calculateTotals();
		
			});
			
			
		}
	
	
	    $(function() {

			$( "#clientList" ).autocomplete({
			  appendTo: $('#clientList').parent(),
			  source: "{{action('InvoiceController@clientList')}}",
			  minLength: 0,
			  select: function( event, ui ) {
				  
				  $('#client_id').val(ui.item.id);
				  
				log( ui.item ?
				  "Selected: " + ui.item.value + " aka " + ui.item.id :
				  "Nothing selected, input was " + this.value );
				  
				  $.ajax({
					  method: "GET",
					  url: "{{action('ClientController@showPlain')}}",
					  data: { id : ui.item.id }
					})
					  .done(function( msg ) {
						$('#clientInfo').html(msg);
						
						
					  });
							 
						
			  }
			});
			
			$('#taxRate').on('input', function() {
				var taxRate = parseFloat($("#taxRate").val()) / 100;
				var subTotal = parseFloat($("#subtotal").val());
				
				$("#subtotal").val(subTotal.toFixed(2));
				$("#total").val((subTotal* (1 + taxRate) ).toFixed(2));
			});

			$('.addLine').on('click', function(){

				$('#lineItems').append(genRow());
				
				applyHandlers();
				
				recalculateIDs();

			});
			
			applyHandlers();
			
			
			
			$( "#dueDate" ).datepicker({
			  defaultDate: "+1day",
			  dateFormat: "{{$jquery_datepicker_dateFormat}}",
			  minDate: 1
			});
			
		  });
		  
		  
	</script>