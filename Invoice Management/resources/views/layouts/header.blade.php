        <div class="row">
            <div class="col-lg-6"> 
                <div class="row">
                    <div class="col-lg-2">
                        <img src="{{URL::asset('images/64x64.png')}}" />
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <span class="text-muted">{{Auth::user()->name}}</span>
                        </div>
						<div class="row">
							<span class="text-muted">{{Auth::user()->email}}</span>
                        </div>
                        <div class="row">
                            <a href="{{URL::action('Auth\AuthController@getLogout')}}">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <nav>
                  <ul class="nav nav-pills pull-right">
                    <li role="presentation" @if($nav == 'Home') class="active" @endif><a href="{{URL::action('HomeController@index')}}">Home</a></li>
                    <li role="presentation" @if($nav == 'Clients') class="active" @endif><a href="{{URL::action('ClientController@index')}}">Clients</a></li>
                    <li role="presentation" @if($nav == 'Services') class="active" @endif><a href="{{URL::action('ServicesController@index')}}">Services</a></li>
					<li role="presentation" @if($nav == 'Invoices') class="active" @endif><a href="{{URL::action('InvoiceController@index')}}">Invoices</a></li>
                    <li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href="{{URL::action('ReportController@annually')}}">Annually</a></li>
						<li><a href="{{URL::action('ReportController@monthly')}}">Monthly</a></li>
						<li><a href="{{URL::action('ReportController@client')}}">Client</a></li>
					  </ul>
					</li>
					<li role="presentation" @if($nav == 'Help') class="active" @endif><a href="{{URL::action('HelpController@index')}}">Help</a></li>
                  </ul>
                </nav>
            </div>
        </div>