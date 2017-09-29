@extends('layouts.master')
@section('title', '- Criar Atividade')
@section('titlesection', 'Criar Atividade')
@section('atividadesAtivo','active')
@section('principal')
@parent

<script type="text/javascript">
  function showVal(newVal){
  document.getElementById("valBox").innerHTML=newVal;
}

</script>
<form action="/CadastraAtividade" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
      <li role="presentation" ><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Informações Básicas</a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Informações de Localização</a></li>
      <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Presença</a></li>
      <li role="presentation" class="active"><a href="#Horarios" aria-controls="messages" role="tab" data-toggle="tab">Cadastrar Horários</a></li>
      <li><a href="#Coordenadores" aria-expanded="false" role="tab" data-toggle="tab">Adição de Coordenadores</a></li>
    </ul>
    





    <!-- Tab panes -->
    <div class="tab-content">






      <div role="tabpanel" class="tab-pane" id="home">
        <fieldset>
          <center><legend> Dados da Atividade
          </legend></center>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="nome">Nome</label>
              <input type="text" id="nome" name="nome" value="{{ $val->atiNome }}" class="form-control" placeholder="Nome" disabled>
            </div>
            <div class="form-group">
              <label for="Conteudo">Conteudo</label>
              <input type="text" id="Email" name="conteudo" value="{{ $val->atiConteudo }}" class="form-control" placeholder="Conteudo da Atividade" disabled >
            </div>
            <div class="form-group">
              <label for="Pré-Requisitos">Pré-Requisitos</label>
              <input type="text" id="CPF" name="prequisitos" value="{{ $val->atiPreRequisito }}" class="form-control" placeholder="Pré-Requisitos"  disabled>
            </div>
            <div class="form-group">
              <label for="Pré-Requisitos">Tipo de Atividade</label>
              <select name="tpoAtividade" class="form-control" disabled>
                @foreach($atv as $row)
                @if($row->tipAtiCod!=1)
                <option value="{{ $row->tipAtiCod }}">{{ $row->tipAtiNome }}</option>
                @endif
                @endforeach
              </select>
            </div>

          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="Preço">Preço</label>
              <input type="number" id="RG" name="Preco" class="form-control"  value="{{ $val->atiNome }}" placeholder="Preço" step="0.01" min="0" disabled>
            </div>
            <div class="form-group">
              <label for="Material">Necessidade de Material ou Ambiente</label>
              <input type="text" id="RG" name="ambiente" class="form-control"  value="{{ $val->atiNecessidadeMaterialAmbiente }}" placeholder="Necessidade de Material ou Ambiente"  disabled>
            </div>
            <div class="form-group">
              <label for="Material">Carga Horaria</label>
              <input type="number" id="RG" name="horario" class="form-control"  value="{{ $val->atiCargaHoraria }}" placeholder="Carga Horária"  min="{{ $val->atiCargaHoraria }}" disabled>
            </div>
            <div class="form-group">
              <label for="Area_Conhecimento">Pacote Incluido no Evento ?</label>
              <select name="Pacote" class="form-control" disabled>
                <option value="Sim">Sim</option>
                <option value="Nao">Não</option>
              </select>
            </div>
          </div>

          
        </fieldset>

      </div>




      <div role="tabpanel" class="tab-pane" id="profile">

       <fieldset>
        
        <center><legend> Endereço
          </legend></center>
        <div class="col-lg-6">
          
          <div class="form-group">
            <label for="Rua">Rua</label>
            <input type="text" id="Rua" name="Rua" value="{{ $end->endRua }}" class="form-control" placeholder="Rua" disabled>
          </div>
          <div class="form-group">
            <label for="Numero">Numero</label>
            <input type="text" id="numero" name="numero" value="{{ $end->endNumero }}" class="form-control" placeholder="Numero" disabled>
          </div>
          <div class="form-group">
            <label for="Bairro">Bairro</label>
            <input type="text" id="Bairro" name="Bairro" class="form-control" value="{{ $end->endBairro }}" placeholder="Bairro" disabled>
          </div>
          <div class="form-group">
            <label for="Complemento">Complemento</label>
            <input type="text" id="Complemento" name="Complemento" class="form-control" value="{{ $end->endComplemento }}" placeholder="Pais" disabled>
          </div>
           <div class="form-group">
  <label for="comment">Informações Adicionais</label>
  <textarea class="form-control" rows="5" name="adicional" placeholder="Informações Adicionais" disabled>{{ $end->endInfAdicionais }}</textarea>
