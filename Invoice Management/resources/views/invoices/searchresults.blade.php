<div id="searchResults">

@if(count($rows) > 0)

	<table class="table-hover table striped">
				<thead>
					<tr>
						<th>Invoice Number</th>
						<th>Client Name</th>
						<th>Date Created (UTC)</th>
						<th>Date Due (UTC)</th>
						<th>Date Sent (UTC)</th>
						<th>Date Paid (UTC)</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
@foreach($rows as $key => $value)
			<tr id="row-{{$value->id}}" @if(!is_null($value->paidDate)) class="paidRow" @endif>
				<td>{{ $value->invoiceNumber }}</td>
				<td>{{ $value->clientName }}</td>
				<td>{{ $value->created_at->format($carbon_dateFormat)}}</td>
				<td>{{ $value->dueDate->format($carbon_dateFormat)}}</td>
				<td>{{ !is_null($value->sentEmail) ? $value->sentEmail->format($carbon_dateFormat):"N/A" }}</td>
				<td>{{ !is_null($value->paidDate) ? $value->paidDate->format($carbon_dateFormat):"N/A" }}</td>
				<td>
					@if(is_null($value->sentEmail))
					<button type="button" id="edit-form-btn" class="btn btn-default" href="{{URL::action('InvoiceController@edit', ["$value->id"])}}" data-toggle="modal" data-target="#edit-form">Edit</button>
					@endif
					
					<button type="button" id="view-form-btn" class="btn btn-info" href="{{URL::action('InvoiceController@show', ["$value->id"])}}" data-toggle="modal" data-target="#view-form">View</button>
					
					@if(is_null($value->sentEmail))
					<button type="button" id="delete-form-btn" class="btn btn-danger" data-href="{{URL::action('InvoiceController@delete', ["$value->id"])}}" data-toggle="modal" data-target="#confirm-delete">Delete</button>
					@endif
					
					@if(!is_null($value->sentEmail) && is_null($value->paidDate))
					<button type="button" id="paidDate-form-btn" class="btn btn-info" data-href="{{URL::action('InvoiceController@payInvoice', ["$value->id"])}}" data-toggle="modal" data-target="#confirm-paidDate">Mark as Paid</button>
					@endif
					
					@if(is_null($value->paidDate))
					<button type="button" data-href="{{URL::action('InvoiceController@sendEmail', ['id' => $value->id])}}"  class="btnEmail btn btn-default" >E-Mail Invoice</button>
					
					@endif
				 </td>

			</tr>
@endforeach
			</tbody>
	</table>

{!! $rows->render() !!}

@else
		<table id="searchResults" class="table-hover table striped"> 
			<thead>
				<tr>
					<th>Invoice Number</th>
						<th>Client Name</th>
						<th>Date Created</th>
						<th>Date Sent</th>
						<th>Date Paid (UTC)</th>
						<th>Actions</th>
				</tr>
			</thead>
		</table>
		<p class="text-center text-muted">No results found</div>
@endif
</div>