<div id="searchResults">

@if(count($rows) > 0)

	<table class="table-hover table striped">
				<thead>
					<tr>
						<th>Service Name</th>
						<th>Short Description</th>
						<th>Flat Rate</th>
						<th>Hourly Rate</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
@foreach($rows as $key => $value)
			<tr id="row-{{$value->id}}">
				<td>{{ $value->name }}</td>
				<td>{{ $value->shortDescription }}</td>
				<td>{{ $value->flatRate }}</td>
				<td>{{ $value->hourlyRate }}</td>
				<td>
					
					<button type="button" id="edit-form-btn" class="btn btn-default" href="services/{{$value->id}}/edit" data-toggle="modal" data-target="#edit-form">Edit</button>
					
					<button type="button" id="view-form-btn" class="btn btn-info" href="services/{{$value->id}}" data-toggle="modal" data-target="#view-form">View</button>
					
					<button type="button" id="delete-form-btn" class="btn btn-danger" data-href="services/{{$value->id}}/destroy" data-toggle="modal" data-target="#confirm-delete">Delete</button>
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
					<th>Service Name</th>
						<th>Short Description</th>
						<th>Flat Rate</th>
						<th>Hourly Rate</th>
						<th>Actions</th>
				</tr>
			</thead>
		</table>
		<p class="text-center text-muted">No results found</div>
@endif
</div>