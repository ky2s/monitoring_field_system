<!DOCTYPE html>
<html >

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Dashboard</title>
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css">
	<link href="{{ asset('assets/DataTables/media/css/dataTables.bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/DataTables/media/css/buttons.dataTables.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/DataTables/media/css/responsive.dataTables.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/DataTables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/validationEngine.jquery.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/datepicker3.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/jquery.ui.autocomplete.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('assets/css/ace-fonts.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('assets/css/ace.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('assets/css/semantic.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}" type="text/css">


	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.css" media="screen" />

	<style type="text/css">
		.icontainer {
		  display: inline-block;
		}
		.manImg {
		  display: none;
		}
		.hover-text:hover ~ .manImg {
		  display: block;  
		}
		@yield('addstyle')
	</style>
<body>
	
	<div id="wrapper">

		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed pull-left flat" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" style="margin-left:15px;">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand hidden-xs" href="#">Dashboard</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li id="lihome" class="active"><a href="{{URL::route('home')}}"><i class="fa fa-home"></i> Home</a></li>
						@if(Auth::user()->tipe=='sa' || Auth::user()->tipe=='manager' || Auth::user()->tipe=='admin')
						<li id="liuser"><a href="{{URL::route('userlist')}}"><i class="fa fa-user"></i> User</a></li>
						@endif
						@if(Auth::user()->tipe=='manager' || Auth::user()->tipe=='admin')
						<li id="liteam"><a href="{{URL::route('teamlist')}}"><i class="fa fa-users"></i> Team</a></li>
						@endif
						@if(Auth::user()->tipe=='admin' || count(Auth::user()->adminproject) >0)
						<li id="liproject"><a href="{{URL::route('projectlist')}}"><i class="fa fa-pencil-square-o"></i> Project</a></li>
						@endif
						<!-- @if(Auth::user()->tipe=='admin' || Auth::user()->tipe=='auditor')
						<li id="lireport"><a href="{{URL::route('reportlist')}}"><i class="fa fa-exclamation-circle"></i> Report</a></li>
						@endif -->
					</ul>
					<ul class="nav navbar-nav navbar-right hidden-xs">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user-circle-o" aria-hidden="true"></i> Hai, {{Auth::user()->name}} <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu">
							<!-- <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
							<li><a href="#"><i class="fa fa-gear"></i> Setting</a></li>
							<li role="separator" class="divider"></li> -->
							<li><a href="{{ route('logout') }}" onclick="event.preventDefault();
						document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a></li>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form> 
						</ul>
					</li>
				</ul>
				</div><!--/.nav-collapse -->

				<ul class="nav navbar-nav navbar-right pull-right navbar-nav-sm hidden-md hidden-lg hidden-sm navbar-user">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user-circle-o" aria-hidden="true"></i> Hai, {{Auth::user()->name}} <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
							<li><a href="#"><i class="fa fa-gear"></i> Setting</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#"><i class="fa fa-sign-out"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
		<div class="clearfix"></div>
		<div class="header-page">
			<div class="container-fluid">
				<div class="row">
					@yield('header')
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
			<div id="page-content" class="container-fluid">
				@yield('content')
			</div>
		</div>
	<footer class="footer-login" style="position:relative;">
		<div class="container text-center">
			<p style="color:#e0e0e0;"><i class="fa fa-copyright"></i> Copyright 2017 - All right Reserved</p>
		</div>
	</footer>
	
	<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/jquery-ui.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/aos.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
	<script src="{{ asset('assets/DataTables/media/js/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('assets/DataTables/media/js/dataTables.responsive.min.js') }}"></script>
	<script type="text/javascript" src="{{asset('assets/js/dataTables.buttons.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/jszip.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/buttons.html5.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/buttons.print.js')}}"></script>
	<script src="{{ asset('assets/js/jquery.mask.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.maskMoney.js') }}"></script>
	<script src="{{ asset('assets/js/select2.full.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.validationEngine.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.validationEngine-en.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('assets/js/moment.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-tagsinput.min.js') }}"></script>
	<script src="{{ asset('assets/js/ace-extra.js') }}"></script>
	<script src="{{ asset('assets/js/ace.js') }}"></script>
	<script src="{{ asset('assets/js/chartli.js') }}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.pack.min.js"></script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxC7K19XTG66MkYgfK-YEpuCQxljz5n78&callback=initMap" type="text/javascript"></script>
	<script>
		@yield('statjs')
	</script>
	<script>
    AOS.init();
  	</script>
  	<script type="text/javascript">
  		@yield('funjscript')
  	</script>
  	<script type="text/javascript">
  		$( document ).ready(function() {
  			@yield('jscript')
  			<?php
  				$action = app('request')->route()->getAction();

		        $controller = class_basename($action['controller']);

		        list($controller, $action) = explode('@', $controller);
		        // $controller."----".$action;
  			?>
  			@if($controller == 'UserController' || $controller == 'RegisterController')
	  			$("#lihome").removeClass('active');
	  			$("#liuser").addClass('active');
	  		@elseif($controller == 'TeamController' || $controller == 'TmemberController' || $controller == 'TmanagerController')
	  			$("#lihome").removeClass('active');
	  			$("#liteam").addClass('active');
	  		@elseif($controller == 'FormController' || $controller == 'ProjectController' || $controller == 'FormdetailController')
	  			$("#lihome").removeClass('active');
	  			$("#liproject").addClass('active');
  			@endif
  			// alert('{{$controller."--".$action}}');

  		});

  				$(document).ready(function() {
			/*
			*   Examples - images
			*/

			$("a#example2").fancybox({
				'overlayShow'	: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
		});

  	</script>
</body>
</html>				