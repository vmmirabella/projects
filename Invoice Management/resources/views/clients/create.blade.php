                <div class="modal-header">
					<h1>Create A New Client</h1>
                </div>
                <div class="modal-body">
                    @include('errors.list')
	
					{!! Form::open(['url' => 'clients', 'id' => 'createForm' ]) !!}
					
					@include('clients.form',['submitButtonText' => 'Add Client', 'onClick' => 'editBeforeClosing(\'createForm\')'])
					
					{!! Form::close() !!}
                </div>
				