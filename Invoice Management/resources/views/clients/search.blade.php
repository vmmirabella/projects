@extends('layouts.default')

@section('title')
Clients
@stop

@section('head')  
      <style>
            <!-- http://bootsnipp.com/snippets/featured/stylish-input-using-icon-font -->
          .stylish-input-group .input-group-addon{
                background: white !important;
            }
            .stylish-input-group .form-control{
                border-right:0; 
                box-shadow:0 0 0; 
                border-color:#ccc;
            }
            .stylish-input-group button{
                border:0;
                background:transparent;
            }
      </style>
@stop

@section('body')  

		@include('layouts.header', ['nav' => 'Clients'] )

        <div class="row">
            <h1 class="text-center">Clients</h1>
        </div>
        <div class="row">
            <form class="form-inline " id="searchBar" action="clients" method="GET" >
                <div class="col-sm-6 col-sm-offset-3" >
                    <div id="imaginary_container"> 
                        <div class="input-group stylish-input-group">
                            <input type="text" class="form-control" name="search"  placeholder="Search by company name or address..." value="{{Input::get('search')}}"  size="60">
							
                            <span class="input-group-addon">
                                <button type="submit" >
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>  
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
		
        <br />
        <div class="row text-center">
			<div class="btn-group" >
				<button type="button" id="create-form-btn" class="btn btn-default" href="clients/create" data-toggle="modal" data-target="#create-form">Create A New Client</button>
				
				<a class="btn btn-default" href="clients" role="button">View All Clients</a>
			</div>
        </div>
        
        <hr />
		
      @include('clients.searchresults')
      @include('clients.delete')
	  @include('clients.emptyModal')

@stop	