                <div class="modal-header">
					<h1>Edit</h1>
                </div>
                <div class="modal-body">
                    @include('errors.list')
	
	
					{!! Form::model($rows, ['method' => 'PATCH', 'action' => ['InvoiceController@update', $rows->id], 'id' => 'editForm']) !!}
					
					@include('invoices.form',['submitButtonText' => 'Edit Invoice', 'onClick' => 'editBeforeClosing(\'editForm\', true)'])
					
					{!! Form::close() !!}
                </div>
                
            