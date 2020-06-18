<div class="form-group">
		{!! Form::label('companyName', 'Company Name:') !!}
		{!! Form::text('companyName', null, ['class' => 'form-control']) !!}
	</div>
	
<div class="form-group">
		{!! Form::label('clientName', 'Client Name:') !!}
		{!! Form::text('clientName', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('email', 'E-Mail:') !!}
		{!! Form::text('email', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('phone', 'Phone Number:') !!}
		{!! Form::text('phone', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('unitNumber', 'Unit Number:') !!}
		{!! Form::text('address[unitNumber]', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('street', 'Street:') !!}
		{!! Form::text('address[street]', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('city', 'City:') !!}
		{!! Form::text('address[city]', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('province', 'Province:') !!}
		{!! Form::text('address[province]', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('postalCode', 'Postal Code:') !!}
		{!! Form::text('address[postalCode]', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group text-right">
		<button type="button" id="ajax-submit-btn" class="btn btn-default" onclick="{{$onClick}}">{{$submitButtonText}}</button> 
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	</div>