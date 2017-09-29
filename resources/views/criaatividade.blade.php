@extends('layouts.master')
@section('title', '- Criar Atividade')
@section('titlesection', 'Criar Atividade')
@section('atividadesAtivo','active')
@section('principal')
@parent
<form action="/CadastraAtividade" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div>

		<!-- Nav tabs -->
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active" ><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Informações Básicas</a></li>
				<li ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Informações de Localização</a></li>
				<li ><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Inscrições</a></li>
				
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="home">
					<fieldset>
						<center><legend> <b>Dados da Atividade</b>
						</legend></center>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="nome">Nome</label>
								<input type="text" id="nome" name="nome" value="" class="form-control" placeholder="Nome" required>
							</div>
							<div class="form-group">
								<label for="Conteudo">Conteúdo</label>
								<input type="text" id="Email" name="conteudo" value="" class="form-control" placeholder="Conteudo da Atividade" required>
							</div>
							<div class="form-group">
								<label for="Pré-Requisitos">Pré-Requisitos</label>
								<input type="text" id="CPF" name="prequisitos" value="" class="form-control" placeholder="Pré-Requisitos"  required>
							</div>
							<div class="form-group">
								<label for="Pré-Requisitos">Tipo de Atividade</label>
								<select name="tpoAtividade" class="form-control">
									@foreach($atv as $row)
									@if($row->tipAtiCod<>1)
									<option value="{{ $row->tipAtiCod }}">{{ $row->tipAtiNome }}</option>
									@endif
									@endforeach
								</select>
							</div>



						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="Preço">Preço</label>
								<input type="number" name="Preco" class="form-control" min="0" step="0.1" required>
							</div>
							<div class="form-group">
								<label for="Material">Necessidade de Material ou Ambiente</label>
								<input type="text" id="RG" name="ambiente" class="form-control"  value="" placeholder="Necessidade de Material ou Ambiente"  required>
							</div>
							<div class="form-group">
								<label for="Material">Carga Horária</label>
								<input type="number" name="horario" class="form-control" step="1" min="0" required>
							</div>
							<div class="form-group">
								<label for="Area_Conhecimento">A inscrição em um evento dá direito a participar desta atividade?</label>
								<select name="Pacote" class="form-control">
									<option value="Nao">Não</option>
									<option value="Sim">Sim</option>
								</select>
							</div>
						</div>

						
					</fieldset>

				</div>
				<div role="tabpanel" class="tab-pane" id="profile">

					<fieldset>
						
						<center><legend><b>Endereço</b></legend></center>
						<div class="col-lg-6">

							<div class="form-group">
								<label for="Rua">Rua</label>
								<input type="text" id="Rua" name="Rua" value="@if($enderecoEvento <> null) {{$enderecoEvento->endRua}}  @endif" class="form-control" placeholder="Rua" required>
							</div>
							<div class="form-group">
								<label for="Numero">Número</label>
								<input type="text" id="numero" name="numero" value="@if($enderecoEvento <> null) {{$enderecoEvento->endNumero}}  @endif" class="form-control" placeholder="Numero" required>
							</div>
							<div class="form-group">
								<label for="Bairro">Bairro</label>
								<input type="text" id="Bairro" name="Bairro" class="form-control" value="@if($enderecoEvento <> null) {{$enderecoEvento->endBairro}}  @endif" placeholder="Bairro" required>
							</div>
							<div class="form-group">
								<label for="Complemento">Complemento</label>
								<input type="text" id="Complemento" name="Complemento" class="form-control" value="@if($enderecoEvento <> null) {{$enderecoEvento->endComplemento}}  @endif" placeholder="Complemento">
							</div>
							<div class="form-group">
								<label for="comment">Informações Adicionais</label>
								<textarea class="form-control" rows="5" name="adicional" placeholder="Informações Adicionais"></textarea>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="Cidade">Cidade</label>
								<input type="text" id="Cidade" name="Cidade" class="form-control" value="@if($enderecoEvento <> null) {{$enderecoEvento->endCidade}}  @endif" placeholder="Cidade" required>
							</div>
							<div class="form-group">
								<label for="CEP">CEP</label>
								<input type="text" id="CEP" name="CEP" class="form-control" value="@if($enderecoEvento <> null) {{$enderecoEvento->endCEP}}  @endif" placeholder="CEP" required>
							</div>
							<div class="form-group">
								<label for="Estado">Estado</label>
								<input type="text" id="Estado" name="Estado" class="form-control" value="@if($enderecoEvento <> null) {{$enderecoEvento->endEstado}}  @endif" placeholder="Estado" required>
							</div> 
							<div class="form-group">
								<label for="Pais">País</label>
								<input type="text" id="Pais" name="Pais" class="form-control" value="@if($enderecoEvento <> null) {{$enderecoEvento->endPais}}  @endif" placeholder="Pais" required>
							</div>
						</div>
						

					</fieldset>


				</div>
				<div role="tabpanel" class="tab-pane" id="messages">

					<fieldset>
						<center><legend><b>Inscrições</b></legend></center>
						<div class="form-group">
							<label for="dataIniInsc">Data do Início das Inscrições</label>
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="date" id="ini" name="iniIns" value="@if($dataIniInscricao <> null) {{ date('Y-m-d', strtotime($dataIniInscricao)) }} @endif" class="form-control" placeholder="Definição do Início das datas de Inscrição"  >
							</div>
						</div>
						<div class="form-group">
							<label for="dataIniInsc">Data do Término das Inscrições</label>
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="date" id="fim" name="fimIns" value="@if($dataFimInscricao <> null) {{ date('Y-m-d', strtotime($dataFimInscricao)) }} @endif" class="form-control" placeholder="Definição do Término das datas de Inscrição"  >
							</div>
						</div>
						<div class="form-group">
							<label for="Instituição">Número de Vagas</label>
							<input type="number" name="NumeroVagas"  step="1" min="0" class="form-control" required>
						</div>
						<button type="submit" name="Cadastrar" class="btn btn-primary">Cadastrar Atividade</button>
					</fieldset>
				</div>


			</div>

		</div>
	</div>
</div>
</form>



@endsection