<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
      <script src="{{URL::asset('js/jquery-1.11.3.min.js')}}"></script>
	  
    <link href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{URL::asset('bootstrap/js/bootstrap.min.js')}}"></script>
	
	<script src="{{URL::asset('js/jquery-ui/jquery-ui.min.js')}}"></script>
	<link href="{{URL::asset('js/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('js/jquery-ui/jquery-ui.theme.min.css')}}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	@yield('head')
	</head>
  <body>
	<noscript>
	 <div class="alert alert-danger" role="alert">
	  <strong>Warning!</strong> This site requires javascript in order to function properly. Please enable javascript and refresh the page.
	</div>
	</noscript>
	<div class="container">
		@yield('body')
	</div>
	</body>
</html>
	