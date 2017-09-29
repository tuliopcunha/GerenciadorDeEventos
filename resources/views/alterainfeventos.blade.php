@extends('layouts.master')
@section('title', '- Edição de Evento')
@section('titlesection', 'Edição de Evento')
@section('eventosAtivo', 'active')
@section('principal')
@parent
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_0" data-toggle="tab" aria-expanded="true">Coordenadores</a></li>
      <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="false" id="basicas">Básicas</a></li>
      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false" id="localizacao">Localização</a></li>
      <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false" id="inscricao">Inscrição</a></li>
      <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false" id="pagamento">Pagamento</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_0">
        <div class="box-body box-success">
          <fieldset>

            <div class="col-lg-8 push-right">
             <!-- Second Colun -->
             <form action="/eventos/{{$meuEvento->eveNome}}/{{$meuEvento->eveCod}}/adicionar_coordenador" method="post" id="adicionaCoordenador">
              {!! csrf_field() !!}
             <label for="coordenador">Novo Coordenador</label>
             <div class="form-group">
              <?php 
              $usuarios =DB::table('users')
              ->get();
              ?>
              <div class="col-lg-6">
                <div class="box">
                  <div class="box-body">
                    <div class="form-group">
                      <label>Selecione o usuário para conceder a permissão de coordenador</label>
                      <select name="usuario" id="usuario" class="form-control">
                        @foreach($usuarios as $row)
                        <option value="{{ $row->id }}">{{ $row->name }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="col-lg-6">
                <div class="box">
                  <div class="box-body">
                    <label>Atuais Coordenadores do Evento</label>
                    <ul>
                      @foreach($coordenadores as $usuario)
                      <li> {{$usuario->name}} </li>
                      @endforeach
                    </ul>   
                  </div>
                </div>
              </div>  
            </div>
            <div align="center">
            <button type="submit" id="adicionaCoordenador" name="OK" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="right">

            <button type="button" class="btn btn-primary" onclick='verify("#tab_0","#basicas")'>Proximo</button>
          </div>
        </fieldset>
        </div>
        </div>


        <div class="tab-pane" id="tab_1">
        <div class="box-body box-success">
          <fieldset>
            <form action="/eventos/{{$meuEvento->eveNome}}/{{$meuEvento->eveCod}}/editar_evento/confirmacao" method="post">
            {!! csrf_field() !!}
            <input type="hidden" value="{{$meuEvento->eveCod}}" id="codigo"></input>
            <div class="col-lg-4">

              <div class="form-group">
                <label for="Rua">Nome Do Evento</label>
                <input type="text" id="nome" name="nome" value="{{$meuEvento->eveNome}}" class="form-control" placeholder="Nome" >
              </div>
              <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea rows="5" cols="15" name="descricao" style=" max-width: 100%; max-height: 100px; " name="descricao" value="<?php $meuEvento->eveDescricao ?>" class="form-control" placeholder="Coloque uma breve Descrição do Evento ou deixe em branco para manter a descrição anterior"></textarea>
              </div>
            </div>
            
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="right">

            <button type="button" class="btn btn-primary" onclick='verify("#tab_1","#localizacao")'>Proximo</button>
          </div>
        </fieldset>
      </div>
      <!-- /.box-body -->
    </div>

    <!-- /.tab-pane -->
    <div class="tab-pane" id="tab_2">
      <fieldset>
        <div class="col-lg-6">

          <div class="form-group">
            <label for="Rua">Rua</label>
            <input type="text" id="Rua" name="Rua" value="{{ $ende->endRua }}" class="form-control" placeholder="Rua" >
          </div>
          <div class="form-group">
            <label for="Numero">Numero</label>
            <input type="text" id="numero" name="numero" value="{{ $ende->endNumero }}" class="form-control" placeholder="Numero">
          </div>
          <div class="form-group">
            <label for="Bairro">Bairro</label>
            <input type="text" id="Bairro" name="Bairro" class="form-control" value="{{$ende->endBairro}}" placeholder="Bairro" >
          </div>
          <div class="form-group">
            <label for="Complemento">Complemento</label>
            <input type="text" id="Complemento" name="Complemento" class="form-control" value="{{$ende->endComplemento}}" placeholder="Complemento" >
          </div>
        </div>
        <div class="col-lg-6">
         <div class="form-group">
          <label for="Cidade">Cidade</label>
          <input type="text" id="Cidade" name="Cidade" class="form-control" value="{{$ende->endCidade}}" placeholder="Cidade" >
        </div>
        <div class="form-group">
          <label for="CEP">CEP</label>
          <input type="text" id="CEP" name="CEP" class="form-control" value="{{$ende->endCEP}}" placeholder="CEP" >
        </div>
        <div class="form-group">
          <label for="Estado">Estado</label>
          <input type="text" id="Estado" name="Estado" class="form-control" value="{{$ende->endEstado}}" placeholder="Estado" >
        </div> 
        <div class="form-group">
          <label for="Pais">País</label>
          <input type="text" id="Pais" name="Pais" class="form-control" value="{{$ende->endPais}}" placeholder="Pais" >
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="right">
        <button type="button" class="btn btn-primary" onclick='verify("#tab_2","#inscricao")'>Proximo</button>
      </div>
    </fieldset>
  </div>  

  <div class="tab-pane" id="tab_3">
    <fieldset>
      <div class="col-md-6">
        <div class="form-group">
          <label for="tipoInscricaoEvento">Tipo de Inscrição do Evento</label><br>
          <?php 
          $tipoInscricaoEvento =DB::table('tipo_inscricao_evento')
          ->get();
          ?>
          @foreach($tipoInscricaoEvento as $elemento)
          <div class="form-group box box-success box-solid collapsed-box"> 
            <div class="input-group" data-widget="collapse" onclick="document.getElementById('{{$elemento->tieCod}}').checked=true;">
              <i hidden></i>
              <span class="input-group-addon">
                <input type="radio" id="{{$elemento->tieCod}}" name="tipoInscricaoEvento" value="{{$elemento->tieCod}}" onclick="document.getElementById('{{$elemento->tieCod}}').checked=true;" @if($elemento->tieCod == 0) checked @endif>
              </span>
              <input type="text" class="form-control" value="{{$elemento->tieNome}}" disabled>
            </div>
            <div class="box-body" onclick="document.getElementById('{{$elemento->tieCod}}').checked=true;">
              <?php echo($elemento->tieDescricao);?>
              <br>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="dataIniInsc">Data do Inicio das Inscrições</label>
          <div class="input-group date">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="date" id="dataIniInsc" name="dataIniInsc" value="{{ date('Y-m-d', strtotime($meuEvento->eveDataIniInsc)) }}" class="form-control" placeholder="Definição do Início das datas de Inscrição"  >
          </div>
        </div>

        <div class="form-group">
          <label for="dataTerInsc">Data do Término das Inscrições</label>
          <div class="input-group date">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>

            <input type="date" id="dataFimInsc" name="dataFimInsc" value="{{ date('Y-m-d', strtotime($meuEvento->eveDataFimInsc)) }}" class="form-control" placeholder="Definição do Término das datas de Inscrição"  >
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="right">
        <button type="button" class="btn btn-primary" onclick='verify("#tab_3","#pagamento")'>Proximo</button>
      </div>                   
    </fieldset> 
  </div>    

  <div class="tab-pane" id="tab_4">
    <fieldset>
      <div class="col-md-6">
        <div class="form-group">
          <label for="Inicio">Tipo de Cobrança</label>
          <?php 
          $tiposCobranca =DB::table('tipo_cobranca')->get();
          ?>
          <select name="tipoCobranca" id="tipoCobranca" class="form-control select2 select2-hidden-accessible">
            @foreach($tiposCobranca as $elemento)
            <option value="<?php echo "$elemento->tipCobCod"; ?>"><?php echo "$elemento->tipCobNome" ?></option>

            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="Inicio">Tipo de Pagamento</label>
          <?php 
          $tiposPagamento =DB::table('tipo_pagamento')->get();
          ?>
          <select name="tipoPagamento" id="tipoPagamento" class="form-control select2 select2-hidden-accessible">
            @foreach($tiposPagamento as $elemento)
            <option value="<?php echo "$elemento->tipPagCod"; ?>"><?php echo "$elemento->tipPagNome" ?></option>

            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="Inicio">Preço</label>
          <input type="number" id="preco" name="preco"  value="" class="form-control" >
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="right">
      <button type="submit" class="btn btn-primary">Atualizar</button>
    </div>
    </fieldset> 
    
    <!-- /.tab-pane --> 
  </form>   
  <!-- /.tab-content -->
</div>  

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
