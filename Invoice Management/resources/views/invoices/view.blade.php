				<div class="modal-header">
					<h1>View Invoice</h1>
				</div>
				<div class="modal-body container col-xs-12">
				
						
						<div class="row">
							<div class="col-xs-12">
							@if(isset($rows) && isset($rows->client))
								@include('clients.view', ['rows' => $rows->client, 'hideModal' => true ] )
							@endif
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">Invoice Number</div>
							<div class="col-xs-9">{{$rows->invoiceNumber}}</div>
						</div>
						<div class="row">
							<div class="col-xs-3">E-Mail Sent On</div>
							<div class="col-xs-9" id="sentEmail" >{{$rows->sentEmail ? $rows->sentEmail->format($carbon_dateFormat.' e'):"N/A"}}</div>
						</div>
						<div class="row">
							<div class="col-xs-3">Due Date</div>
							<div class="col-xs-9">{{ $rows->dueDate->format($carbon_dateFormat.' e') }}</div>
						</div>
						<div class="row">
							<div class="col-xs-3">Paid Date</div>
							<div class="col-xs-9">{{ $rows->paidDate ? $rows->paidDate->format($carbon_dateFormat.' e'):"N/A"}}</div>
						</div>
					
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Flat Rate</th>
									<th>Hourly Rate</th>
									<th>Total Hours</th>
									<th>Total Price</th>
								</tr>
							</thead>
							<tbody>
								@foreach($rows->invoiceLineItems as $value)
								<tr>
									<td>{{$value->name}}</td>
									<td>{{$value->flatRate}}</td>
									<td>{{$value->hourlyRate}}</td>
									<td>{{$value->totalHours}}</td>
									<td>{{$value->totalPrice}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
								
						<div class="row">
							<div class="col-xs-offset-6 col-xs-3 text-right">Subtotal</div>
							<div class="col-xs-3">$ {{$rows->subtotal}}</div>
						</div>
						<div class="row">
							<div class="col-xs-offset-6 col-xs-3 text-right">Estimated Tax</div>
							<div class="col-xs-3">$ {{sprintf('%0.2f', ($rows->taxRate/100)*$rows->subtotal)}}</div>
						</div>
						<div class="row">
							<div class="col-xs-offset-6 col-xs-3 text-right">Total</div>
							<div class="col-xs-3">$ {{$rows->total}}</div>
						</div>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				
            </div>	
			