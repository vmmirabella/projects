                <div class="modal-header">
					<h1>Create A New Invoice</h1>
                </div>
                <div class="modal-body">
                    @include('errors.list')
	
					{!! Form::open(['url' => 'invoices', 'id' => 'createForm' ]) !!}
					
					@include('invoices.form',['submitButtonText' => 'Add Invoice', 'onClick' => 'editBeforeClosing(\'createForm\')'])
					
					{!! Form::close() !!}
					<script>
						
						$(function(){
							
							function randomString(length, chars) {
								var result = '';
								for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
								return result;
							}
							var rString = randomString(12, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
							$('#createForm').find('#invoiceNumber').val(rString);
							
						});
						
						
					</script>
					
                </div>
				