@extends('layouts.confirmacao')
@section('title',' - Confirmação de Registro')
@section('titlesection', 'Confirmação de Registro')
@section('principal')
@parent
<section class="content">
	<form action="/confirmacao/info" method="post" id="confirmacao">
		{!! csrf_field() !!}

		<div class="row">

			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#dados" data-toggle="tab" aria-expanded="true">Dados Pessoais</a></li>
					<li class=""><a href="#localizacao" data-toggle="tab" aria-expanded="false" id="dadoslocalizacao">Localização</a></li>
					<li class=""><a href="#formacao" data-toggle="tab" aria-expanded="false" id="dadosformacao">Formação Acadêmica</a></li>
				</ul>
			</div>

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
							<input type="text" id="cpf" name="cpf" class="form-control" value="{{ $user->usuCpf }}" placeholder="CPF" size="14" disabled>
						</div>
						<div class="form-group">
							<label for="rg">RG *</label>
							<input type="text" id="rg" name="rg" class="form-control" placeholder="RG" minlength="9" maxlength="14" required>
						</div>
						<div class="form-group">
							<label for="data">Data de Nascimento *</label>
							<input type="date" id="data" name="data" class="form-control" placeholder="DD/MM/AAAA" required>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="form-group">
							<label for="instvinc">Instituição Vinculada</label>
							<input type="text" id="instvinc" name="instvinc" class="form-control" placeholder="Instituição Vinculada" maxlength="45">
						</div> 
						<div class="form-group">
							<label for="matricula">Matrícula *</label>
							<input type="text" id="matricula" name="matricula" class="form-control" maxlength="15" placeholder="Matricula" required>
						</div>
						<div class="form-group">
							<label for="obsesp">Observações Especiais</label>
							<input type="text" id="obsesp" name="obsesp" class="form-control"  placeholder="Observações Especiais" maxlength="45">
						</div>
						
					</div>

					<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
						<div class="form-group">
							<label for="telefone1">Telefone 1 *</label>
							<input type="text" id="telefone1" name="telefone1" class="form-control" placeholder="Telefone 1"  size="16" maxlength="16" required>
						</div>
						<div class="form-group">
							<label for="telefone2">Telefone 2</label>
							<input type="text" id="telefone2" name="telefone2" class="form-control" placeholder="Telefone 2" size="16" maxlength="16">
						</div>
						<div class="form-group">
							<label for="lattes">Link do Curriculum Lattes</label>
							<input type="text" id="lattes" name="lattes" class="form-control" placeholder="Link" maxlength="100">
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="right">
						<button type="button" class="btn btn-primary" onclick='verify("#dados","#dadoslocalizacao")'>Proximo</button>
					</div>

				</div>


				<div class="tab-pane" id="localizacao">

					<div class="col-lg-5">
						<div class="form-group">
							<label for="rua">Logradouro *</label>
							<input type="text" id="rua" name="rua" class="form-control" placeholder="Rua/Avenida/Alameda" maxlength="45" required>
						</div>
						<div class="form-group">
							<label for="numero">Número *</label>
							<input type="text" id="numero" name="numero"  class="form-control" placeholder="Número" maxlength="5" required>
						</div>
						<div class="form-group">
							<label for="complemento">Complemento</label>
							<input type="text" id="complemento" name="complemento" class="form-control" maxlength="45" placeholder="Complemento">
						</div>
						<div class="form-group">
							<label for="bairro">Bairro *</label>
							<input type="text" id="bairro" name="bairro" class="form-control" placeholder="Bairro" maxlength="45" required>
						</div> 
					</div>


					<div class="col-lg-4">
						<div class="form-group">
							<label for="cep">CEP *</label>
							<input type="text" id="cep" name="cep" size="9" maxlength="9" class="form-control" placeholder="CEP" required>
						</div>

						<div class="form-group">
							<label for="uf">Estado *</label>
							<select id="uf" name="uf" default="MG" class="form-control" required></select>
						</div> 
						<div class="form-group">
							<label for="cidade">Cidade *</label>
							<select id="cidade" name="cidade" class="form-control" required></select>
						</div>
						<div class="form-group">
							<label for="pais">País *</label>
							<input type="text" id="pais" name="pais" class="form-control" value="Brasil" placeholder="País" maxlength="45" required> 
						</div>
					</div>
					<div class="col-lg-12" align="right">
						<button class="btn btn-primary" type="button" onclick="verify('#localizacao','#dadosformacao')">Proximo</button>
					</div>


				</div>


				<div class="tab-pane" id="formacao">


					<div class="col-lg-4">

						<div class="form-group">
							<label for="areaconhecimento">Área do Conhecimento *</label>
							<select name="areaconhecimento" class="form-control">
								@foreach ($area_conhecimento as $area)
								<option value="{{ $area->areCod }}">{{ $area->areNome }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="titulo">Título *</label>
							<select name="titulo" class="form-control" required>
								@foreach ($titulos as $titulo)
								<option value="{{ $titulo->titCod }}">{{ $titulo->titNome }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="instituicao">Instituição de Formação *</label>
							<input type="text" id="instituicao" name="instituicao" class="form-control" placeholder="Instituição de Formação" maxlength="45" required> 
						</div>

						<div class="form-group">
							<label for="ano">Ano Formação *</label>
							<input type="text" id="ano" name="ano" class="form-control" placeholder="Ano que irá se formar ou se formou" maxlength="45" required>
						</div>

					</div>
					<div class="col-lg-12" align="right">
						<button align="center" type="submit" id="submit" name="Cadastrar" class="btn btn-primary">Cadastrar-se</button>

					</div>
				</div>

			</div>
		</form>
	</section>

	<script type="text/javascript" src="{!! asset('data/js/cidades.js') !!}"></script>
	<script>
		$('#uf').ufs({
			onChange: function(uf){
				$('#cidade').cidades({uf: uf});
			}
		});
	</script>


	@endsection