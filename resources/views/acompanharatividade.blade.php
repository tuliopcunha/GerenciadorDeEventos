@extends('layouts.master')
@section('titlesection', 'Atividade')
@section('atividadesAtivo','active')
@section('principal')
@parent

<div>


  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li role="presentation" class="active" ><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Informações Básicas</a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Informações de Localização</a></li>
      <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Lista de Presença</a></li>
      <li role="presentation" ><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Quadro de Horários</a></li>
      <li><a href="#Vinculos" aria-expanded="false" role="tab" data-toggle="tab">Vinculo</a></li>
      <li><a href="#Coordenadores" aria-expanded="false" role="tab" data-toggle="tab">Adição de Coordenadores</a></li>
    </ul>

    <!-- Nav tabs -->




    <!-- Tab panes -->
    <div class="tab-content">
     <div role="tabpanel" class="tab-pane active" id="home">
      <fieldset>
       <center><legend> <b>Dados da atividade</b>
       </legend></center>
       <div class="col-lg-6">
        <div class="form-group">
         <label for="nome">Nome</label>
         <input type="text" id="nome" name="nome" value="{{ $dados->atiNome }}" class="form-control" placeholder="Nome" disabled>
       </div>
       <div class="form-group">
         <label for="Conteudo">Conteúdo</label>
         <input type="text" id="Email" name="conteudo" value="{{ $dados->atiConteudo }}" class="form-control" placeholder="Conteudo da Atividade"disabled>
       </div>
       <div class="form-group">
         <label for="Pré-Requisitos">Pré-Requisitos</label>
         <input type="text" id="CPF" name="prequisitos" value="{{ $dados->atiPreRequisitos }}" class="form-control" placeholder="Pré-Requisitos" disabled >
       </div>
       <div class="form-group">
         <label for="Pré-Requisitos">Tipo de Atividade</label>
         @if($dados->ati_tipAtiCod==2)
         <input type="text" id="CPF" name="prequisitos" value="Curso" class="form-control" placeholder="Pré-Requisitos" disabled >
         @elseif($dados->ati_tipAtiCod==3)
         <input type="text" id="CPF" name="prequisitos" value="Palestra" class="form-control" placeholder="Pré-Requisitos" disabled >
         @endif
         
       </div>

     </div>
     <div class="col-lg-6">
      <div class="form-group">
       <label for="Preço">Preço</label>
       <input type="text" id="RG" name="Preco" class="form-control"  value="{{ $dados->atiPreco }}" placeholder="Preço" disabled >
     </div>
     <div class="form-group">
       <label for="Material">Necessidade de Material ou Ambiente</label>
       <input type="text" id="RG" name="ambiente" class="form-control"  value="{{ $dados->atiNecessidadeMaterialAmbiente }}" placeholder="Necessidade de Material ou Ambiente"disabled  >
     </div>
     <div class="form-group">
       <label for="Material">Carga Horária</label>
       <input type="text" id="RG" name="horario" class="form-control"  value="{{ $dados->atiCargaHoraria }}" placeholder="Carga Horária" disabled >
     </div>




     @if($alteracao==1)

     <form method="post" action="/atividades/minhas_atividades/informacoes/alterainformacoes">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" value="{{ $dados->atiCod }}"  name="Cod"></input>
      <button class="btn btn-primary" name="Altear">Alterar Informações</button>
    </form>
    @endif








    
  </div>
</div>
</fieldset>

<div role="tabpanel" class="tab-pane" id="profile">
  <fieldset>

   <center><legend> <b>Endereço</b>
   </legend></center>
   <div class="col-lg-6">

    <div class="form-group">
     <label for="Rua">Logradouro</label>
     <input type="text" id="Rua" name="Rua" value="<?php 
     echo $ende->endRua?>" class="form-control" placeholder="Rua/Avenida/Alameda"disabled>
   </div>
   <div class="form-group">
     <label for="Numero">Número</label>
     <input type="text" id="numero" name="numero" value="<?php echo $ende->endNumero?>" class="form-control" placeholder="Numero" disabled>
   </div>
   <div class="form-group">
     <label for="Bairro">Bairro</label>
     <input type="text" id="Bairro" name="Bairro" class="form-control" value="<?php echo $ende->endBairro ?>" placeholder="Bairro" disabled>
   </div>
   <div class="form-group">
     <label for="Complemento">Complemento</label>
     <input type="text" id="Complemento" name="Complemento" class="form-control" value="<?php echo $ende->endComplemento?>" placeholder="Pais" disabled>
   </div>
   <div class="form-group">
    <label for="comment">Informações Adicionais</label>
    <textarea class="form-control" rows="5" name="adicional" placeholder="Informações Adicionais" disabled>{{ $ende->endInfAdicionais }}</textarea>
  </div>
</div>
<div class="col-lg-6">
  <div class="form-group">
   <label for="Cidade">Cidade</label>
   <input type="text" id="Cidade" name="Cidade" class="form-control" value="<?php echo $ende->endCidade?>" placeholder="Cidade" disabled>
 </div>
 <div class="form-group">
   <label for="CEP">CEP</label>
   <input type="text" id="CEP" name="CEP" class="form-control" value="<?php echo $ende->endCEP?>" placeholder="CEP" disabled>
 </div>
 <div class="form-group">
   <label for="Estado">Estado</label>
   <input type="text" id="Estado" name="Estado" class="form-control" value="<?php echo $ende->endEstado?>" placeholder="Estado" disabled>
 </div> 
 <div class="form-group">
   <label for="Pais">País</label>
   <input type="text" id="Pais" name="Pais" class="form-control" value="<?php echo $ende->endPais?>" placeholder="Pais" disabled>
 </div>
