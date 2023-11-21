<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link href="{{ asset('assetsbaru/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/DataTables/media/css/dataTables.bootstrap.css') }}" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
	<!-- Ionicons -->
	<link href="{{ asset('assets/css/ionicons.min.css') }}" rel="stylesheet">
	<!-- Theme style -->
	<link href="{{ asset('assetsbaru/css/AdminLTE.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/validationEngine.jquery.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/datepicker3.min.css') }}" rel="stylesheet">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	folder instead of downloading all of them to reduce the load. -->
	<link href="{{ asset('assetsbaru/css/_all-skins.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/jquery.ui.autocomplete.css') }}" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- Google Font -->
	<link href="{{ asset('assets/css/googleapi.css') }}" rel="stylesheet">
	<style>
	.select2-container .select2-selection--single{
	box-sizing: border-box;
	cursor: pointer;
	display: block;
	height:35px;
	user-select: none;
	-webkit-user-select: none;
	}
	</style>
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">


<div class="wrapper">

	<header class="main-header">
		<!-- Logo -->
		<a href="{{URL::to('/')}}/home" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini"><b>e</b>S</span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><b>e</b>Survey</span>
		</a>
			<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
				
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="user user-menu">
						<a href="#">Selamat Datang {{strtoupper(Auth::user()->name)}}&nbsp;&nbsp;&nbsp;</a>
					</li>
					<li class="user user-menu">
						<a href="{{ route('logout') }}"
						onclick="event.preventDefault();
						document.getElementById('logout-form').submit();" class="btn btn-primary btn-flat">Sign out</a>
					</li>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form> 
				</ul>
			</div>
		</nav>
	</header>

	<!-- Left side column. contains the logo and sidebar -->
  	<aside class="main-sidebar">
  		<!-- sidebar: style can be found in sidebar.less -->
	    <section class="sidebar">
			<!-- 
				Sidebar user panel
			<div class="user-panel">
				<div class="pull-left image">
					<img src="{{ asset('assetsbaru/img/avatar.png') }}" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p>Users</p>
					<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
				</div>
			</div>
			-->

	      	<!-- search form -->
			<!-- <form action="#" method="get" name ="q" class="sidebar-form search-menu-box" id="life-search">
				<div class="input-group">
					<input type="text" name="q" class="form-control" placeholder="Search..." id="filter">
					<span class="input-group-btn">
						<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
					</span>
				</div>
			</form> -->
	      	<!-- /.search form -->

			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu" data-widget="tree">
	        	<li class="header">Menu--{{Auth::user()->tipe}}</li>
				<li><a href="{{URL::to('/home')}}"><i class="glyphicon glyphicon-home"></i> <span>Home</span></a></li>  
				
						<li class="treeview" id="master">
							<a href="#">
							<i class="fa fa-list"></i>
							<span class="link-title">&nbsp;master&nbsp;<!-- <i class="fa fa-chevron-down"></i> --></span> 
							<!--  <span class="fa fa-chevron-down"></span>-->
							</a>
							<ul class="treeview-menu">
								@if(Auth::user()->tipe=='sa' || Auth::user()->tipe=='admin')
								<li class ="treeview" id="usermenu">
								<li id ="usermenu">
									<a href="{{URL::route('userlist')}}">
										<i class="fa fa-circle-o"></i> &nbsp; User &nbsp;
											<i><span class="fa fa-chevron-down"></i></span>
									</a>
								</li>
								@endif
								@if(Auth::user()->tipe=='manager' || Auth::user()->tipe=='admin')
								<li id ="team">
									<a href="{{URL::route('teamlist')}}">
										<i class="fa fa-circle-o"></i> &nbsp; Team &nbsp;
											<i><span class="fa fa-chevron-down"></i></span>
									</a>
								</li>
								@if(Auth::user()->tipe=='admin')
								<li id ="project">
									<a href="{{URL::route('projectlist')}}">
										<i class="fa fa-circle-o"></i> &nbsp; Project &nbsp;
											<i><span class="fa fa-chevron-down"></i></span>
									</a>
								</li>
								@endif
								@endif
								@if(Auth::user()->tipe=='member')
								<li id ="project">
									<a href="{{URL::route('formmemberlist')}}">
										<i class="fa fa-circle-o"></i> &nbsp; Form &nbsp;
											<i><span class="fa fa-chevron-down"></i></span>
									</a>
								</li>
								@endif
								<li id ="report">
									<a href="{{URL::route('reportlist')}}">
										<i class="fa fa-circle-o"></i> &nbsp; Report &nbsp;
											<i><span class="fa fa-chevron-down"></i></span>
									</a>
								</li>
							</ul>
						</li>
	    </section>
	    <!-- /.sidebar -->
  	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			@yield('header')
		</section>
		
		<!-- Main content -->
		<section class="content" style="overflow:auto;">
			<div class="row">
				@yield('content')
			</div>
		</section>
		<!-- /.content -->
	</div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3.1.1 -->
<script src="{{ asset('assetsbaru/js/jquery-3.1.1.min.js') }}"></script>
  <script src="{{ asset('assetsbaru/js/jquery-migrate-3.0.0.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('assetsbaru/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assetsbaru/js/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assetsbaru/js/adminlte.min.js') }}"></script>
<script src="{{ asset('assets/DataTables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/DataTables/media/js/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/jquery.mask.js') }}"></script>
<script src="{{ asset('assets/js/jquery.maskMoney.js') }}"></script>
<script src="{{ asset('assets/js/select2.full.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validationEngine.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validationEngine-en.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>



<script src="{{ asset('assets/js/jquery.mark.min.js') }}"></script>
<script type="text/javascript">
@yield('jscript')    
</script>
<script>
$.fn.openMenu = function () {
        var className = $(this).attr('class');
	if(className == "treeview"){
		$(this).addClass("active");
	}else if(className == "treeview-menu" ){
		$(this).addClass("menu-open");
		$(this).css({ display: "block" });
	}
};

$.fn.closeMenu = function () {
        var className = $(this).attr('class');
	var count = $(this).length;
	if(count > 1){
		$.each($(this), function( key, element ) {
			className = $(element).attr('class');
			if(className == "treeview active"){
				$(element).removeClass("active");
			}else if(className == "treeview-menu menu-open" ){
				$(element).removeClass("menu-open");
				$(element).css({ display: "none" });
			}
		});
	}else{
		if(className == "treeview active"){
			$(this).removeClass("active");
		}else if(className == "treeview-menu menu-open" ){
			$(this).removeClass("menu-open");
			$(this).css({ display: "none" });
		}
	}
};

$(".search-menu-box").on('input', function() {
    var filter = $(this).val();
    $(".sidebar-menu > li").each(function(){
        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
            $(this).hide();
        } else {
            $(this).show();
            $(this).parentsUntil(".treeview").openMenu();
        }
    });
});
</script>
</body>
</html>