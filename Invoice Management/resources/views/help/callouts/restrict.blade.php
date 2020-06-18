
@if(!isset($rules) || $field === 'companyName' || $field === 'longDescription')
	<div class="bs-callout bs-callout-warning">
		<h4>Restrictions</h4>
		There are no restrictions on this field
	</div>
@elseif(!isset($rules[$field]))

	<div class="bs-callout bs-callout-warning">
		<h4>Restrictions</h4>
		<ul>
	@if(strcmp($field, "database_id") === 0)
		<li>The field must be filled in via autocomplete</li>
	@endif
	
	@if(strcmp($field, "add_service") === 0 )
		<li>An invoice must have at least one line item.</li>
	@endif
		</ul>
	</div>
@else
	<div class="bs-callout bs-callout-warning">
		<h4>Restrictions</h4>
		<ul>
	@if(strPos($rules[$field], 'alpha_spaces') !== FALSE )
			<li>May only contain letters, dashes, apostrophes and spaces.</li>
	@endif
	
	@if(strPos($rules[$field], 'unique') !== FALSE )
			<li>The field must be unique.</li>
	@endif
	
	@if(strPos($rules[$field], 'alpha_num_spaces') !== FALSE)
			<li>May only contain letters, numbers and spaces.</li>
	@endif
	
	@if(strPos($rules[$field], 'numeric') !== FALSE)
		<li>May only contain numeric characters.</li>
		
		@if(strPos($rules[$field], 'min:') !== FALSE)
			
			<li>Must be a minimum of {{$rules['range'][$field]['min']}}.</li>
		@endif
		
		@if(strPos($rules[$field], 'max:') !== FALSE) 
			<li>Must be less than or equal to {{$rules['range'][$field]['max']}}.</li>
		@endif
	@else
		@if(strPos($rules[$field], 'min:') !== FALSE)
			<li>Must be a minimum of {{$rules['range'][$field]['min']}} characters long.</li>
		@endif
		
		@if(strPos($rules[$field], 'max:') !== FALSE)
			<li>Must be less than or equal to {{$rules['range'][$field]['max']}} characters</li>
		@endif
	@endif
	
	@if(strPos($rules[$field], 'email') !== FALSE)
		<li>Must match the standard e-mail format</li>
	@endif
	
	@if(strcmp($field, "dueDate") === 0 )
		<li>The due date must be at least one day ahead of the date you created the invoice</li>
	@endif
	
		</ul>
	</div>
@endif