<!DOCTYPE html>
<html>

<head>
		<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="{{ asset('data/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('data/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('data/css/AdminLTESkins.min.css') }}">
	<link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
	<link rel="shortcut icon" href="{{ asset('/data/dist/img/iconedoif.ico') }}">
	<script type="text/javascript" src="{{ asset('/data/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
	<title>Eventos IFMG @yield('title')</title>
</head>

<body class="fixed hold-transition skin-green-light sidebar-mini">
	<script>
		if (localStorage.getItem('skin')){
			$("body").removeClass("skin-green-light").addClass(localStorage.getItem('skin'));
		}</script>
		<div class="wrapper">
			<header class="main-header" id="header">
				<a href="{{ action('HomeController@index') }}" class="logo">
					<span class="logo-mini"><img src="{{ asset('/data/dist/img/if.png') }}" height="40px" width="30px" alt="Mini Image"></span>
					<span class="logo-lg"><img src="{{ asset('/data/dist/img/if.png') }}" height="40px" width="30px" alt="Mini Image"><b>&nbsp;&nbsp;Eventos</b>IFMG</span>
				</a>
				<nav class="navbar navbar-static-top" role="navigation" id="side0">
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Navegador</span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li>
								<a href="#" data-toggle="control-sidebar" id="side"><i class="fa fa-gears" id="side3"></i></a>
							</li>
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="/data/dist/img/user.png" class="user-image" alt="User Image">
									<span class="hidden-xs">Confirmação de Cadastro</span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header"> 
										<img src="{{ asset('/data/dist/img/user.png') }}" class="img-circle" alt="User Image">
										<p>
											{{ $user->name }} 
										</p>
									</li>
									
									<!-- Menu Footer-->
									
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			<aside class="main-sidebar">
				<section class="sidebar">
					<div class="user-panel">
						<div class="pull-left image">
							<img src="{{ asset('/data/dist/img/user.png') }}" class="img-circle" alt="User Image">
						</div>
						<div class="info">
							<br>
							<p>
							<?php
							$names = explode(" ",$user->name);
							$string = "";
							foreach ($names as $name) {
							if(strlen($string)+strlen($name)<=23){
                              $string.=" ".$name;
							} else {
								break;
							}
							}
							echo $string;
							?> </p>
						</div>
					</div>


					


				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
						@yield('titlesection')
						<small>    @yield('descsection')</small>
					</h1>
				</section>
				<section class="content">
					@section('principal')
					@show
				</section>
			</div>

			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					Projeto em Construção&nbsp;  &nbsp;  
					<a href="#top"><i class="fa fa-arrow-up"></i></a>
				</div>
				Copyright &copy; 2016 <a href="http://www.formiga.ifmg.edu.br/">IFMG </a>- Campus Formiga | Projeto de Pesquisa | Todos os direitos reservados.
			</footer>

			<aside class="control-sidebar control-sidebar-dark" id="controll" >
				<div class="tab-content" id="control">
					<div class="tab-pane active" id="control-sidebar-theme-demo-options-tab">
					</div>
				</div>
			</aside>


				<script type="text/javascript" src="{{ asset('data/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('data/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('data/bootstrap/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('data/plugins/fastclick/fastclick.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('data/dist/js/app.js') }}"></script>
	<script type="text/javascript" src="{{ asset('data/dist/js/demo.js') }}"></script>
			<script type="text/javascript" src="{!! asset('data/js/mask.js') !!}"></script>

		</body>
		</html>