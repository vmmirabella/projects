<div class="modal fade" id="view-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Loading Header..</h1>
                </div>
                <div class="modal-body">
                    Loading content...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
  
</div>



<div class="modal fade" id="edit-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Loading Header..</h1>
                </div>
                <div class="modal-body">
                    Loading content...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>        
</div>

<div class="modal fade" id="create-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Loading Header..</h1>
                </div>
                <div class="modal-body">
                    Loading content...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>        
</div>

<script>
	//https://stackoverflow.com/a/18134067
	$('body').on('hidden.bs.modal', '.modal', function (e) {
		$(e.target).removeData('bs.modal');
		$('.modal-body').html('Loading content...');
	});
	
	function editBeforeClosing(e, editRow) {
		
		if(editRow === undefined)
			editRow = false;
		
		
		$.ajax({
		  type: 'post',
		  url: $('#' + e).attr('action'),
		  data: $('#' + e).serialize(),
		  dataType: 'json',
		  success: function(data){

			//Do something. For example, display a result:
			$('#ajax-submit-btn').replaceWith( '<div class="alert alert-success">  <strong>Success!</strong></div>' );
			
			if(editRow == false){
				$('#searchResults > table > tbody').prepend(
				'<tr id="row-'+ data['id'] + '">' +
				'<td></td> <td></td> <td></td> <td></td> <td></td> <td>' +
				'<button type="button" id="edit-form-btn" class="btn btn-default" href="clients/'+ data['id'] + '/edit" data-toggle="modal" data-target="#edit-form">Edit</button> <button type="button" id="view-form-btn" class="btn btn-info" href="clients/'+ data['id'] + '" data-toggle="modal" data-target="#view-form">View</button> <button type="button" id="delete-form-btn" class="btn btn-danger" data-href="clients/'+ data['id'] + '/destroy" data-toggle="modal" data-target="#confirm-delete">Delete</button>' +
				'</td></tr>'
				);
			}
			
			
			console.log(data);
			//edit table row to reflect changes
			rowToEdit = $('#row-' + data['id'] );
				
			rowToEdit.find('td:nth-child(1)').html(data['companyName']);
			rowToEdit.find('td:nth-child(2)').html(data['clientName']);
			rowToEdit.find('td:nth-child(3)').html(data['email']);
			rowToEdit.find('td:nth-child(4)').html(data['address']['unitNumber'] 
			+ " " + data['address']['street'] 
			+ " " + data['address']['city']
			+ " " + data['address']['province']
			+ " " + data['address']['postalCode']);
			rowToEdit.find('td:nth-child(5)').html(data['phone']);
			rowToEdit.effect("highlight", {color: '#CCFFCC'}, 8000);
			
			
			//Close dialog in 1 second:
			setTimeout( function() { $('.modal.fade.in').modal('hide'); }, 1000 );
			
		  },
		  error: function(data){
			
			var j = $.parseJSON(data.responseText);
			var ul = $('<ul class="alert alert-danger">');
			
			
			$.each( j, function(i, n){	
				ul.append("<li>" + n + "</li>");
			});
			$('#errors').empty();
			$('#errors').append(ul);
			
			// Render the errors with js ...
		  }
		});
	  

	  
	}
	

</script> 

