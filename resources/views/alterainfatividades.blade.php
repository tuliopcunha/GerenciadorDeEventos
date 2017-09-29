@extends('layouts.master')
@section('title', '- Alterar Informações')
@section('titlesection', 'Alterar Informações')
@section('atividadesAtivo','active')
@section('principal')
@parent

<style type="text/css">
  table {
    border: 1px solid #ccc;
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    width: 100%;
  }
  table caption {
    font-size: 1.5em;
    margin: .25em 0 .75em;
  }
  table tr {
    background: #f8f8f8;
    border: 1px solid #ddd;
    padding: .35em;
  }
  table th,
  table td {
    padding: .625em;
    text-align: center;
  }
  table th {
    font-size: .85em;
    letter-spacing: .1em;
    text-transform: uppercase;
  }
  table td img {
    text-align: center;
  }
  @media screen and (max-width: 600px) {
    table {
      border: 0;
    }
    table caption {
      font-size: 1.3em;
    }
    table thead {
      display: none;
    }
    table tr {
      border-bottom: 3px solid #ddd;
      display: block;
      margin-bottom: .625em;
    }
    table td {
      border-bottom: 1px solid #ddd;
      display: block;
      font-size: .8em;
      text-align: right;
    }
    table td:before {
      content: attr(data-label);
      float: left;
      font-weight: bold;
      text-transform: uppercase;
    }
    table td:last-child {
      border-bottom: 0;
    }
  }
</style>
<form action="/atividades/minhas_atividades/informacoes/alterainformacoes/alterado" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="Atividade" value="{{ $dados->atiCod }}">
  <div>


    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#home" aria-expanded="true" role="tab" data-toggle="tab">Informações Basicas</a></li>
        <li><a href="#profile" aria-expanded="false" role="tab" data-toggle="tab">Informações de Localização</a></li>
        <li><a href="#messages" aria-expanded="false" role="tab" data-toggle="tab">Inscrições</a></li>
        <li><a href="#Horarios" aria-expanded="false" role="tab" data-toggle="tab">Horarios</a></li>
        <li><a href="#Vinculos" aria-expanded="false" role="tab" data-toggle="tab">Vincular Atividade</a></li>


      </ul>

      

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
              <input type="text" id="nome" name="nome" value="{{ $dados->atiNome }}" class="form-control" placeholder="Nome">
            </div>
            <div class="form-group">
              <label for="Conteudo">Conteudo</label>
              <input type="text" id="Email" name="conteudo" value="{{ $dados->atiConteudo }}" class="form-control" placeholder="Conteudo da Atividade" >
            </div>
            <div class="form-group">
              <label for="Pré-Requisitos">Pré-Requisitos</label>
              <input type="text" id="CPF" name="prequisitos" value="{{ $dados->atiPreRequisitos }}" class="form-control" placeholder="Pré-Requisitos"  >
            </div>
            <div class="form-group">
              <label for="Pré-Requisitos">Tipo de Atividade</label>
              <select name="tpoAtividade" class="form-control">
                @if($dados->tipAtiCod==1)
                <option value="{{ $dados->ati_tipAtiCod }}">Curso</option>
                <option value="2">Palestra</option>

                @else
                <option value="{{ $dados->ati_tipAtiCod }}">Palestra</option>
                <option value="1">Curso</option>
                @endif
              </select>
            </div>

          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="Preço">Preço</label>
              <input type="number" id="RG" name="Preco" class="form-control"  value="{{ $dados->atiPreco }}" placeholder="Preço" step="0.01" min="0">
            </div>
            <div class="form-group">
              <label for="Material">Necessidade de Material ou Ambiente</label>
              <input type="text" id="RG" name="ambiente" class="form-control"  value="{{ $dados->atiNecessidadeMaterialAmbiente }}" placeholder="Necessidade de Material ou Ambiente"  >
            </div>
            <div class="form-group">
              <label for="Material">Carga Horaria</label>
              <input type="number" id="RG" name="horario" class="form-control"  value="{{ $dados->atiCargaHoraria }}" placeholder="Carga Horária"  min="{{ $dados->atiCargaHoraria }}">

            </div>
            <div class="form-group">
              <label for="Area_Conhecimento">Pacote Incluido no Evento ?</label>
              <select name="Pacote" class="form-control">
                @if($dados->atiIncluidaPcteEvento=='Sim')
                <option value="Sim">Sim</option>
                <option value="Nao">Não</option>
                @else
                <option value="Nao">Não</option>
                <option value="Sim">Sim</option>
                @endif
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
            <input type="text" id="Rua" name="Rua" value="<?php echo $ende->endRua ?>" class="form-control" placeholder="Rua" >
          </div>
          <div class="form-group">
            <label for="Numero">Numero</label>
            <input type="text" id="numero" name="numero" value="<?php echo $ende->endNumero ?>" class="form-control" placeholder="Numero">
          </div>
          <div class="form-group">
            <label for="Bairro">Bairro</label>
            <input type="text" id="Bairro" name="Bairro" class="form-control" value="<?php echo $ende->endBairro ?>"placeholder="Bairro" >
          </div>
          <div class="form-group">
            <label for="Complemento">Complemento</label>
            <input type="text" id="Complemento" name="Complemento" class="form-control" value="<?php echo $ende->endComplemento ?>" placeholder="Pais" >
          </div>
        </div>
        <div class="col-lg-6">
         <div class="form-group">
          <label for="Cidade">Cidade</label>
          <input type="text" id="Cidade" name="Cidade" class="form-control" value="<?php echo $ende->endCidade ?>" placeholder="Cidade" >
        </div>
        <div class="form-group">
          <label for="CEP">CEP</label>
          <input type="text" id="CEP" name="CEP" class="form-control" value="<?php echo $ende->endCEP ?>" placeholder="CEP" >
        </div>
        <div class="form-group">
          <label for="Estado">Estado</label>
          <input type="text" id="Estado" name="Estado" class="form-control" value="<?php echo $ende->endEstado ?>" placeholder="Estado" >
        </div> 
        <div class="form-group">
          <label for="Pais">País</label>
          <input type="text" id="Pais" name="Pais" class="form-control" value="<?php echo $ende->endPais ?>" placeholder="Pais" >
        </div>
      </div>
    </fieldset>


  </div>
  
  <div role="tabpanel" class="tab-pane" id="messages">

    <fieldset>
      <center><legend><b>Inscrições</b></legend></center>
      <div class="col-lg-4">
        <div class="form-group">
          <label for="Inicio">Inicio das Inscrições</label>
          <?php
          $dataini=date('Y-m-d',strtotime($dados->atiDataIniInsc));
          $datafim=date('Y-m-d',strtotime($dados->atiDataFimInsc));


          ?>
          <input type="date" id="Ini" name="iniIns"  value="{{ $dataini }}" class="form-control" >
        </div>
        <div class="form-group">
          <label for="Instituição">Termino das Inscrições</label>
          <input type="date" id="fim_Insc" name="fimIns"  value="{{ $datafim }}" class="form-control">
        </div>
        <div class="form-group">
          <label for="Instituição">Numero de Vagas</label>
          <input type="text" id="Instituição" name="NumeroVagas"  value="{{ $dados->atiNumVagas }}" class="form-control" placeholder="Instituição">
        </div>
      </div>
    </fieldset>
    <button type="submit" name="Cadastrar" class="btn btn-primary">Cadastrar Atividade</button>
  </div>

