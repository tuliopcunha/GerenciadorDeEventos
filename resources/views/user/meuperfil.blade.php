@extends('layouts.master')
@section('title',' - Meu Perfil')
@section('titlesection', 'Meu Perfil')
@section('css')
@parent
<link rel="stylesheet" href="{{ asset('data/css/passwordbar.css') }}"> 
@endsection
@section('principal')
@parent
<section class="content">
	<div class="row">

		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#dados" data-toggle="tab" aria-expanded="true">Dados Pessoais</a></li>
				<li class=""><a href="#localizacao" data-toggle="tab" aria-expanded="false" id="dadoslocalizacao">Localização</a></li>
				<li class=""><a href="#formacao" data-toggle="tab" aria-expanded="false" id="dadosformacao">Formação Acadêmica</a></li>
				<li class=""><a href="#senha" data-toggle="tab" aria-expanded="false" id="alterarsenha">Alterar Senha</a></li>
			</ul>
		</div>	

		<form action="/meu_perfil" method="post">
			{!! csrf_field() !!}
			<div class="tab-content">


				<div class="tab-pane active" id="dados">

					<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
						<div class="form-group">
							<label for="nome">Nome *</label>
							<input type="text" id="nome" name="nome" value="{{ $user->name }}" class="form-control" placeholder="Nome" maxlength="100" required>
						</div>
						<div class="form-group">
							<label for="email">Email *</label>
							<input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email" maxlength="100" required>
						</div>
						<div class="form-group">
							<label for="cpf">CPF *</label>
							<input type="text" id="cpf" name="cpf" class="form-control" value="{{ $user->usuCpf }}" placeholder="CPF" size="14" maxlength="14" required>
						</div>
						<div class="form-group">
							<label for="rg">RG *</label>
							<input type="text" id="rg" name="rg" value="{{ $user->usuRg }}" class="form-control" placeholder="RG" minlength="9" maxlength="14" required>
						</div>
						<div class="form-group">
							<label for="data">Data de Nascimento *</label>
							<input type="date" id="data" name="data" class="form-control" value="{{ $user->usuDataNascimento }}" required>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="form-group">
							<label for="instvinc">Instituição Vinculada</label>
							<input type="text" id="instvinc" name="instvinc" value="{{ $user->usuInstituicaoVinculo }}" class="form-control" placeholder="Instituição Vinculada" maxlength="45">
						</div> 
						<div class="form-group">
							<label for="matricula">Matrícula *</label>
							<input type="text" id="matricula" name="matricula" class="form-control" value="{{ $user->usuMatricula }}"  placeholder="Matricula" maxlength="15" required>
						</div>						     
						<div class="form-group">
							<label for="obsesp">Observações Especiais</label>
							<input type="text" id="obsesp" name="obsesp" class="form-control" value="{{ $user->usuObsPne }}" placeholder="Observações Especiais" maxlength="45">
						</div>
						
					</div>

					<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
						<div class="form-group">
							<label for="telefone1">Telefone 1 *</label>
							<input type="text" id="telefone1" name="telefone1" value="{{ $user->usuTel1 }}" class="form-control" placeholder="Telefone 1" maxlength="16" required>
						</div>
						<div class="form-group">
							<label for="telefone2">Telefone 2</label>
							<input type="text" id="telefone2" name="telefone2" value="{{ $user->usuTel2 }}" class="form-control" placeholder="Telefone 2" maxlength="16">
						</div>
						<div class="form-group">
							<label for="lattes">Link do Curriculum Lattes</label>
							<input type="text" id="lattes" name="lattes" class="form-control" value="{{ $user->usuLattes }}" placeholder="Link" maxlength="100">
						</div>

					</div>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="right">
						<button type="button" class="btn btn-primary" onclick='verify("#dados","#dadoslocalizacao")'>Proximo</button>
					</div>

				</div>


				<div class="tab-pane" id="localizacao">

					<div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
						<div class="form-group">
							<label for="rua">Logradouro *</label>
							<input type="text" id="rua" name="rua" class="form-control" value="{{ $endereco->endRua }}" placeholder="Rua/Avenida/Alameda" maxlength="45" required>
						</div>
						<div class="form-group">
							<label for="numero">Número *</label>
							<input type="text" id="numero" name="numero"  class="form-control" value="{{  $endereco->endNumero }}" placeholder="Número" maxlength="5" required>
						</div>
						<div class="form-group">
							<label for="complemento">Complemento</label>
							<input type="text" id="complemento" name="complemento" class="form-control" value="{{  $endereco->endComplemento }}" placeholder="Complemento" maxlength="15">
						</div>
						<div class="form-group">
							<label for="bairro">Bairro *</label>
							<input type="text" id="bairro" name="bairro" class="form-control" value="{{  $endereco->endBairro }}" placeholder="Bairro" maxlength="45" required>
						</div> 
					</div>


					<div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
						<div class="form-group">
							<label for="cep">CEP *</label>
							<input type="text" id="cep" name="cep" maxlength="9" value="{{ $endereco->endCEP }}" class="form-control" placeholder="CEP" required>
						</div>

						<div class="form-group">
							<label for="uf">Estado *</label>
							<select id="uf" name="uf" default="{{$endereco->endEstado }}" class="form-control" required></select>
						</div> 
						<div class="form-group">
							<label for="cidade">Cidade *</label>
							<select id="cidade" name="cidade" default="{{ $endereco->endCidade }}" class="form-control" required></select>
						</div>
						<div class="form-group">
							<label for="pais">País *</label>
							<input type="text" id="pais" name="pais" class="form-control" value="{{  $endereco->endPais }}" maxlength="45" required> 
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="right">
						<button class="btn btn-primary" type="button" onclick="verify('#localizacao','#dadosformacao')">Proximo</button>
					</div>


				</div>



				<div class="tab-pane" id="formacao">


					<div class="col-lg-4">

						<div class="form-group">
							<label for="areaconhecimento">Área do Conhecimento *</label>
							<select name="areaconhecimento" default="Selecione" class="form-control">
								@foreach ($area_conhecimento as $area)
								@if ($area->areCod==$formacao->for_areCod)
								<option value="{{ $area->areCod }}" selected>{{ $area->areNome }}</option>
								@else
								<option value="{{ $area->areCod }}">{{ $area->areNome }}</option>
								@endif
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="titulo">Título *</label>
							<select name="titulo" class="form-control" required>
								@foreach ($titulos as $titulo)
								@if ($titulo->titCod==$formacao->for_titCod)
								<option value="{{ $titulo->titCod }}" selected>{{ $titulo->titNome }}</option>
								@else
								<option value="{{ $titulo->titCod }}">{{ $titulo->titNome }}</option>
								@endif
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="instituicao">Instituição de Formação *</label>
							<input type="text" id="instituicao" name="instituicao"  value="{{ $formacao->forInstituicao }}" class="form-control" placeholder="Instituição de Formação"  maxlength="45" required>
						</div>

						<div class="form-group">
							<label for="ano">Ano de Formação *</label>
							<input type="text" id="ano" name="ano" class="form-control" value="{{ $formacao->forAno }}" placeholder="Ano" placeholder="Ano que irá se formar ou se formou" value="{{ $formacao->forAno }}"  maxlength="45" required>
						</div>

					</div>
					<div class="col-lg-12" align="right">
						<button align="center" type="submit" id="submit" class="btn btn-primary">Atualizar</button>

					</div>
				</div>
			</form>
			<div class="tab-pane" id="senha">
				<form action="/alterarsenha" method="post" id="formsenha">
					{!! csrf_field() !!}
					<div class="col-lg-4">
						<div class="form-group">
							<label for="passwordold">Senha Atual</label>
							<input type="password" name="passwordOld" id="passwordOld" class="form-control" minlength="6" maxlength="255" oninput="this.setCustomValidity('')">
						</div>

						
						<div class="form-group">
							<label for="passworldnew">Nova Senha</label>
							<input type="password" id="password" id="password" name="password" class="form-control" onfocus="addBarra()" minlength="6" maxlength="255" required oninput="this.setCustomValidity('')">
						</div>
						<div class="center" id="barra">
						</div>

						
						<div class="form-group">
							<label for="passwordconfirm">Confirmar Senha</label>
							<input type="password" name="passwordconfirm" class="form-control" oninput="checkPassword(this)" minlength="6" maxlength="255"  required>
						</div>
						<div class="col-lg-12" align="center">
							<button align="center" id="submitsenha" type="submit" class="btn btn-primary">Confirmar</button>

						</div>
					</div>

				</form>

				<!-- tab pane -->
			</div>
			<!-- tab content -->
		</div>
		<!-- tab panel -->
	</div>
	<!-- row -->
</div>
</section>



@endsection

@section('js')
@parent

<script type="text/javascript" src="{!! asset('data/js/jquery.pstrength.js') !!}"></script>
<script type="text/javascript" src="{!! asset('data/js/cidades.js') !!}"></script>
<script type="text/javascript" src="{!! asset('data/js/mask.js') !!}"></script>
<script>
	$('#uf').ufs({
		onChange: function(uf){
			$('#cidade').cidades({uf: uf});
		}
	});
</script>
@if ($errors->has('passwordOld'))
<script>
	document.getElementById('passwordOld').setCustomValidity('Senha atual incorreta');
</script>
@endif
@if ($errors->has('password'))
<script>
	document.getElementById('password').setCustomValidity('Senha já definida anteriormente');
</script>
@endif
@if ($errors->has('passwordOld') or $errors->has('password'))
<script>	
	$(document).ready(function() {	
		$('#alterarsenha').click()
		$('#submitsenha').click()
	});
</script>
@endif
@endsection