</div>
        </div>
        <div class="col-lg-6">
         <div class="form-group">
          <label for="Cidade">Cidade</label>
          <input type="text" id="Cidade" name="Cidade" class="form-control" value="{{ $end->endCidade }}" placeholder="Cidade" disabled>
        </div>
        <div class="form-group">
          <label for="CEP">CEP</label>
          <input type="text" id="CEP" name="CEP" class="form-control" value="{{ $end->endCEP }}" placeholder="CEP" disabled>
        </div>
        <div class="form-group">
          <label for="Estado">Estado</label>
          <input type="text" id="Estado" name="Estado" class="form-control" value="{{ $end->endEstado }}" placeholder="Estado" disabled>
        </div> 
        <div class="form-group">
          <label for="Pais">País</label>
          <input type="text" id="Pais" name="Pais" class="form-control" value="{{ $end->endPais }}" placeholder="Pais" disabled>
        </div>
      </div>
    </fieldset>


  </div>









  <div role="tabpanel" class="tab-pane" id="messages">

    <fieldset>
    <center><legend> <b>Inscrições</b> 
          </legend></center>
    
      <div class="col-lg-4">
        <div class="form-group">
        <?php
          $dataini=date('Y-m-d',strtotime($val->atiDataIniInsc));
          $datafim=date('Y-m-d',strtotime($val->atiDataFimInsc));


          ?>
          <label for="Inicio">Inicio das Inscrições</label>
          <input type="date" id="Ini" name="iniInsc"  value="{{ $dataini }}" class="form-control" disabled>
        </div>
        <div class="form-group">
          <label for="Instituição">Termino das Inscrições</label>
          <input type="date" id="fim_Insc" name="fimIns"  value="{{ $datafim }}" class="form-control" disabled>
        </div>
        <div class="form-group">
          <label for="Instituição">Numero de Vagas</label>
          <input type="text" id="Instituição" name="NumeroVagas"  value="{{ $val->atiNumVagas }}" class="form-control" placeholder="Instituição" disabled>
        </div>
      </div>
    </fieldset>
    
    

</div>


<div role="tabpanel" class="tab-pane active" id="Horarios">
<fieldset>
  
  
    <b><h4><font color="red"> {{ $mensagem }} </font></h4></b>
<div class="col-lg-6">
        <h4> <b> A atividade {{ $val->atiNome }} terá uma carga horária de {{ $val->atiCargaHoraria }} horas. </b></h4>
        <h4> <b> Já foram cadastradas {{ $total }} horas. </b></h4><br>
         @if($total<=$val->atiCargaHoraria)

            <input type="hidden" name="Codigo" value="{{ $val->atiCod }}">   
            <h4><b> Cadastre o restante dos horários</b> </h4>

            <h5><b>Escolha o dia</b></h5> 
            <input type="date" name="data" class="form-control"></input> <br> <br>


            <h5><b>Defina o horário da atividade na data escolhida</b></h5>




            <b>De:</b> <input type="Time" name="Inicio"> <b>Até:</b> <input type="Time" name="Fim"> <br> <br>



         <!--   De: <select name="Inicio" class="form-control">
            @for($i=7;$i<=22;$i++)
            <option >{{ $i }}:00</option>
            @endfor
          </select>


          Até: <select name="Fim" class="form-control">
          @for($i=7;$i<=22;$i++)
          <option>{{ $i }}:00</option>
          @endfor


        </select>-->
        <button type="submit" class="btn btn-primary" name="cHorario">Cadastrar Horario</button>
    @endif


    </div>
</fieldset>

</div>


<div role="tabpanel" class="tab-pane" id="Coordenadores">

  <div class="row">
   <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
     <form action="/atividades/minhas_atividades/informacoes/adiciona_coordenador" method="post">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <center><legend> <b>Adicione um outro coordenador para a atividade</b>
         <input type="hidden" name="Atividade" value="{{ $val->atiCod }}">
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
    


@endsection