</form>
<div role="tabpanel" class="tab-pane" id="Horarios">
  <center><legend><b>Datas e Horários da Atividade</b></legend></center>
  <table>
    <thead>
      <tr>
        <th scope="col">Data</th>
        <th scope="col">Horário Início</th>
        <th scope="col">Horário Termino</th>
        <th scope="col">Remover</th>
      </tr>
    </thead>
    <tbody>
      <tr>
       <?php
       ?>
       @foreach($hor as $horario)
       @if($horario->hor_atiCod==$dados->atiCod)
       <?php 
       $horaInicio=$horario->horDataIniRealizacao;
       $horaIni = substr($horaInicio, 11, 8); 
       $horaFim = $horario->horDataFimRealizacao;
       $horaF= substr($horaFim, 11, 8); 
       ?>
       

       <form action="/atividades/minhas_atividades/informacoes/alterainformacoes/removeHorario" method="post" id="{{ $horario->horCod }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="codHorario" value="{{ $horario->horCod }}">
        <input type="hidden" name="codAtividade" value="{{ $dados->atiCod }}">
        <td><?php 
          $data = substr($horario->horDataIniRealizacao, 0, 10); 
          setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
          date_default_timezone_set('America/Sao_Paulo');
          echo strftime('%A, %d de %B de %Y', strtotime($data));
          ?></td>
          <td>{{ $horaIni }}</td>
          <td>{{ $horaF }}</td>
          <td><a href="#" onClick="document.getElementById('{{ $horario->horCod }}').submit();">Clique Aqui Para Remover</a></td>

        </form>
      </tr>
      @endif

      @endforeach

    </tbody>
  </table>
</div>

<div role="tabpanel" class="tab-pane" id="Vinculos">


  <div class="row">
   <center><legend> <b>Vinculo de sua Atividade com seu evento</b>
   </legend></center>

   <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">




    <form action="/atividades/minhas_atividades/informacoes/alterainformacoes/vinculo" method="post">
      <input type="hidden" name="Codigo" value="{{ $dados->atiCod }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group">
        <label for="Instituição">Vincular atividade ao evento: </label>
        <select class="form-control" name="Evento">
          @if($vinculo == 0)
          Não possui eventos para ser vinculado
          @else
          @foreach($vinculo as $evento)

          <option value="{{ $evento->eveCod }}"><?php echo $evento->eveNome; ?></option>

          @endforeach


          @endif
          


        </select>
      </div>

      <br>
      <button name="Vincular" class="btn btn-primary">Vincular</button>


    </form>


  </div>

  <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">

   <div class="form-group">
    <label for="Instituição"><h4><b>@if($ver==1)
      Não possui vinculo</b> </h4></label>
      @else
      Atividade vinculada ao evento:  {{ $evento->eveNome }}</b> </h4></label>
      @endif
      
    </div>

  </div>
  

</div>







</div>





</div>
</div>
</div>






@endsection