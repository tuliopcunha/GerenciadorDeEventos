@extends('layouts.master')
@section('title', " - $meuEvento->eveNome")
@section('titlesection', '')
@section('meusDadosAtivo','active')
@section('descsection', '')
@section('css')
@parent
<link rel="stylesheet" href="{{ asset('data/plugins/fullcalendar/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('data/plugins/fullcalendar/fullcalendar.print.css') }}" media="print">
@endsection
@section('principal')
@parent


<div class="row">
  <div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-success">
      <div class="box-body box-profile">
        

        <h3 class="profile-username text-center">{{ $meuEvento->eveNome }}</h3>

        <p class="text-muted text-center"><i>Início:</i> {{ date('d-m-y', strtotime($dataInicio)) }} &nbsp;&nbsp;<i>Fim:</i> {{date('d-m-y', strtotime($dataFim))}}</p>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            
            <b>Inscritos</b> <a class="pull-right disabled">{{$inscritos}}</a>
            
          </li>
        </ul>

        <b><p class="text-muted text-center">Inscrições de <br> {{ date('d-m-y', strtotime($meuEvento->eveDataIniInsc)) }} &nbsp; a &nbsp; {{date('d-m-y', strtotime($meuEvento->eveDataFimInsc))}}</p></b>

        @if(($codUsuario==$meuEvento->eve_usuCod)&&($dataHoje < $meuEvento->eveDataIniInsc))
        <form action="/eventos/{{$meuEvento->eveNome}}/{{$meuEvento->eveCod}}/editar_evento" method="get">
          {!! csrf_field() !!}
          <input type="hidden" name="Codigo" value="{{ $meuEvento->eveCod }}">
          <button type="submit" class="btn btn-success btn-block" name="Participar"> <b> Editar Evento &nbsp;&nbsp;</b><i class="fa fa-gears"></i></button>
        </form>
        @else
        <form action="/eventos/{{$meuEvento->eveNome}}/{{$meuEvento->eveCod}}/inscrever_se" method="post">
          {!! csrf_field() !!}
          <input type="hidden" name="Codigo" value="{{ $meuEvento->eveCod }}">
          @if((strtotime($dataHoje) > strtotime($dataFim))||(session('id') == $meuEvento->eve_usuCod))
          <i class="btn btn-default btn-block disabled" name=""> <b> Inscrever-se &nbsp;&nbsp;</b><i class="glyphicon glyphicon-pencil"></i></i>
          @elseif(!$inscrito)
          <button type="submit" class="btn btn-primary btn-block" name="Participar"> <b> Inscrever-se &nbsp;&nbsp;</b><i class="glyphicon glyphicon-pencil"></i></button>
          @elseif($inscrito)
          <button type="submit" class="btn btn-danger btn-block" name="Cancelar"><b> Cancelar Inscrição &nbsp;&nbsp;</b><i class="glyphicon glyphicon-pencil"></i></button>
          @endif    
        </form>
        @endif

      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- About Me Box -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Dados do Evento</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <strong><i class="fa fa-map-marker margin-r-5"></i> Local</strong>

        <p class="text-muted">{{$endereco->endCidade}}, {{$endereco->endEstado}}</p>

        <hr>

        <strong><i class="fa fa-pencil margin-r-5"></i> Atividades</strong>

        <p>
          @foreach ($atividades as $aE)
          @if($aE->ati_tipAtiCod==2)
          <span class="label label-danger">{{ $aE->atiNome }}</span>
          @elseif($aE->ati_tipAtiCod==3)
          <span class="label label-success">{{ $aE->atiNome }}</span>
          @endif
          @endforeach
        </p>

        <hr>

        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

        <p></p>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#calender" data-toggle="tab" aria-expanded="true">Calendário</a></li>
        <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Informações</a></li>
        <li class=""><a href="#activity" data-toggle="tab" aria-expanded="false">Atividades</a></li>
        @if($codUsuario == $meuEvento->eve_usuCod)
        <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Configurações</a></li>
        @endif
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="calender">
          <div id="calendar"></div>
          <script type="text/javascript">
            $(function () {

        /* initialize the external events
        -----------------------------------------------------------------*/
        function ini_events(ele) {
          ele.each(function () {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
              title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
              zIndex: 1070,
              revert: true, // will cause the event to go back to its
              revertDuration: 0  //  original position after the drag
            });

          });
        }
        ini_events($('#external-events div.external-event'));

        /* initialize the calendar
        -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
        $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          buttonText: {
            Hoje: 'today',
            Mes: 'month',
            Semana: 'week',
            Dia: 'day'
          },
          //Random default events
          events: [
          @foreach ($horario as $dt)
          @foreach ($atividades as $at)
          @if($dt->hor_atiCod == $at->atiCod)
          {

            title: '<?php echo($at->atiNome) ?>',
            <?php

            $dataI = substr($dt->horDataIniRealizacao, 0, 10);
            $dataF = substr($dt->horDataFimRealizacao, 0, 10);
            $dataIn = date('d-m-Y',strtotime($dataI));
            $dataFi = date('d-m-Y',strtotime($dataF));
            $diaInicio=date('d',strtotime($dataIn)); 
            $mesInicio=date('m',strtotime($dataIn)); 
            $anoInicio=date('Y',strtotime($dataIn)); 
            $diaFim=date('d',strtotime($dataFi)); 
            $mesFim=date('m',strtotime($dataFi)); 
            $anoFim=date('Y',strtotime($dataFi));

            $mesInicio=$mesInicio-1; 
            $mesFim=$mesFim-1; 

            $horaInicio=$dt->horDataIniRealizacao;
            $horaIni = substr($horaInicio, 11, 8); 
            $horaFim = $dt->horDataFimRealizacao;
            $horaFinal= substr($horaFim, 11, 8);
            $horaInicio=date('H',strtotime($horaIni)); 
            $minutoInicio=date('i',strtotime($horaIni));
            $horaF=date('H',strtotime($horaFinal)); 
            $minutoF=date('i',strtotime($horaFinal));

            ?>
            start: new Date({{ $anoInicio }}, {{ $mesInicio }}, {{ $diaInicio }}, {{ $horaInicio }}, {{ $minutoInicio }}),
            end: new Date({{ $anoFim }}, {{ $mesFim }}, {{ $diaFim }}, {{ $horaF }}, {{ $minutoF }}),
            @if($at->ati_tipAtiCod==1)
            backgroundColor: "#f56954", //red
              borderColor: "#f56954" //red
              @elseif($at->ati_tipAtiCod==2)
            backgroundColor: "#008000", //green
              borderColor: "#008000" //green
              @endif
              
            },
            @endif
            @endforeach
            @endforeach

            {
             title: 'Click for Google',
             start: new Date(1997, m, 28),
             end: new Date(1997, m, 29),
             url: 'http://google.com/',
              backgroundColor: "#3c8dbc", //Primary (light-blue)
              borderColor: "#3c8dbc" //Primary (light-blue)
            }
            ],
            editable: false,
          droppable: false, // this allows things to be dropped onto the calendar !!!
          drop: function (date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            copiedEventObject.backgroundColor = $(this).css("background-color");
            copiedEventObject.borderColor = $(this).css("border-color");

            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
              // if so, remove the element from the "Draggable Events" list
              $(this).remove();
            }

          }
        });

        /* ADDING EVENTS */
        var currColor = "#3c8dbc"; //Red by default
        //Color chooser button
        var colorChooser = $("#color-chooser-btn");
        $("#color-chooser > li > a").click(function (e) {
          e.preventDefault();
          //Save color
          currColor = $(this).css("color");
          //Add color effect to button
          $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
        });
        $("#add-new-event").click(function (e) {
          e.preventDefault();
          //Get value and make sure it is not null
          var val = $("#new-event").val();
          if (val.length == 0) {
            return;
          }

          //Create events
          var event = $("<div />");
          event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
          event.html(val);
          $('#external-events').prepend(event);

          //Add draggable funtionality
          ini_events(event);

          //Remove event from text input
          $("#new-event").val("");
        });
      });
    </script>
  </div>
  
  <!-- /.tab-pane -->
  <div class="tab-pane" id="timeline">
    <!-- The timeline -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            {{$meuEvento->eveNome}}
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <div class="row invoice-info">
        <div class="col-sm-8">
          <strong>Descrição</strong><br>
          <?php echo($meuEvento->eveDescricao); ?>
        </div><br><br>
        <hr><br>
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
          <address>
            <strong>Endereço</strong><br>
            {{$endereco->endRua}}, {{$endereco->endNumero}}<br>
            {{$endereco->endCidade}}, {{$endereco->endCEP}}<br>
            {{$endereco->endEstado}}, {{$endereco->endPais}}<br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-6 invoice-col">
          <b> Período de Inscrições: </b> {{ date('d-m-y', strtotime($meuEvento->eveDataIniInsc)) }} &nbsp;-&nbsp; {{date('d-m-y', strtotime($meuEvento->eveDataFimInsc))}}<br><br>

          <b>Data de Realização: </b> {{ date('d-m-y', strtotime($dataInicio)) }} &nbsp;-&nbsp; {{date('d-m-y', strtotime($dataFim))}}<br><br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- this row will not appear when printing -->
    </section>
  </div>
  <!-- /.tab-pane -->
  <!-- atividades-pane -->
  <div class="tab-pane" id="activity">
    <div class="box">
      <!-- /.box-header -->
      <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
        <thead>
          <tr role="row"><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">Nome</th><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column descending" aria-sort="ascending">Tipo</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Responsável</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Carga Horaria</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Incluida no Evento</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Vagas</th></tr>
        </thead>
        <tbody>
          <?php $atividadesMostradas = array() ?>
          @foreach($atividades as $atividade)
          <?php 
            $QuantidadeVagas = DB::table('inscricao')
                      ->where('ins_atiCod',$atividade->atiCod)
                      ->count();
          ?>            
          @if((($atividade->ati_staCod==8)||($atividade->ati_staCod==7))&&(!in_array($atividade, $atividadesMostradas)))
          <tr role="row" class="odd">
            <td class="">
              <form method="post" action="/atividades/atividades_disponiveis/mais_informacoes" id="{{ $atividade->atiNome}}EditaAtividade"> 
                {!! csrf_field() !!}
                <input type="hidden" name="Codigo" value="{{ $atividade->atiCod }}">
                <a onclick="document.forms['{{ $atividade->atiNome}}EditaAtividade'].submit();" >
                  <center> {{ $atividade->atiNome}} </center></a>
                </form>
              </td>
              <td class="sorting_1"><?php switch ($atividade->ati_tipAtiCod) {
                case 1:
                echo "Palestra";
                break;

                case 2:
                echo "Curso";
                break;
              } ?></td>

              <td>&nbsp;</td>

              <td><center>{{$atividade->atiCargaHoraria}}</center></td>
              <td><center><?php if($atividade->atiIncluidaPcteEvento <> NULL)
                echo '<i class="fa fa-check"></i>';
                else
                  echo '  ';    
                ?></center></td>
                <td>{{$QuantidadeVagas}}/{{$atividade->atiNumVagas}}</td>
              </tr>
              <?php if(!in_array($atividade, $atividadesMostradas))
              array_push($atividadesMostradas, $atividade); ?>
              @endif
              @endforeach

            </tbody>
                <!--
                <tfoot>
                <tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>
                </tfoot>
              -->
            </table></div></div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>


    <div class="tab-pane" id="settings">
      <form action="/eventos/disponiveis" method="post" id="settings">
        <div class="box">
         
         <div class="box-body">
          <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row"><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">Nome</th><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column descending" aria-sort="ascending">Incluida no Evento</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Editar Atividade</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Excluir Atividade</th></tr>
            </thead>
            <tbody>
              @foreach($atividades as $atividade)
              <tr role="row" class="odd">
                <td class="">
                  {{$atividade->atiNome}}
                </td>
                <td><center><?php if($atividade->atiIncluidaPcteEvento <> NULL)
                  echo '<i class="fa fa-check"></i>';
                  else
                    echo '  ';    
                  ?></center></td>
                  <td class="">
                    @if($atividade->ati_staCod == 6)
                    <form method="post" action="/atividades/minhas_atividades/informacoes/alterainformacoes" id="{{ $atividade->atiNome}}EditaHorarios">
                      <input type="hidden" name="Status" value="6"> 
                      {!! csrf_field() !!}
                      <input type="hidden" name="Codigo" value="{{ $atividade->atiCod }}">
                      <a onclick="document.forms['{{ $atividade->atiNome}}EditaHorarios'].submit();" >
                        <center> <i class="fa fa-edit"></i> </center></a>
                      </form>
                      @else
                      <form method="post" action="/atividades/minhas_atividades/informacoes/alterainformacoes" id="{{ $atividade->atiNome}}EditaAtividade"> 
                        {!! csrf_field() !!}
                        <input type="hidden" name="Cod" value="{{ $atividade->atiCod }}">
                        <a onclick="document.forms['{{ $atividade->atiNome}}EditaAtividade'].submit();" >
                          <center> <i class="fa fa-edit"></i> </center></a>
                        </form>
                        @endif
                      </td>

                      
                      <td class=""><a><center> <i class="glyphicon glyphicon-remove"></i></center></a></td>
                    </tr>
                    @endforeach

                  </tbody>
                <!--
                <tfoot>
                <tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>
                </tfoot>
              -->
            </form>  
          </table></div></div>
          <div style="float: right;">  
            <form action="/eventos/cria_atividade" method="post" id="adicionarAtividade">
              {!! csrf_field() !!}
              <input type="hidden" name="codigo" value="{{ $meuEvento->eveCod }}">
              <button type="submit" class="btn btn-block btn-success"> <i class="glyphicon glyphicon-plus"></i> &nbsp; Adicionar Atividade </button>
            </form>

          </div>  
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    
  </div>
  <!-- /.tab-pane -->
</div>    
@endsection

@section('js')
@parent
<script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('data/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('data/plugins/fullcalendar/lang/pt-br.js') }}"></script>
@endsection