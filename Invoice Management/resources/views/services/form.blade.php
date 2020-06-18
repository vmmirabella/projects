<div class="form-group">
		{!! Form::label('name', 'Name:') !!}
		{!! Form::text('name', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('shortDescription', 'Short Description:') !!}
		{!! Form::text('shortDescription', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('flatRate', 'Flat Rate:') !!}
		{!! Form::text('flatRate', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('hourlyRate', 'Hourly Rate:') !!}
		
		@if(!isset($rows))
		{!! Form::text('hourlyRate', 0, ['class' => 'form-control']) !!}
		@else
		{!! Form::text('hourlyRate', $rows->hourlyRate, ['class' => 'form-control']) !!}	
		@endif
	</div>
	
	<div class="form-group">
		{!! Form::label('longDescription', 'Long Description:') !!}
		{!! Form::textarea('longDescription', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group text-right">
		<button type="button" id="ajax-submit-btn" class="btn btn-default" onclick="{{$onClick}}">{{$submitButtonText}}</button> 
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	</div>