			@if(!isset($hideModal))	
				
				<div class="modal-header">
					<h1>View Client</h1>
				</div>
				<div class="modal-body">
			@endif
					<table class="table table-striped">
						<tr>
								<td class="text-muted text-right">Company Name</td>
								<td class="text-left">{{$rows->companyName}}</td>
						</tr>
						<tr>
								<td class="text-muted text-right">Client Name</td>
								<td class="text-left">{{$rows->clientName}}</td>
						</tr>
						<tr>
								<td class="text-muted text-right">E-Mail</td>
								<td class="text-left">{{$rows->email}}</td>
						</tr>
						<tr>
								<td class="text-muted text-right">Address</td>
								<td class="text-left">
								@if(isset($rows->address->unitNumber))
								Unit #{{ $rows->address->unitNumber }}
								@endif
								
								{{ $rows->address->street }}
								{{ $rows->address->city }}
								{{ $rows->address->province }} 
								{{ $rows->address->postalCode }}
								</td>
						</tr>
						<tr>
								<td class="text-muted text-right">Phone Number</td>
								<td class="text-left">{{$rows->phone}}</td>
						</tr>
						
					</table>
		@if(!isset($hideModal))			
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>	
		@endif