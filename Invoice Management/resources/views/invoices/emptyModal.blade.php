<div class="modal fade" id="view-form" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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



<div class="modal fade" id="edit-form" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<div class="modal fade" id="create-form" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
	
	function assignEmailBtnHandler(){
		$('.btnEmail').on('click', function(e){
			e.preventDefault();
			var url =  this.getAttribute('data-href');

			$.ajax({
				  type: 'get',
				  url: url,
				  dataType: 'json',
				  success: function(data){
				  console.log(data);
					  
					  if(data['status'] == 'success') {
						 var originalText = $(e.currentTarget).text();
						 $(e.currentTarget).text('E-mail Sent');
						 $(e.currentTarget).removeClass('btn-default');
						 $(e.currentTarget).addClass('btn-success');
						 setTimeout(function() {
							$(e.currentTarget).text(originalText);
							$(e.currentTarget).addClass('btn-default');
							$(e.currentTarget).removeClass('btn-success');
							
							var rowToEdit = $(e.currentTarget).parent();
							
							if(rowToEdit.find('#paidDate-form-btn').length < 1) {
								var id = rowToEdit.parent().attr('id').split('-')[1];
								
								
								var markAsPaid = '<button type="button" id="paidDate-form-btn" class="btn btn-info" data-href="invoices/' + id +'/payInvoice" data-toggle="modal" data-target="#confirm-paidDate">Mark as Paid</button>';
								rowToEdit.find('#edit-form-btn').remove();
								rowToEdit.find('#delete-form-btn').remove();
								rowToEdit.find('#view-form-btn').after(markAsPaid);
							}
							
						  }, 1500);
							  
					  } else {
						
						 console.log(data['status']); 
						  
					  }
						
						
				  },
				  error: function(data){
					  console.log("error");
					  console.log(data);
					
				  }
			});
				
				
		});
	}
	
	function editBeforeClosing(e, editRow) {
		
		if(editRow === undefined)
			editRow = false;
		
		$('#' + e).find('#invoiceNumber').prop('disabled', false);

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
				'<td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td>' +
				'<button type="button" id="edit-form-btn" class="btn btn-default" href="invoices/'+ data['id'] + '/edit" data-toggle="modal" data-target="#edit-form">Edit</button> <button type="button" id="view-form-btn" class="btn btn-info" href="invoices/'+ data['id'] + '" data-toggle="modal" data-target="#view-form">View</button> <button type="button" id="delete-form-btn" class="btn btn-danger" data-href="invoices/'+ data['id'] + '/destroy" data-toggle="modal" data-target="#confirm-delete">Delete</button>' +
				'<button type="button" data-href="invoices/sendEmail?id='+ data['id'] +'" class="btnEmail btn btn-default">E-Mail Invoice</button>' +
				'</td></tr>'
				);
				
				assignEmailBtnHandler();
			}
			
			console.log(data);
			//edit table row to reflect changes
			rowToEdit = $('#row-' + data['id'] );
				
				
			if(data['sentEmail'] == ""){
				data['sentEmail'] = "N/A";
			}
			
			if(data['paidDate'] == ""){
				data['paidDate'] = "N/A";
			}
				
			rowToEdit.find('td:nth-child(1)').html(data['invoiceNumber']);
			rowToEdit.find('td:nth-child(2)').html(data['clientName']);
			rowToEdit.find('td:nth-child(3)').html(data['created_at']);
			rowToEdit.find('td:nth-child(4)').html(data['dueDate']); 
			rowToEdit.find('td:nth-child(5)').html(data['sentEmail']);
			rowToEdit.find('td:nth-child(6)').html(data['paidDate']);
			rowToEdit.effect("highlight", {color: '#CCFFCC'}, 8000);
				
			
			$('#' + e).find('#invoiceNumber').prop('disabled', true);
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
		
		$('#' + e).find('#invoiceNumber').prop('disabled', true);
	}
	
	assignEmailBtnHandler();
</script> 

