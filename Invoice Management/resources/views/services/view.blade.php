				<div class="modal-header">
					<h1>View Service</h1>
				</div>
				<div class="modal-body">
					<table class="table table-striped">
						<tr>
								<td class="text-muted text-right">Name</td>
								<td class="text-left">{{$rows->name}}</td>
						</tr>
						<tr>
								<td class="text-muted text-right">Short Description</td>
								<td class="text-left">{{$rows->shortDescription}}</td>
						</tr>
						<tr>
								<td class="text-muted text-right">Long Description</td>
								<td class="text-left">{{$rows->longDescription}}</td>
						</tr>
						<tr>
								<td class="text-muted text-right">Flat Rate</td>
								<td class="text-left">{{$rows->flatRate}}</td>
						</tr>
						<tr>
								<td class="text-muted text-right">Hourly Rate</td>
								<td class="text-left">{{$rows->hourlyRate}}</td>
						</tr>

					</table>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>	