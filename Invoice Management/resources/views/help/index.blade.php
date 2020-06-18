@extends('layouts.default')

@section('title')
Help
@stop

@section('head')  
    <style>
		/* CSS for Bootstrap 3 callouts found in the Bootstrap Documentation at http://getbootstrap.com/css */
		.bs-callout {
		padding: 20px;
		margin: 20px 0;
		border: 1px solid #eee;
		border-left-width: 5px;
		border-radius: 3px;
		}
		
		.bs-callout h4 {
			margin-top: 0;
			margin-bottom: 5px;
		}
		
		.bs-callout p:last-child {
			margin-bottom: 0;
		}
		
		.bs-callout code {
			border-radius: 3px;
		}
		
		.bs-callout+.bs-callout {
			margin-top: -5px;
		}
		
		.bs-callout-default {
			border-left-color: #777;
		}
		
		.bs-callout-default h4 {
			color: #777;
		}
		
		.bs-callout-primary {
			border-left-color: #428bca;
		}
		
		.bs-callout-primary h4 {
			color: #428bca;
		}
		
		.bs-callout-success {
			border-left-color: #5cb85c;
		}
		
		.bs-callout-success h4 {
			color: #5cb85c;
		}
		
		.bs-callout-danger {
			border-left-color: #d9534f;
		}
		
		.bs-callout-danger h4 {
			color: #d9534f;
		}
		
		.bs-callout-warning {
			border-left-color: #f0ad4e;
		}
		
		.bs-callout-warning h4 {
			color: #f0ad4e;
		}
		
		.bs-callout-info {
			border-left-color: #5bc0de;
		}
		
		.bs-callout-info h4 {
			color: #5bc0de;
		}
	</style>
@stop

