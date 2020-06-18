<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Delete Confirmation
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
					<button type="button" id="delete-ok" class="btn btn-danger" data-dismiss="modal">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    <script>
		var deleteurl;
		var rowToRemove;
		
        $('#confirm-delete').on('show.bs.modal', function(e) {
			$(this).find('.modal-body').html('Are you sure you would like to delete this client?');
            deleteurl = $(e.relatedTarget).data('href');
			rowToRemove = $(e.relatedTarget).parents('tr').first();
			
        });
		
		$('#delete-ok').click(function(e) {
			var CSRF_TOKEN = '{{ csrf_token()}}';
	
			// Using the core $.ajax() method
			$.ajax({
			 
				// The URL for the request
				url: deleteurl,
			 
				// The data to send (will be converted to a query string)
				data: {
					_token: CSRF_TOKEN,
					
				},
			 
				// Whether this is a POST or GET request
				type: "GET",
			 
				// The type of data we expect back
				dataType : "json",
			 
				// Code to run if the request succeeds;
				// the response is passed to the function
				success: function( json ) {
					if(json['status'] =='error')
						alert('Error: ' + json['message']);
					 else {
						console.log(json['status'] + ': ' + json['message']);
						rowToRemove.remove();
						if ( $("#searchResults > table > tbody > tr").length === 0 ) {
							$('#searchResults > table').after('<p class="text-center text-muted">No results found</div>');
						}
					 }
					
					deleteurl = null;
					rowToRemove = null;
				},
			 
				// Code to run if the request fails; the raw request and
				// status codes are passed to the function
				error: function( xhr, status, errorThrown ) {
					alert( "Sorry, there was a problem!" );
					console.log( "Error: " + errorThrown );
					console.log( "Status: " + status );
					console.dir( xhr );
				}
			});
		
		});
		
    </script>
</div>
	
	