<div class="modal fade" id="confirm-paidDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Payment Confirmation
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" id="paidDate-ok" class="btn btn-danger" data-dismiss="modal">Mark As Paid</button>
                    
                </div>
            </div>
        </div>
    <script>
		var paidDateUrl;
		var rowToEdit;
		
        $('#confirm-paidDate').on('show.bs.modal', function(e) {
			$(this).find('.modal-body').html('Are you sure you would like to mark this invoice as paid?');
            paidDateurl = $(e.relatedTarget).data('href');
			rowToEdit = $(e.relatedTarget).parents('tr').first();
			
        });
		
		$('#paidDate-ok').click(function(e) {
			var CSRF_TOKEN = '{{ csrf_token()}}';
	
			// Using the core $.ajax() method
			$.ajax({
			 
				// The URL for the request
				url: paidDateurl,
			 
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
				success: function( data ) {
					if(data['status']!="success")
						alert(data['status']);
					 else {
						rowToEdit.find('td:nth-child(6)').html(data['paidDate']);
						rowToEdit.find('td:nth-child(7)').find('#paidDate-form-btn').remove();
						rowToEdit.find('td:nth-child(7)').find('.btnEmail').remove();
						rowToEdit.addClass('paidRow');
						
					 }
					
					paidDateurl = null;
					rowToEdit = null;
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
	
	