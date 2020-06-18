                <div class="modal-header">
					<h1>Edit: {{$rows->name}}</h1>
                </div>
                <div class="modal-body">
                    @include('errors.list')
	
	
					{!! Form::model($rows, ['method' => 'PATCH', 'action' => ['ServicesController@update', $rows->id], 'id' => 'editForm']) !!}
					
					@include('services.form',['submitButtonText' => 'Edit Service', 'onClick' => 'editBeforeClosing(\'editForm\', true)'])
					
					{!! Form::close() !!}
                </div>
                
            