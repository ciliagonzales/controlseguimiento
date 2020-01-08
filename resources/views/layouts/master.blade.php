<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de nivel de cumplimiento</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	{{-- <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css"> --}}
  {{-- <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css"> --}}
  {{-- <link rel="stylesheet" href="dist/css/AdminLTE.min.css"> --}}
  {{-- <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css"> --}}
  {{-- <link rel="stylesheet" href="bower_components/morris.js/morris.css"> --}}
  {{-- <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css"> --}}
  {{-- <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"> --}}
  {{-- <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css"> --}}
	{{-- <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> --}}
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> --}}
</head>
<body class="sidebar-mini" style="height: auto;">
    <div class="wrapper" id="app">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
				</li>
			</ul>
    
			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- Messages Dropdown Menu -->
				<li class="nav-item dropdown">
					<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
						@switch(Auth::user()->tipo)
							@case(1)
								Administrador ({{Auth::user()->user}}) <span class="caret"></span>	
								@break
							@case(2)
								Encargado ({{Auth::user()->user}})<span class="caret"></span>	
								@break
							@default
								
						@endswitch
						{{-- {{ Auth::user()->user }} <span class="caret"></span> --}}
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<a class="dropdown-item" href="{{ route('logout') }}"
							onclick="event.preventDefault();
										  document.getElementById('logout-form').submit();">
							 {{ __('Cerrar Sesión') }}
						 </a>

						 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							 @csrf
						 </form>
					</div>
				</li>
			</ul>
		</nav>
    
		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary">
			<!-- Brand Logo -->
			@php
				$tipo = Auth::user()->tipo;
				$user = Auth::user()->user;
				$pass = Auth::user()->password;
				$objOficina = DB::select("select IDOficina from encargadooficina where user = '$user'");
				$IDOficina = 0;
				if(isset($objOficina[0]->IDOficina))
				{
					$IDOficina = $objOficina[0]->IDOficina;
				}
				if(isset($IDOficina))
				{
					$objAbr = DB::select("SELECT Abreviacion FROM `oficinas` where IDOficina = $IDOficina");
					if(isset($objAbr[0]->Abreviacion))
					{
						$abr = $objAbr[0]->Abreviacion;
					}
					
				}
				if(!isset($abr))
				{
					$abr = "OPC";
				}	
			@endphp
			<router-link to="/home" class="brand-link text-center">
				<span class="brand-text font-weight-light">{{$abr}}</span>
				<img src="img/logo.png" alt="" height="40" width="40">
			</router-link>
    
			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user (optional) -->
				{{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
					</div>
					<div class="info">
						<a href="#" class="d-block">Usuario Autenticado</a>
					</div>
				</div> --}}
    
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

						@switch(Auth::user()->tipo)
							@case(1)
							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fa fa-folder"></i>
									<p>
										Areas
										<i class="fa fa-angle-right right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/unidades" class="nav-link">
											<i class="fa fa-plus-circle nav-icon"></i>
											<p>Oficinas</p>
										</router-link>
									</li>
								</ul>
													
							</li>
							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fa fa-folder" aria-hidden="true"></i>
									<p>
										Configuración
										<i class="fa fa-angle-right right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/objetivos" class="nav-link">
											<i class="fa fa-tasks nav-icon" aria-hidden="true"></i>
											<p>Objetivos</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/procesos" class="nav-link">
											<i class="fa fa-tasks nav-icon" aria-hidden="true"></i>
											<p>Proc. Estratégicos</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/actividades" class="nav-link">
											<i class="fa fa-briefcase nav-icon" aria-hidden="true"></i>
											<p>Actividades</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/subactividades" class="nav-link">
											<i class="fa fa-tasks nav-icon" aria-hidden="true"></i>
											<p>Sub Actividades</p>
										</router-link>
									</li>
									{{-- <li class="nav-item">
										<router-link to="/venta" class="nav-link">
											<i class="fa fa-dollar nav-icon" aria-hidden="true"></i>
											<p>Entregables</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/objetivos" class="nav-link">
											<i class="fa fa-flag nav-icon" aria-hidden="true"></i>
											<p>Objetivos</p>
										</router-link>
									</li>	 --}}
								</ul>
							</li>
							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fa fa-folder"></i>
									<p>
										Reportes
										<i class="fa fa-angle-right right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/upload" class="nav-link">
											<i class="fa fa-cloud-upload nav-icon" aria-hidden="true"></i>
											<p>Centro de cargas</p>
										</router-link>
									</li>
								</ul>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/avances" class="nav-link">
											<i class="fa fa-tasks nav-icon" aria-hidden="true"></i>
											<p>Avance</p>
										</router-link>
									</li>
								</ul>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/reporte" class="nav-link">
											<i class="fa fa-tasks nav-icon" aria-hidden="true"></i>
											<p>Reporte</p>
										</router-link>
									</li>
								</ul>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/ejecucion" class="nav-link">
											<i class="fa fa-tasks nav-icon" aria-hidden="true"></i>
											<p>Ejecución</p>
										</router-link>
									</li>
								</ul>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/download" class="nav-link">
											<i class="fa fa-download nav-icon" aria-hidden="true"></i>
											<p>Centro de descargas</p>
										</router-link>
									</li>
								</ul>
							</li>
							@break
							@case(2)
							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fa fa-folder"></i>
									<p>
										Reportes
										<i class="fa fa-angle-right right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/upload" class="nav-link">
											<i class="fa fa-cloud-upload nav-icon" aria-hidden="true"></i>
											<p>Centro de cargas</p>
										</router-link>
									</li>
								</ul>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/avances" class="nav-link">
											<i class="fa fa-tasks nav-icon" aria-hidden="true"></i>
											<p>Avance</p>
										</router-link>
									</li>
								</ul>								
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/download" class="nav-link">
											<i class="fa fa-download nav-icon" aria-hidden="true"></i>
											<p>Centro de descargas</p>
										</router-link>
									</li>
								</ul>
								<?php
								if(\Auth::user()->user == "wgomez")
								{
								?>
									<ul class="nav nav-treeview">
										<li class="nav-item">
											<router-link to="/reporte" class="nav-link">
												<i class="fa fa-tasks nav-icon" aria-hidden="true"></i>
												<p>Reporte</p>
											</router-link>
										</li>
									</ul>
									<ul class="nav nav-treeview">
										<li class="nav-item">
											<router-link to="/ejecucion" class="nav-link">
												<i class="fa fa-tasks nav-icon" aria-hidden="true"></i>
												<p>Ejecución</p>
											</router-link>
										</li>
									</ul>
								<?php
								}
								
								?>
							</li>
								@break
							@default
								
						@endswitch

					</ul>
				</nav>
			</div>
		</aside>
    
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper" style="min-height: 600px;">
    
			<!-- Main content -->
			<section class="content mt-4">
                @yield('content')
			</section>
		</div>
		<footer class="main-footer">
			<div class="float-right d-none d-sm-block">
				<b>Versión</b> 1.0
			</div>
			@php
				$anio = date('Y');
			@endphp			
			<strong>Copyright &copy; {{$anio}}   <a href="http://www.google.com">Sistema de nivel de cumplimiento</a>.</strong> Todos los derechos reservados.
		</footer>
    </div>
	
	<script src="{{ asset('js/app.js') }}"></script>
	<script type="text/javascript">
		<!--
		function filterFloat(evt,input){
			// Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
			var key = window.Event ? evt.which : evt.keyCode;    
			var chark = String.fromCharCode(key);
			var tempValue = input.value+chark;
			if(key >= 48 && key <= 57){
				if(filter(tempValue)=== false){
					return false;
				}else{       
					return true;
				}
			}else{
				  if(key == 8 || key == 13 || key == 0) {     
					  return true;              
				  }else if(key == 46){
						if(filter(tempValue)=== false){
							return false;
						}else{       
							return true;
						}
				  }else{
					  return false;
				  }
			}
		}
		function filter(__val__){
			var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
			if(preg.test(__val__) === true){
				return true;
			}else{
			   return false;
			}
			
		}
		-->
		</script>
			
</body>
</html>