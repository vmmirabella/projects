                <div class="modal-header">
					<h1>Create A New Service</h1>
                </div>
                <div class="modal-body">
                    @include('errors.list')
	
					{!! Form::open(['url' => 'services', 'id' => 'createForm' ]) !!}
					
					@include('services.form',['submitButtonText' => 'Add Service', 'onClick' => 'editBeforeClosing(\'createForm\')'])
					
					{!! Form::close() !!}
                </div>
				