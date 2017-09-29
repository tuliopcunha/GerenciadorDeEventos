@extends('layouts.master')
@section('title', '- Criação de Evento')
@section('titlesection', 'Criação de Evento')
@section('eventosAtivo', 'active')
@section('principal')
@parent
<form action="/eventos/cadastraEvento" method="post">
  {!! csrf_field() !!}

<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Básicas</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Localização</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Inscrição</a></li>
              <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Pagamento</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
               <form role="form">
              <div class="box-body box-success">
                    <fieldset>
                      <div class="col-lg-6">
                        
                        <div class="form-group">
                          <label for="Rua">Nome Do Evento</label>
                          <input type="text" id="nome" name="nome" value="" class="form-control" placeholder="Nome" >
                        </div>
                        <div class="form-group">
                          <label for="descricao">Descrição</label>
                          <textarea rows="5" cols="15" name="descricao" style=" max-width: 100%; max-height: 100px; " name="descricao" value="" class="form-control" placeholder="Breve Descrição sobre o Evento"></textarea>
                        </div>
                      </div>
                      <div class="col-lg-6">
                         <!-- Second Colun -->
                         <div class="form-group">
                          <?php 
                            $usuarios =DB::table('users')
                                        ->get();
                          ?>
                          <label for="coordenador">Coordenador</label>
                          <select name="coordenador" id="coordenador" class="form-control select2 select2-hidden-accessible">
                        @foreach($usuarios as $user)
                            <option value="{{$user->id}}" @if($user->id == session('id')) selected @endif><?php echo "$user->name" ?></option>

                        @endforeach
                          </select>
                        </div>
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
                        <input type="text" id="Rua" name="Rua" value="" class="form-control" placeholder="Rua" >
                      </div>
                      <div class="form-group">
                        <label for="Numero">Número</label>
                        <input type="text" id="numero" name="numero" value="" class="form-control" placeholder="Numero">
                      </div>
                      <div class="form-group">
                        <label for="Bairro">Bairro</label>
                        <input type="text" id="Bairro" name="Bairro" class="form-control" value="" placeholder="Bairro" >
                      </div>
                      <div class="form-group">
                        <label for="Complemento">Complemento</label>
                        <input type="text" id="Complemento" name="Complemento" class="form-control" value="" placeholder="Complemento" >
                      </div>
                    </div>
                    <div class="col-lg-6">
                     <div class="form-group">
                      <label for="Cidade">Cidade</label>
                      <input type="text" id="Cidade" name="Cidade" class="form-control" value="" placeholder="Cidade" >
                    </div>
                    <div class="form-group">
                      <label for="CEP">CEP</label>
                      <input type="text" id="CEP" name="CEP" class="form-control" value="" placeholder="CEP" >
                    </div>
                    <div class="form-group">
                      <label for="Estado">Estado</label>
                      <input type="text" id="Estado" name="Estado" class="form-control" value="" placeholder="Estado" >
                    </div> 
                    <div class="form-group">
                      <label for="Pais">País</label>
                      <input type="text" id="Pais" name="Pais" class="form-control" value="" placeholder="Pais" >
                    </div>
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
                          <label for="dataIniInsc">Data do Início das Inscrições</label>
                          <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" id="dataIniInsc" name="dataIniInsc" value="" class="form-control" placeholder="Definição do Início das datas de Inscrição"  >
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="dataTerInsc">Data do Término das Inscrições</label>
                          <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                          <input type="date" id="dataFimInsc" name="dataFimInsc" value="" class="form-control" placeholder="Definição do Término das datas de Inscrição"  >
                          </div>
                        </div>
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
                  </fieldset> 

              <!-- /.tab-pane -->
              <div class="box-footer">
                  <div class="col-xs-3 pull-right">
                    <button type="submit" class="btn btn-primary pull-right">Criar Evento</button>
                  </div>
                  <div>  
                    <a href="/home" class="btn btn-danger pull-right">Cancelar</a>
                  </div> 
                </div>            
            </div>
                
              </div>
            </form>   
            <!-- /.tab-content -->
          </div>  

@endsection