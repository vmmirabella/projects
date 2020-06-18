                <div class="modal-header">
					<h1>Edit</h1>
                </div>
                <div class="modal-body">
                    @include('errors.list')
	
	
					{!! Form::model($rows, ['method' => 'PATCH', 'action' => ['ClientController@update', $rows->id], 'id' => 'editForm']) !!}
					
					@include('clients.form',['submitButtonText' => 'Edit Client', 'onClick' => 'editBeforeClosing(\'editForm\', true)'])
					
					{!! Form::close() !!}
                </div>
                
            