@section('body')  

	@include('layouts.header', ['nav' => 'Help'] )
	
	<div class="row"> 	
		<h1>Clients</h1>
		<hr>
		<ol>
			<li>
				<p>Search - Searches the database for the entered information.</p>
				
				{!! Html::image('images/help/clientsMAIN.JPG', 'The client search page', array('class' => 'img-thumbnail')) !!}
				
				<p>Type in the information you are looking for and hit the magnify icon or hit enter.
				The information searched will be: 
					<ul>
						<li>Company Name</li>
						<li>Client Name</li>
						<li>E-mail</li>
						<li>Address</li>
						<li>Phone Number</li>
					</ul>
				</p>
				<p>The search will only filter by a single column (ie. If you type in 'John' it will look for 'John' in Company Name, Client Name, E-mail, Address and Phone number).</p>
				<p>"No results found" will be returned if the information being searched is not within the database or the original search contained multiple searchs (ie. "John 416-555-555" wouldn't work because 
				the whole phrase is taken rather then each seperately).	</p>
			</li>	
				
			<li>
				<p>Create/Edit - Add a new client&#8217;s information into the database or edit an existing client in the database</p>
				
				{!! Html::image('images/help/clientCreateEdit.JPG', 'The client create/edit form', array('class' => 'img-thumbnail')) !!}
				
				<ol type="a">
						<li>
							<p>(Company Name) - @include('help.badges.required', ['required' => false] ) - Field for the client&#8217;s company. Can be left blank if the client does not belong to a company.</p>
							@include('help.callouts.restrict', [ 'field' => 'companyName'])
							
						</li>
						<li>
							<p>(Client Name) - @include('help.badges.required', ['required' => true] ) - Field for the client&#8217;s first name or first and last name.</p>
							@include('help.callouts.restrict', [ 'field' => 'clientName'])
						</li>
						<li>
							<p>(E-mail) - @include('help.badges.required', ['required' => true] ) - Field for the client&#8217;s email address.</p>
							@include('help.callouts.restrict', [ 'field' => 'email'])
						</li>
						<li>
							<p>(Phone Number) - @include('help.badges.required', ['required' => true] ) - Field for the client&#8217;s phone number. Can be in 416-555-555 or 416 555 555 or (416) 555 555 or (416) 555-555.</p>
							@include('help.callouts.restrict', [ 'field' => 'phone'])
						</li>
					<li>
						<p>(Unit Number) - @include('help.badges.required', ['required' => false] ) - Field for the client&#8217;s unit number/apt number/suite number</p>
						@include('help.callouts.restrict', [ 'field' => 'address.unitNumber'])
					</li>
					<li>
						<p>(Street) - @include('help.badges.required', ['required' => true] ) - Field for the client&#8217;s house number and street name (ie. 55 GroveTree)</p>
						@include('help.callouts.restrict', [ 'field' => 'address.street' ])
					</li>
					<li>
						<p>(City) - @include('help.badges.required', ['required' => true] ) - Field for the city the client lives in.</p>
						@include('help.callouts.restrict', [ 'field' => 'address.city' ])
					</li>
					<li>
						<p>(Province) - @include('help.badges.required', ['required' => true] ) - Field for the province the client lives in.</p>
						@include('help.callouts.restrict', [ 'field' => 'address.province' ])
					</li>
					<li>
						<p>(Postal Code): - @include('help.badges.required', ['required' => true] ) - Field for the client&#8217;s postal code.</p>
						@include('help.callouts.restrict', [ 'field' => 'address.postalCode' ])
					</li>
				</ol>
			</li>	
			<li>
				<p>View All - Resets search parameter and displays every client currently in the database.</p>
			</li>
			<li>
				<p>View - View a specific existing client&#8217;s full information.</p>
			</li>
			
			<li>
				<p>Delete - Delete a specific existing client from the database.</p>
			</li>
		</ol>
		
		@include('help.callouts.info', [ 'note' => 'Invoices already paid/sent are unaffected by Delete and Edit as the client&#8217;s information is saved along with the invoice seperately.' ])
		
		<h1>Services</h1>
		<hr>
		<ol>
			<li>
				<p>Search - searches the database for the entered information</p>
				
				{!! Html::image('images/help/servicesMAIN.JPG', 'The services search page', array('class' => 'img-thumbnail')) !!}
				
				<p>Type in the information you are looking for and hit the magnify icon or hit enter. The information that will be searched: Service name, short description, flat rate and hourly rate.</p>
				<p>The search will only filter by a single column (ie. If you type in 'consultation' it will look for 'consultation' under each column being displayed (service name, short description, flat rate and hourly rate).</p>
				<p>"No results found" will be returned if the information being searched is not within the database or the original search contained multiple searchs (ie. "consultation 55" wouldn't work because the whole phrase is taken rather then each seperately).</p>
			</li>
		
			<li>
				<p>Create/Edit - Create a new service to be added in the database or edit an existing database</p>
				
				{!! Html::image('images/help/servicesCreateEdit.JPG', 'The services create/edit form', array('class' => 'img-thumbnail')) !!}
				
				<ol type="a">
					<li><p>(Name) - @include('help.badges.required', ['required' => true] ) - Field for the name of the service to be added.</p>
						@include('help.callouts.restrict', [ 'field' => 'name'])
					</li>
					<li>
						<p>(Short Description) - @include('help.badges.required', ['required' => false] ) - Brief description about the service.</p>
						@include('help.callouts.restrict', [ 'field' => 'shortDescription'])
					</li>
					<li>
						<p>(Flat Rate) - @include('help.badges.required', ['required' => true] ) - Field for the base cost of this service.</p>
						@include('help.callouts.restrict', [ 'field' => 'flatRate'])
					</li>
					<li>
						<p>(Hourly Rate) - @include('help.badges.required', ['required' => false] ) - Field for the hourly rate that will be added together with flat. This field is not needed.</p>
						@include('help.callouts.restrict', [ 'field' => 'hourlyRate'])
					</li>
					<li>
						<p>(Long Description) - @include('help.badges.required', ['required' => false] ) - Long description of the service, any notes can go here.</p>
						@include('help.callouts.restrict', [ 'field' => 'longDescription'])
					</li>
				</ol>
			</li>
			<li>
				<p>View All - Resets search parameters and displays all services within the database.</p>
			</li>
			<li>
				<p>View - View a specific existing service&#8217;s full information.</p>
			</li>
			<li>
				<p>Delete - Delete a specific existing service from the database.</p>
			</li>
		</ol>
		
		@include('help.callouts.info', [ 'note' => 'Invoices already paid/sent are unaffected by Delete and Edit as the service&#8217;s information is saved along with the invoice seperately.' ])
		
		<h1>Invoices</h1>
		<hr>
		<ol>
			<li>
				<p>Search - seaches the database for the entered information</p>
				
				{!! Html::image('images/help/InvoicesMAIN.JPG', 'The invoices search page', array('class' => 'img-thumbnail')) !!}
				
				<ol type="a">
					<li>
						<p>(Text searchbox) Type in the information you are looking for and hit the magnify icon or hit enter.</p>
						<p>The information that will be searched if date restrictions are not placed: Invoice number, client name.</p>
					</li>
					<li>
						<p>(Date Range) - @include('help.badges.required', ['required' => false] ) - Select a range of dates you wish to either further restrict with a search or just search based on the date range</p>		
						<p>"No results found" will be returned if the information being searched is not within the database or the original search contained multiple searchs (ie. "consultation 55" wouldn't work because the whole phrase is taken rather then each seperately). To further restrict results you can enter a date range along with a specific search phrase.</p>
					</li>
				</ol>
			</li>
			<li>
				<p>Create/Edit - Create a new invoice for a client in the database using existing services. You can only edit an invoice that hasn't been sent to the client.</p>
				
				{!! Html::image('images/help/InvoicesCreateEdit.JPG', 'The invoices create/edit form', array('class' => 'img-thumbnail')) !!}
				
				<ol type="a">
					<li>
						<p>(Invoice Number) - @include('help.badges.required', ['required' => true] ) - Field that contains a unique 12 character string to identify the invoice. Generated by the system, cannot be edited.</p>
					</li>
					<li>
						<p>(Due Date) - @include('help.badges.required', ['required' => true] ) - Field that contains the when the invoice is due by. For best results use calender that appears when the text-field is selected.</p>
						@include('help.callouts.restrict', [ 'field' => 'dueDate'])
					</li>
					<li>
						<p>(Client) - @include('help.badges.required', ['required' => true] ) - Field for the client this invoice will be sent to and is for. You can press down on the arrow keys to get a list of existing clients to select from.</p> 
						<p>You can also start typing in their name and then select from the list of matching clients. Currently you must select a client from the list generated either by typing or by pressing the down arrow key followed by enter or mouseclick.</p>
						<p>If the client&#8217;s information populates on the form then the client has successfully been selected. If the client&#8217;s information doesn't appear after selection try again with the above methods.</p>
						@include('help.callouts.restrict', [ 'field' => "database_id"])
					</li>
					<li>
						<p>(Service Line Item) - @include('help.badges.required', ['required' => true] ) - Line item for services already existing in the database. </p>
						<ul>
							<li>
								<p>Hours - @include('help.badges.required', ['required' => true] ) - The number of hours spent with a particular service.</p>
								@include('help.callouts.restrict', [ 'field' => 'invoiceLineItems.1.totalHours'])
							</li>
							<li>
								<p>Service Name - @include('help.badges.required', ['required' => true] ) - Field for an existing service. You can press down on the arrow keys or begin typing the service&#8217;s name to view a list of existing services to select from. Currently you must select a service from the generated list and then press enter or mouseclick the desired service.  A service is correctly selected when the total field is populated with a price.</p>
								@include('help.callouts.restrict', [ 'field' => 'invoiceLineItems.1.name'])
							</li>
							<li>
								<p>Total: Total price for this service. Calculation: Flate rate + (hours x hourly rate)</p>
							</li>
						</ul>
					</li>
					<li>
						<p>Add Service - You can add multiple service line items. You can also remove extra line items.</p>				
						@include('help.callouts.restrict', [ 'field' => 'add_service'] )
					</li>
					<li>
						<p>(Subtotal) - Disabled field that calculates the subtotal of all services before taxes.</p>
					</li>
					<li>
						<p>(Tax Rate) - Tax rate to be applied to the invoice, this would be HST or GST+PST.</p>
					</li>
					<li>
						<p>(Total) - Total price with tax rate.</p>
					</li>
				</ol>
			</li>
			<li>
				<p>View All - Resets search parameters and displays all invoices within the database.</p>
			</li>
			<li>
				<p>View - View a specific existing invoice&#8217;s full information.</p>
			</li>
			<li>
				<p>Delete - Delete a specific existing invoice from the database. You can only delete an invoice if an e-mail hasn't been sent to the client.</p>
			</li>
			<li>
				<p>Email Invoice - Send an email notification to the client with the following details of the invoice: Invoice number, due date, list of services and their cost, subtotal, tax and total.</p>
				<p>Once an email has been sent to a client both Delete and Edit will be disabled and removed from the view. You can re-send an email if needed by pressing e-mail invoice again.</p>
			</li>
			<li>
				<p>Mark as Paid - Once an email notification has been sent this button will appear and replace edit/delete. Once the invoice has been paid you click this button to make the invoice as paid which will then lock the invoice and save it in the database. Once an invoice is marked as paid you will be unable to edit, delete, email and only allowed to view that invoice.</p>
			</li>
		</ol>
		
		@include('help.callouts.info', [ 'note' => 'If you create an invoice and then go and edit the client, the client in invoice WILL NOT update with that information, you must re-select that client. The same will happen with services, if you create an invoice and then edit that service the service in invoice WILL NOT update and you must manually update it by re-selecting.'])

		<h1>Reports</h1>
		<hr>
		{!! Html::image('images/help/reports.JPG', 'The reports dropdown menu', array('class' => 'img-thumbnail')) !!}
		
		<p>Press the menu option Reports to see a dropdown list of the types of reports to generate.</p>
		
		{!! Html::image('images/help/reportsPAGE.JPG', 'The reports form', array('class' => 'img-thumbnail')) !!}
		
		<ol>
			<li>
				<p>Annually - Reports are generated based on annual earnings or outstanding invoices. You can view all invoices based on annual earnings/outstanding invoices or restrict to within a specific year or set of years.</p>
			</li>
			<li>
				<p>Monthly - Reports are generated based on monthly earnings or outstanding invoices. You can view all invoices based on monthly earnings/outstanding invoices or restrict to within a specific set of months.</p>
			</li>
			<li>
				<p>Client - Reports are generated by Client. You can view all paid/outstanding invoices from cliet or you can restrict the range by selecting a start and end date.</p>
				<ol type="a">
					<li>
						<p>You can select a range to restrict the what the graph will generate. If no range is selected the graph will find all invoices and then display them annually or monthly depending what was chosen.</p>
					</li>
					<li>
						<p>(Invoice Type) - @include('help.badges.required', ['required' => true] ) - You can select outstanding invoices which are invoices that have an email sent to a client at least once but haven't been paid yet. You can also select paid invoices which will display all invoices that have been paid for that month/year.</p>
					
						<p>Each graph you are able to select either oustanding invoices or view earnings based on the report chosen. The default is outstanding invoices currently.</p>
					</li>
				</ol>
			</li>
		</ol>
		
		@include('help.callouts.info', [ 'note' => 'Note: You can zoom in on each graph by selecting and dragging the mouse over the area you want zoomed in.'] )

	</div>
	<div class="row" style="margin-bottom:50px"></div>
@stop	