<div id="searchResults">

@if(count($rows) > 0)

	<table class="table-hover table striped">
				<thead>
					<tr>
						<th>Company Name</th>
						<th>Client Name</th>
						<th>E-Mail</th>
						<th>Address</th>
						<th>Phone Number</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
@foreach($rows as $key => $value)
			<tr id="row-{{$value->id}}">
				<td>{{ $value->companyName }}</td>
				<td>{{ $value->clientName }}</td>
				<td>{{ $value->email }}</td>
				<td>
				@if($value->address->unitNumber)
				Unit #{{ $value->address->unitNumber }}
				@endif
				{{ $value->address->street }}
				{{ $value->address->city }} {{ $value->address->province }} {{ $value->address->postalCode }}
				</td>
				<td>{{ $value->phone }}</td>
				<td>
					
					<button type="button" id="edit-form-btn" class="btn btn-default" href="clients/{{$value->id}}/edit" data-toggle="modal" data-target="#edit-form">Edit</button>
					
					<button type="button" id="view-form-btn" class="btn btn-info" href="clients/{{$value->id}}" data-toggle="modal" data-target="#view-form">View</button>
					
					<button type="button" id="delete-form-btn" class="btn btn-danger" data-href="clients/{{$value->id}}/destroy" data-toggle="modal" data-target="#confirm-delete">Delete</button>
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
					<th>Company Name</th>
					<th>Client Name</th>
					<th>E-Mail</th>
					<th>Address</th>
					<th>Phone Number</th>
					<th>Actions</th>
				</tr>
			</thead>
		</table>
		<p class="text-center text-muted">No results found</div>
@endif
</div>