</div>
</fieldset>


</div>






<div role="tabpanel" class="tab-pane" id="messages">
  <?php

  $dataI = substr($dados->atiDataIniInsc, 0, 10);
  $dataF = substr($dados->atiDataFimInsc, 0, 10);
  $dataIn = date('d-m-Y',strtotime($dataI));
  $dataFi = date('d-m-Y',strtotime($dataF));
  $data=date('Y-m-d H:i:s');; 
  ?>
  <fieldset>
    <form action="/pdf" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <center><legend> <b>Lista de presença para impressão(.pdf)</b>
      </legend></center><br>
      <div class="form-group">

       <input type="hidden" value="{{ $dados->atiCod }}" name="atividade"></input>
       <b>Data e Horario:  </b><select name="horario">
       @foreach($horario as $hora)
       <?php
       $horaInicio=substr($hora->horDataIniRealizacao, 11, 8);
       $horaFim=substr($hora->horDataFimRealizacao, 11, 8);
       $data = substr($hora->horDataIniRealizacao, 0, 10);
       $dataFi = date('d/m/Y',strtotime($data));
       ?>
       <option value="{{ $hora->horCod }}">{{ $dataFi }} |  {{ $horaInicio }} - {{ $horaFim }}</option>
       @endforeach

     </select> &nbsp;<button class="btn btn-primary" name="Gerar" type="submit">Gerar Lista Virtual</button>
     

   </div> 
 </form>
</fieldset>


<form method="post" action="/atividades/minhas_atividades/informacoes/listapresenca" >
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="atv" value="{{ $dados->atiCod }}">
  <center><legend> <b>Lista de Presença virtual</b>
  </legend></center>
  <b>Data e Horário: </b><select name="horario">
  @foreach($horario as $hora)
  <?php
  $horaInicio=substr($hora->horDataIniRealizacao, 11, 8);
  $horaFim=substr($hora->horDataFimRealizacao, 11, 8);
  $data = substr($hora->horDataIniRealizacao, 0, 10);
  $dataFi = date('d/m/Y',strtotime($data));
  ?>
  <option value="{{ $hora->horCod }}">{{ $dataFi }} |  {{ $horaInicio }} - {{ $horaFim }}</option>
  @endforeach

</select> <button class="btn btn-primary" type="submit" name="Listar">Listar</button>
</form>
</fieldset>
</div>
<div role="tabpanel" class="tab-pane" id="settings">
 <center><legend> <b>Vinculo de Atividade ao Evento</b>
 </legend></center>
 <br>
 <table border="1" class="table table-striped">
   <thead>
    <tr>
     <th>Atividade</th>
     <th>Data</th>
     <th>Horário de Inicio</th>
     <th>Horário de Termino</th>
   </tr>
 </thead>
 <tbody>


  <?php
  ?>
  @foreach($horario as $horari)
  @if($horari->hor_atiCod==$dados->atiCod)
  <?php 
  $horaInicio=$horari->horDataIniRealizacao;
  $horaIni = substr($horaInicio, 11, 8); 
  $horaFim = $horari->horDataFimRealizacao;
  $horaF= substr($horaFim, 11, 8); 
  ?>
  <tr>
   <td>{{ $dados->atiNome }}</td>
   <td><?php 
    $data = substr($horari->horDataIniRealizacao, 0, 10); 
    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    echo strftime('%A, %d de %B de %Y', strtotime($data));
    ?></td>
    <td>{{ $horaIni }}</td>
    <td>{{ $horaF }}</td>
  </tr>
  @endif

  @endforeach

</tbody>
</table>
</div>


<div role="tabpanel" class="tab-pane" id="Vinculos">


  <div class="row">
   <center><legend> <b>Vínculo de Atividade ao Evento</b>
   </legend></center>




   <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">

     <div class="form-group">
      <label for="Instituição"><h4><b>@if($ver==1)
        Não possui vínculo
        @else
        Atividade vinculada ao evento:  {{ $evento->eveNome }}
        @endif</b> </h4></label>
      </div>
      
      
    </div>

  </div>
  

</div>

<div role="tabpanel" class="tab-pane" id="Coordenadores">

  <div class="row">
   <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
     <form action="/atividades/minhas_atividades/informacoes/adiciona_coordenador" method="post">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <center><legend> <b>Adicione um outro coordenador para a atividade</b>
         <input type="hidden" name="Atividade" value="{{ $dados->atiCod }}">
       </legend></center>

       <select class="form-control" name="Cadidatos">
        @foreach($coordenadores as $candidatos)
        <option value="{{ $candidatos->id }}">{{ $candidatos->name }}</option>

        @endforeach
      </select>
      <br>
      <button class="btn btn-primary" name="CCoordenador">Cadastrar</button>
    </form>
  </div>
  




  

  <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
    <center><legend> <b>Lista de Coordenadores</b>
    </legend></center>
    <ul>
     

     @foreach($nomeCoordenadores as $cod)
     @if($cod->id==session('id'))
     <li><b>{{ $cod->name }}</b></li>
     @else
     <li>{{ $cod->name }}</li>
     @endif
     @endforeach
   </ul>



 </div>
 
 
</div>


</div>
</div>

</div>
</div>
</div>











</div>




</div>

</div>


@endsection