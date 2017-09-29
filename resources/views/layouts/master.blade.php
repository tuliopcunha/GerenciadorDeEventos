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
	@section('css')
	@show
	<script type="text/javascript" src="{{ asset('/data/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
	<title>Eventos IFMG @yield('title')</title>
</head>


<body class="fixed hold-transition skin-green-light sidebar-mini">
	<script>
		if (localStorage.getItem('skin')){
			$("body").removeClass("skin-green-light").addClass(localStorage.getItem('skin'));

		}
	</script>
	<div class="wrapper">
		<header class="main-header" id="header">
			<!-- Barra Superior -->
			<a href="{{ url('/') }}" class="logo">
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
						<li class="dropdown user user-menu" onclick="alteraCor()">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="{{ asset('/data/dist/img/user.png') }}" class="user-image" alt="User Image">
								<span class="hidden-xs">{{ session('perfilAtual') }}</span>
							</a>
							<ul class="dropdown-menu">
								<!-- Imagem do Usuário -->
								<li class="user-header"> 
									<img src="{{ asset('/data/dist/img/user.png') }}" class="img-circle" alt="User Image">
									<p>
										{{ session('name') }}
										<small>{{ session('usuInstituicaoVinculo') }}</small>
									</p>
								</li>
								<li class="user-body">
									<h4 align="center">Acessar como:</h4>
									<form name='selectPerfil' action="/altera_perfil" method="post">
										{!! csrf_field() !!}
										<select class="form-control" name="perfil" onChange="document.selectPerfil.submit();">
											<?php  
											foreach (session('perfis') as $perfil) {
												if($perfil==session('perfilAtual')){
													echo '<option value="'.$perfil.'" selected>'.$perfil.'</option>';
												} else {
													echo '<option value="'.$perfil.'">'.$perfil.'</option>';
												}
											}
											?>
										</select>
									</form>
								</li>
								<!-- Rodapé Menu Usuario -->
								<li class="user-footer">
									<div align=center>
										<a href="{{ url('/meu_perfil') }}" id="perfilbutton" class="btn btn-block btn-success">Meu Perfil</a>
										<a href="{{ url('/logout') }}" id="logoutbutton" class="btn btn-block btn-success">Sair</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<!-- Barra Superior Esquerda -->
		<aside class="main-sidebar">
			<section class="sidebar">

				<div class="user-panel">
					<div class="pull-left image">
						<img src="{{ asset('/data/dist/img/user.png') }}" class="img-circle" alt="User Image">
					</div>
					
					<div class="info">
						<br>
						
						<p>
							<a href="{{ url('/meu_perfil') }}">
								<?php
								$names = explode(" ", session('name'));
								$string = "";
								foreach ($names as $name) {
									if(strlen($string)+strlen($name)<=23){
										$string.=" ".$name;
									} else {
										break;
									}
								}
								echo $string;
								?>
							</a>
						</p>
						
					</div>
				</div>

				<!-- Menu -->
				<ul class="sidebar-menu" >
					<li class="header">MENU</li>

					<li class="@yield('principalAtivo')"><a href="{{ url('/') }}"><i class="fa fa-home disabled"></i> <span>Home</span></a></li>
					<li class="treeview @yield('eventosAtivo')">

						<a href="#"><i class="fa fa-calendar"></i><span disabled>Eventos</span><i class="fa fa-angle-down pull-right"></i></a>

						<ul class="treeview-menu">  
							@if(session('perfilAtual')=='Administrador' or session('perfilAtual')=='Coordenador') 
							<li><a href="{{ url('/eventos/meus_eventos') }}">Meus Eventos</a></li>
							@if(session('coordenadorPermissoes')==3 or session('coordenadorPermissoes')==2 )
							<li><a href="{{ url('/eventos/criarEvento') }}">Criar Evento</a></li>
							@endif
							@endif
							<li><a href="{{ url('/eventos/disponiveis') }}">Eventos Disponíveis</a></li>
							<li><a href="{{ url('/eventos/inscritos') }}">Eventos Inscritos</a></li>
						</ul>
					</li>

					<li class="@yield('atividadesAtivo')">
						<a href="#"><i class="fa fa-pencil"></i> <span>Atividades</span> <i class="fa fa-angle-down pull-right"></i></a>
						<ul class="treeview-menu">
							@if(session('perfilAtual')=='Administrador' or session('perfilAtual')=='Coordenador') 
							<li><a href="{{ url('/atividades/minhas_atividades') }}">Minhas Atividades</a></li>
							@if(session('coordenadorPermissoes')==3 or session('coordenadorPermissoes')==1 )
							<li><a href="{{ url('/atividade/criar_atividade') }}">Criar Atividade</a></li>
							@endif
							@endif
							<li><a href="{{ url('/atividades/atividades_disponiveis') }}">Atividades Disponíveis</a></li>
							<li><a href="{{ url('/atividades/inscricoes') }}">Atividades Inscritas</a></li>
						</ul>
					</li>
						@if(session('perfilAtual')=='Administrador')
					<li class="@yield('paineldeControleAtivo')">
						<a href="#"><i class="fa fa-sliders"></i> <span>Painel de Controle</span> <i class="fa fa-angle-down pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ action('PermissoesUsuarioController@redirecAtividade') }}">Permissão de Atividade</a></li>
							<li><a href="{{ action('PermissoesUsuarioController@redirecEvento') }}">Permissão de Evento</a></li>
						</ul>
					</li>
					@endif
				<!--	<li class="@yield('CertificadoAtivo')"><a href="#"><i class="fa fa-file-text"></i> <span>Certificado</span></a></li> -->
					<li class="@yield('ContatoAtivo')"><a href="{{ url('/contato') }}/@yield('titlesection')"><i class="fa fa-phone"></i> <span>Contato</span></a></li>
					<li class="@yield('sobreAtivo')"><a href="{{ url('/sobre') }}"><i class="fa fa-info-circle"></i> <span>Sobre</span></a></li>
				</ul>
			</section>
		</aside>

		<!-- Tela Principal -->
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
	</div>

	<!-- Rodapé -->
	<footer class="main-footer">
		<div class="pull-right hidden-xs">
			Topo&nbsp;  &nbsp;  
			<a href="#top"><i class="fa fa-arrow-up"></i></a>
		</div>
		Copyright &copy; 2016 <a href="http://www.formiga.ifmg.edu.br/">IFMG </a>- Campus Formiga | Projeto de Pesquisa | Todos os direitos reservados.
	</footer>

	<!-- Control SideBar JS -->
	<aside class="control-sidebar control-sidebar-dark" id="controll" >
		<div class="tab-content" id="control">
			<div class="tab-pane active" id="control-sidebar-theme-demo-options-tab">
			</div>
		</div>
	</aside>

	<!-- Scripts -->
	<script type="text/javascript" src="{{ asset('data/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('data/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('data/bootstrap/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('data/plugins/fastclick/fastclick.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('data/dist/js/app.js') }}"></script>
	<script type="text/javascript" src="{{ asset('data/dist/js/demo.js') }}"></script>
	<script type="text/javascript" src="{{ asset('data/js/alteraCor.js') }}"></script>
	
	
	@section('js')
	@show
</body>
</html>